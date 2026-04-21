<?php
require_once __DIR__ . '/../core/Database.php';

class User {

    public static function findByUsername(string $username): ?array {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    // Bruges til kalender-admin dropdown
    public static function getAll(): array {
        $db = Database::getConnection();

        $stmt = $db->query("SELECT id, username FROM users ORDER BY username");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Bruges hvis du senere vil hente en specifik bruger
    public static function getById(int $id): ?array {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT id, username FROM users WHERE id = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
