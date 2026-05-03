<?php

// Trieda Database zabezpečuje pripojenie k databáze pomocou PDO
class Database
{
    private string $host = "localhost";
    private string $dbName = "fitness_courses";
    private string $username = "root";
    private string $password = "";

    // Metóda vytvorí a vráti PDO pripojenie
    public function connect(): PDO
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4",
                $this->username,
                $this->password
            );

            // Nastavenie zobrazovania chýb
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {
            die("Chyba pripojenia: " . $e->getMessage());
        }
    }
}