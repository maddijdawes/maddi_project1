<?php
session_start();

$conn = new SQLite3("Maddi's Project 1") or die ("unable to open database");
$query = file_get_contents("sql/create-user.sql");
$stmt = $conn->prepare($query);

?>
