<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([currentUserId()]);
$user = $stmt->fetch();

if (!$user) {
    setFlash('error', 'Usuari no trobat.');
    redirect('index.php');
}

require __DIR__ . '/../includes/header.php';
?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Perfil d'usuari</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Nom d'usuari</th>
                        <td><?= h($user['username']) ?></td>
                    </tr>
                    <tr>
                        <th>Nom complet</th>
                        <td><?= h($user['name']) ?></td>
                    </tr>
                    <tr>
                        <th>Correu electrònic</th>
                        <td><?= h($user['email']) ?></td>
                    </tr>
                    <tr>
                        <th>Rol</th>
                        <td><?= h($user['role']) ?></td>
                    </tr>
                </table>
                <a href="index.php" class="btn btn-secondary">Tornar</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
