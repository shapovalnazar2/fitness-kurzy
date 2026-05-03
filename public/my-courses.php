<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/Order.php';

// Kontrola, či je používateľ prihlásený
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Pripojenie k databáze
$db = new Database();
$conn = $db->connect();

// Načítanie kurzov zakúpených používateľom
$orderModel = new Order($conn);
$courses = $orderModel->getUserCourses((int)$_SESSION['user_id']);
?>

<link rel="stylesheet" href="style.css">

<div class="container">

    <div class="nav">
        <a href="index.php">Domov</a>
        <a href="my-courses.php">Moje kurzy</a>

        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <a href="admin-courses.php">Administrácia</a>
        <?php endif; ?>

        <a href="logout.php">Odhlásiť sa</a>
    </div>

    <div class="hero">
        <div>
            <span class="badge">Používateľ</span>
            <h1>Moje kurzy</h1>
            <p>Zoznam všetkých kurzov, ktoré ste si zakúpili.</p>
        </div>
    </div>

    <?php if (empty($courses)): ?>
        <p style="margin-top:20px;">Zatiaľ nemáte zakúpený žiadny kurz.</p>
    <?php endif; ?>

    <div class="course-grid">
        <?php foreach ($courses as $course): ?>
            <div class="course-card fade-up">
                <span class="badge"><?= htmlspecialchars($course['difficulty']) ?></span>

                <h2><?= htmlspecialchars($course['title']) ?></h2>
                <p><?= htmlspecialchars($course['description']) ?></p>
                <p><strong>Cena:</strong> <?= htmlspecialchars($course['price']) ?> €</p>
                <p><strong>Trvanie:</strong> <?= htmlspecialchars($course['duration_weeks']) ?> týždňov</p>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script src="script.js"></script>