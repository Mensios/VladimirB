<?php
$host = 'localhost'; // или 127.0.0.1
$db   = 'stolmach'; // название вашей базы данных
$user = 'root'; // имя пользователя базы данных
$pass = ''; // пароль пользователя базы данных
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connection successful!";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>
