<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <header>
        <h1>Super Admin Portal</h1>
        <nav>
            <a href="/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_firstname'] ?? 'Admin'); ?>!</h2>
        <p>This is the system-wide administration panel.</p>

        <nav class="dashboard-nav">
            <ul>
                <li><a href="/saportal/tenants">Manage Tenants</a></li>
                <li><a href="/saportal/settings">System Settings</a></li>
                <li><a href="/saportal/analytics">View Analytics</a></li>
            </ul>
        </nav>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Luxury Talent Booking. All rights reserved.</p>
    </footer>
</body>
</html>
