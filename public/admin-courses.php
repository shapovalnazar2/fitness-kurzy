<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/Course.php';

// Kontrola, či je používateľ prihlásený ako administrátor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Pripojenie k databáze
$db = new Database();
$conn = $db->connect();

// Načítanie všetkých kurzov pre administráciu
$courseModel = new Course($conn);
$courses = $courseModel->getAll();
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
            <span class="badge">Admin panel</span>
            <h1>Administrácia kurzov</h1>
            <p>Správa tréningových kurzov – pridávanie, úprava a vymazanie kurzov.</p>
            <a href="create-course.php">Pridať kurz</a>
        </div>
    </div>

    <div class="course-grid">
        <?php foreach ($courses as $course): ?>
            <div class="course-card fade-up">
                <span class="badge"><?= htmlspecialchars($course['difficulty']) ?></span>

                <h2><?= htmlspecialchars($course['title']) ?></h2>
                <p><?= htmlspecialchars($course['description']) ?></p>
                <p><strong>Cena:</strong> <?= htmlspecialchars($course['price']) ?> €</p>
                <p><strong>Trvanie:</strong> <?= htmlspecialchars($course['duration_weeks']) ?> týždňov</p>

                <a href="edit-course.php?id=<?= $course['id'] ?>">Upraviť</a>
                <a href="delete-course.php?id=<?= $course['id'] ?>" onclick="return confirm('Naozaj chcete vymazať tento kurz?')">
                    Vymazať
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script src="script.js"></script>