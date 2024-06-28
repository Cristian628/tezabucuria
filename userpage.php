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
$pr=[];
$res=[];
$sql= mysqli_query($linkDB, "SELECT * FROM profit LEFT JOIN resmateriale using(id_mat)");
while($result = mysqli_fetch_assoc($sql)){
    array_push($pr, ucwords($result['suma_profit']));
    array_push($res, ucwords($result['namemater']));
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
    <link rel="stylesheet" href="css/contlogat.css?<?= filemtime('css/contlogat.css')?>">
    <script src="js/jquery-3.3.1.js"></script>
    <script src='https://cdn.plot.ly/plotly-2.16.1.min.js'></script>
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
        <h1>Catalog</h1>
        <div class="table-container">
            <div class="table-left">
                <h1>Resursele Materiale</h1>
                <table class="tabele">
                    <tr>
                        <th>Id materialului</th>
                        <th>Resursele materiale</th>
                        <th>Cantitatea (Cutii)</th>
                    </tr>
                    <?php
                    $sql = mysqli_query($linkDB,"SELECT * FROM resmateriale LEFT JOIN dateang using(id_ang)");
                    while($result = $sql->fetch_assoc() ): ?>
                    <tr>
                        <form method='POST'>
                            <td><?php echo $result['id_mat'];?> </td>
                            <td><?php echo $result['namemater'];?> </td>
                            <td><?php echo $result['cantitatea'];?> </td>
                        </form><?php endwhile ?>
                    </tr>
                </table>
            </div>
            <div class="table-right">
                <h1>Cheltuielile</h1>
                <table class="tabele">
                    <tr>
                        <th>Id Cheluielilor</th>
                        <th>Denumirea Materialului</th>
                        <th>Id materialului</th>
                        <th>Suma(lei)</th>
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
                            <td><?php echo $result['suma_cheltuieli'];?></td>
                        </form><?php endwhile ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="table-container">
            <div class="table-left">
                <h1>Venitul</h1>
                <table class="tabele">
                    <tr>
                        <th>Id venit</th>
                        <th>Denumirea materialului</th>
                        <th>Id materialului</th>
                        <th>Suma(lei)</th>
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
                            <td><?php echo $result['suma_venit'];?></td>
                        </form><?php endwhile ?>
                    </tr>

                </table>
            </div>
            <div class="table-right">
                <h1>Profitul</h1>
                <table class="tabele">
                    <tr>
                        <th>Id profit</th>
                        <th>Resursele materiale</th>
                        <th>Suma(lei)</th>
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
                        </form><?php endwhile ?>
                    </tr>

                </table>
            </div>

        </div>
        <h1>Diagrama cu datele din tabelul profit</h1>
        <div id='myDiv'></div>
        <script>
            var data = [
                {
                    x: <?php echo json_encode ($res); ?> ,
                    y: <?php echo json_encode ($pr); ?>,
                    type: 'bar'
                }
            ];

            Plotly.newPlot('myDiv', data);
        </script>

</div>


<script src="js/scripts.js"></script>
</body>
</html>
