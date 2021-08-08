<?php include "template.php"; ?>
<title>User Profile</title>

<h1 class='text-primary'>Profile Page</h1>

<?php
$u1 = $_SESSION["user_id"];

echo $u1;

$query=$conn->query("SELECT * FROM 'user' WHERE user_id = '$u1'") or die ("Failed to fetch row!");
while ($data=$query->fetchArray())
{
/* fetch associative array */

    $varName = $data[1];
    $varuser = $data[3];
    $varpro = $data[4];
    $varaccess = $data[5];
}

echo "Name:". " ".$varName;
echo "<br>";
echo "Username:". " ".$varuser;
echo "<br>";
echo "Access Level:". " ".$varaccess;



echo "<img src='uploads/".$varpro."' width='500' height='600' >";

?>
</body>
</html>