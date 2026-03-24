<?php
$navLinks = [
        ["label" => "Sådan virker det", "href" => "/saadan-virker-det"],
        ["label" => "For dig", "href" => "/for-dig"],
        ["label" => "Se kalender", "href" => "/kalender"],
        ["label" => "Bliv frivillig", "href" => "frivillig"],
        ["label" => "Kontakt", "href" => "/kontakt"],
];
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <title>Økonomi-Caféen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">

</head>

<body>
<header>
    <nav>
        <a href="/">Økonomi-Caféen</a>

        <ul>
            <?php foreach ($navLinks as $link): ?>
                <li><a href="<?= htmlspecialchars($link['href']) ?>"><?= htmlspecialchars($link['label']) ?></a></li>
            <?php endforeach; ?>
            <li><button>Få hjælp</button></li>
        </ul>

        <button aria-label="Toggle menu" data-menu-toggle aria-expanded="false">
            <span>Menu</span>
        </button>
    </nav>

    <aside data-mobile-menu>
        <ul>
            <?php foreach ($navLinks as $link): ?>
                <li><a href="<?= htmlspecialchars($link['href']) ?>"><?= htmlspecialchars($link['label']) ?></a></li>
            <?php endforeach; ?>
            <li><button>Få hjælp</button></li>
        </ul>
    </aside>
</header>
