<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/Course.php';

// Kontrola, či je používateľ administrátor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Pripojenie k databáze
$db = new Database();
$conn = $db->connect();

$courseModel = new Course($conn);

// Spracovanie formulára
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vytvorenie nového kurzu
    $courseModel->create(
        $_POST['title'],
        $_POST['description'],
        (float)$_POST['price'],
        $_POST['difficulty'],
        (int)$_POST['duration_weeks']
    );

    // Presmerovanie späť do administrácie
    header('Location: admin-courses.php');
    exit;
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">

    <div class="nav">
        <a href="index.php">Domov</a>
        <a href="my-courses.php">Moje kurzy</a>
        <a href="admin-courses.php">Administrácia</a>
        <a href="logout.php">Odhlásiť sa</a>
    </div>

    <div class="hero">
        <div>
            <span class="badge">Admin</span>
            <h1>Pridať nový kurz</h1>
            <p>Vytvorenie nového tréningového programu pre používateľov.</p>
        </div>
    </div>

    <form method="POST" class="fade-up">

        <input type="text" name="title" placeholder="Názov kurzu" required>

        <textarea name="description" placeholder="Popis kurzu" required></textarea>

        <input type="number" step="0.01" name="price" placeholder="Cena (€)" required>

        <select name="difficulty" required>
            <option value="beginner">Začiatočník</option>
            <option value="intermediate">Pokročilý</option>
            <option value="advanced">Expert</option>
        </select>

        <input type="number" name="duration_weeks" placeholder="Trvanie (týždne)" required>

        <button type="submit">Pridať kurz</button>

    </form>

</div>

<script src="script.js"></script>