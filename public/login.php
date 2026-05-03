<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/User.php';

// Pripojenie k databáze
$db = new Database();
$conn = $db->connect();

$userModel = new User($conn);

$message = '';

// Spracovanie formulára po odoslaní
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Získanie údajov z formulára
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vyhľadanie používateľa podľa emailu
    $user = $userModel->findByEmail($email);

    // Overenie hesla pomocou password_verify
    if ($user && password_verify($password, $user['password'])) {

        // Uloženie údajov do session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        header('Location: index.php');
        exit;
    } else {
        $message = "Nesprávny email alebo heslo.";
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
            <span class="badge">Prihlásenie</span>
            <h1>Prihlásiť sa</h1>
            <p>Zadajte svoje prihlasovacie údaje pre prístup ku kurzom.</p>
        </div>
    </div>

    <form method="POST" class="fade-up">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Heslo" required>

        <button type="submit">Prihlásiť sa</button>

    </form>

    <?php if ($message): ?>
        <p style="color:#f87171; margin-top:15px;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

</div>

<script src="script.js"></script>