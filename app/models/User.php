<?php

// Trieda User zabezpečuje prácu s tabuľkou users (registrácia a prihlásenie)
class User
{
    private PDO $conn;

    // Konštruktor prijíma pripojenie k databáze
    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Vytvorí nového používateľa (registrácia)
    public function create(string $name, string $email, string $password): bool
    {
        $sql = "INSERT INTO users (name, email, password) 
                VALUES (:name, :email, :password)";

        $stmt = $this->conn->prepare($sql);

        // Hashovanie hesla pre bezpečné uloženie
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    // Nájde používateľa podľa emailu (používa sa pri prihlásení)
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}