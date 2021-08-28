<!-- Allow user to access webpages easily through a navigation bar-->
<?php include "template.php";
/**
 * @var SQLite3 $conn
 */

?>


<link rel="stylesheet" href="css/orderForm.css">

<h1 class="text-primary">Products</h1>


<?php

$status = "";
//If input 'code' is filled and isn't empty, all from products table will be selected
if (isset($_POST['code']) && $_POST['code'] != "") {
    $code = $_POST['code'];
    $row = $conn->querySingle("SELECT * FROM products WHERE code='$code'", true);
    $name = $row['productName'];
    $price = $row['price'];
    $image = $row['image'];

    $cartArray = array(
        $code => array(
            'productName' => $name,
            'code' => $code,
            'price' => $price,
            'quantity' => 1,
            'image' => $image)
    );
//Product will be added to cart if session variable shopping cart is empty
    //If the shopping cart already has identical item, message will appear telling the user they already have it in their cart
    if (empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "
<div class='box'>Product is added to your cart!</div>";
    } else {
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if (in_array($code, $array_keys)) {
            $status = "
<div class='box' style='color:red;'>
    Product is already added to your cart!
</div>";
        } else {
            $_SESSION["shopping_cart"] = array_merge(
                $_SESSION["shopping_cart"],
                $cartArray
            );
            $status = "
<div class='box'>Product is added to your cart!</div>";
        }
    }
}
?>




<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>

<?php
//Adds shopping cart icon and updates with each new item added
if (!empty($_SESSION["shopping_cart"])) {
    $cart_count = count(array_keys($_SESSION["shopping_cart"]));
    ?>
    <div class="cart_div">
        <a href="shopping.php"><img src="uploads/cart-icon.png"/>Cart<span>
<?php echo $cart_count; ?></span></a>
    </div>
    <?php
}
?>

<?php

$query=$conn->query("SELECT * FROM 'products'") or die ("Failed to fetch row!");
while ($data=$query->fetchArray())
{
    /* fetch associative array */

    $varimage = $data[7];
    $varcost= $data[6];
}
//Selects all from product table and displays the product name, image and price
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


<?php
//The code below sanitises code data to prevent XSS attacks
function sanitise_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>