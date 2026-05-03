<?php
session_start();

// Zapnutie zobrazovania chýb počas vývoja
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../app/core/Database.php';
require_once '../app/models/Course.php';

// Pripojenie k databáze
$database = new Database();
$connection = $database->connect();

// Načítanie všetkých kurzov
$courseModel = new Course($connection);
$courses = $courseModel->getAll();

// Filtrovanie kurzov podľa náročnosti
$difficulty = $_GET['difficulty'] ?? '';

if ($difficulty !== '') {
    $courses = array_filter($courses, function ($course) use ($difficulty) {
        return $course['difficulty'] === $difficulty;
    });
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">

    <div class="hero">
        <div>
            <span class="badge">Online fitness platforma</span>
            <h1>Fitness Kurzy Trénera</h1>
            <p>
                Profesionálne tréningové programy pre silu, chudnutie a celkovú premenu postavy.
                Vyberte si kurz, ktorý vám pomôže dosiahnuť vaše fitness ciele.
            </p>
            <a href="#kurzy">Zobraziť kurzy</a>
        </div>
    </div>

    <div class="nav">
        <a href="index.php">Domov</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="my-courses.php">Moje kurzy</a>

            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="admin-courses.php">Administrácia</a>
            <?php endif; ?>

            <a href="logout.php">Odhlásiť sa</a>
        <?php else: ?>
            <a href="register.php">Registrácia</a>
            <a href="login.php">Prihlásenie</a>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Prihlásený používateľ: <?= htmlspecialchars($_SESSION['user_name']) ?></p>
    <?php endif; ?>

    <div class="section about-section fade-up">
        <div>
            <h2>O trénerovi</h2>
            <p>
                Som osobný fitness tréner so zameraním na silový tréning a zdravý životný štýl
            </p>
            <div class="info-box">
                <p>- viac ako 3 roky skúseností vo fitness</p>
                <p>- aktívny športovec od 6 rokov</p>
                <p>- individuálny prístup ku každému klientovi</p>
            </div>
        </div>

        <img class="trainer-photo" src="images/trainer.jpg" alt="Fitness tréner">
    </div>

    <div class="section fade-up">
        <h2>Prečo si vybrať moje kurzy?</h2>

        <div class="info-box">
            <p>- tréningové plány pre rôzne úrovne</p>
            <p>- jasná štruktúra kurzov</p>
            <p>- možnosť zakúpiť kurz po prihlásení</p>
            <p>- vlastný profil so zoznamom zakúpených kurzov</p>
        </div>
    </div>

    <div class="section fade-up">
        <h2>Moje portfólio</h2>

        <div class="portfolio-grid">
            <div class="portfolio-card">
                <img src="images/gym.jpg" alt="Silový tréning">
                <h3>Silový tréning</h3>
                <p>Tvorba tréningových plánov pre naberanie svalovej hmoty.</p>
            </div>

            <div class="portfolio-card">
                <img src="images/workout.jpg" alt="Chudnutie">
                <h3>Chudnutie</h3>
                <p>Programy zamerané na spaľovanie tuku a zlepšenie kondície.</p>
            </div>

            <div class="portfolio-card">
                <img src="images/me.PNG" alt="Individuálny prístup">
                <h3>Individuálny prístup</h3>
                <p>Kurzy prispôsobené rôznym úrovniam začiatočníkov aj pokročilých.</p>
            </div>
        </div>
    </div>

    <h2 id="kurzy">Dostupné kurzy</h2>

    <form method="GET" class="filter-form">
        <select name="difficulty">
            <option value="">Všetky kurzy</option>
            <option value="beginner" <?= $difficulty === 'beginner' ? 'selected' : '' ?>>Začiatočník</option>
            <option value="intermediate" <?= $difficulty === 'intermediate' ? 'selected' : '' ?>>Pokročilý</option>
            <option value="advanced" <?= $difficulty === 'advanced' ? 'selected' : '' ?>>Expert</option>
        </select>

        <button type="submit">Filtrovať</button>
    </form>

    <div class="course-grid">
        <?php foreach ($courses as $course): ?>
            <div class="course-card fade-up">
                <span class="badge"><?= htmlspecialchars($course['difficulty']) ?></span>

                <h2><?= htmlspecialchars($course['title']) ?></h2>
                <p><?= htmlspecialchars($course['description']) ?></p>
                <p><strong>Cena:</strong> <?= htmlspecialchars($course['price']) ?> €</p>
                <p><strong>Trvanie:</strong> <?= htmlspecialchars($course['duration_weeks']) ?> týždňov</p>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="buy.php?course_id=<?= $course['id'] ?>">Kúpiť kurz</a>
                <?php else: ?>
                    <a href="login.php">Prihláste sa pre kúpu kurzu</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script src="script.js"></script>