<?php include "template.php"; ?>

<title>Home Page</title>


<h1 class='text-primary'>Welcome to our shopfront</h1>
<?php
// Prints the username and password onto the login page
echo "username: admin";
echo "<br>";
echo "password: admin";
echo "<br>";
echo "username: maddi";
echo "<br>";
echo "password: maddi";
echo "<br>";
echo "username: user";
echo "<br>";
echo "password: user";
echo "<br>";
echo "<br>";
?>

<?php
//If user is not logged in, a login button will appear prompting them to enter their username and password
if (!isset($_SESSION["username"])) : ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required="required"/>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required="required"/>
        </div>

        <center>
            <button name="login" class="btn btn-primary"><span
                        class="glyphicon glyphicon-log-in"></span> Login
            </button>
        </center>
    </form>
<?php endif; ?>
</body>
</html>

<?php include 'login.php'; ?>



