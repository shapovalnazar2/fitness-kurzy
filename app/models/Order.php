<?php

// Trieda Order zabezpečuje nákup kurzov a prácu s tabuľkou orders
class Order
{
    private PDO $conn;

    // Konštruktor prijíma pripojenie k databáze
    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Vytvorí záznam o zakúpení kurzu používateľom
    public function buyCourse(int $userId, int $courseId): bool
    {
        // INSERT IGNORE zabráni duplikácii (rovnaký kurz kúpený viackrát)
        $sql = "INSERT IGNORE INTO orders (user_id, course_id) 
                VALUES (:user_id, :course_id)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'user_id' => $userId,
            'course_id' => $courseId
        ]);
    }

    // Získa všetky kurzy zakúpené konkrétnym používateľom
    public function getUserCourses(int $userId): array
    {
        $sql = "SELECT courses.*
                FROM orders
                JOIN courses ON orders.course_id = courses.id
                WHERE orders.user_id = :user_id
                ORDER BY orders.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}