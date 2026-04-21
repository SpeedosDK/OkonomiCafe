<?php
require_once __DIR__ . '/../../models/Message.php';

$unreadCount = Message::countUnread();

$navLinks = [
        ["label" => "Sådan virker det", "href" => "/saadan-virker-det"],
        ["label" => "For dig", "href" => "/for-dig"],
        ["label" => "Se kalender", "href" => "/kalender"],
        ["label" => "Bliv frivillig", "href" => "/frivillig"],
        ["label" => "Kontakt", "href" => "/kontakt"],
];

// Hvis logget ind → tilføj medarbejder-links
if (isset($_SESSION['username'])) {
    $navLinks[] = ["label" => "Kalender admin", "href" => "/kalender-admin"];
    $label = "Beskeder";
    if ($unreadCount > 0) {
        $label .= " <span class='badge'>{$unreadCount}</span>";
    }

    $navLinks[] = ["label" => $label, "href" => "/messages"];

} else {
    // Hvis IKKE logget ind → vis login
    $navLinks[] = ["label" => "Kun for medarbejdere", "href" => "/login"];
}
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <title>Økonomi-Caféen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body>
<header>
    <nav>
        <a href="/">Økonomi-Caféen</a>

        <ul>
            <?php foreach ($navLinks as $link): ?>
                <li>
                    <a href="<?= htmlspecialchars($link['href']) ?>">
                        <?= $link['label'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>


        <?php if (isset($_SESSION['username'])): ?>
            <section class="logged-in-info">
                Logget ind som <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>

                <form action="/logout" method="POST" class="logout-form" style="display:inline;">
                    <button type="submit" class="logout-button">Log ud</button>
                </form>
            </section>
        <?php endif; ?>

        <button aria-label="Toggle menu" data-menu-toggle aria-expanded="false">
            <span>Menu</span>
        </button>
    </nav>

    <aside data-mobile-menu>
        <ul>
            <?php foreach ($navLinks as $link): ?>
                <li>
                    <a href="<?= htmlspecialchars($link['href']) ?>">
                        <?= $link['label'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    </aside>
</header>
