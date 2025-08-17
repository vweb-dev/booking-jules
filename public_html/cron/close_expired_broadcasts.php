<?php
// This script is intended to be run by a cron job, e.g., every minute.
// It marks event broadcasts as 'expired' if they have passed their expiration time.

// Set base path and include necessary files
$basePath = __DIR__ . '/..';
require_once $basePath . '/config/config.php';
require_once $basePath . '/models/DB.php';

echo "Running event broadcast cleanup cron job at " . date('Y-m-d H:i:s') . "\n";

try {
    $pdo = DB::getInstance();

    // The query updates the status of broadcasts from 'active' to 'expired'
    // where the expiration timestamp is in the past.
    $stmt = $pdo->prepare("
        UPDATE event_broadcasts
        SET status = 'expired'
        WHERE expires_at < NOW() AND status = 'active'
    ");
    $stmt->execute();

    $updated_count = $stmt->rowCount();

    echo "Cleanup complete. Marked {$updated_count} broadcast(s) as expired.\n";

} catch (Exception $e) {
    // Log the error.
    $error_message = "Error during broadcast cleanup: " . $e->getMessage() . "\n";
    echo $error_message;
    error_log($error_message, 3, $basePath . '/logs/cron_errors.log');
}

echo "Cron job finished.\n";
?>
