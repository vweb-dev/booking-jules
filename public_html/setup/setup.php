<?php

// --- Security and Pre-flight Checks ---

// Only allow POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Prevent re-running the setup.
if (file_exists(__DIR__ . '/../config/config.php')) {
    exit('Application is already configured. The setup directory should be deleted.');
}

// --- Configuration Variables ---

$configDir = __DIR__ . '/../config';
$dbConfigFile = $configDir . '/database.php';
$appConfigFile = $configDir . '/config.php';
$securityConfigFile = $configDir . '/security.php';

$dbHost = $_POST['db_host'] ?? 'localhost';
$dbName = $_POST['db_name'] ?? '';
$dbUser = $_POST['db_user'] ?? '';
$dbPass = $_POST['db_pass'] ?? '';
$appUrl = rtrim($_POST['app_url'] ?? '', '/');

// --- Step 1: Write Configuration Files ---

try {
    // Create config directory if it doesn't exist.
    if (!is_dir($configDir)) {
        mkdir($configDir, 0755, true);
    }

    // Database Config
    $dbConfigContent = "<?php\n\n// Database configuration\nreturn [\n    'host' => '" . addslashes($dbHost) . "',\n    'dbname' => '" . addslashes($dbName) . "',\n    'user' => '" . addslashes($dbUser) . "',\n    'pass' => '" . addslashes($dbPass) . "',\n    'charset' => 'utf8mb4'\n];\n";
    file_put_contents($dbConfigFile, $dbConfigContent);

    // App Config
    $appConfigContent = "<?php\n\n// Application configuration\ndefine('APP_URL', '" . addslashes($appUrl) . "');\n";
    file_put_contents($appConfigFile, $appConfigContent);

    // Security Config
    $secretKey = bin2hex(random_bytes(32));
    $securityConfigContent = "<?php\n\n// Security settings\ndefine('SECRET_KEY', '" . $secretKey . "');\n";
    file_put_contents($securityConfigFile, $securityConfigContent);

} catch (Exception $e) {
    die("Error: Could not write configuration files. Please check file permissions. Details: " . $e->getMessage());
}

// --- Step 2: Test Database Connection and Import Schema ---

try {
    $dsn = "mysql:host={$dbHost};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `{$dbName}`;");

    // Import Schema
    $schemaSql = file_get_contents(__DIR__ . '/../db/schema.sql');
    if ($schemaSql === false) {
        throw new Exception("Could not read schema.sql file.");
    }
    $pdo->exec($schemaSql);

    // Import Seeds
    $seedsSql = file_get_contents(__DIR__ . '/../db/seeds.sql');
    if ($seedsSql === false) {
        throw new Exception("Could not read seeds.sql file.");
    }
    $pdo->exec($seedsSql);

} catch (PDOException $e) {
    // Clean up created config files on failure
    unlink($dbConfigFile);
    unlink($appConfigFile);
    unlink($securityConfigFile);
    die("Database Error: Could not connect or import schema. Please check your credentials and database server. Details: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// --- Step 3: Clean Up / Self-Destruct ---

// This part is crucial for security.
try {
    // Delete the installer files
    unlink(__DIR__ . '/index.php');
    unlink(__FILE__); // This deletes the current file (setup.php)

    // Remove the setup directory
    rmdir(__DIR__);
} catch (Exception $e) {
    // If cleanup fails, it's not catastrophic, but the user should be warned.
    $warning = "?setup_warning=" . urlencode("Installation successful, but failed to automatically delete the /setup directory. Please remove it manually for security reasons.");
    header('Location: ' . $appUrl . '/' . $warning);
    exit;
}

// --- Step 4: Redirect to Home with Success Message ---

header('Location: ' . $appUrl . '/?setup=success');
exit;
