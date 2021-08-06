<?php include "template.php"; ?>
<title>User Profile</title>

<h1 class='text-primary'>Profile Page</h1>

<?php
$query=$conn->query("SELECT * FROM 'user'") or die ("Failed to fetch row!");
while ($data=$query->fetchArray())
{

}
