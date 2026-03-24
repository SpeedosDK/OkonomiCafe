<?php
/** @var array $data */
/** @var int $year */
/** @var int $month */
// Første dag i måneden
$firstDay = strtotime("$year-$month-01");

// Hvor mange dage er der i måneden?
$daysInMonth = date('t', $firstDay);

// Hvilken ugedag starter måneden på? (1 = mandag)
$startWeekday = date('N', $firstDay);

// Beregn næste og forrige måned
$prevMonth = $month - 1;
$prevYear = $year;
if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }

$nextMonth = $month + 1;
$nextYear = $year;
if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }

// Navne på måneder
$monthNames = [
    1 => "Januar", 2 => "Februar", 3 => "Marts", 4 => "April",
    5 => "Maj", 6 => "Juni", 7 => "Juli", 8 => "August",
    9 => "September", 10 => "Oktober", 11 => "November", 12 => "December"
];
?>

<main class="kalender-side">
    <h1>Kalender</h1>

    <div class="kalender-navigation">
        <a href="/kalender?year=<?= $prevYear ?>&month=<?= $prevMonth ?>">← Forrige måned</a>
        <strong><?= $monthNames[$month] ?> <?= $year ?></strong>
        <a href="/kalender?year=<?= $nextYear ?>&month=<?= $nextMonth ?>">Næste måned →</a>
    </div>

    <table class="kalender-tabel">
        <thead>
        <tr>
            <th>Man</th>
            <th>Tir</th>
            <th>Ons</th>
            <th>Tor</th>
            <th>Fre</th>
            <th>Lør</th>
            <th>Søn</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            // Tomme felter før månedens start
            for ($i = 1; $i < $startWeekday; $i++) {
                echo "<td class='tom'></td>";
            }

            // Dage i måneden
            $weekday = $startWeekday;
            for ($day = 1; $day <= $daysInMonth; $day++, $weekday++) {

                echo "<td>$day</td>";

                // Ny række hver søndag
                if ($weekday % 7 == 0) {
                    echo "</tr><tr>";
                }
            }

            // Fyld resten af rækken med tomme felter
            while ($weekday % 7 != 1) {
                echo "<td class='tom'></td>";
                $weekday++;
            }
            ?>
        </tr>
        </tbody>
    </table>
</main>
