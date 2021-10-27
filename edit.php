<!-- Allow user to access webpages easily through a navigation bar-->
<?php include "template.php";
/**
 *  This is the user's profile page.
 * It shows the Users details including picture, and a link to edit the details.
 *
 * @var SQLite3 $conn
 */

ob_start();
?>
<!-- Title reflects page contents-->
<title>Edit your Profile</title>

<h1 class='text-primary'>Edit Your Profile</h1>

<?php
//Checks if user is logged in. If not, they are redirected to login page
if (isset($_GET["user_id"])) {
    $userToLoad = $_GET["user_id"];
} else {
    header("location:index.php");
}
//Selects all information from user database where user id is the same as the person currently logged in
$query = $conn->query("SELECT * FROM user WHERE user_id='$userToLoad'");
    $userData = $query->fetchArray();
    //Setting the data from the user table as variables to distinguish their purpose
    $user_id = $userData[0];
    $userName = $userData[1];
    $password = $userData[2];
    $name = $userData[3];
    $profilePic = $userData[4];
    $accessLevel = $userData[5];
    $varemail = $userData[6];
    $varaddress = $userData[7];
    $varphone = $userData[8];

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <!--Prints current user information on webpage-->
            <h3>Username : <?php echo $userName; ?></h3>
            <p> Name : <?php echo $name ?> </p>
            <p> Email : <?php echo $varemail ?> </p>
            <p> Address : <?php echo $varaddress ?> </p>
            <p> Phone Number : <?php echo $varphone ?> </p>
            <p> Access Level : <?php echo $accessLevel ?> </p>
            <p>Profile Picture:</p>
            <?php echo "<img src='uploads/" . $profilePic . "' width='100' height='100'>" ?>
        </div>
        <div class="col-md-6">
            <!-- Creates a button to upload files and submit information-->
            <!--Then prints updated information onto webpage-->
            <form action="edit.php?user_id=<?php echo $user_id ?>" method="post"
                  enctype="multipart/form-data">
            <p>Name: <input type="text" name="name" value="<?php echo $name ?>"></p>
                <p>Email: <input type="text" name="email" value="<?php echo $varemail ?>"></p>
                <p>Address: <input type="text" name="address" value="<?php echo $varaddress ?>"></p>
                <p>Phone Number: <input type="text" name="phone" value="<?php echo $varphone ?>"></p>
                <p>Access Level: <input type="text" name="accessLevel" value="<?php echo $accessLevel ?>"></p>
                <p>Profile Picture: <input type="file" name ="file"></p>
                <input type="submit" name="formSubmit" value="Submit">
            </form>
        </div>
    </div>
</div>

<?php
//Code below sanitises data and prevents against XSS attacks
if ($_SERVER["REQUEST_METHOD"]== "POST") {
    $newName = sanitise_data($_POST['name']);
    $newEmail = sanitise_data($_POST['email']);
    $newAddress = sanitise_data($_POST['address']);
    $newPhone = sanitise_data($_POST['phone']);
    $newAccessLevel = sanitise_data($_POST['accessLevel']);

//Whatever the user enters in the submission boxes will replace the data that is in the database
    $sql = "UPDATE user SET name = :newName, email = :newEmail, address = :newAddress, phone = :newPhone, accessLevel=:newAccessLevel WHERE username='$userName'";
    $sqlStmt = $conn->prepare($sql);
    $sqlStmt->bindValue(":newName", $newName);
    $sqlStmt->bindValue(":newEmail", $newEmail);
    $sqlStmt->bindValue(":newAddress", $newAddress);
    $sqlStmt->bindValue(":newPhone", $newPhone);
    if ($accessLevel == "Administrator") {
        $sqlStmt->bindValue(":newAccessLevel", $newAccessLevel);
    } else {
        $sqlStmt->bindValue(":newAccessLevel", $accessLevel);
    }
    $sqlStmt->execute();

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
                $fileDestination = 'uploads/' . $fileNameNew;
                //command to upload.
                move_uploaded_file($fileTmpName, $fileDestination);

                $sql = "UPDATE user SET profilePic=:newFileName WHERE username='$userName'";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':newFileName', $fileNameNew);
                $stmt->execute();
                header("location:profile.php");
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
