<?php
// This script is intended to be run by a cron job, e.g., every minute.
// It deletes status posts that have passed their expiration time.

// Set base path and include necessary files
$basePath = __DIR__ . '/..';
require_once $basePath . '/config/config.php';
require_once $basePath . '/models/DB.php';

echo "Running status post cleanup cron job at " . date('Y-m-d H:i:s') . "\n";

try {
    $pdo = DB::getInstance();

    // The query is simple: delete from the table where the expiration timestamp
    // is in the past.
    $stmt = $pdo->prepare("DELETE FROM status_posts WHERE expires_at < NOW()");
    $stmt->execute();

    $deleted_count = $stmt->rowCount();

    echo "Cleanup complete. Deleted {$deleted_count} expired status post(s).\n";

} catch (Exception $e) {
    // Log the error. In a real cron job, you might send an email or log to a file.
    $error_message = "Error during status post cleanup: " . $e->getMessage() . "\n";
    echo $error_message;
    error_log($error_message, 3, $basePath . '/logs/cron_errors.log'); // Example logging
}

echo "Cron job finished.\n";
?>
