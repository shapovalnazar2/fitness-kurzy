<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/User.php';

// Pripojenie k databáze
$db = new Database();
$conn = $db->connect();

$userModel = new User($conn);

$message = '';

// Spracovanie registračného formulára
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vytvorenie nového používateľa
    if ($userModel->create($name, $email, $password)) {
        $message = "Registrácia úspešná! Teraz sa môžete prihlásiť.";
    } else {
        $message = "Chyba pri registrácii.";
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">

    <div class="nav">
        <a href="index.php">Domov</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="my-courses.php">Moje kurzy</a>

            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="admin-courses.php">Administrácia</a>
            <?php endif; ?>

            <a href="logout.php">Odhlásiť sa</a>
        <?php else: ?>
            <a href="login.php">Prihlásenie</a>
            <a href="register.php">Registrácia</a>
        <?php endif; ?>
    </div>

    <div class="hero">
        <div>
            <span class="badge">Nový účet</span>
            <h1>Registrácia</h1>
            <p>Vytvorte si účet a získajte prístup k nákupu fitness kurzov.</p>
        </div>
    </div>

    <form method="POST" class="fade-up">
        <input type="text" name="name" placeholder="Meno" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Heslo" required>
        <button type="submit">Registrovať</button>
    </form>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

</div>

<script src="script.js"></script>