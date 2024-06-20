<?php
	session_start();
    require_once('db.php');
   
    $login = $_POST['login'];
    $password = $_POST['password'];
    

$check_user = mysqli_query($pdo, "SELECT * FROM users WHERE login = '$login' AND password = '$password'");
	
if (empty($login) || empty($password))
{
$_SESSION['message'] = 'Пожалуйста, заполните все поля';
}
else {
if (mysqli_num_rows($check_user) > 0) {
  $user = mysqli_fetch_assoc($check_user);
  $_SESSION['user'] = [
    "login" => $user['login'],
    "email" => $user['email']
];
$_SESSION['message'] = 'Авторизация прошла успешно!';
  header('Location: profile.php');
} else {
  $_SESSION['message'] = 'У нас нет такого пользователя';
  }
}
    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style-reg.css">
        <title>Login</title>
    </head>
<body>

<div class="login-page">
  <div class="form">
    <form class="register-form"action="" method="POST">
            
            
                    <label>Login</label>
                    <input type="text" name="login" placeholder='Login'>
                    <input type="password" name="password" placeholder='Password'>
                    <button>Log in</button>
            
       
    </form>
    <form class="login-form" action="reg.php">
            <button>sign up</button>
        </form>
        <form action="index.php" >
            <button>Back</button>
        </form>
  </div>


</div>
</body>
</html><?php
	session_start();
    require_once('connect_db.php');
   
    $login = $_POST['login'];
    $password = $_POST['password'];
    

$check_user = mysqli_query($link, "SELECT * FROM user WHERE login = '$login' AND password = '$password'");
	
if (empty($login) || empty($password))
{
$_SESSION['message'] = 'Пожалуйста, заполните все поля';
}
else {
if (mysqli_num_rows($check_user) > 0) {
  $user = mysqli_fetch_assoc($check_user);
  $_SESSION['user'] = [
    "login" => $user['login'],
    "email" => $user['email']
];
$_SESSION['message'] = 'Авторизация прошла успешно!';
  header('Location: profile.php');
} else {
  $_SESSION['message'] = 'У нас нет такого пользователя';
  }
}
    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style-reg.css">
        <title>Login</title>
    </head>
<body>

<div class="login-page">
  <div class="form">
    <form class="register-form"action="" method="POST">
            
            
                    <label>Login</label>
                    <input type="text" name="login" placeholder='Login'>
                    <input type="password" name="password" placeholder='Password'>
                    <button>Log in</button>
            
       
    </form>
    <form class="login-form" action="reg.php">
            <button>sign up</button>
        </form>
        <form action="index.php" >
            <button>Back</button>
        </form>
  </div>


</div>
</body>
</html>