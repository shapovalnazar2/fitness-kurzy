<?php

session_start();

require_once '../app/core/Database.php';
require_once '../app/models/Course.php';

// Kontrola, či je používateľ prihlásený ako administrátor
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

// Vymazanie kurzu podľa ID
$courseModel = new Course($conn);
$courseModel->delete((int)$_GET['id']);

// Presmerovanie späť do administrácie
header('Location: admin-courses.php');
exit;