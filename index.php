<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Стоматологическая клиника</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
</head>
<body>
    <header>
        <h1>Добро пожаловать в нашу стоматологическую клинику</h1>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="services.html">Услуги</a></li>
                <li><a href="about.html">О нас</a></li>
                <li><a href="contacts.html">Контакты</a></li>
                <li><a href="dashboard.html">Личный кабинет</a></li>
                <?php
                if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
                    echo '<li><a href="admin.html">Админ</a></li>';
                }
                ?>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li><a href="logout.php">Выход</a></li>';
                } else {
                    echo '<li><a href="#auth-forms">Вход/Регистрация</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <main>
        <section class="slider">
            <div><img src="images/clinic.jpg" alt="Стоматологическая клиника"></div>
            <div><img src="images/service1.jpg" alt="Отбеливание зубов"></div>
            <div><img src="images/service2.jpg" alt="Дентальные имплантаты"></div>
        </section>

        <section class="hero fade-in-up">
            <h2>Добро пожаловать в нашу стоматологическую клинику</h2>
            <p>Ваша улыбка - наш приоритет. Мы предлагаем широкий спектр стоматологических услуг, чтобы удовлетворить ваши потребности.</p>
            <button class="appointment-btn">Записаться на прием</button>
        </section>

        <section class="testimonials fade-in-up">
            <h2>Отзывы наших пациентов</h2>
            <div class="testimonial">
                <img src="images/patient1.jpg" alt="Пациент 1">
                <h3>Джон Доу</h3>
                <p>"Лучшая стоматологическая клиника, в которой я когда-либо был! Очень рекомендую."</p>
            </div>
            <div class="testimonial">
                <img src="images/patient2.jpg" alt="Пациент 2">
                <h3>Джейн Смит</h3>
                <p>"Профессиональный и дружелюбный персонал. Отличные услуги."</p>
            </div>
        </section>

        <section class="team">
            <h2>Наша команда</h2>
            <div class="team-member">
                <img src="images/doctor1.jpg" alt="Доктор Джон Доу">
                <h3>Доктор Джон Доу</h3>
                <p>Главный стоматолог</p>
            </div>
            <div class="team-member">
                <img src="images/doctor2.jpg" alt="Доктор Джейн Смит">
                <h3>Доктор Джейн Смит</h3>
                <p>Ортодонт</p>
            </div>
        </section>

        <section id="auth-forms">
            <div>
                <h2>Вход</h2>
                <form id="loginForm">
                    <label for="loginEmail">Электронная почта:</label>
                    <input type="email" id="loginEmail" name="email" required>
                    <label for="loginPassword">Пароль:</label>
                    <input type="password" id="loginPassword" name="password" required>
                    <label for="loginRemember">Запомнить меня</label>
                    <input type="checkbox" id="loginRemember" name="remember">
                    <button type="submit">Войти</button>
                </form>
            </div>

            <div>
                <h2>Регистрация</h2>
                <form id="registerForm">
                    <label for="registerEmail">Электронная почта:</label>
                    <input type="email" id="registerEmail" name="email" required>
                    <label for="registerPassword">Пароль:</label>
                    <input type="password" id="registerPassword" name="password" required>
                    <label for="registerConfirmPassword">Подтвердите пароль:</label>
                    <input type="password" id="registerConfirmPassword" name="confirm_password" required>
                    <button type="submit">Зарегистрироваться</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>Свяжитесь с нами: 123-456-7890 | email@example.com</p>
        <p>&copy; 2024 Стоматологическая клиника. Все права защищены.</p>
    </footer>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="scripts.js"></script>
    <script>
        $(document).ready(function(){
            $('.slider').slick({
                dots: true,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear'
            });
        });
    </script>
</body>
</html>
