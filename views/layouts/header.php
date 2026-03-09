<?php
$navLinks = [
    ["label" => "Sådan virker det", "href" => "#saadan-virker-det"],
    ["label" => "For dig", "href" => "#for-dig"],
    ["label" => "Bliv frivillig", "href" => "#frivillig"],
    ["label" => "Kontakt", "href" => "#kontakt"],
];
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <title>Min Side</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<header>
    <nav>
        <a href="/">Økonomi-Caféen</a>

        <!-- Desktop nav -->
        <ul>
            <?php foreach ($navLinks as $link): ?>
                <li><a href="<?= htmlspecialchars($link['href']) ?>"><?= htmlspecialchars($link['label']) ?></a></li>
            <?php endforeach; ?>
            <li><button>Få hjælp</button></li>
        </ul>

        <!-- Mobile toggle -->
        <button aria-label="Toggle menu" data-menu-toggle>
            <span>Menu</span>
        </button>
    </nav>

    <!-- Mobile menu -->
    <aside data-mobile-menu style="display: none;">
        <ul>
            <?php foreach ($navLinks as $link): ?>
                <li><a href="<?= htmlspecialchars($link['href']) ?>"><?= htmlspecialchars($link['label']) ?></a></li>
            <?php endforeach; ?>
            <li><button>Få hjælp</button></li>
        </ul>
    </aside>
</header>

<script src="/js/mobileHeader.js"></script>




