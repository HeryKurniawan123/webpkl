const CACHE_NAME = "smkn1-v1";

const urlsToCache = [

  "/",

  "/manifest.json",

  "/images/logo.png"

];



// Install SW

self.addEventListener("install", event => {

  event.waitUntil(

    caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache))

  );

});



// Fetch

self.addEventListener("fetch", event => {
  event.respondWith(
    fetch(event.request)
      .then(response => {
        // Simpan response terbaru ke cache
        const resClone = response.clone();
        caches.open(CACHE_NAME).then(cache => cache.put(event.request, resClone));
        return response;
      })
      .catch(() => caches.match(event.request))
  );
});


// Update SW

self.addEventListener("activate", event => {

  event.waitUntil(

    caches.keys().then(keys =>

      Promise.all(

        keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))

      )

    )

  );

});