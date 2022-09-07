<?php
    require "bd.php";

    unset($_SESSION['logged_user']);
    header('Location: login.php')
?>