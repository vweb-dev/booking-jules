<?php
// A temporary script to generate placeholder images.

$width = 108;
$height = 192; // 9:16 aspect ratio

// Create image resource
$image = imagecreatetruecolor($width, $height);

// Allocate colors
$bg_color = imagecolorallocate($image, 10, 10, 10); // near black
$text_color = imagecolorallocate($image, 150, 150, 150); // grey

// Fill background
imagefill($image, 0, 0, $bg_color);

// Add "9:16" text to the center of the image
$text = "9:16";
$font_size = 5; // Use a built-in font
$text_width = imagefontwidth($font_size) * strlen($text);
$text_height = imagefontheight($font_size);
$x = ($width - $text_width) / 2;
$y = ($height - $text_height) / 2;
imagestring($image, $font_size, $x, $y, $text, $text_color);

// Define output paths. These match the paths in seeds.sql.
$photo_path = __DIR__ . '/public_html/uploads/photos/sample-9-16.jpg';
$thumb_path = __DIR__ . '/public_html/uploads/photos/thumb-sample-9-16.jpg';

// Ensure the directory exists
if (!is_dir(dirname($photo_path))) {
    mkdir(dirname($photo_path), 0755, true);
}

// Save the image as a JPEG
imagejpeg($image, $photo_path, 90);

// For the thumbnail, we'll just create a copy of the main image.
copy($photo_path, $thumb_path);

// Free up memory
imagedestroy($image);

echo "Placeholder images 'sample-9-16.jpg' and 'thumb-sample-9-16.jpg' created successfully in public_html/uploads/photos/\n";
?>
