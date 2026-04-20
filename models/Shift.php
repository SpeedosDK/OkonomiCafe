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
                shifts.user_id,
                users.username AS name
            FROM shifts
            JOIN users ON users.id = shifts.user_id
            WHERE shifts.date LIKE ?
            ORDER BY shifts.date
        ");

        $stmt->execute(["$year-$monthPadded-%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $date, int $user_id, string $expertise): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO shifts (date, user_id, expertise)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$date, $user_id, $expertise]);
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM shifts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function update(int $id, int $user_id, string $expertise): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            UPDATE shifts 
            SET user_id = ?, expertise = ?
            WHERE id = ?
        ");
        return $stmt->execute([$user_id, $expertise, $id]);
    }
}
