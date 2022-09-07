<?php
require "bd.php";
if (!isset($_SESSION['logged_user'])){
    header('Location: /login.php');
}

$data = $_POST;
$id = $_SESSION[logged_user][id];
$checkSymbolBottom = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'];
$checkSymbolTop = ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
$checkNumbers = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
$checkSymbol = ['!', '_', '-', '#'];

$query = "SELECT `password` FROM `users` WHERE `id` = $id";
$result = mysqli_query($link,$query);
if ($result) {
    while ($a = mysqli_fetch_assoc($result)) {
        $pass = $a["password"];
    }
}

if (isset($data['do_change']))
{
    $errors = array();

    if (trim($data['oldPassword']) == '') {
        $errors[] = 'Введите старый пароль!';
    }

    if (trim($data['newPassword']) == '') {
        $errors[] = 'Введите новый пароль!';
    }

    if (trim($data['newPassword_2']) == '') {
        $errors[] = 'Повторите новый пароль!';
    }

    if ($pass != $data['oldPassword']) {
        $errors[] = 'Введите старый пароль правильно!';
    }

    if (in_array($data[newPassword], $checkSymbolBottom)) {
        $errors[] = 'Отсутствует символ нижнего регистра';
    }

    if (in_array($data[newPassword], $checkSymbolTop)) {
        $errors[] = 'Отсутствует символ верхнего регистра';
    }

    if (in_array($data[newPassword], $checkNumbers)) {
        $errors[] = 'Отсутствует цифра';
    }

    if (in_array($data[newPassword], $checkSymbol)) {
        $errors[] = 'Отсутствует один из спецсимволов ! - _ #';
    }

    if ($data['newPassword_2'] != $data['newPassword']) {
        $errors[] = 'Повторите пароль!';
    }

    if (empty($errors)) {
        $query = "UPDATE `users` SET `password` = '".$data[newPassword]."' WHERE `users`.`id` = $id";
        $result = mysqli_query($link,$query);
        if ($result)
            echo("<script>alert('Пароль успешно поменян');location.href='/user.php/'</script>");
        else
            echo("<script>alert('Что-то пошло не так');location.href='/user.php/'</script>");
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
    <h2>Изменение пароля</h2>
    <form action="changePassword.php" method="POST">
        <p>
            <p><strong>Старый пароль</strong></p>
            <input type="password" name="oldPassword" value="<?php echo @$data['oldPassword'];?>">
            </p>
        <p>
            <p><strong>Новый пароль</strong></p>
            <input type="password" name="newPassword" value="<?php echo @$data['newPassword'];?>">
            </p>
        <p>
            <p><strong>Подтвердите пароль</strong></p>
            <input type="password" name="newPassword_2">
        </p>
        <button type="submit" name="do_change" class="change">Изменить</button>
        <p class="text"><a href="/user.php">Вернуться</a></p>
    </form>
</div>
</body>
</html>