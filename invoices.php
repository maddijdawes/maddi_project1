<?php include "template.php"; ?>
<title>Invoicing</title>
<?php
/**
 * Invoicing page
 * This page is used for different cases:
 * 1) Users to view their "open" orders as a list.
 * 2) Users to view invoices from individual orders (using the order variable in url)
 * 3) Inform users if they have not previously made any orders.
 * 4) Administrators to view all orders.
 * 5) If user is not logged in, then redirect them to index.php
 *
 * "Defines" the conn variable, removing the undefined variable errors.
 * @var SQLite3 $conn
 */
?>

<?php
if (empty($_GET["order"])) { // Showing the list of open order (case 1)
    echo "<h1 class='text-primary'>Invoices</h1>";
    echo "<h2 class='text-primary'>Choose your invoice number below.</h2>";
    // If user is logged in and they are an admin, then they can view all orders from the 'rder' table
    if (isset($_SESSION["user_id"])) { // Case 1 or 3?
        if($_SESSION["level"] =="Administrator") {
            $query = $conn->query("SELECT orderCode FROM rder");
            $count = $conn->querySingle("SELECT orderCode FROM `rder`");
        } else {
            // If user is logged in and their access level is 'user', then they can only view their open orders
            $userID = $_SESSION["user_id"];
            $query = $conn->query("SELECT orderCode FROM rder WHERE customerID='$userID' AND status='OPEN'");
            $count = $conn->querySingle("SELECT orderCode FROM `rder` WHERE customerID='$userID' AND status='OPEN'");
        }
        $orderCodesForUser = [];
        if ($count > 0){  // Has the User made orders previously? Case 1
            while ($data = $query->fetchArray()) {
                $orderCode = $data[0];
                array_push($orderCodesForUser, $orderCode);
            }
            echo "<p>";

            //Gets the unique order numbers from the extracted table above.
            $unique_orders = array_unique($orderCodesForUser);
            // Produce a list of links of the Orders for the user.
            // Opens a new page for in invoices that displays the specific order that they clicked on
            foreach ($unique_orders as $order_ID) {
                echo "<p><a href='invoices.php?order=" . $order_ID . "'>Order : " . $order_ID . "</a></p>";
            }
        } else { // Case 3
            echo "<p class='alert-danger'>You don't have any open orders. Please make an order to view them</p>";
        }
    } else {// Case 5
        header("Location:index.php");
    }
} else {// Case 2 - There is an order code in the URL
    //Displays the user's order details, from what they purchased, the subtotal, quantity and price of the individual items
    $order_id = $_GET["order"];
    echo"<h1 class='text-primary'>Invoice -". $order_id ."</h1>";
    $query = $conn->query("SELECT p.productName, p.price, o.quantity, p.price*o.quantity as SubTotal, o.orderDate, o.status FROM rder o INNER JOIN products p on o.productCode = p.code WHERE orderCode='$order_id'");

    $total = 0;
    //Page headers
    echo"<div class='container-fluid'><div class='row'><div class='col text-success'>Product Name</div><div class='col text-success'>Price</div><div class='col text-success'>Quantity</div><div class='col text-success'>Subtotal</div></div>";
    while($data = $query->fetchArray()) {
        echo"<div class='row'>";
        //Collecting the data on from the order table and printing it on webpage
        $productName = $data[0];
        $price = $data[1];
        $quantity = $data[2];
        $subtotal = $data[3];
        $orderDate = $data[4];
        $status = $data[5];
        $total = $total + $subtotal;
        echo"<div class='col'>". $productName ."</div>";
        echo"<div class='col'>$". $price ."</div>";
        echo"<div class='col'>". $quantity ."</div>";
        echo"<div class='col'>$". $subtotal ."</div>";

        echo"</div>";
    }

    echo"<div class='row'><div class='col'></div><div class='col'></div><div class='col display-4'>Total : $". $total ."</div></div>";
    echo"<div class='row'><div class='col'></div><div class='col'></div><div class='col'>". $orderDate ."</div></div>";
   //If admin is logged in, they can decide to close an order or leave it open
    if ($_SESSION["level"] == "Administrator") {
        if (!empty($_GET["status"])) {
            if ($_GET["status"]=="CLOSED") {
                $conn->exec("UPDATE rder SET status='CLOSED' WHERE orderCode='$order_id'");
                $orderMessage = "Order #:".$order_id." has been dispatched";
                $customer_id = $conn->querySingle("SELECT customerID FROM rder WHERE orderCode = '$order_id'");
                $conn->exec("INSERT INTO messaging (sender, recipient, message, dateSubmitted) VALUES ('1', $customer_id,'$orderMessage', '$orderDate')");
            } else {
                $conn->exec("UPDATE rder SET status='OPEN' WHERE orderCode='$order_id'");
                $orderMessage = "Order #:".$order_id." has been re-opened";
                $customer_id = $conn->querySingle("SELECT customerID FROM rder WHERE orderCode = '$order_id'");
                $conn->exec("INSERT INTO messaging (sender, recipient, message, dateSubmitted) VALUES ('1', $customer_id,'$orderMessage', '$orderDate')");
            }
        }
        if ($status=="OPEN") {
            echo "STATUS: OPEN";
            echo "<p><a href='invoices.php?order=".$order_id."&status=CLOSED'>Click here to close</a></p>";
        } else {
            echo "STATUS: CLOSED";
            echo "<p><a href='invoices.php?order=".$order_id."&status=OPEN'>Click here to open</a></p>";
        }
    }
}

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
