<?php

header('Content-Type: application/json');

// Check if config exists. If not, setup hasn't been run.
if (!file_exists(__DIR__ . '/../../config/config.php')) {
    http_response_code(503); // Service Unavailable
    echo json_encode(['error' => 'Application not configured.']);
    exit;
}

require_once __DIR__ . '/../../models/DB.php';

try {
    $pdo = DB::getInstance();

    // This query selects approved media from active users with public profiles.
    // It joins tables to get the talent's first name along with the media path.
    $stmt = $pdo->query("
        SELECT
            tm.file_path,
            tm.thumb_path,
            tm.media_type,
            u.first_name
        FROM
            talent_media AS tm
        JOIN
            users AS u ON tm.user_id = u.id
        JOIN
            talent_profiles AS tp ON u.id = tp.user_id
        WHERE
            tm.approval_status = 'approved'
            AND tp.privacy_level = 'public'
            AND u.is_active = 1
        ORDER BY
            tm.uploaded_at DESC
        LIMIT 20
    ");

    $feed = $stmt->fetchAll();

    echo json_encode($feed);

} catch (Exception $e) {
    // In production, you would log this error and return a more generic message.
    http_response_code(500); // Internal Server Error
    error_log($e->getMessage());
    echo json_encode(['error' => 'An error occurred while fetching the feed.']);
}
