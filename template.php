<?php require_once 'config.php'; ?>

<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar-expand-lg navbar-light bg-light">
<div class="container-fluid">
    <a class="navbar-brand" href="index.php">
        <img src="image/image.PNG" alt="" width="80" height="80">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <!--Displays Home Page for everyone to see-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            </li>

            <?php
            //Will only show registration page if user is not logged in
            if (!isset($_SESSION["username"])) { ?>
            <li class="nav-item">
                <a class="nav-link" href="registration.php">Sign up</a>
            </li>
            <?php
            // Will not show the following pages if user is logged in
            } else { ?>
                <li class="nav-item">
                <a class="nav-link" href="orderform.php">Our products</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="shopping.php">Shopping Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"href="contact.php">Contact Us</a>
                </li>
            <li class="nav-item">
                <a class="nav-link"href="invoices.php">Invoices</a>
            </li>
                <a class="nav-link" href="profile.php">User Profile</a>
            </li>
            </li>
            <?php } ?>

            <?php if (isset($_SESSION["level"])) : ?>
                <?php if ($_SESSION["level"] == "Administrator") : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Administrator Functions</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="user-search.php">Search Users</a>
                            <a class="dropdown-item" href="user-add.php">Add Users</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="product-add.php">Add Products</a>
                        </ul>
                    </li>


                <?php endif; ?>
            <?php endif; ?>

        </ul>
        <?php
        //If user is logged in, webpage will display their name and the a button to logout. If user is not logged in, a sign in button will appear
        if (isset($_SESSION["name"])) {
            echo "<div class='alert alert-success d-flex'><span>Welcome, ".$_SESSION["name"]."<br><a href='logout.php'>Logout</a></span></div>";
        } else {
            echo "<div class='alert alert-info d-flex'><a href='index.php'>Sign In</a>";
        }
        ?>
    </div>
</div>
</nav>

<?php


function outputFooter()
{
//The code below shows the last modified time and date on the webpage
    date_default_timezone_set('Australia/Canberra');
    echo "<footer>This page was last modified: " . date("F d Y H:i:s.", filemtime("index.php")) . "</footer>";
}
?>

<script src="js/bootstrap.bundle.js"></script>