<?php include "template.php"; ?>

<title>Search Users</title>
<h1>Search Users</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

    <div class="form-group">
        <label>Type in UserName</label>
        <input type="search" name="search-user" class="form-control" required="required"/>
    </div>

    <center>
        <button name="search" class="btn btn-primary">Search</button>
    </center>

</form>


<?php
//Checks if user is admin. If they are, the amount of users in the user table is counted and displayed
if (isset($_SESSION['level']) == "Administrator") {
    $userCount = $conn->query("SELECT count(*) FROM user");
    $results = $userCount->fetchArray();
    $userCountNumber = $results[0];
    echo "<br>The number of users is :" . $userCountNumber . "</br>";
//If search button is pressed, the the database will select the username that matches the one that was entered.
    if (isset($_POST['search'])) {
        $userToSearch = ($_POST['search-user']);

        $userSearch = $conn->query("SELECT count(*) as count, * FROM user WHERE username LIKE '$userToSearch'");
        $results = $userSearch->fetchArray();
        $userNumberOfRows = $results[1];
        if ($userNumberOfRows > 0) {
            $user_id = $results[1];
            $username = $results[2];
            $name = $results[4];
            $profilePic = $results[5];
            $accessLevel = $results[6];
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <!--Displays the user's information-->
                        <h3>Username : <?php echo $username; ?></h3>
                        <p>Profile Picture:</p>
                        <?php echo "<img src='images/profilePic/" . $profilePic . "' width='100' height='100'>" ?>
                    </div>
                    <div class="col-md-6">
                        <p> Name : <?php echo $name ?> </p>
                        <p> Access Level : <?php echo $accessLevel ?> </p>
                        <p><a href="edit.php?user_id=<?php echo $user_id ?>" title="Edit">Edit Profile</a></p>
                    </div>


                </div>
            </div>
            <?php
            //If username is not in user table, the admin will  be informed that the user does not exist
        } else {
            echo "No Users Found";
        }

    }
}
?>
