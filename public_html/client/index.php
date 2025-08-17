<?php
$allowed_roles = ['Client'];
require_once __DIR__ . '/../includes/auth-guard.php';

// The auth guard has confirmed the user is a Client.
// The default view for a client is their feed.
require_once __DIR__ . '/../views/client/feed.php';
?>
