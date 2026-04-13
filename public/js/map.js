/**
 * Initialiserer OpenStreetMap-kort via Leaflet.js.
 * Skift koordinaterne (lat, lng) og zoom-niveau hvis nødvendigt.
 */
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('map');
    if (!mapEl) return; // Kun kør hvis #map findes på siden

    
    const lat  = 55.224578;
    const lng  = 11.757058;
    const zoom = 16;

    const map = L.map('map').setView([lat, lng], zoom);

    // OpenStreetMap tile-layer (gratis, ingen API-nøgle nødvendig)
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>-bidragydere',
    }).addTo(map);

    // Markør
    L.marker([lat, lng])
        .addTo(map)
        .bindPopup(
            '<strong>Økonomi-Caféen</strong><br>Femøvej 3, 4700 Næstved'
        )
        .openPopup();
});



