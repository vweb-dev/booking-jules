<?php
// public_html/saportal/login.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - Luxury Talent Booking</title>
    <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
    <h1>Super Admin Login</h1>
    <form action="/api/auth/login.php?role=sa" method="POST">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
