<?php
require_once __DIR__ . '/../core/Database.php';

class Shift
{
    public static function getByMonth(int $year, int $month): array {
        $db = Database::getConnection();
        $monthPadded = str_pad($month, 2, '0', STR_PAD_LEFT);

        $stmt = $db->prepare("SELECT * FROM shifts WHERE date LIKE ?");
        $stmt->execute(["$year-$monthPadded-%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $date, string $name, string $expertise): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO shifts (date, name, expertise) VALUES (?, ?, ?)");
        return $stmt->execute([$date, $name, $expertise]);
    }

    public static function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM shifts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function update(int $id, string $name, string $expertise): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE shifts SET name = ?, expertise = ? WHERE id = ?");
        return $stmt->execute([$name, $expertise, $id]);
    }
}
