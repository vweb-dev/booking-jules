<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Talent Booking - RCE</title>
    <meta name="theme-color" content="#d4af37"/>
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="manifest" href="manifest.webmanifest">
</head>
<body>
    <header>
        <h1>Luxury Talent Booking</h1>
        <nav>
            <a href="/explore">Explore</a>
            <a href="/login">Login</a>
        </nav>
    </header>

    <main>
        <section id="hero">
            <h2>Red Carpet Edition</h2>
            <p>The premier platform for connecting elite talent with exclusive opportunities.</p>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Luxury Talent Booking. All rights reserved.</p>
    </footer>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch(error => {
                        console.log('ServiceWorker registration failed: ', error);
                    });
            });
        }
    </script>
</body>
</html>
