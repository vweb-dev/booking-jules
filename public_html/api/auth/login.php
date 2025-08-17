<?php

require_once __DIR__ . '/../../models/User.php';

// Always start the session at the beginning of an auth script.
session_start();

// --- Security and Pre-flight Checks ---

// Only allow POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit('Method Not Allowed');
}

// Check if config exists. If not, setup hasn't been run.
if (!file_exists(__DIR__ . '/../../config/config.php')) {
    http_response_code(500);
    exit('Application not configured. Please run setup.');
}

// --- Input Processing ---

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

// Determine the source of the login attempt to redirect correctly on failure.
$is_sa_login_attempt = isset($_GET['role']) && $_GET['role'] === 'sa';
$failure_redirect_url = $is_sa_login_attempt ? '/saportal/login.php?error=invalid' : '/login.php?error=invalid';

if (!$email || !$password) {
    header('Location: ' . $failure_redirect_url);
    exit;
}

// --- User Authentication ---

try {
    $user = User::findByEmail($email);

    // Verify user exists, is active, and password is correct.
    if ($user && $user->is_active && $user->verifyPassword($password)) {

        // --- Authentication successful ---

        // Regenerate session ID to prevent session fixation.
        session_regenerate_id(true);

        // Store essential user data in the session.
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_role'] = $user->getRoleName();
        $_SESSION['user_firstname'] = $user->first_name;
        $_SESSION['user_company_id'] = $user->company_id;

        // Redirect based on role.
        $role = $_SESSION['user_role'];
        $redirect_url = '/'; // Default redirect

        switch ($role) {
            case 'Super Admin':
                $redirect_url = '/saportal/';
                break;
            case 'Tenant Admin':
                $redirect_url = '/admin/';
                break;
            case 'Talent':
                $redirect_url = '/talent/';
                break;
            case 'Client':
                $redirect_url = '/client/feed';
                break;
        }

        header('Location: ' . $redirect_url);
        exit;

    } else {
        // --- Authentication failed ---
        header('Location: ' . $failure_redirect_url);
        exit;
    }

} catch (Exception $e) {
    // In production, you would log this error.
    // For now, we'll just show a generic error.
    error_log($e->getMessage());
    $failure_redirect_url = $is_sa_login_attempt ? '/saportal/login.php?error=server' : '/login.php?error=server';
    header('Location: ' . $failure_redirect_url);
    exit;
}
