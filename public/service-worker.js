const CACHE_NAME = 'bienes-raices-v2';
const urlsToCache = [
  '/',
  '/manifest.json'
];

// Instalación del Service Worker
self.addEventListener('install', event => {
  console.log('Service Worker instalado');
  self.skipWaiting();
});

// Activación del Service Worker
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            console.log('Eliminando cache antigua:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Interceptar peticiones de red
self.addEventListener('fetch', event => {
  // Solo manejar requests HTTP/HTTPS
  if (!event.request.url.startsWith('http')) {
    return;
  }
  
  // Skip chrome-extension and other non-standard schemes
  const url = new URL(event.request.url);
  if (url.protocol !== 'http:' && url.protocol !== 'https:') {
    return;
  }

  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // Cache hit - devolver respuesta
        if (response) {
          return response;
        }
        
        // Fetch desde la red
        return fetch(event.request).catch(() => {
          // Si falla la red, devolver una respuesta básica para HTML
          if (event.request.destination === 'document') {
            return caches.match('/');
          }
        });
      })
      .catch(() => {
        // Fallback básico
        if (event.request.destination === 'document') {
          return new Response('Offline', { status: 503 });
        }
      })
  );
});