<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/Order.php';

// Kontrola, či je používateľ prihlásený
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Kontrola, či je odoslané ID kurzu
if (!isset($_GET['course_id'])) {
    header('Location: index.php');
    exit;
}

// Pripojenie k databáze
$db = new Database();
$conn = $db->connect();

// Vytvorenie objednávky (zakúpenie kurzu)
$orderModel = new Order($conn);
$orderModel->buyCourse(
    (int)$_SESSION['user_id'],
    (int)$_GET['course_id']
);

// Presmerovanie na stránku "Moje kurzy"
header('Location: my-courses.php');
exit;