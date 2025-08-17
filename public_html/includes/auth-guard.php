<?php

// This script should be required by any page that needs authentication.
// It expects a variable `$allowed_roles` to be defined in the calling script,
// which is an array of role names that are allowed to access the page.
// e.g., $allowed_roles = ['Super Admin', 'Tenant Admin'];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    header('Location: /login.php?error=unauthorized');
    exit;
}

// 2. Check if the user's role is allowed to access this page
$user_role = $_SESSION['user_role'];
if (!in_array($user_role, $allowed_roles)) {
    // If not allowed, redirect them to their own dashboard.
    $redirect_url = '/'; // Default redirect

    switch ($user_role) {
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
}

// If we reach here, the user is authenticated and authorized.
// The rest of the page can now be executed.
