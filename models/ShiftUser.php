<?php
require_once __DIR__ . '/../core/Database.php';

class ShiftUser
{
    public static function assign(int $shiftId, int $userId): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO shift_user (shift_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$shiftId, $userId]);
    }

    public static function deleteAllForShift(int $shiftId): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM shift_user WHERE shift_id = ?");
        return $stmt->execute([$shiftId]);
    }

    public static function getUsersForShift(int $shiftId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT users.id, users.username
            FROM shift_user
            JOIN users ON users.id = shift_user.user_id
            WHERE shift_user.shift_id = ?
        ");
        $stmt->execute([$shiftId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
