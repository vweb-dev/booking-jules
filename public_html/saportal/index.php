<?php
$allowed_roles = ['Super Admin'];
require_once __DIR__ . '/../includes/auth-guard.php';

// The auth guard has confirmed the user is a Super Admin.
// Now, we can show the main view for the Super Admin portal.
require_once __DIR__ . '/../views/saportal/index.php';
?>
