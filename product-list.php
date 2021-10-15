<?php include "template.php"; ?>
<?php include 'login.php'; ?>
<title>Product List</title>

<h1 class='text-primary'>Product List</h1>

<?php
//Selects the name and image of every product in product table
$productList = $conn->query("SELECT productName, image, code FROM products");
?>

<div class="container-fluid">
    <?php
    // Grabs each row from array
    while ($productData = $productList->fetchArray()) {
        ?>
        <div class="row">
            <div class="col-md-2">
                <?php
                echo '<img src="image/'.$productData[1].'" width="100" height="100">';
                ?>
            </div>
            <div class="col-md-4">
                <?php echo $productData[0]; ?>
            </div>
            <div class="col-md-2">
                <!--            edit button-->
                <a href="product-edit.php?prodCode=<?php echo $productData[2]; ?>">Edit</a>
            </div>
            <div class="col-md-2">
                <!--            delete button-->
                <a href="product-remove.php?prodCode=<?php echo $productData[2]; ?>">Delete</a>
            </div>
        </div>
        <?php
    }
    ?>


</div>
