<?php

session_start();

// Zrušenie všetkých session premenných
$_SESSION = [];

// Zničenie session (odhlásenie používateľa)
session_destroy();

// Presmerovanie na hlavnú stránku
header('Location: index.php');
exit;