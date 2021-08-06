<?php
include "template.php";

$mysqli = new mysqli ( $dbHost, $dbUser, $dbPass, $dbName );
$result = $mysqli->query ( "SELECT * FROM rder" );
$invoice = $result->fetch_assoc ();
?>



<div id="page-wrap">
    <textarea id="header">INVOICE</textarea>
    <div id="identity">

        <textarea id="address">
