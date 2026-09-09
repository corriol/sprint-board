<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validCsrf()) {
    http_response_code(400);
    exit('La petició per tancar la sessió no és vàlida.');
}

$_SESSION = [];
session_destroy();
redirect('login.php');
