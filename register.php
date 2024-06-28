<!-- PHP command to link server.php file with registration form  -->
<?php $error2='';
include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucuria</title>
    <link href="css/playfair+display.css" rel="stylesheet">
    <link href="css/familyPoppins.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/logreg.css">
    <script src="js/jquery-3.3.1.js"></script>
</head>

<body>
<div class="wrapper">
    <header>
        <nav>
            <div class="menu-icon">
                <i class="fa fa-bars fa-2x"></i>
            </div>
            <div class="logo"><img src="./img/bucuria-logo.edit.png" class="imagine"></div>
            <div class="menu">
                <ul>
                    <li><a href="Index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="content">
    <h1>Sistema de registrare a utilizatorului</h1>


    <div class="form" id="signUp">
        <form method="POST">
            <div class="error">
                <?php echo $error2 ?>
            </div>

            <!--------- To check user regidtration status ------->
            <p>
                <?php
                if (!isset($_COOKIE["id_ang"]) OR !isset($_SESSION["id_ang"]) ) {
                    echo "Please first register to proceed.";
                }
                ?>
            </p>
            <input type="text" name="name" placeholder="User Name"> <br> <br>
            <input type="email" name="email" placeholder="Email"> <br><br>
            <input type="password" name="password" placeholder="Password"><br><br>
            <input type="password" name="repeatPassword" placeholder="Repeat Password"><br><br>
            <label for="checkbox">Stay logged in</label>
            <input type="checkbox" name="stayLoggedIn" id="chechbox" value="1"> <br><br>
            <input type="submit" name="signUp" value="Registrare">
            <p>Ai deja un cont? <a href="login.php">Login</a></p>
        </form>
    </div>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>