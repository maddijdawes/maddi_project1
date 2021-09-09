<?php
session_start();
// User is redirected to the index page immediately if the session is no longer available
// Unset only indicated index in session variable, e.g. 'name', 'level', and 'user_id'
unset($_SESSION["user_id"]);
unset($_SESSION["name"]);
unset($_SESSION["username"]);
unset($_SESSION["level"]);
unset($_SESSION["shopping_cart"]);
header("Location:index.php");
?>


