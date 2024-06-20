<?php

session_start();

  require_once('db.php');
   if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['confirm']) and !empty($_POST['email'])) {
        $login = $_POST['login'];
        $password = ($_POST['password']);
        $email = $_POST['email'];
      //  $query = "INSERT INTO User SET login='$login', email ='$email', password='$password'"; 
        //$result = mysqli_query($link, $query);
    
        if ($password === $confirm){

         

            mysqli_query($pdo, "INSERT INTO users (login,email,password) VALUES ('$login','$email','$password')");
            $_SESSION['message'] = 'Регистрация прошла успешно!';
            header('Location: login.php');
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
	
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-reg.css">
    <title>Registration</title>
</head>

<body>
   


<div class="login-page">
  <div class="form">
      <form class="register-form"action="" method="POST">
        
            <label class="title">
                Регистрация
            </label>
            <input type="text" name="login" placeholder="Логин" required="">
            <input type="email" name="email" placeholder="Почта" required="">
            <input type="password" name="password" placeholder="Пароль" required="">
            <input type="password" name="confirm" placeholder="Подтвердите пароль" required="">
            <button class="login-form">Зарегистрироваться</button>
        
    </form>
    <form class="login-form" action="login.php">
        Уже есть аккаунт? <a href="login.php" class="login-btn">Войти</a>
    </form>
        
    <form class="login-form" action="index.php" >
        
    <button>Назад</button>
    </form>
  </div>
</div>


</body>
</html><?php
session_start();
  require_once ('connect_db.php');
  $login = $_POST['login'];
  $pass = $_POST['password'];
  $email = $_POST['email'];
  $repeatpass = $_POST['repeatpass'];

  if (empty($login) || empty($pass) || empty($email) || empty ($repeatpass)) {
    $_SESSION['message'] = 'Заполните все поля';
    header('Location: ../form-register.php');
  } else {
    if ($pass === $repeatpass) {
      if (!empty($_FILES['file'])) {
        $file = $_FILES['file'];
        $srcFileName = $file['name'];       
        $newFilePath = __DIR__ . '/uploads/' . $srcFileName;       
        $allowedExtensions = ['jpg', 'png', 'gif'];    
        $extension = pathinfo($srcFileName, PATHINFO_EXTENSION);
        if (!in_array($extension, $allowedExtensions)) {        
          $_SESSION['message'] = 'Загрузка файлов с таким расширением запрещена';
          header('Location: ../form-register.php');       
        } elseif ($file['error'] !== UPLOAD_ERR_OK) {       
          $_SESSION['message'] = 'Ошибка при загрузке файла';
          header('Location: ../form-register.php');
        } elseif (file_exists($newFilePath)) {
          $_SESSION['message'] = 'Файл с таким именем уже существует';
          header('Location: ../form-register.php');
        } elseif (!move_uploaded_file($file['tmp_name'], $newFilePath)) {
          $_SESSION['message'] = 'Ошибка при загурзке файла';
          header('Location: ../form-register.php');
        } else {
        $path = 'http://mysite/uploads/' . $srcFileName;
        }
        }
      // $path = 'uploads/'. $_FILES['avatar']['name'];
      // if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
      //   $_SESSION['message'] = 'Ошибка при загрузке';
      //   header('Location: ../form-register.php');
      // } 
      $pass = md5($pass);

      mysqli_query($connect, "INSERT INTO user (login,email,password,avatar) VALUES ('$login','$email','$pass','$path')");
      $_SESSION['message'] = 'Регистрация прошла успешно!';
      header('Location: ../form-auto.php');
    }
    else if ($pass != $repeatpass) { 
    $_SESSION['message'] = 'Пароли не совпадают';
    header('Location: ../form-register.php');
    } 
}
?>