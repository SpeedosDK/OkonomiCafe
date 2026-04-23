<main>

    <!-- HERO -->
    <section class="hero" aria-labelledby="hero-title">
        <header>
            <h1 id="hero-title">Gratis & uvildig rådgivning</h1>
            <p class="subtitle">Økonomi-Caféen</p>
        </header>

        <p>
            Få styr på din økonomi i et trygt, uformelt rum.
            Vores frivillige studerende hjælper dig – helt gratis og uden løftede pegefingre.
        </p>

        <nav aria-label="Primære call-to-actions">
            <ul>
                <li><a href="/kontakt" class="btn primary">Få hjælp nu</a></li>
                <li><a href="/frivillig" class="btn secondary">Bliv frivillig</a></li>
            </ul>
        </nav>

    </section>



    <!-- KONTAKT -->
    <section id="kontakt" aria-labelledby="home-kontakt-title">
        <h2 id="home-kontakt-title">Find os</h2>
        <address>
            <p>Økonomi-Caféen<br>
               Femøvej 3, 4700 Næstved</p>
        </address>
        <figure class="map-container">
            <section id="frontpage-map" style="height: 400px;"></section>
            <button id="frontFindVejBtn" class="btn primary" style="margin-top: 10px;">
                Find vej fra min position
            </button>
        </figure>

    </section>


</main>

<script>
    const destLat = 55.224578;
    const destLon = 11.757058;

    // Opret kort
    const frontMap = L.map('frontpage-map').setView([destLat, destLon], 16);

    // Tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(frontMap);

    // Marker
    L.marker([destLat, destLon]).addTo(frontMap)
        .bindPopup("Økonomi-Caféen<br>Femøvej 3, 4700 Næstved");

    // Find vej funktion
    function frontFindVej() {
        if (!navigator.geolocation) {
            alert("Din browser understøtter ikke geolokation.");
            return;
        }

        navigator.geolocation.getCurrentPosition(pos => {
            const userLat = pos.coords.latitude;
            const userLon = pos.coords.longitude;

            L.marker([userLat, userLon]).addTo(frontMap)
                .bindPopup("Din position").openPopup();

            fetch(`https://router.project-osrm.org/route/v1/driving/${userLon},${userLat};${destLon},${destLat}?overview=full&geometries=geojson`)
                .then(r => r.json())
                .then(data => {
                    const route = data.routes[0].geometry;
                    const routeLayer = L.geoJSON(route).addTo(frontMap);
                    frontMap.fitBounds(routeLayer.getBounds());
                });

        }, err => {
            alert("Kunne ikke hente din position.");
            console.error(err);
        });
    }

    document.getElementById("frontFindVejBtn").addEventListener("click", frontFindVej);
</script>

