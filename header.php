<?php
session_start();
?>
<header>
    <h1>Стоматологическая клиника</h1>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="services.php">Услуги</a></li>
            <li><a href="about.php">О нас</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <li><a href="dashboard.php">Личный кабинет</a></li>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') { ?>
                <li><a href="admin.php">Админ</a></li>
            <?php } ?>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <li><a href="logout.php">Выход</a></li>
            <?php } else { ?>
                <li><a href="#auth-forms">Вход/Регистрация</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>
