<?php

header('Content-Type: application/json');

$allowed_roles = ['Client'];
require_once __DIR__ . '/../../includes/auth-guard.php';
require_once __DIR__ . '/../../models/DB.php';

// The user is authenticated and is a Client.
// We can get their company ID from the session.
$company_id = $_SESSION['user_company_id'];

if (!$company_id) {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'User is not associated with a company.']);
    exit;
}

try {
    $pdo = DB::getInstance();

    // This query selects approved media from active Talent users
    // belonging to the same company as the logged-in Client.
    $stmt = $pdo->prepare("
        SELECT
            tm.id as media_id,
            tm.file_path,
            tm.thumb_path,
            tm.media_type,
            u.id as talent_user_id,
            u.first_name,
            u.last_name
        FROM
            talent_media AS tm
        JOIN
            users AS u ON tm.user_id = u.id
        WHERE
            u.company_id = ?
            AND u.role_id = 3 -- Role ID for 'Talent'
            AND tm.approval_status = 'approved'
            AND u.is_active = 1
        ORDER BY
            tm.uploaded_at DESC
    ");

    $stmt->execute([$company_id]);
    $feed = $stmt->fetchAll();

    echo json_encode($feed);

} catch (Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode(['error' => 'An error occurred while fetching the client feed.']);
}
