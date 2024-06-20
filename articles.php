<?php
require 'config.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && !empty($_POST['action'])) {
            $action = $_POST['action'];

            if ($action === 'add') {
                $title = $_POST['articleTitle'];
                $content = $_POST['articleContent'];
                $author = $_POST['articleAuthor'];
                $image_path = '';

                if (isset($_FILES['articleImage']) && $_FILES['articleImage']['error'] === UPLOAD_ERR_OK) {
                    $image_path = 'images/' . basename($_FILES['articleImage']['name']);
                    move_uploaded_file($_FILES['articleImage']['tmp_name'], $image_path);
                }

                $query = $pdo->prepare('INSERT INTO articles (title, content, author, image_path) VALUES (?, ?, ?, ?)');
                if ($query->execute([$title, $content, $author, $image_path])) {
                    echo json_encode(['status' => 'success', 'message' => 'Статья добавлена успешно']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Ошибка добавления статьи']);
                }
            } else {
                throw new Exception('Invalid action');
            }
        } else {
            throw new Exception('Action not set in POST request');
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['action']) && !empty($_GET['action'])) {
            $action = $_GET['action'];

            if ($action === 'list') {
                $query = $pdo->query('SELECT * FROM articles ORDER BY created_at DESC');
                $articles = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($articles as &$article) {
                    $article['short_description'] = mb_substr(strip_tags($article['content']), 0, 150) . '...';
                }
                echo json_encode($articles);
            } elseif ($action === 'view' && isset($_GET['id'])) {
                $id = $_GET['id'];
                $query = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
                $query->execute([$id]);
                $article = $query->fetch(PDO::FETCH_ASSOC);
                echo json_encode($article);
            } else {
                throw new Exception('Invalid action in GET request');
            }
        } else {
            throw new Exception('Action not set in GET request');
        }
    } else {
        throw new Exception('Invalid request method');
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
