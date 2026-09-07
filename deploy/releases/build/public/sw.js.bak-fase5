const CACHE_NAME = 'sgdv-offline-v1';

self.addEventListener('install', event => {
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', event => {

    if (event.request.method !== 'GET') {
        return;
    }

    const url = new URL(event.request.url);

    /*
     * Solo cacheamos documentos públicos
     */
    if (url.pathname.startsWith('/consulta/documento/')) {

        event.respondWith(cacheLastDocument(event.request));

    }

});

async function cacheLastDocument(request) {

    const cache = await caches.open(CACHE_NAME);

    try {

        const response = await fetch(request);

        if (response.ok) {

            /*
             * Eliminamos documentos anteriores
             */

            const keys = await cache.keys();

            for (const key of keys) {

                await cache.delete(key);

            }

            await cache.put(request, response.clone());

        }

        return response;

    } catch (e) {

        const cached = await cache.match(request);

        if (cached) {

            return cached;

        }

        return new Response(

            `
            <html>
            <head>
                <title>SGDV</title>
            </head>

            <body style="font-family:Arial;padding:40px">

                <h2>Sin conexión</h2>

                <p>
                    Este documento no está disponible
                    porque nunca fue consultado
                    mientras existía conexión.
                </p>

            </body>

            </html>
            `,

            {
                headers: {
                    'Content-Type': 'text/html'
                },
                status: 503
            }

        );

    }

}
