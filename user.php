<?php
require "bd.php";
if (!isset($_SESSION['logged_user'])){
    header('Location: /login.php');
}

if ($_POST["shared"]) //отправка id
    {
        $id = $_POST["shared"];
        header("Location: /share.php?otvet=$id");
    }

$id = $_SESSION[logged_user][id];

$userPhoto = array();
$query = "SELECT * FROM `photo` WHERE `owner_id`= $id";
$result = mysqli_query($link,$query);
if ($result) {
    while ($a = mysqli_fetch_assoc($result)){
        array_push($userPhoto, $a);
    }
}
$numberRecords = count($userPhoto); //количество фотографий
$numberPages = ceil($numberRecords / 4); //количество страниц

$pages = (int)$_POST["pages"];
$pages = ((int)$_POST["pages"] < 1) ? 1 : (int)$_POST["pages"];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleUser.css">
    <title>Фотосервис</title>
</head>
<body>
<div class="header">
    <div class="exit"><a href="/logout.php">Выйти</a></div>
    <hr>
</div>
<div class="main">
    <div class="personalData">
        <h2>Мои данные</h2>
        Имя: <?php echo $_SESSION["logged_user"]["name"] ?><br>
        Фамилия: <?php echo $_SESSION["logged_user"]["surname"] ?><br>
        Номер телефона: <?php echo $_SESSION["logged_user"]["phone"] ?><br>
        <a href="/changePassword.php">Изменить пароль</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/photo.php">Вернуться на главную</a>
    </div>
    <div class="myPhotos">
        <h2>Мои фотографии</h2>
        <div class="pages">
            <form method="post">
                <?php
                echo'Страницы: ';
                for ($i = 1; $i <= (int)$numberPages; $i++)
                    echo '<button class="buttonPages" name="pages" value="'.$i.'">'.$i.'</button>';
                ?>
            </form>
        </div>
        <div class="photos">
            <hr>
            <?php
            $pagesCheck = $pages * 4;
            for ($i = $pagesCheck - 4; $i < $pagesCheck; $i++) {
                if ($i >= $numberRecords)
                    break;
                else
                    echo '<a href="/photos/'.$userPhoto[$i][id].'.php"><div class="image"><img src="/photos/'.$userPhoto[$i][path].'"><div class="info"><h3>'.$userPhoto[$i][name].'</h3>'.$userPhoto[$i][hashtag].'</div><form method="post"><button name="shared" value="'.$userPhoto[$i][id].'">Поделиться</button></form></div></a><hr>';
            }
            ?>
        </div>
    </div>
    <div class="myMessage">
        <h2>Фотографии, которыми с вами поделились</h2>
<?php
$message = array();
$query = "SELECT * FROM `shared` WHERE `komy`=$id";

$result = mysqli_query($link,$query);
if ($result) {
    while ($a = mysqli_fetch_assoc($result)){
        array_push($message, $a);
    }
}
$message = array_reverse($message);
$messageRecords = count($message); //количество фотографий
$messagePages = ceil($messageRecords / 5); //количество страниц

$pagesMessage = (int)$_POST["pagesMessage"];
$pagesMessage = ((int)$_POST["pagesMessage"] < 1) ? 1 : (int)$_POST["pagesMessage"];

echo '<form method="post">';
echo'Страницы: ';
for ($i = 1; $i <= (int)$messagePages; $i++)
    echo '<button class="buttonPages" name="pagesMessage" value="'.$i.'">'.$i.'</button>';
echo '</form>';

$messageCheck = $pagesMessage * 5;
for ($i = $messageCheck - 5; $i < $messageCheck; $i++) {
    if ($i >= $messageRecords)
        break;
    else
        echo '<a href="/photos/'.$message[$i][idPhoto].'.php"><div class="message"><div class="mes">'.$message[$i][nameUser].' '.$message[$i][surnameUser].' '.$message[$i][phoneUser].' поделился с вами фотографией. Нажмте на сообщение чтобы просмотреть фотографию</div></div></a>';
}
?>
    </div>
</div>
</body>
</html>
