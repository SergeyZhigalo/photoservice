<?php
require "bd.php";

$data = $_POST;
$checkSymbolBottom = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'];
$checkSymbolTop = ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
$checkNumbers = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
$checkSymbol = ['!', '_', '-', '#'];

if (isset($data['do_signup']))
{
    $errors = array();
    if (trim($data['name']) == '') {
        $errors[] = 'Введите имя!';
    }

    if (trim($data['surname']) == '') {
        $errors[] = 'Введите фамилию!';
    }

    if ($data['phone'] == '') {
        $errors[] = 'Введите номер телефона!';
    }

    if ($data['password'] == '') {
        $errors[] = 'Введите пароль!';
    }

    if ($data['password_2'] != $data['password']) {
        $errors[] = 'Повторите пароль!';
    }

    if (R::count('users', "phone = ?", array($data['phone'])) > 0) {
        $errors[] = 'Пользователь с таким номером телефона уже существует';
    }

    if (in_array($data[password], $checkSymbolBottom)) {
        $errors[] = 'Отсутствует символ нижнего регистра';
    }

    if (in_array($data[password], $checkSymbolTop)) {
        $errors[] = 'Отсутствует символ верхнего регистра';
    }

    if (in_array($data[password], $checkNumbers)) {
        $errors[] = 'Отсутствует цифра';
    }

    if (in_array($data[password], $checkSymbol)) {
        $errors[] = 'Отсутствует один из спецсимволов ! - _ #';
    }

    if (empty($errors)) {
        $user = R::dispense('users');
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->phone = $data['phone'];
        $user->password = $data['password'];
        R::store($user);
        header('Location: login.php');
    }else{
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
<h2>Форма регистарации</h2>
<form action="signup.php" method="POST">
    <p>
        <p><strong>Введите ваше имя</strong></p>
        <input type="text" name="name" onkeyup="Rus(this);" onchange="Rus(this)" value="<?php echo @$data['name'];?>">
    </p>
    <p>
    <p><strong>Введите вашу фамилию</strong></p>
        <input type="text" name="surname" onkeyup="Rus(this);" onchange="Rus(this)" value="<?php echo @$data['surname'];?>">
    </p>
    <p>
        <p><strong>Введите ваш телефон</strong></p>
        <input type="text" name="phone" class="phone" value="<?php echo @$data['phone'];?>">
    </p>
    <p>
        <p><strong>Введите пароль</strong></p>
        <input type="password" name="password" value="<?php echo @$data['password'];?>">
    </p>
    <p>
        <p><strong>Повторите пароль</strong></p>
        <input type="password" name="password_2">
    </p>
    <button type="submit" name="do_signup" class="signup">Зарегистрироваться</button>
    <p class="text">Уже авторизованны? Можете <a href="login.php">перейти</a> на страницу входа</p>
</form>
<script src="../libs/JQuery.js"></script>
<script src="../libs/jquery.maskedinput.min.js"></script>
<script>
    function Rus(obj) {
        obj.value = obj.value.replace(/[^а-яА-ЯёЁ -]/ig,'');
    }
    $(".phone").mask("89999999999");
</script>
</div>
</body>
</html>