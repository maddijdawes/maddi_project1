<?php include "template.php"; ?>


<h1>Edit Profile</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">
                <h2>Personal Details</h2>

                <p>Please your personal details:</p>
                <p>First Name<input type="text" name="F_name"></p>
                <p>Last Name<input type="text" name="L_name"></p>
                <p>Address<input type="text" name="address"></p>
                <p>Age<input type="text" name="age"></p>

                <!-- Creates a button to upload files and submit information-->
                <br>
                <p>Profile Picture</p>

                <input type="file"
                       name="file">

            </div>
        </div>
    </div>
    <input type="submit" name="formSubmit" value="Submit">
</form>
</div>


</form>

<h1>Current information</h1>
<?php
require_once 'conn.php';
//Whatever the user enters in the submission boxes will replace the data that is in the database
$term = ($_SERVER["REQUEST_METHOD"]);
$u1 = $_SESSION["user_id"];
$query= $conn->query("UPDATE 'user' SET name='.$term.' WHERE user_id = '$u1'");
$query= $conn->query("UPDATE 'user' SET username='.$term.' WHERE user_id = '$u1'");
$query= $conn->query("UPDATE 'user' SET password='.$term.' WHERE user_id= '$u1'");
$query= $conn->query("UPDATE 'user' SET address='.$term.' WHERE user_id = '$u1'");



?>
<?php
// Selects all the information from the user table by the last entry
$query=$conn->query("SELECT * FROM user ORDER BY user_id DESC LIMIT 1") or die("Failed to fetch row!");
while ($data=$query->fetchArray()){


    $varuser = $data[1];
    $NameFirst = $data[4];
    $NameSecond = $data[5];
    $Address = $data[6];
    $Age = $data[7];

//Prints the information on the webpage
    echo "<br>";
    echo "Your username:". " ". $varuser;
    echo "<br>";
    echo "Your First name:". " ". $NameFirst;
    echo "<br>";
    echo "Your Last name:". " ". $NameSecond;
    echo "<br>";
    echo "Your address:". " ". $Address;
    echo "<br>";
    echo "Your age:". " ". $Age;
    echo "<br>";

}
?>

<?php
// Connects to the database and selects the picture from the image database to be displayed.
require_once 'conn.php';
$query = $conn->query("SELECT * FROM images") or die ("Failed to fetch row!");
while ($data = $query->fetchArray()) {
    $d1 = $data[1];
}
echo "Profile picture:";
echo "<br>";
echo "<img src='uploads/" . $d1 . "' width='100' height='100'>";



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

<script src="../../Downloads/Assessment_03_Starting_Template/Assessment_03_Starting_Template/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>

</body>
</html>
