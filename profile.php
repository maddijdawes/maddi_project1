<?php include "template.php"; ?>
<h1 class='text-primary'>Profile Page</h1>

</head>
<body>
<table border="1" width="50%">
    <tr>

        <th><a href="edit.php">Edit Profile</a></th>
    </tr>
</table>


<?php
$u1 = $_SESSION["user_id"];


//Selects all information from user table where the user_id is congruent with the session variable
$query=$conn->query("SELECT * FROM 'user' WHERE user_id = '$u1'") or die ("Failed to fetch row!");
while ($data=$query->fetchArray())
{
/* fetch associative array */
//Sets the data to its corresponding categories
    $varName = $data[1];
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
</body>
</html>


