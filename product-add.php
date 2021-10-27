
<?php
//Displays navigation bar and page headers
include "template.php"; ?>
<title>Create New Product</title>
<h1 class='text-primary'>Create New Product</h1>

<?php
$query = $conn->query("SELECT DISTINCT category FROM products");
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <!--Products Details-->

            <div class="col-md-6">
                <h2>Products Details</h2>
                <p>Product Name<input type="text" name="prodName" class="form-control" required="required"></p>
                <p>Category
                    <select name="prodCategory">
                        <?php
                        //Allows for a drop down bar of different categories available
                        while ($row = $query->fetchArray()) {
                            echo '<option>'.$row[0].'</option>';
                        }
                        ?>
                    </select>
                </p>
                <p>Quantity<input type="number" name="prodQuantity" class="form-control" required="required"></p>
            </div>
            <div class="col-md-6">
                <h2>Product List</h2>
                <!--Product List-->
                <p>Price<input type="number" step="0.01" name="prodPrice" class="form-control" required="required"></p>
                <p>Product Code<input type="text" name="prodCode" class="form-control" required="required"></p>
                <p>Product Picture <input type="file" name="prodImage" class="form-control" required="required"></p>
            </div>
        </div>
    </div>
    <input type="submit" name="formSubmit" value="Submit">
</form>

<?php
// If a form is submitted, the data will be sanitised
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    Customer Details
    $prodName = sanitise_data($_POST['prodName']);
    $prodCategory = sanitise_data($_POST['prodCategory']);
    $prodQuantity = sanitise_data($_POST['prodQuantity']);
    $prodPrice = sanitise_data($_POST['prodPrice']);
    $prodCode = sanitise_data($_POST['prodCode']);

//check if product exists.
    $query = $conn->query("SELECT COUNT(*) FROM products WHERE code='$prodCode'");
    $data = $query->fetchArray();
    $numberOfProducts = (int)$data[0];

    if ($numberOfProducts > 0) {
        echo "Sorry, username already taken";
    } else {
// Product Registration commences

//for the image table.
        $file = $_FILES['prodImage'];

//Variable Names
        $fileName = $_FILES['prodImage']['name'];
        $fileTmpName = $_FILES['prodImage']['tmp_name'];
        $fileSize = $_FILES['prodImage']['size'];
        $fileError = $_FILES['prodImage']['error'];
        $fileType = $_FILES['prodImage']['type'];

//defining what type of file is allowed
// We seperate the file, and obtain the end.
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
//We ensure the end is allowable in our thing.
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                //File is smaller than yadda.
                if ($fileSize < 10000000000) {
                    //file name is now a unique ID based on time with IMG- precedding it, followed by the file type.
                    $fileNameNew = uniqid('IMG-', True) . "." . $fileActualExt;
                    //upload location
                    $fileDestination = 'image/' . $fileNameNew;
                    //command to upload.
                    move_uploaded_file($fileTmpName, $fileDestination);
                    //Updates new information into products and modify the existing records in the table
                    $sql = "UPDATE products SET productName= :newProdName, category= :newProdCategory, quantity= :newProdQuantity, price= :newProdPrice, image= :newFileName, code= :newProdCode WHERE code='$prodCode'";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':newProdName', $newName);
                    $stmt->bindValue(':newProdCategory', $newCategory);
                    $stmt->bindValue(':newProdQuantity', $newQuantity);
                    $stmt->bindValue(':newProdPrice', $newPrice);
                    $stmt->bindValue(':newFileName', $fileNameNew);
                    $stmt->bindValue(':newProdCode', $newCode);
                    $stmt->execute();
                    header("location:index.php");
                } else {
                    echo "Your image is too big!";
                }
            } else {
                echo "there was an error uploading your image!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    }
}

?>

</body>
</html>


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
