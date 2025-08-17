<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore - Luxury Talent Booking</title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body class="reel-context">

    <header class="reel-header">
        <a href="/" class="back-link">&larr; Home</a>
        <h1>Explore Talent</h1>
    </header>

    <main id="reel-viewer">
        <!-- Reel items will be injected here by JavaScript -->
        <div class="reel-item active">
            <div class="reel-loading">Loading talent...</div>
        </div>
    </main>

    <div class="reel-nav">
        <button id="prev-reel">Previous</button>
        <button id="next-reel">Next</button>
    </div>

    <!-- We will use ui.js to power the feed -->
    <script src="assets/js/http.js"></script>
    <script src="assets/js/ui.js"></script>
    <script>
        // Initialize the explore feed
        document.addEventListener('DOMContentLoaded', () => {
            UI.initExploreFeed();
        });
    </script>
</body>
</html>
