<?php
require "bd.php";
if (!isset($_SESSION['logged_user'])){
    header('Location: /login.php');
}

$idPhoto = $_GET["otvet"];
$idUser = $_SESSION["logged_user"]["id"];
$nameUser = $_SESSION["logged_user"]["name"];
$surnameUser = $_SESSION["logged_user"]["surname"];
$phoneUser = $_SESSION["logged_user"]["phone"];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleShare.css">
    <title>Фотосервис</title>
</head>
<body>

<div class="main">
    <form method="post" class="search">
        <input type="text" name="poisk_user" placeholder="поиск юзера" value="<?php echo $_POST["poisk_user"];?>">
        <button class="but">Найти</button>
    </form>
    <?php
    $search = $_POST[poisk_user];
    $separation = explode(" ", $search);
    $searchName = $separation[0];
    $searchSurname = $separation[1];
    $searchPhone = $separation[2];

    $userPhoto = array();
    $query = "SELECT * FROM `users` WHERE `name` LIKE '%".$searchName."%' AND `surname` LIKE '%".$searchSurname."%' AND `phone` LIKE '%".$searchPhone."%' ";
    $result = mysqli_query($link,$query);
    if ($result)
        while ($a = mysqli_fetch_assoc($result))
            array_push($userPhoto, $a);
    $numberRecords = count($userPhoto); //количество фотографий
    $numberPages = ceil($numberRecords / 10); //количество страниц

    $pages = (int)$_POST["pages"];
    $pages = ((int)$_POST["pages"] < 1) ? 1 : (int)$_POST["pages"];
    ?>
    <div class="pages">
        <form method="post">
            <?php
            echo'Страницы: ';
            for ($i = 1; $i <= (int)$numberPages; $i++)
                echo '<button class="buttonPages" name="pages" value="'.$i.'">'.$i.'</button>';
            ?>
        </form>
    </div>
    <div class="users">
        <hr>
        <table>
            <?php
            $pagesCheck = $pages * 10   ;
            if ($numberRecords == 0){
                echo'<div class="zero"><h2>Совпадений не обнаруженно</h2></div>';
            }
            for ($i = $pagesCheck - 10; $i < $pagesCheck; $i++)
                if ($i >= $numberRecords)
                    break;
                else
                    echo '<tr><td>'.$userPhoto[$i][name].' '.$userPhoto[$i][surname].' '.$userPhoto[$i][phone].'</td><td class="right"><form method="post"><button name="him" class="him" value="'.$userPhoto[$i][id].'">Отправить</button></form></td></tr>';
            ?>
        </table>
    </div>
    <?php
    if ($_POST[him]){
        $him = $_POST[him];
        $query = "INSERT INTO `shared` (`id`, `idUser`, `nameUser`, `surnameUser`, `phoneUser`, `komy`, `idPhoto`) VALUES (NULL,  '".$idUser."', '".$nameUser."', '".$surnameUser."', '".$phoneUser."', '".$him."', '".$idPhoto."');";
        $result = mysqli_query($link,$query);
        if ($result)
            echo("<script>alert('Фотография отправлена');location.href='/user.php/'</script>");
        else
            echo("<script>alert('Возникла непредвиденная ошибка');location.href='/user.php/'</script>");
    }
    ?>
</div>
</body>
</html>