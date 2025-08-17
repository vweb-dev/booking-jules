<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talent Dashboard</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <header>
        <h1>Talent Dashboard</h1>
        <nav>
            <a href="/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_firstname'] ?? 'Talent'); ?>!</h2>
        <p>Manage your profile, media, and bookings.</p>

        <nav class="dashboard-nav">
            <ul>
                <li><a href="/talent/profile/edit">Edit Profile</a></li>
                <li><a href="/talent/media/upload">Upload Media</a></li>
                <li><a href="/talent/bookings">View My Bookings</a></li>
                <li><a href="/talent/broadcasts">View Event Broadcasts</a></li>
            </ul>
        </nav>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Luxury Talent Booking. All rights reserved.</p>
    </footer>
</body>
</html>
