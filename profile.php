<?php include "template.php"; ?>

<h1 class='text-primary'>Profile Page</h1>

<?php
$u1 = $_SESSION["user_id"];


//Selects all information from user table where the user_id is congruent with the session variable
$query=$conn->query("SELECT * FROM 'user' WHERE user_id = '$u1'") or die ("Failed to fetch row!");
while ($data=$query->fetchArray())
{
/* fetch associative array */
//Sets the data to its corresponding categories
    $varName = $data[1];
    $user_id = $data[0];
    $varuser = $data[3];
    $varpro = $data[4];
    $varaccess = $data[5];
    $varemail = $data[6];
    $varaddress = $data[7];
    $varphone = $data[8];
}
//Prints user information on webpage
echo "Name:". " ".$varName;
echo "<br>";
echo "Username:". " ".$varuser;
echo "<br>";
echo "Access Level:". " ".$varaccess;
echo "<br>";
echo "Email Address:". " ".$varemail;
echo "<br>";
echo "Home Address:". " ".$varaddress;
echo "<br>";
echo "Phone Number:". " ".$varphone;
echo "<br>";



echo "<img src='uploads/".$varpro."' width='500' height='600' >";

?>

</head>
<body>
<table border="1" width="50%">
    <tr>

        <p><a href="edit.php?user_id=<?php echo $user_id ?>" title="Edit">Edit Profile</a></p>
    </tr>
</table>
</body>
</html>
<?php
//Prints messages from message table where the user id matches the current one
$numberOfRowsReturned = $conn->querySingle("SELECT count(*) FROM messaging WHERE recipient='$u1'");

if ($numberOfRowsReturned > 0) {
    $messages = $conn->query("SELECT * FROM messaging WHERE recipient='$u1'");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 text-success"><h2>From</h2></div>
        <div class="col-md-4 text-success"><h2>Message</h2></div>
        <div class="col-md-4 text-success"><h2>Date Sent</h2></div>
    </div>

<?php
    //Displays the username as the sender on message table
while($individual_message = $messages->fetchArray()) {
    $sender = $individual_message[1];
    $message = $individual_message[3];
    $dateSubmitted = $individual_message[4];
    $senderName = $conn->querySingle("SELECT username FROM user WHERE user_id='$sender'");

    ?>
    <divclass="row">
    <divclass="col-md-4">


    <?php
    //If it can't display username, display user id instead
    if (!$senderName) {
        echo $sender;
    } else {
        echo $senderName;
    }
    ?>


    </div>

    <divclass="col-md-4"><?php echo $message;?></div>
    <divclass="col-md-4"><?php echo $dateSubmitted;?></div>
    </div>

    <?php
}

?>
<?php
}
?>
