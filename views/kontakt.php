<?php
$address = "Femøvej 3, 4700 Næstved";
$url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address);

$opts = [
        "http" => [
                "header" => "User-Agent: OkonomiCafe/1.0 (kontakt@okonomicafe.dk)\r\n"
        ]
];

$context = stream_context_create($opts);
$response = file_get_contents($url, false, $context);

$data = json_decode($response, true);

$lat = $data[0]['lat'] ?? 55.224578;
$lon = $data[0]['lon'] ?? 11.757058;
?>



<section id="kontakt" aria-labelledby="kontakt-title">
    <h2 id="kontakt-title">Kontakt os</h2>

    <section id="kontakt-formular" aria-labelledby="kontakt-formular-title">
        <h2 id="kontakt-formular-title">Send os din besked</h2>

        <form action="/send-message" method="post">
        <label for="navn">Navn</label>
            <input type="text" id="navn" name="navn" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="besked">Hvad vil du gerne have hjælp med?</label>
            <textarea id="besked" name="besked" rows="5" required></textarea>

            <button type="submit" class="btn primary">Send besked</button>
        </form>
    </section>

    <section id="find-os" aria-labelledby="find-os-title">
        <h2 id="find-os-title">Find os</h2>
        <address>
            <p>Økonomi-Caféen<br>
                Femøvej 3, 4700 Næstved</p>
        </address>

        <figure class="map-container">
            <section id="map" style="height: 400px;"></section>
            <button id="findVejBtn" class="btn primary" style="margin-top: 10px;">
                Find vej fra min position
            </button>
        </figure>

    </section>
</section>

<!-- Dit eget script – placeret til sidst -->
<script>
    const destLat = <?= $lat ?>;
    const destLon = <?= $lon ?>;

    // Opret kort
    const map = L.map('map').setView([destLat, destLon], 16);

    // OSM tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Marker på destinationen
    L.marker([destLat, destLon]).addTo(map)
        .bindPopup("Økonomi-Caféen<br>Femøvej 3, 4700 Næstved");

    // Funktion til at hente rute
    function findVej() {
        if (!navigator.geolocation) {
            alert("Din browser understøtter ikke geolokation.");
            return;
        }

        navigator.geolocation.getCurrentPosition(pos => {
            const userLat = pos.coords.latitude;
            const userLon = pos.coords.longitude;

            // Marker brugerens position
            L.marker([userLat, userLon]).addTo(map)
                .bindPopup("Din position").openPopup();

            // Hent rute fra OSRM
            fetch(`https://router.project-osrm.org/route/v1/driving/${userLon},${userLat};${destLon},${destLat}?overview=full&geometries=geojson`)
                .then(r => r.json())
                .then(data => {
                    const route = data.routes[0].geometry;

                    const routeLayer = L.geoJSON(route).addTo(map);

                    map.fitBounds(routeLayer.getBounds());
                });

        }, err => {
            alert("Kunne ikke hente din position.");
            console.error(err);
        });
    }

    // Knap-event
    document.getElementById("findVejBtn").addEventListener("click", findVej);
</script>
