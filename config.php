<?php
session_start();

$conn = new SQLite3("db/db_maddi") or die ("unable to open database");
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
$query_01 = file_get_contents("sql/create-message.sql");
createTable($query_01, "Messaging");
$query_02 = file_get_contents("sql/create-order.sql");
createTable($query_02, "Order_Details");
$query_03 = file_get_contents("sql/create-products.sql");
createTable($query_03, "Products");

function addUser($username, $unhashedPassword, $name, $profilePic, $accessLevel) {
    global $conn;
    $hashedPassword = password_hash($unhashedPassword, PASSWORD_DEFAULT);
    $sqlstmt = $conn->prepare("INSERT INTO user (username, password, name, profilePic, accessLevel) VALUES (:username, :hashedPassword, :name, :profilePic, :accessLevel)");
    $sqlstmt->bindValue(':username', $username);
    $sqlstmt->bindValue(':hashedPassword', $hashedPassword);
    $sqlstmt->bindValue(':name', $name);
    $sqlstmt->bindValue(':profilePic', $profilePic);
    $sqlstmt->bindValue(':accessLevel', $accessLevel);
    if ($sqlstmt->execute()) {
       /// echo "<p style='color: greenyellow'>User: ".$username.": Table Created Successfully</p>";

    } else {
        echo "<p style='color: red'>User: ".$username.": Table Created Successfully<?p>";
    }

}


$query = $conn->query("SELECT COUNT(*) as count FROM user");
$rowcount = $query->fetchArray();
$userCount = $rowcount["count"];

if ($userCount == 0 ){
addUser("admin", "admin", "Administrator", "admin.jpg", "Administrator");
addUser("user", "user", "User", "user.jpg", "User");
addUser("maddi", "maddi", "Maddi", "maddi.jpg", "User");
}

function add_product($productName, $productCategory, $productQuantity, $productPrice, $productImage, $productCode) {
    global$conn;
    $sqlstmt = $conn->prepare("INSERT INTO products (productName, category, quantity, price, image) VALUES (:name, :category, :quantity, :price, :image, :code)");
    $sqlstmt->bindValue(':name', $productName);
    $sqlstmt->bindValue(':category', $productCategory);
    $sqlstmt->bindValue(':quantity', $productQuantity);
    $sqlstmt->bindValue(':price', $productPrice);
    $sqlstmt->bindValue(':image', $productImage);
    $sqlstmt->bindValue(':code', $productCode);

    if($sqlstmt->execute()) {
      //  echo"<p style='color: green'>Product:".$productName.": Created Successfully</p>";
    }else{
        echo"<p style='color: red'>Product:".$productName.": Created Failure</p>";
    }
}


$query= $conn->query("SELECT COUNT(*) as count FROM products");
$rowCount = $query->fetchArray();
$productCount = $rowCount["count"];

if($productCount == 0) {
    add_product('White Cami','Tops - Cropped', 30, 20,'whitecami.PNG','a4d84470');
    add_product("Abrand High-waisted jeans", "Jeans - High - waisted", "110", "130", "");

}
?>