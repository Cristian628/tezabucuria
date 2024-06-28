<?php
session_start();
//------ PHP code for User registration form---
$error = "";
if (array_key_exists("signUp", $_POST)) {

    // Database Link
    $linkDB = mysqli_connect("localhost","root","","teza");
    if (mysqli_connect_error()) { //for connection error finding
        die ('There was an error while connecting to database');
    }
    //Taking HTML Form Data from User
    $name = mysqli_real_escape_string($linkDB, $_POST['name']);
    $email = mysqli_real_escape_string($linkDB, $_POST['email']);
    $password = mysqli_real_escape_string($linkDB,  $_POST['password']);
    $repeatPassword = mysqli_real_escape_string($linkDB,  $_POST['repeatPassword']);

    // PHP form validation PHP code
    if (!$name) {
        $error .= "Name is required <br>";
    }
    if (!$email) {
        $error .= "Email is required <br>";
    }
    if (!$password) {
        $error .= "Password is required <br>";
    }
    if ($password !== $repeatPassword) {
        $error .= "Password does not match <br>";
    }
    if ($error) {
        $error = "<b>There were error(s) in your form!</b> <br>".$error;
    }  else {

        //Check if email is already exist in the Database

        $query = "SELECT * FROM dateang WHERE email = '$email'";
        $result = mysqli_query($linkDB, $query);
        if (mysqli_num_rows($result) > 0) {
            $error .="<p>Your email has taken already!</p>";
        } else {
            
            $query = "INSERT INTO dateang (nameang, email, namepass) VALUES ('$name', '$email', '$password')";

            if (!mysqli_query($linkDB, $query)){
                $error ="<p>Could not sign you up - please try again.</p>";
            } else {

                //session variables to keep user logged in
                $_SESSION['id_ang'] = mysqli_insert_id($linkDB);
                $_SESSION['name'] = $name;

                //Setcookie function to keep user logged in for long time
                if ($_POST['stayLoggedIn'] == '1') {
                    setcookie('id_ang', mysqli_insert_id($linkDB), time() + 60*60*365);
                    //echo "<p>The cookie id is :". $_COOKIE['id']."</P>";
                }
                //Redirecting user to home page after successfully logged in
                
                if($_SESSION['admin']){
                    header("Location: contlogat.php");
                }
                else{
                    header("Location: userpage.php");

                }

            }

        }

    }
}

//-------User Login PHP Code ------------

if (array_key_exists("logIn", $_POST)) {

    // Database Link
    include('linkDB.php');

    //Taking form Data From User
    $email = mysqli_real_escape_string($linkDB, $_POST['email']);
    $password = mysqli_real_escape_string($linkDB,  $_POST['password']);

    //Check if input Field are empty
    if (!$email) {
        $error .= "Email is required <br>";
    }
    if (!$password) {
        $error .= "Password is required <br>";
    }
    if ($error) {
        $error = "<b>There were error(s) in your form!</b><br>".$error;
    }

    else {
        //matching email and password

        $query = "SELECT * FROM dateang WHERE email='$email'";
        $result = mysqli_query($linkDB, $query);
        $row = mysqli_fetch_array($result);

        if (isset($row)) {
            if ($password == $row['namepass']) {

                //session variables to keep user logged in
                $_SESSION['id_ang'] = $row['id_ang'];
                $_SESSION['admin'] = $row['admin'];
                //Logged in for long time untill user didn't log out
                if ($_POST['stayLoggedIn'] == '1') {
                    setcookie('id_ang', $row['id_ang'], time() + 60*60*24); //Logged in permanently
                }
                setcookie('id_ang', $row['id_ang'], time() + 60*60);
                if($_SESSION['admin']){
                    header("Location: contlogat.php");
                }
                else{
                    header("Location: userpage.php");

                }

            } else {
                $error2 = "Combinarea dintre email si parola nu este valida";
            }

        }  else {
            $error2 = "Combinarea dintre email si parola nu este valida!!!";
        }
    }
}
?>