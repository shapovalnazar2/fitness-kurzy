<?php

// Trieda Course zabezpečuje prácu s tabuľkou courses v databáze
class Course
{
    private PDO $conn;

    // Konštruktor prijíma PDO pripojenie k databáze
    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Získa všetky kurzy z databázy
    public function getAll(): array
    {
        $sql = "SELECT * FROM courses ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nájde jeden kurz podľa jeho ID
    public function find(int $id)
    {
        $sql = "SELECT * FROM courses WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vytvorí nový kurz
    public function create(string $title, string $description, float $price, string $difficulty, int $durationWeeks): bool
    {
        $sql = "INSERT INTO courses (title, description, price, difficulty, duration_weeks)
                VALUES (:title, :description, :price, :difficulty, :duration_weeks)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'difficulty' => $difficulty,
            'duration_weeks' => $durationWeeks
        ]);
    }

    // Aktualizuje existujúci kurz podľa ID
    public function update(int $id, string $title, string $description, float $price, string $difficulty, int $durationWeeks): bool
    {
        $sql = "UPDATE courses 
                SET title = :title, 
                    description = :description, 
                    price = :price, 
                    difficulty = :difficulty, 
                    duration_weeks = :duration_weeks
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'difficulty' => $difficulty,
            'duration_weeks' => $durationWeeks
        ]);
    }

    // Vymaže kurz podľa ID
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}