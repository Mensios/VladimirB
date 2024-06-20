<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $db->query("SELECT * FROM services");
    $services = $stmt->fetchAll();
    echo json_encode($services);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        echo json_encode(['status' => 'error', 'message' => 'Доступ запрещен']);
        exit;
    }

    $serviceName = $_POST['serviceName'];
    $serviceDescription = $_POST['serviceDescription'];
    $servicePrice = $_POST['servicePrice'];

    $stmt = $db->prepare("INSERT INTO services (service_name, description, price) VALUES (?, ?, ?)");
    $stmt->execute([$serviceName, $serviceDescription, $servicePrice]);
    echo json_encode(['status' => 'success', 'message' => 'Услуга добавлена']);
}
?>
