<?php
require "../bd.php";
    $query = "SELECT * FROM `photo` WHERE id=7";
    $result = mysqli_query($link,$query);
    if ($result) {
        while ($otvet = mysqli_fetch_assoc($result)){
            $id = $otvet[id];
            $ownerId = $otvet[owner_id];
            $pathFile = $otvet[path];
            $name = $otvet[name];
            $hashtag = $otvet[hashtag];
        }
    }
echo'<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="/css/stylePhotoFile.css"><title>Все играют а я автомат хочу</title></head><body>
<div class="header"><a href="/photo.php">На главную</a></div><hr>
<div class="imageOne"><img src="'.$pathFile.'"><div class="nameOne"><h3>'.$name.'</h3></div><div class="hashtagPhotosOne">'.$hashtag.'</div>';
if ($ownerId == $_SESSION["logged_user"]["id"]) {
echo'<div class="zagolovki"><div class="changeOne"><h3 class="zagolovok">Изменить название</h3><div class="spoiler"><form method="post"><input type="text" class="idOne" name="id" value="'.$id.'"><input type="text" name="name" value="'.$name.'" maxlength="40"><br><button type="submit" name="changeName" value="check" class="changeName">Изменить название</button></form></div>
<h3 class="zagolovok">Изменить хештеги</h3><div class="spoiler"><form method="post"><input type="text" class="idOne" name="id" value="'.$id.'"><input type="text" name="hashtag" value="'.$hashtag.'" maxlength="50"><br><button type="submit" name="changeHashtag" value="check" class="changeHashtag">Изменить хештеги</button></form></div>
<h3 class="zagolovok">Удалить фотографию</h3><div class="spoiler"><form method="post"><input type="text" class="idOne" name="id" value="'.$id.'"><button type="submit" name="delete" value="check" class="delete">Удалить</button></form></div></div></div></div>
<script src="../libs/JQuery.js"></script><script src="../spoiler.js"></script></body></html>
';
}
    if ($_POST[changeName]) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        if($name == "")
            $name = 'Untitled';
        $query = "UPDATE `photo` SET `name` = '".$name."' WHERE `photo`.`id` = ".$id.";";
        $result = mysqli_query($link,$query);
        if ($result)
            echo("<script>location.href=location.href</script>");
        unset($_POST[id]);
        unset($_POST[name]);
        unset($_POST[changeName]);
    }
    if ($_POST[changeHashtag]) {
        $id = $_POST[id];
        $hashtag = $_POST[hashtag];
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
        $query = "UPDATE `photo` SET `hashtag` = '".$hashtag."' WHERE `photo`.`id` =".$id.";";
        $result = mysqli_query($link,$query);
        if ($result)
            echo("<script>location.href=location.href</script>");
        unset($_POST[id]);
        unset($_POST[hashtag]);
        unset($_POST[changeHashtag]);
    }
    if ($_POST[delete]) {
        $id = $_POST[id];
        $query = "DELETE FROM `photo` WHERE `photo`.`id` = ".$id.";";
        $result = mysqli_query($link,$query);
        $pathFile = $id;
        $pathFilePhoto = $id;
        $pathFile .= '.php';
        $pathFilePhoto .= '.png';
        unlink($pathFile);
        unlink($pathFilePhoto);
        if ($result)
            echo("<script>alert('фотография удалена');location.href='/photo.php/'</script>");
        unset($_POST[id]);
        unset($_POST[delete]);
    }?>