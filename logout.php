<?php
//PHP code to logout user from website
    unset($_SESSION['id_ang']);
    setcookie("id_ang", "", time() - 3600);
    $_COOKIE['id_ang'] = "";
    $_SESSION=[];
    header("Location: login.php");

?>