<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();

if (isAuthenticated()) {
    redirect('index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Tots els camps són obligatoris.';
    } elseif (login($username, $password)) {
        setFlash('success', 'Has iniciat sessió correctament.');
        redirect('index.php');
    } else {
        $error = 'Usuari o contrasenya incorrectes.';
    }
}

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici de sessió - <?= h(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="card-title text-center mb-4"><?= h(APP_NAME) ?></h1>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= h($error) ?></div>
                        <?php endif; ?>
                        <form method="post">
                            <?= csrfField() ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuari</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= h($username ?? '') ?>" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contrasenya</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                        <p class="text-center text-muted mt-3 small">
                            Usuaris de prova: admin / alice / bob / carol / david / eva<br>
                            Contrasenya: 1234
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
