
<section id="kontakt" aria-labelledby="kontakt-title">
        <h2 id="kontakt-title">Kontakt os</h2>

    <section id="kontakt-formular" aria-labelledby="kontakt-formular-title">
        <h2 id="kontakt-formular-title">Send os din besked</h2>

        <form action="/kontakt-handler.php" method="post">
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
            <iframe
                src="https://www.openstreetmap.org/export/embed.html?bbox=11.7421%2C55.2166%2C11.7721%2C55.2326&amp;layer=mapnik&amp;marker=55.2246%2C11.7571"
                title="Kort over Økonomi-Caféens placering"
                loading="lazy"
            ></iframe>
            <figcaption>
                <a href="https://www.openstreetmap.org/?mlat=55.224578&mlon=11.757058#map=16/55.224578/11.757058" target="_blank" rel="noopener">
                    Se større kort
                </a>
            </figcaption>
        </figure>
    </section>
    </section>