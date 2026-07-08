<?php

require_once __DIR__ . '/../config/config.php';

function getDB(): PDO {
    static $db = null;
    if ($db === null) {
        $dbDir = dirname(DB_PATH);
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0755, true);
        }
        $db = new PDO('sqlite:' . DB_PATH, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        $db->exec('PRAGMA journal_mode=WAL');
        $db->exec('PRAGMA foreign_keys=ON');
    }
    return $db;
}

function initDB(): void {
    $db = getDB();
    $schema = file_get_contents(__DIR__ . '/../sql/schema.sql');
    $db->exec($schema);

    $count = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($count == 0) {
        $seed = file_get_contents(__DIR__ . '/../sql/seed.sql');
        $db->exec($seed);
    }
}
