<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/Course.php';

// Kontrola, či je používateľ administrátor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Kontrola, či bolo odoslané ID kurzu
if (!isset($_GET['id'])) {
    header('Location: admin-courses.php');
    exit;
}

// Pripojenie k databáze
$db = new Database();
$conn = $db->connect();

$courseModel = new Course($conn);

// Načítanie konkrétneho kurzu podľa ID
$course = $courseModel->find((int)$_GET['id']);

if (!$course) {
    header('Location: admin-courses.php');
    exit;
}

// Spracovanie formulára po odoslaní
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseModel->update(
        (int)$_GET['id'],
        $_POST['title'],
        $_POST['description'],
        (float)$_POST['price'],
        $_POST['difficulty'],
        (int)$_POST['duration_weeks']
    );

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
            <h1>Upraviť kurz</h1>
            <p>Úprava existujúceho tréningového programu.</p>
        </div>
    </div>

    <form method="POST" class="fade-up">
        <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" required>

        <textarea name="description" required><?= htmlspecialchars($course['description']) ?></textarea>

        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($course['price']) ?>" required>

        <select name="difficulty" required>
            <option value="beginner" <?= $course['difficulty'] === 'beginner' ? 'selected' : '' ?>>Začiatočník</option>
            <option value="intermediate" <?= $course['difficulty'] === 'intermediate' ? 'selected' : '' ?>>Pokročilý</option>
            <option value="advanced" <?= $course['difficulty'] === 'advanced' ? 'selected' : '' ?>>Expert</option>
        </select>

        <input type="number" name="duration_weeks" value="<?= htmlspecialchars($course['duration_weeks']) ?>" required>

        <button type="submit">Uložiť zmeny</button>
    </form>

</div>

<script src="script.js"></script>