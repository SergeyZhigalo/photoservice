<?php
require "bd.php";
$checkAuthorization = (isset($_SESSION['logged_user'])) ? true : false;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/styleMain.css?nocashe=1.5">
    <title>Фотосервис</title>
</head>
<body>
    <div class="status">
        <?php
        if ($checkAuthorization == true)
            echo'<div class="aut">Вы авторизованы как '.$_SESSION['logged_user']["name"].' '.$_SESSION['logged_user']["surname"].'! <a href="/user.php">Личный кабинет</a></div>';
        else
            echo'<div class="aut"><a href="login.php">Вход</a>&nbsp&nbsp&nbsp<a href="signup.php">Регистрация</a></div>';
        ?>
    </div>
<hr>
<?php
$types = array('image/jpg', 'image/png', 'image/jpeg');
$checkImage = false;
$checkSize = false;
$size = 1000001;

if ($_POST[addPhoto])
{
    if (in_array($_FILES['picture']['type'], $types))
        $checkImage = true;
    else
        echo'<div class="red">Запрещённый тип файла</div><hr>';
}

if ($_FILES['picture']['size'] < $size)
    $checkSize = true;
else
    echo'<div class="red">Слишком большой размер файла</div><hr>';


if ($_POST[addPhoto] and $checkImage and $checkSize)
{
    $path  = 'photos/';
    $data  = $_POST;

    function imageresize($outfile,$infile,$neww,$newh,$quality) {
        $im=imagecreatefromjpeg($infile);
        $im1=imagecreatetruecolor($neww,$newh);
        imagecopyresampled($im1,$im,0,0,0,0,$neww,$newh,imagesx($im),imagesy($im));
        imagejpeg($im1,$outfile,$quality);
        imagedestroy($im);
        imagedestroy($im1);
    }

    if($data[name] == "")
        $data[name] = 'Untitled';

    if($data[hashtag] == "")
        $data[hashtag] = '&nbsp';

    $query = "SELECT `id` FROM photo WHERE id=(SELECT MAX(id) FROM photo)";
    $result = mysqli_query($link,$query);
    if ($result) {
        while ($test = mysqli_fetch_assoc($result)){
            $pathFile = $test["id"] + 1;
            $pathFilePhoto = $test["id"] + 1;
            $id = $test["id"] + 1;
        }
    }
    $pathFile .= '.php';
    $pathFilePhoto .= '.png';

$contentFile = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (!@copy($_FILES['picture']['tmp_name'], $path.$pathFilePhoto)) // загрузка файла и вывод сообщения
        {
            echo'<div class="red">Что-то пошло не так</div><hr>';
        }else{
            file_put_contents($path.$pathFile, $contentFile);
            echo'<div class="green">Загрузка прошла удачно <a href="/'.$path.$pathFile.'">ссылка</a></div><hr>';
        }
    }

    $size = getimagesize($path . $pathFilePhoto);
    $minimumSide = ($size[0] <= $size[1]) ? $size[0] : $size[1];

    imageresize($path.$pathFilePhoto ,$path.$pathFilePhoto, $minimumSide, $minimumSide,100);

    $hashtag = $data[hashtag];
    $separation = explode(" ", $hashtag);
    for ($i = 0; $i <= count($separation); $i++) {
        if ($separation[$i][0] != '#')
            unset($separation[$i]);
        if (iconv_strlen($separation[$i]) == 1)
            unset($separation[$i]);
    }
    $hashtag = '';
    $hashtag = implode(" ", $separation);
    if ($hashtag == '')
        $hashtag = '&nbsp;';

    $query = "INSERT INTO `photo` (`id`, `owner_id`, `name`, `path`, `hashtag`) VALUES ('".$id."', '".$_SESSION['logged_user']['id']."', '".$data["name"]."', '".$pathFilePhoto."', '".$hashtag."')";
    $result = mysqli_query($link,$query);

    $checkImage = false;
    $checkSize = false;
    unset($_POST[hashtag]);
    unset($_POST[name]);
    unset($_POST[addPhoto]);
    unset($_FILES[picture]);
}
?>
    <div class="add" id="add">
        <h2>Добавление фотографии</h2>
        <form method="post" enctype="multipart/form-data">
            <p><div class="example-1"><div class="form-group"><label class="label"><i class="material-icons">attach_file</i><span class="title">Добавить файл</span><input type="file" name="picture" accept="image/jpeg, image/jpeg, image/png" class="file"></label></div></div></p>
            <p>Введите название фотографии <input type="text" name="name" id="name" maxlength="40"></p>
            <p>Введите хештеги к фотографии <input type="text" name="hashtag" id="hashtag" maxlength="50"></p>
            <?php
            if ($checkAuthorization == true)
                echo'<p><button type="submit" value="Загрузить" name="addPhoto" class="addPhoto">Загрузить</button></p>';
            else
                echo'<p><button disabled class="notAut">Чтобы загрузить фотографии зарегистрируйтесь</button></p>';
            ?>
        </form>
    </div>
<hr>
    <div class="content">
        <?php
        $b = array();
        $pages = (int)$_POST["pages"];
        $pages = ((int)$_POST["pages"] < 1) ? 1 : (int)$_POST["pages"];
        $search = $_POST["poisk_title"];
        if (iconv_strlen($search) < 3)
            $search = '';
        $query = "SELECT * FROM `photo` WHERE `name` LIKE '%".$search."%' or `hashtag` LIKE '%".$search."%'";
        $result = mysqli_query($link,$query);
        if ($result) {
            while ($a = mysqli_fetch_assoc($result)){
                array_push($b, $a);
            }
        }
        $numberRecords = count($b); //количество фотографий
        $numberPages = ceil($numberRecords / 6); //количество страниц
        ?>
        <div class="searchAndPages">
            <div class="search">
        <form method="post">
                <input type="text" name="poisk_title" placeholder="поиск по названию или хештегу" value="<?php echo $_POST["poisk_title"];?>">
                <button class="poisk">Найти</button>
            </div>
            <div class="pages">
                <?php
                echo'Страницы: ';
                for ($i = 1; $i <= (int)$numberPages; $i++)
                    echo '<button class="buttonPages" name="pages" value="'.$i.'">'.$i.'</button>';
                ?>
        </form>
            </div>
        </div>
        <div class="main">
            <h2>Просмотр фотографий</h2>
            <div class="photos">
                <?php
                $pagesCheck = $pages * 6;
                if ($numberRecords == 0){
                    echo'<div class="zero"><h2>Совпадений не обнаруженно</h2></div>';
                }
                for ($i = $pagesCheck - 6; $i < $pagesCheck; $i++) {
                    if ($i >= $numberRecords)
                        break;
                    else
                        echo '<a href="/photos/'.$b[$i][id].'.php"><div class="image"><img src="/photos/'.$b[$i][path].'"><div class="name"><h3>'.$b[$i][name].'</h3></div><div class="hashtag">'.$b[$i][hashtag].'</div></div></a>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>