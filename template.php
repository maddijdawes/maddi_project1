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
        <ul class="navbar-nav">
            <li class="nav-item">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="orderform.php">Our products</a>
            <li class="nav-item">
                <a class="nav-link" href="registration.php.php">Sign up</a>
            <li class="nav-item">
                <a class="nav-link" href="shopping.php">Shopping Cart</a>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">User Profile</a>
            </li>
            </li>
        </ul>
    </div>
</div>
</nav>

<?php
function sanitise_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function outputFooter()
{
    date_default_timezone_set('Australia/Canberra');
    echo "<footer>This page was last modified: " . date("F d Y H:i:s.", filemtime("index.php")) . "</footer>";
}
?>

<script src="js/bootstrap.bundle.js"></script>