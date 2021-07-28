<?php
session_start();

$conn = new SQLite3("Maddi's Project 1") or die ("unable to open database");
function createTable($sqlStmt, $tableName)
{
    global $conn;
    $stmt = $conn->prepare($sqlStmt);
    if ($stmt->execute()) {
        echo "<p style='color: greenyellow'>".$tableName.": Table Created Successfully</p>";

    } else {
        echo "<p style='color: red'>".$tableName.": Table Created Successfully<?p>";
    }
}

$query = file_get_contents("sql/create-user.sql");
createTable($query, "User");
$query_01 = file_get_contents("sql/create-user-Copy.sql");
createTable($query_01, "Messaging");
?>