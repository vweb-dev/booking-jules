<?php
// Prevent re-running the setup if the config file already exists.
if (file_exists(__DIR__ . '/../config/config.php')) {
    header("Location: /");
    exit('Application is already configured. The setup directory should be deleted.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - Luxury Talent Booking</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 40px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h1 { color: #1a1a1a; text-align: center; }
        form div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { display: block; width: 100%; padding: 12px; background: #d4af37; color: #fff; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; }
        button:hover { background: #c8a02b; }
        .notice { padding: 15px; background: #fff3cd; border: 1px solid #ffeeba; color: #856404; border-radius: 4px; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Luxury Talent Booking Setup</h1>
        <p class="notice">
            Welcome! Please provide your database details below. This information will be used to create a <code>config/database.php</code> file.
        </p>
        <form action="setup.php" method="POST">
            <div>
                <label for="db_host">Database Host</label>
                <input type="text" id="db_host" name="db_host" value="localhost" required>
            </div>
            <div>
                <label for="db_name">Database Name</label>
                <input type="text" id="db_name" name="db_name" required>
            </div>
            <div>
                <label for="db_user">Database User</label>
                <input type="text" id="db_user" name="db_user" required>
            </div>
            <div>
                <label for="db_pass">Database Password</label>
                <input type="password" id="db_pass" name="db_pass">
            </div>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
            <div>
                <label for="app_url">Application URL</label>
                <input type="text" id="app_url" name="app_url" value="<?php echo htmlspecialchars('http://' . $_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <button type="submit">Install Now</button>
        </form>
    </div>
</body>
</html>
