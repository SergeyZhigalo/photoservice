<?php
require "bd.php";

$data = $_POST;
if (isset($data['do_login']))
{
    $errors = array();

    $user = R::findOne('users', 'phone = ?', array($data['phone']));
    if ($user) {
        if ($data['password'] != $user['password']) {
            $errors[] = 'Неверно введен пароль!';
        }else{
            $_SESSION['logged_user'] = $user;
            header('Location: ../index.php');
        }
    }else{
        $errors[] = 'Пользователь с таким логином не найден!';
    }

    if (!empty($errors)) {
        echo'<div style="color: red;">'.array_shift($errors).'</div><hr>';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/styleRegistration.css">
    <title>Фотосервис</title>
</head>
<body>
<div class="main">
    <h2>Форма входа</h2>
    <form action="login.php" method="POST">
        <p>
            <p><strong>Ваш телефон</strong></p>
            <input type="text" name="phone" class="phone" value="<?php echo @$data['phone'];?>">
        </p>
        <p>
            <p><strong>Ваш пароль</strong></p>
            <input type="password" name="password" value="<?php echo @$data['password'];?>">
        </p>
        <button type="submit" name="do_login" class="login">Войти</button>
        <p class="text">Вы еще не зарегистрированны? Можете <a href="signup.php">перейти</a> на страницу регистрации</p>
        <p class="text">Можете <a href="photo.php">перейти</a> на главную страницу, но ваши возможности будут ограниченны</p>
    </form>
<script src="../libs/JQuery.js"></script>
<script src="../libs/jquery.maskedinput.min.js"></script>
<script>
    $(".phone").mask("89999999999");
</script>
</div>
</body>
</html>