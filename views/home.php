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
                <li><a href="#kontakt" class="btn primary">Få hjælp nu</a></li>
                <li><a href="#frivillig" class="btn secondary">Bliv frivillig</a></li>
            </ul>
        </nav>

<!--        <figure class="hero-image">-->
<!--            <img src="/images/hero.png" alt="Unge mennesker i caféen">-->
<!--        </figure>-->
    </section>


    <!-- SÅDAN VIRKER DET -->
    <section id="saadan-virker-det" aria-labelledby="steps-title">
        <h2 id="steps-title">Sådan virker det</h2>

        <ol>
            <li>
                <h3>Trin 1: Udfyld formularen</h3>
                <p>Beskriv kort hvad du gerne vil have hjælp med.</p>
            </li>

            <li>
                <h3>Trin 2: Vent på svar</h3>
                <p>Vi svarer dig på email.</p>
            </li>

            <li>
                <h3>Trin 3: Mød op og få konkrete råd</h3>
                <p>Gå hjem med enkle værktøjer og et overblik du kan handle på.</p>
            </li>
        </ol>
    </section>

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



    <!-- FOR DIG -->
    <section id="for-dig" aria-labelledby="fordig-title">
        <h2 id="fordig-title">Du er ikke alene med din økonomi</h2>

        <p>
Mange føler at “pengene bare forsvinder”. Det er helt normalt – og det er præcis det vi hjælper med.
Uanset om du har brug for et simpelt budget eller bare vil tale med nogen, er du velkommen.
        </p>

        <section class="info-grid">
            <article>
                <h3>Trygt & fortroligt</h3>
                <p>Alt foregår i et uformelt, ikke-dømmende rum. Din situation er din – vi lytter.</p>
            </article>

            <article>
                <h3>Simple værktøjer</h3>
                <p>Få konkrete budget-tips og overskuelige metoder du kan bruge med det samme.</p>
            </article>
        </section>
    </section>


    <!-- BLIV FRIVILLIG -->
    <section id="frivillig" aria-labelledby="frivillig-title">
        <h2 id="frivillig-title">Bliv frivillig</h2>

        <p>
Vil du hjælpe andre med at få styr på deres økonomi?
    Som frivillig rådgiver bliver du en del af et fællesskab og gør en reel forskel.
        </p>

        <a href="#kontakt" class="btn primary">Kontakt os for at blive frivillig</a>
    </section>


    <!-- KONTAKT -->
    <section id="kontakt" aria-labelledby="kontakt-title">
        <h2 id="kontakt-title">Kontakt os</h2>

        <p>Har du spørgsmål, brug for hjælp eller vil du høre mere om at blive frivillig?</p>

        <address>
            <p><strong>Adresse:</strong> Zealand, Campus Næstved</p>
            <p><strong>Email:</strong> <a href="mailto:kontakt@oekonomi-cafeen.dk">kontakt@oekonomi-cafeen.dk</a></p>
            <p><strong>Åbningstider:</strong> Tirsdag & torsdag kl. 14–17</p>
        </address>
    </section>

</main>
