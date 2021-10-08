<?php include "template.php"; ?>
<?php include 'login.php'; ?>
<title>Product List</title>

<h1 class='text-primary'>Product List</h1>

<?php
$productList = $conn->query("SELECT productName, image FROM products");
?>

<div class="container-fluid">
    <?php
    // Grabs each row from array
    while ($productData = $productList->fetchArray()) {
        ?>
        <div class="row">
            <div class="col-md-2">
                <?php
                echo '<img src="images/productImages/'.$productData[1].'" width="50" height="50">';
                ?>
            </div>
            <div class="col-md-4">
                <?php echo $productData[0]; ?>
            </div>
            <div class="col-md-2">
                <!--            edit button-->
                Edit
            </div>
            <div class="col-md-2">
                <!--            delete button-->
                Delete
            </div>
        </div>
        <?php
    }
    ?>


</div>
