const CACHE_NAME = 'sgdv-offline-v2';


self.addEventListener('install', event => {

    self.skipWaiting();

});


self.addEventListener('activate', event => {

    event.waitUntil(
        clients.claim()
    );

});


self.addEventListener('fetch', event => {


    if (event.request.method !== 'GET') {
        return;
    }


    const url = new URL(event.request.url);


    if (
        url.pathname.startsWith('/consulta/documento/')
    ) {

        event.respondWith(
            cacheDocument(event.request)
        );

    }


});



async function cacheDocument(request)
{

    const cache =
        await caches.open(CACHE_NAME);


    try {


        const response =
            await fetch(request);



        if(response.ok){


            await cache.put(
                request,
                response.clone()
            );


        }


        return response;


    } catch(error){


        const cached =
            await cache.match(request);



        if(cached){

            return cached;

        }



        return new Response(

            `
            <html>
            <body style="font-family:Arial;padding:40px">

            <h2>SGDV Offline</h2>

            <p>
            Documento no disponible en este dispositivo.
            </p>

            </body>
            </html>
            `,

            {
                status:503,
                headers:{
                    'Content-Type':'text/html'
                }
            }

        );


    }

}
