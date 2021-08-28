<?php
session_start();

//Connects to database and creates tables
$conn = new SQLite3("db/db_maddi") or die ("unable to open database");
function createTable($sqlStmt, $tableName)
{
    global $conn;
    $stmt = $conn->prepare($sqlStmt);
    if ($stmt->execute()) {
      // echo "<p style='color: greenyellow'>".$tableName.": Table Created Successfully</p>";

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


//Function to add values into the user table, such as name, password and email
function addUser($username, $unhashedPassword, $name, $profilePic, $accessLevel, $email, $address, $phone) {
    global $conn;
    $hashedPassword = password_hash($unhashedPassword, PASSWORD_DEFAULT);
    $sqlstmt = $conn->prepare("INSERT INTO user (username, password, name, profilePic, accessLevel, email, address, phone) VALUES (:username, :hashedPassword, :name, :profilePic, :accessLevel, :email, :address, :phone)");
    $sqlstmt->bindValue(':username', $username);
    $sqlstmt->bindValue(':hashedPassword', $hashedPassword);
    $sqlstmt->bindValue(':name', $name);
    $sqlstmt->bindValue(':profilePic', $profilePic);
    $sqlstmt->bindValue(':accessLevel', $accessLevel);
    $sqlstmt->bindValue(':email', $email);
    $sqlstmt->bindValue(':address', $address);
    $sqlstmt->bindValue(':phone', $phone);
    if ($sqlstmt->execute()) {
       /// echo "<p style='color: greenyellow'>User: ".$username.": Table Created Successfully</p>";

    } else {
        echo "<p style='color: red'>User: ".$username.": Table Created Successfully<?p>";
    }

}

//Counts the amount of users in table and adds the user 'maddi', 'user', and administrator if the number is 0
$query = $conn->query("SELECT COUNT(*) as count FROM user");
$rowcount = $query->fetchArray();
$userCount = $rowcount["count"];

if ($userCount == 0 ){
addUser("admin", "admin", "Administrator", "admin.jpg", "Administrator", "Admin email", "Admin address", "02838922");
addUser("user", "user", "User", "user.jpg", "User", "User email", "User address", "20200201");
addUser("maddi", "maddi", "Maddi", "maddi.jpg", "User", "Maddi's email", "Maddi's address", "02932299202");
}
//Function to add values into the product table, such as price, image and code
function add_product($productName, $productCategory, $productQuantity, $productPrice, $productImage, $productCode) {
    global$conn;
    $sqlstmt = $conn->prepare("INSERT INTO products (productName, category, quantity, price, image, code) VALUES (:name, :category, :quantity, :price, :image, :code)");
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
    add_product('Abrand High-waist jeans', 'Jeans - High-waisted', '110', '130', 'abrand-jeans.jpg', 'jfr569');
    add_product('Green Cami', 'Tops - Cropped', '200', '50', 'green_cami.jpg', '29201iwe');
    add_product('Tommy High-waist jeans', 'Jeans - High-waisted', '40', '130', 'highrise_jeans.jpg', 'dqiueu23');
    add_product('Halter Dress', 'Dress - Halterneck', '14', '60', 'halter_dress.jpg', '27djwi');
    add_product('Brown Dress', 'Dress - Halterneck', '74', '80', 'brown_dress.jpg', '65f4dry');
    add_product('Black backless dress', 'Dress - Backless', '830', '70', 'backless_blackdress.jpg', '383902d');
    add_product('Cream backless dress', 'Dress - Cream', '280', '90', 'cream_backlessdress.jpg', '38dnsks');
    add_product('White Heels', 'Shoes - Heels', '53', '80', 'white_heels.jpg', 'si2ol');
    add_product('Black Heels', 'Shoes - Heels', '379', '70', 'black_heels.jpg', 'sdkow257d');
    add_product('Drop silver Bellyring', 'Earring - Bellyring', '23', '27', 'drop_bellyring.jpg', '92jsp');
    add_product('Silver Butterfly bellyring', 'Earring - Bellyring', '290', '23', 'butterfly_bellyring.jpg', 'wi9ks0');
    add_product('Silver stud earring', 'Earring - stud', '291', '12', 'silver_studearrings.jpg', '920d' );
    add_product('Double stud earrings', 'Earring - stud', '29', '13', 'double_studearrings.jpg', 'w90sapa0');
}
?>