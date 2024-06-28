<?php
include ('server.php');
$linkDB = mysqli_connect("localhost","root","","teza");
if (mysqli_connect_error()) { //for connection error finding
    die ('There was an error while connecting to database');
}
if(isset($_COOKIE["id_ang"]))
    {
        $ang = $_SESSION["id_ang"];
        $user = mysqli_fetch_assoc(mysqli_query($linkDB, "SELECT * FROM dateang WHERE id_ang = $ang"));
        $query = "SELECT * FROM resmateriale JOIN cheltuieli USING (id_mat) JOIN venit USING (id_mat) JOIN profit USING (id_mat);";
        $analis = mysqli_query($linkDB, $query);
        while($result = mysqli_fetch_assoc($analis))
        {
            $profit = $result['suma_venit'] - $result['suma_cheltuieli'];
            $id_mat = $result['id_mat'];
            mysqli_query($linkDB, "UPDATE profit set suma_profit = $profit where id_mat = $id_mat");
        }
        }
else {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bucuria</title>
    <link href="css/playfair+display.css" rel="stylesheet">
    <link href="css/familyPoppins.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/contlogat.css">
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
                <li><a href="index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>
<div class="content">
    <h1>Tabelul cu Baza de Date</h1>
    <table class="tabele">
        <tr>
            <th>Id materialului</th>
            <th>Resursele materiale</th>
            <th>Cantitatea (Cutii)</th>
            <th>Editarea</th>
            <th>Stergerea</th>
        </tr>
        <?php
        $sql = mysqli_query($linkDB,"SELECT * FROM resmateriale LEFT JOIN dateang using(id_ang)");
        while($result = $sql->fetch_assoc() ): ?>
        <tr>
            <form method='POST'>
                <td><?php echo $result['id_mat'];?></td>
                <td><input type="text" id="hello" name="namemater" required value="<?php echo $result['namemater'];?>"/> </td>
                <td><input type="text" id="hello" name="cantitatea" required value="<?php echo $result['cantitatea'];?>"/></td>
                <td><?php echo"<input type='hidden' name='id_mat' value='".$result['id_mat']."' /> <input type='submit' name='id_mat_1' value='&#9999;'>";?></td>
                <td>
                    <?php echo"<input type='hidden' name='id_mat' value='".$result['id_mat']."' /> <input type='submit' name='delete' value='&#10006;'>"?>
                </td>
            </form><?php endwhile ?>
        </tr>
        <tr>
            <form method='POST'>
                <td> <input type="text" name='new_mat_id_1'/></td>
                <td> <input type="text" name="new_mat_id"/></td>
                <td> <input type="text" name="new_cantitatea_id"/></td>
                <td colspan = "4">
                    <input type='submit' name='add_mat' value='Adaugati'> </td>
                </td>
            </form>
        </tr>
        <?php
        if(isset($_POST['id_mat_1'])){
            if(!empty($_POST['namemater'])) {
                $qwerty="UPDATE resmateriale SET namemater = '".$_POST['namemater']."' WHERE`id_mat`='".$_POST['id_mat']."'";
                echo $qwerty;
                $result=mysqli_query($linkDB, $qwerty);
                if($result){
                    echo '<script>window.location="contlogat.php"</script>';

                }}}
        if(isset($_POST['id_mat_1'])){
            if(!empty($_POST['cantitatea'])) {
                $qwerty="UPDATE resmateriale SET cantitatea = '".$_POST['cantitatea']."' WHERE`id_mat`='".$_POST['id_mat']."'";
                echo $qwerty;
                $result=mysqli_query($linkDB, $qwerty);
                if($result){
                    echo '<script>window.location="contlogat.php"</script>';

                }}}
        if(isset($_POST['delete'])){
            $delete_id = $_POST['id_mat'];
            $result= mysqli_query($linkDB, " DELETE FROM resmateriale WHERE resmateriale.id_mat = '$delete_id' ");
            if($result){
                echo '<script>window.location="contlogat.php"</script>';
            }
        }
        if(isset($_POST['add_mat'])) {
            if (!empty($_POST['new_mat_id'])) {
                $new_mater_name = $_POST['new_mat_id'];
                $new_mater_id = $_POST['new_mat_id_1'];
                $new_mater_nam = $_POST['new_cantitatea_id'];
                $result = mysqli_query($linkDB, " INSERT INTO `resmateriale` (`id_mat`, `namemater` , `cantitatea`) VALUES ('$new_mater_id','$new_mater_name','$new_mater_nam')");
                $result = mysqli_query($linkDB, " INSERT INTO `cheltuieli` (`id_mat`,`id_ang` ) VALUES ('$new_mater_id','$ang')");
                $result = mysqli_query($linkDB, " INSERT INTO `profit` (`id_mat`,`id_ang`) VALUES ('$new_mater_id','$ang')");
                $result = mysqli_query($linkDB, " INSERT INTO `venit` (`id_mat`,`id_ang`) VALUES ('$new_mater_id','$ang')");

                if ($result) {
                    echo '<script>window.location="contlogat.php"</script>';
                }
            }
        }
        ?>
    </table>
    <br>
    <table class="tabele">
        <tr>
            <th>Id Cheluielilor</th>
            <th>Denumirea Materialului</th>
            <th>Id materialului</th>
            <th>Suma(lei)</th>
            <th>Editarea</th>
            <th>Stergerea</th>
        </tr>
        <?php
        $sql = mysqli_query($linkDB,"SELECT * FROM cheltuieli LEFT JOIN resmateriale using(id_mat)");
        while($result = $sql->fetch_assoc() ):
        ?>
        <tr>
            <form method='POST'>
                <td><?php echo $result['id_cheltuieli'];?></td>
                <td><?php echo $result['namemater']?></td>
                <td><?php echo $result['id_mat']?></td>
                <td><input type="text" id="hello" name="suma_cheltuieli" required value="<?php echo $result['suma_cheltuieli'];?>"</></td>
                <td><?php echo"<input type='hidden' name='id_cheltuieli' value='".$result['id_cheltuieli']."' /> <input type='submit' name='id_cheltuieli_1' value='&#9999;'>";?></td>
                <td>
                    <?php echo"<input type='hidden' name='id_cheltuieli' value='".$result['id_cheltuieli']."' /> <input type='submit' name='delete' value='&#10006;'>"?>
                </td>
            </form><?php endwhile ?>
        </tr>
            <?php
            if(isset($_POST['id_cheltuieli_1'])){
            if(!empty($_POST['suma_cheltuieli'])) {
                $qwerty="UPDATE cheltuieli SET suma_cheltuieli = '".$_POST['suma_cheltuieli']."' WHERE`id_cheltuieli`='".$_POST['id_cheltuieli']."'";
                echo $qwerty;
                $result=mysqli_query($linkDB, $qwerty);
                if($result){
                    echo '<script>window.location="contlogat.php"</script>';

                }}}
            if(isset($_POST['delete'])){
                $delete_id = $_POST['id_cheltuieli'];
                $result= mysqli_query($linkDB, " DELETE FROM cheltuieli WHERE cheltuieli.id_cheltuieli = '$delete_id' ");
                if($result){
                    echo '<script>window.location="contlogat.php"</script>';
                }
            }
            if(isset($_POST['add_mat'])) {
                if (!empty($_POST['new_mat_id'])) {
                    $new_mater_name = $_POST['new_mat_id'];
                    $new_mater_id = $_POST['new_mat_id_1'];
                    $result = mysqli_query($linkDB, " INSERT INTO `cheltuieli` VALUES ('','$new_mater_name','$new_mater_id','')");
                    if ($result) {
                        echo '<script>window.location="contlogat.php"</script>';
                    }
                }
            }

            ?>
    </table>
    <br>

    <table class="tabele">
        <tr>
            <th>Id venit</th>
            <th>Denumirea materialului</th>
            <th>Id materialului</th>
            <th>Suma(lei)</th>
            <th>Editarea</th>
            <th>Stergerea</th>
        </tr>
        <?php
        $sql = mysqli_query($linkDB,"SELECT * FROM venit LEFT JOIN resmateriale using(id_mat)");
        while($result = $sql->fetch_assoc() ):
        ?>
        <tr>
            <form method='POST'>
                <td><?php echo $result['id_venit'];?></td>
                <td><?php echo $result['namemater']?></td>
                <td><?php echo $result['id_mat']?></td>
                <td><input type="text" id="hello" name="suma_venit" required value="<?php echo $result['suma_venit'];?>"</></td>
                <td><?php echo"<input type='hidden' name='id_venit' value='".$result['id_venit']."' /> <input type='submit' name='id_venit_1' value='&#9999;'>";?></td>
                <td>
                    <?php echo"<input type='hidden' name='id_venit' value='".$result['id_venit']."' /> <input type='submit' name='delete' value='&#10006;'>"?>
                </td>
            </form><?php endwhile ?>
        </tr>
        <?php
        if(isset($_POST['id_venit_1'])){
            if(!empty($_POST['suma_venit'])) {
                $qwerty="UPDATE venit SET suma_venit = '".$_POST['suma_venit']."' WHERE`id_venit`='".$_POST['id_venit']."'";
                echo $qwerty;
                $result=mysqli_query($linkDB, $qwerty);
                if($result){
                    echo '<script>window.location="contlogat.php"</script>';

                }}}
        if(isset($_POST['delete'])){
            $delete_id = $_POST['id_venit'];
            $result= mysqli_query($linkDB, " DELETE FROM venit WHERE venit.id_venit = '$delete_id' ");
            if($result){
                echo '<script>window.location="contlogat.php"</script>';
            }
        }
        if(isset($_POST['add_mat'])) {
            if (!empty($_POST['new_mat_id'])) {
                $new_mater_name = $_POST['new_mat_id'];
                $new_mater_id = $_POST['new_mat_id_1'];
                $result = mysqli_query($linkDB, " INSERT INTO `venit` VALUES ('','$new_mater_id','$new_mater_name','')");
                if ($result) {
                    echo '<script>window.location="contlogat.php"</script>';
                }
            }
        }
        ?>
    </table>
    <br>
    <table class="tabele">
        <tr>
            <th>Id profit</th>
            <th>Resursele materiale</th>
            <th>Suma(lei)</th>
            <th>Ștergere</th>
        </tr>
        <?php
        $sql = mysqli_query($linkDB,"SELECT * FROM profit LEFT JOIN resmateriale using(id_mat)");
        while($result = $sql->fetch_assoc() ):
        ?>
        <tr>
            <form method='POST'>
                <td><?php echo $result['id_profit'];?></td>
                <td><?php echo $result['namemater']?></td>
                <td><?php echo $result['suma_profit']; ?></td>
                <td>
                    <?php echo"<input type='hidden' name='id_profit' value='".$result['id_profit']."' /> <input type='submit' name='delete' value='&#10006;'>"?>
                </td>
            </form><?php endwhile ?>
        </tr>
        <?php
        if(isset($_POST['delete'])) {
            $delete_id = $_POST['id_profit'];
            $result = mysqli_query($linkDB, " DELETE FROM profit WHERE profit.id_profit = '$delete_id' ");
            if ($result) {
                echo '<script>window.location="contlogat.php"</script>';
            }
        }
        ?>
    </table>
</div>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>
