<?php include "template.php";
/**
 *  This is the product edit page.
 * It shows the product details including picture, to edit.
 *
 * @var SQLite3 $conn
 */

ob_start();
?>
    <!-- Title reflects page contents-->
    <title>Edit the product</title>

    <h1 class='text-primary'>Edit the product</h1>

<?php
//Checks if product code matches the given code; if not, user will be redirected to login page
if (isset($_GET["prodCode"])) {
    $prodCode = $_GET["prodCode"];
} else {
    header("location:index.php");
}
//Selects all information from products table where the product code is congruent with given code.
$query = $conn->query("SELECT * FROM products WHERE code='$prodCode'");
$prodData = $query->fetchArray();
//Sets data to variables to distinguish their purpose
$prodID = $prodData[0];
$prodName = $prodData[2];
$prodCategory = $prodData[3];
$prodQuantity= $prodData[4];
$prodPrice = $prodData[5];
$prodImage = $prodData[6];


?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!--Prints current user information on webpage-->
                <h3>Product Name : <?php echo $prodName; ?></h3>
                <p>Product Picture:</p>
                <?php echo "<img src='image/" . $prodImage . "' width='100' height='100'>" ?>
            </div>
            <div class="col-md-6">
                <!-- Creates a button to upload files and submit information-->
                <!--Then prints updated information onto webpage-->
                <form action="product-edit.php?prodCode=<?php echo $prodCode ?>" method="post"
                      enctype="multipart/form-data">
                    <p>Name: <input type="text" name="prodName" value="<?php echo $prodName ?>"></p>
                    <p>Category: <input type="text" name="prodCategory" value="<?php echo $prodCategory ?>"></p>
                    <p>Quantity : <input type="number" name="prodQuantity" value="<?php echo $prodQuantity ?>"> </p>
                    <p>Price : <input type="number" name="prodPrice" value="<?php echo $prodPrice ?>"> </p>
                    <p>Code : <input type="text" name="prodCode" value="<?php echo $prodCode ?>"></p>
                    <p>Profile Picture: <input type="file" name="file"></p>
                    <input type="submit" name="formSubmit" value="Submit">
                </form>
            </div>
        </div>
    </div>

<?php
//Code below sanitises data and prevents against XSS attacks
if ($_SERVER["REQUEST_METHOD"]== "POST") {
    $newName = sanitise_data($_POST['prodName']);
    $newCategory = sanitise_data($_POST['prodCategory']);
    $newQuantity = sanitise_data($_POST['prodQuantity']);
    $newPrice = sanitise_data($_POST['prodPrice']);
    $newCode = sanitise_data($_POST['prodCode']);

//Updates product table for new information
    $sql = "UPDATE products SET productName= :newName, category= :newCategory, quantity= :newQuantity, price= :newPrice, image= :newFileName, code= :newCode WHERE code='$prodCode'";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':newName', $newName);
    $stmt->bindValue(':newCategory', $newCategory);
    $stmt->bindValue(':newQuantity', $newQuantity);
    $stmt->bindValue(':newPrice', $newPrice);
    $stmt->bindValue(':newFileName', $fileNameNew);
    $stmt->bindValue(':newCode', $newCode);
    $stmt->execute();



// Update Profile picture
    $file = $_FILES['file'];

//Variable Names
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

//defining what type of file is allowed
// We seperate the file, and obtain the end.
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
//We ensure the end is allowable in our thing.
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    //This means that if the file does exist
    if ($_FILES["file"]["error"] == !4) {
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
                    header("location:product-list.php");
                } else {
                    echo "Your image is too big!";
                }
            } else {
                echo "there was an error uploading your image!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    } else {
        echo "No image uploaded";
    }
}


//The code below sanitises code data to prevent XSS attacks
function sanitise_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

ob_end_flush();
?>