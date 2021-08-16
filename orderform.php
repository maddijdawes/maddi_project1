<title>Order Form</title>
<?php include "template.php";?>
<link rel="stylesheet" href="css/orderForm.css">

<h1 class="text-primary">Order Form</h1>

<?php

$query=$conn->query("SELECT * FROM 'products'") or die ("Failed to fetch row!");
while ($data=$query->fetchArray())
{
    /* fetch associative array */

    $varimage = $data[7];
    $varcost= $data[6];
}

$result = $conn ->query("SELECT * FROM products");
while ($row = $result->fetchArray()) {
    echo "<div class='product_wrapper'>
    <form method ='post' action =''>
    <input type='hidden' name='code' value=" . $row['code'] . " />
    <div class='image'><img src='image/" . $row['image'] . "' width='100' height='100'/></div>
    <div class='name'>" . $row['productName'] . "</div>
    <div class='price'>$" . $row['price'] . "</div>
    <button type='submit' class='buy'>Add to Cart</button>
    </form>
    </div>";
}
?>
