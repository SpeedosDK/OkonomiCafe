<?php
require_once __DIR__ . '/../core/Database.php';

class Message {

    public static function create($name, $email, $message) {
        $db = Database::getConnection();

        $stmt = $db->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
    }

    public static function all() {
        $db = Database::getConnection();

        $stmt = $db->query("SELECT * FROM messages ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function markAsRead($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function addReply($id, $reply) {
        $db = Database::getConnection();

        $stmt = $db->prepare("UPDATE messages SET reply = ?, is_read = 1 WHERE id = ?");
        $stmt->execute([$reply, $id]);
    }

    public static function find($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function countUnread(): int {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT COUNT(*) FROM messages WHERE is_read = 0");
        return (int)$stmt->fetchColumn();
    }
}
