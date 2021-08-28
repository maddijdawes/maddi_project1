<?php include "template.php"; ?>
<title>User Registration</title>
<h1 class='text-primary'>User Registration</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <!--Customer Details-->

            <div class="col-md-6">
                <h2>Account Details</h2>
                <p>Please enter wanted username and password:</p>
                <p>User Name<input type="text" name="username" class="form-control" required="required"></p>
                <p>Password<input type="password" name="password" class="form-control" required="required"></p>

            </div>
            <div class="col-md-6">
                <h2>More Details</h2>
                <!--More user details-->
                <p>Please enter More Personal Details:</p>
                <p>Name<input type="text" name="name" class="form-control" required="required"></p>
                <p>Email<input type="text" name="email" class="form-control" required="required"></p>
                <p>Address<input type="text" name="address" class="form-control" required="required"></p>
                <p>Phone<input type="text" name="phone" class="form-control" required="required"></p>
                <p>Profile Picture <input type="file" name="file" class="form-control" required="required"></p>
            </div>
        </div>
    </div>
    <input type="submit" name="formSubmit" value="Submit">
</form>

<?php
// If a form is submitted, the data will be sanitised
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    Customer Details
    $username = sanitise_data($_POST['username']);
    $password = sanitise_data($_POST['password']);
    $name = sanitise_data($_POST['name']);
    $email = sanitise_data($_POST['email']);
    $address = sanitise_data($_POST['address']);
    $phone = sanitise_data($_POST['phone']);

//check if user exists.
    $query = $conn->query("SELECT COUNT(*) FROM user WHERE username='$username'");
    $data = $query->fetchArray();
    $numberOfUsers = (int)$data[0];

    if ($numberOfUsers > 0) {
        echo "Sorry, username already taken";
    } else {
// User Registration commences

//for the user-hashed table.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//for the image table.
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
                    $sql = "INSERT INTO user (username, password, name, profilePic, accessLevel) VALUES (:newUsername, :newPassword, :newName, :newImage, 'User')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':newUsername', $username);
                    $stmt->bindValue(':newPassword', $hashed_password);
                    $stmt->bindValue(':newName', $name);
                    $stmt->bindValue(':newImage', $fileNameNew);
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