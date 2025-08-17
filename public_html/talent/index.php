<?php
$allowed_roles = ['Talent'];
require_once __DIR__ . '/../includes/auth-guard.php';

// The auth guard has confirmed the user is a Talent.
// Now, we can show the main view for the Talent portal.
require_once __DIR__ . '/../views/talent/index.php';
?>
