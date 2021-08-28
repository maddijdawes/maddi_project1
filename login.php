<?php
//Connects back to config file
require_once 'config.php';

//If user has clicked login, then their username and password will be sanitised
if (isset($_POST['login'])) {
    $username = sanitise_data($_POST['username']);
    $password = sanitise_data($_POST['password']);
//Returns the number of rows in user table and selects where the username is congruent with the one given by the user when registering
    $query = $conn->query("SELECT COUNT(*) as count, * FROM `user` WHERE `username`='$username'");
    $row = $query->fetchArray();
    $count = $row['count'];
    if ($count > 0) {
        if (password_verify($password, $row['password'])) {
            $_SESSION["user_id"] = $row[1];
            $_SESSION["name"] = $row[4];
            $_SESSION["username"] = $row[2];
            $_SESSION['level'] = $row[6];
            $_SESSION['email'] = $row[7];
            $_SESSION['address'] = $row[8];
            $_SESSION['phone'] = $row[9];

            header("location:profile.php");
        } else {
            echo "<div class='alert alert-danger'>Invalid username or password</div>";
        }
    }
}

//The code below sanitises code data to prevent XSS attacks
function sanitise_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>


