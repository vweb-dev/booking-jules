<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - Luxury Talent Booking</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="client-feed-context">

    <div class="client-layout">

        <!-- Main Reel Viewer -->
        <main class="reel-container">
            <header class="reel-header">
                <h1>Talent Feed</h1>
                <a href="/logout.php">Logout</a> <!-- A logout script will be needed -->
            </header>

            <div id="reel-viewer">
                <div class="reel-item active">
                    <div class="reel-loading">Loading talent...</div>
                </div>
            </div>

            <div class="reel-nav">
                <button id="prev-reel">Previous</button>
                <button id="next-reel">Next</button>
            </div>
        </main>

        <!-- Shortlist Sidebar -->
        <aside id="shortlist-sidebar">
            <h2>Shortlist</h2>
            <ul id="shortlist-items">
                <!-- Shortlisted talent will be injected here -->
                <li class="empty-shortlist">Your shortlist is empty.</li>
            </ul>
            <div class="shortlist-actions">
                <button>Create Booking</button>
            </div>
        </aside>

    </div>

    <script src="/assets/js/http.js"></script>
    <script src="/assets/js/ui.js"></script>
    <script>
        // Initialize the client feed
        document.addEventListener('DOMContentLoaded', () => {
            UI.initClientFeed();
        });
    </script>
</body>
</html>
