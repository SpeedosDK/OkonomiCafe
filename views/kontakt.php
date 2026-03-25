
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
    </section>