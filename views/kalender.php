<?php
/** @var int $year */
/** @var int $month */

require_once __DIR__ . '/../models/Shift.php';

// Sørg for at month altid er 2-cifret (01, 02, 03...)
$monthPadded = str_pad($month, 2, '0', STR_PAD_LEFT);

// Første dag i måneden
$firstDay = strtotime("$year-$monthPadded-01");

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

// Hent vagter via Shift-modellen (JOIN + GROUP_CONCAT)
$rows = Shift::getByMonth($year, $month);

// Organisér vagter efter dato
$shifts = [];
foreach ($rows as $row) {
    $shifts[$row['date']][] = [
            'names'     => $row['names'],      // "Thomas, Maria"
            'expertise' => $row['expertise']
    ];
}
?>

<main class="kalender-side">
    <h1>Kalender</h1>

    <nav class="kalender-navigation">
        <a href="/kalender?year=<?= $prevYear ?>&month=<?= $prevMonth ?>">← Forrige måned</a>
        <strong><?= $monthNames[$month] ?> <?= $year ?></strong>
        <a href="/kalender?year=<?= $nextYear ?>&month=<?= $nextMonth ?>">Næste måned →</a>
    </nav>

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

                $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day);

                $hasShifts = isset($shifts[$dateString]) ? "has-shifts" : "";
                echo "<td class='day-cell $hasShifts' data-date='$dateString'>";

                echo "<strong>$day</strong>";

                if (isset($shifts[$dateString])) {
                    foreach ($shifts[$dateString] as $shift) {
                        echo "<p class='shift'>";
                        echo "<span class='name'>{$shift['names']}</span><br>";
                        echo "<span class='expertise'>{$shift['expertise']}</span>";
                        echo "</p>";
                    }
                }

                echo "</td>";

                if ($weekday % 7 == 0) {
                    echo "</tr><tr>";
                }
            }

            // Udfyld resten af rækken
            while ($weekday % 7 !== 1) {
                echo "<td class='tom'></td>";
                $weekday++;
            }
            ?>
        </tr>
        </tbody>
    </table>

    <!-- Popup -->
    <dialog id="dayModal">
        <h2 id="modalDate"></h2>
        <section id="modalShifts"></section>
        <form method="dialog">
            <button>Luk</button>
        </form>
    </dialog>

    <script>
        document.querySelectorAll('.day-cell').forEach(cell => {
            cell.addEventListener('click', () => {
                const date = cell.dataset.date;
                const shifts = cell.querySelectorAll('.shift');

                document.getElementById('modalDate').innerText = date;

                let html = "";
                shifts.forEach(shift => {
                    const name = shift.querySelector('.name').innerText;
                    const expertise = shift.querySelector('.expertise').innerText;

                    html += "<p><strong>" + name + "</strong><br>" +
                        expertise + "</p>";
                });

                if (html === "") {
                    html = "<p>Ingen medarbejdere denne dag.</p>";
                }

                document.getElementById('modalShifts').innerHTML = html;
                document.getElementById('dayModal').showModal();
            });
        });
    </script>

</main>
