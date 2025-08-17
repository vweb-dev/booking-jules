const CACHE_NAME = 'ltb-rce-static-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/index.php',
    '/login.php',
    '/explore', // This will be handled by a route, but caching the path is good
    '/manifest.webmanifest',
    '/assets/css/app.css',
    '/assets/js/http.js',
    '/assets/js/ui.js',
    '/assets/img/logo-192.png',
    '/assets/img/logo-512.png'
    // Note: Views and other PHP files are server-side and cannot be cached directly.
    // We cache the URL endpoints that render them.
];

// Install event: cache all static assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Service Worker: Caching assets');
                return cache.addAll(ASSETS_TO_CACHE);
            })
    );
});

// Activate event: clean up old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Service Worker: Clearing old cache');
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Fetch event: serve from cache or network, but bypass cache for API calls
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Bypassing cache for API calls is a security and data-freshness requirement.
    if (url.pathname.startsWith('/api/')) {
        // Do not use the cache for API requests.
        // Respond with a network request.
        return;
    }

    // For all other requests, use a cache-first strategy.
    event.respondWith(
        caches.match(request).then(cachedResponse => {
            // If the response is in the cache, return it.
            if (cachedResponse) {
                return cachedResponse;
            }

            // If the response is not in the cache, fetch it from the network.
            return fetch(request);
        })
    );
});
