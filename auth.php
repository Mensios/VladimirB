<?php
header('Content-Type: application/json');
require 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Метод не разрешен']);
    exit;
}

$action = $_POST['action'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($action === 'register') {
    $query = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $query->execute([$email]);
    if ($query->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Электронная почта уже зарегистрирована']);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $role = 'user'; // Default role
    $query = $pdo->prepare('INSERT INTO users (email, password, role) VALUES (?, ?, ?)');
    if ($query->execute([$email, $hashedPassword, $role])) {
        echo json_encode(['status' => 'success', 'message' => 'Регистрация прошла успешно']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка регистрации']);
    }
} elseif ($action === 'login') {
    $query = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $query->execute([$email]);
    if ($query->rowCount() === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Неверная электронная почта или пароль']);
        exit;
    }

    $user = $query->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['email'];
        $_SESSION['role'] = $user['role']; // Save the user role
        echo json_encode(['status' => 'success', 'message' => 'Вход выполнен успешно']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Неверная электронная почта или пароль']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Неверное действие']);
}
?>
