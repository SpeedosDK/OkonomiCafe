<?php
/** @var int $year */
/** @var int $month */

$firstDay = strtotime("$year-$month-01");
$daysInMonth = date('t', $firstDay);
$startWeekday = date('N', $firstDay);

$prevMonth = $month - 1;
$prevYear = $year;
if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }

$nextMonth = $month + 1;
$nextYear = $year;
if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }

$monthNames = [
    1 => "Januar", 2 => "Februar", 3 => "Marts", 4 => "April",
    5 => "Maj", 6 => "Juni", 7 => "Juli", 8 => "August",
    9 => "September", 10 => "Oktober", 11 => "November", 12 => "December"
];

require_once __DIR__ . '/../core/Database.php';
$db = Database::getConnection();

$stmt = $db->prepare("SELECT * FROM shifts WHERE date LIKE ?");
$stmt->execute(["$year-$month-%"]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$shifts = [];
foreach ($rows as $row) {
    $shifts[$row['date']][] = [
            'name' => $row['name'],
            'expertise' => $row['expertise']
    ];
}

?>

<main class="kalender-admin">
    <h1>Admin – Kalender</h1>

    <div class="kalender-navigation">
        <a href="/kalender-admin?year=<?= $prevYear ?>&month=<?= $prevMonth ?>">← Forrige måned</a>
        <strong><?= $monthNames[$month] ?> <?= $year ?></strong>
        <a href="/kalender-admin?year=<?= $nextYear ?>&month=<?= $nextMonth ?>">Næste måned →</a>
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
            for ($i = 1; $i < $startWeekday; $i++) {
                echo "<td class='tom'></td>";
            }

            $weekday = $startWeekday;
            for ($day = 1; $day <= $daysInMonth; $day++, $weekday++) {

                $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day);

                $hasShifts = isset($shifts[$dateString]) ? "has-shifts" : "";
                echo "<td class='day-cell $hasShifts' data-date='$dateString'>";

                echo "<strong>$day</strong>";

                if (isset($shifts[$dateString])) {
                    foreach ($shifts[$dateString] as $shift) {
                        echo "<p class='shift'>";
                        echo "<span class='name'>{$shift['name']}</span><br>";
                        echo "<span class='expertise'>{$shift['expertise']}</span>";
                        echo "</p>";
                    }
                }

                echo "</td>";

                if ($weekday % 7 == 0) {
                    echo "</tr><tr>";
                }
            }

            while ($weekday % 7 != 1) {
                echo "<td class='tom'></td>";
                $weekday++;
            }
            ?>
        </tr>
        </tbody>
    </table>

    <!-- Admin popup -->
    <dialog id="adminModal">
        <h2 id="adminModalDate"></h2>

        <form method="POST" action="/kalender-admin">
            <input type="hidden" name="date" id="adminDate">

            <label>Navn</label>
            <input type="text" name="name" required>

            <label>Ekspertise</label>
            <input type="text" name="expertise" required>

            <button type="submit">Gem</button>
            <button type="button" onclick="document.getElementById('adminModal').close()">Luk</button>
        </form>
    </dialog>

    <script>
        document.querySelectorAll('.day-cell').forEach(cell => {
            cell.addEventListener('click', () => {
                const date = cell.dataset.date;

                document.getElementById('adminModalDate').innerText = "Tilføj medarbejder: " + date;
                document.getElementById('adminDate').value = date;

                document.getElementById('adminModal').showModal();
            });
        });
    </script>

</main>
