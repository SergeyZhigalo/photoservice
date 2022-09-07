<?php
    require "libs/rb.php";
    R::setup('mysql:host=localhost;dbname=worldskills', 'root', 'root');
    session_start();
    $link = mysqli_connect('localhost','root','root','worldskills');
