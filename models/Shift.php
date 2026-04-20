<?php
require_once __DIR__ . '/../core/Database.php';

class Shift
{
    public static function getByMonth(int $year, int $month): array {
        $db = Database::getConnection();
        $monthPadded = str_pad($month, 2, '0', STR_PAD_LEFT);

        $stmt = $db->prepare("
            SELECT 
                shifts.id,
                shifts.date,
                shifts.expertise,
                GROUP_CONCAT(users.username SEPARATOR ', ') AS names,
                GROUP_CONCAT(users.id SEPARATOR ',') AS user_ids
            FROM shifts
            LEFT JOIN shift_user ON shift_user.shift_id = shifts.id
            LEFT JOIN users ON users.id = shift_user.user_id
            WHERE shifts.date LIKE ?
            GROUP BY shifts.id
            ORDER BY shifts.date
        ");

        $stmt->execute(["$year-$monthPadded-%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $date, string $expertise): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO shifts (date, expertise) VALUES (?, ?)");
        $stmt->execute([$date, $expertise]);
        return $db->lastInsertId();
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM shifts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function update(int $id, string $expertise): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE shifts SET expertise = ? WHERE id = ?");
        return $stmt->execute([$expertise, $id]);
    }
}
