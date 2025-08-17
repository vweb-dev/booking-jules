<?php
$allowed_roles = ['Tenant Admin'];
require_once __DIR__ . '/../includes/auth-guard.php';

// The auth guard has confirmed the user is a Tenant Admin.
// Now, we can show the main view for the Tenant Admin portal.
require_once __DIR__ . '/../views/admin/index.php';
?>
