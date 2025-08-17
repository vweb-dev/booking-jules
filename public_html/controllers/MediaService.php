<?php

class MediaService {

    const ALLOWED_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/gif'];
    const ALLOWED_VIDEO_TYPES = ['video/mp4', 'video/quicktime'];
    const MAX_FILE_SIZE = 50 * 1024 * 1024; // 50 MB
    const TARGET_ASPECT_RATIO = 9 / 16;
    const ASPECT_RATIO_TOLERANCE = 0.02;

    /**
     * Validates and stores an uploaded file.
     *
     * @param array $file The file array from $_FILES.
     * @param string $uploadDir The target directory relative to /public_html/.
     * @return string|false The new filename on success, or false on failure.
     */
    public static function validateAndStore(array $file, string $uploadDir): string|false {
        // 1. Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            // Handle error
            return false;
        }

        // 2. Check file size
        if ($file['size'] > self::MAX_FILE_SIZE) {
            // Handle error
            return false;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($file['tmp_name']);

        // 3. Check MIME type and validate aspect ratio
        if (in_array($mime_type, self::ALLOWED_IMAGE_TYPES)) {
            list($width, $height) = getimagesize($file['tmp_name']);
            if ($width == 0 || $height == 0) return false;

            $aspect_ratio = $width / $height;
            if (abs($aspect_ratio - self::TARGET_ASPECT_RATIO) > self::ASPECT_RATIO_TOLERANCE) {
                // Aspect ratio is not 9:16
                return false;
            }
        } elseif (in_array($mime_type, self::ALLOWED_VIDEO_TYPES)) {
            // Server-side validation of video aspect ratio is complex and requires tools
            // like ffmpeg/ffprobe. This is a known limitation of a pure PHP environment.
            // We will trust client-side validation for now, but a robust implementation
            // would queue the video for processing by a background worker.
        } else {
            // Invalid file type
            return false;
        }

        // 4. Generate unique filename and store the file
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFilename = uniqid('media_', true) . '.' . $extension;
        $destination = __DIR__ . '/../' . $uploadDir . '/' . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $newFilename;
        }

        return false;
    }

    /**
     * Placeholder for video normalization logic.
     * In a real application, this would use ffmpeg to scale and pad the video.
     *
     * @param string $filePath The path to the video file.
     * @return bool
     */
    public static function normalizeVideo(string $filePath): bool {
        /*
        // Example ffmpeg command:
        $ffmpeg_path = '/usr/bin/ffmpeg';
        $outputPath = $filePath . '_norm.mp4';

        $command = "{$ffmpeg_path} -i {$filePath} -vf 'scale=1080:1920:force_original_aspect_ratio=decrease,pad=1080:1920:(ow-iw)/2:(oh-ih)/2,setsar=1' {$outputPath}";

        // Execute the command
        shell_exec($command);

        // Check if output file exists and handle replacing original, etc.
        */

        // For this project, we just return true as a placeholder.
        return true;
    }
}
