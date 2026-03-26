<?php
/** @var int $year */
/** @var int $month */

// Sørg for at month altid er 2-cifret
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

// Hent vagter fra databasen (via model)
require_once __DIR__ . '/../models/Shift.php';
$rows = Shift::getByMonth($year, $month);

// Organisér vagter efter dato
$shifts = [];
foreach ($rows as $row) {
    $shifts[$row['date']][] = [
            'id'        => $row['id'],
            'name'      => $row['name'],
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
                        echo "<span class='name'>{$shift['name']}</span><br>";
                        echo "<span class='expertise'>{$shift['expertise']}</span><br>";

                        // Rediger-knap
                        echo "<button 
                                type='button'
                                class='edit-btn'
                                data-id='{$shift['id']}'
                                data-name='" . htmlspecialchars($shift['name'], ENT_QUOTES) . "'
                                data-expertise='" . htmlspecialchars($shift['expertise'], ENT_QUOTES) . "'
                                data-date='{$dateString}'>
                                Rediger
                              </button>";

                        // Slet-knap
                        echo "<form method='POST' action='/delete-shift' style='display:inline'>
                                <input type='hidden' name='id' value='{$shift['id']}'>
                                <button type='submit' class='delete-btn'>Slet</button>
                              </form>";

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

    <!-- Admin popup: Opret vagt -->
    <dialog id="adminModal">
        <h2 id="adminModalDate"></h2>

        <form method="POST" action="/save-shift">
            <input type="hidden" name="date" id="adminDate">

            <label>Navn</label>
            <input type="text" name="name" required>

            <label>Ekspertise</label>
            <input type="text" name="expertise" required>

            <button type="submit">Gem</button>
            <button type="button" onclick="document.getElementById('adminModal').close()">Luk</button>
        </form>
    </dialog>

    <!-- Admin popup: Rediger vagt -->
    <dialog id="editModal">
        <h2>Rediger vagt</h2>

        <form method="POST" action="/update-shift">
            <input type="hidden" name="id" id="editId">

            <label>Navn</label>
            <input type="text" name="name" id="editName" required>

            <label>Ekspertise</label>
            <input type="text" name="expertise" id="editExpertise" required>

            <button type="submit">Gem ændringer</button>
            <button type="button" onclick="document.getElementById('editModal').close()">Luk</button>
        </form>
    </dialog>

    <script>
        // Klik på dag -> opret vagt
        document.querySelectorAll('.day-cell').forEach(cell => {
            cell.addEventListener('click', (e) => {
                // Undgå at klik på rediger/slet åbner "opret"-modal
                if (e.target.closest('button') || e.target.closest('form')) return;

                const date = cell.dataset.date;

                document.getElementById('adminModalDate').innerText = "Tilføj medarbejder: " + date;
                document.getElementById('adminDate').value = date;

                document.getElementById('adminModal').showModal();
            });
        });

        // Klik på rediger-knap -> rediger vagt
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('editId').value = btn.dataset.id;
                document.getElementById('editName').value = btn.dataset.name;
                document.getElementById('editExpertise').value = btn.dataset.expertise;

                document.getElementById('editModal').showModal();
            });
        });
    </script>

</main>
