<?php

function login(string $username, string $password): bool {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        return true;
    }
    return false;
}

function logout(): void {
    $_SESSION = [];
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    session_destroy();
}

function isAuthenticated(): bool {
    return isset($_SESSION['user_id']);
}

function requireAuth(): void {
    if (!isAuthenticated()) {
        setFlash('error', 'Cal iniciar sessió per accedir a esta pàgina.');
        header('Location: login.php');
        exit;
    }
}

function currentUserId(): ?int {
    return $_SESSION['user_id'] ?? null;
}

function currentUserName(): ?string {
    return $_SESSION['user_name'] ?? null;
}

function currentUserRole(): ?string {
    return $_SESSION['user_role'] ?? null;
}

function isTeacher(): bool {
    return ($_SESSION['user_role'] ?? '') === 'teacher';
}
