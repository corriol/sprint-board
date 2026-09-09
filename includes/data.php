<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

function loadData(): array
{
    $contents = file_get_contents(DATA_PATH);

    if ($contents === false) {
        throw new RuntimeException('No s’han pogut llegir les dades de l’aplicació.');
    }

    $data = json_decode($contents, true);
    if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException('El fitxer de dades no té un format JSON vàlid.');
    }

    return $data;
}

function saveData(array $data): bool
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false || file_put_contents(DATA_PATH, $json, LOCK_EX) === false) {
        return false;
    }

    return true;
}

function findRecord(array $records, int $id): ?array
{
    foreach ($records as $record) {
        if ((int) ($record['id'] ?? 0) === $id) {
            return $record;
        }
    }
    return null;
}

function recordName(array $records, ?int $id, string $fallback): string
{
    $record = $id === null ? null : findRecord($records, $id);
    return $record['name'] ?? $fallback;
}
