<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_firstname'] ?? 'Admin'); ?>!</h2>
        <p>This is your company's administration panel.</p>

        <nav class="dashboard-nav">
            <ul>
                <li><a href="/admin/talent">Manage Talent</a></li>
                <li><a href="/admin/media/approve">Approve Media</a></li>
                <li><a href="/admin/broadcasts/new">Create Event Broadcast</a></li>
                <li><a href="/admin/bookings">View Bookings</a></li>
                <li><a href="/admin/settings">Company Settings</a></li>
            </ul>
        </nav>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Luxury Talent Booking. All rights reserved.</p>
    </footer>
</body>
</html>
