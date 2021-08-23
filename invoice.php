<?php
include "template.php";


$query = $conn->query("SELECT * FROM 'rder'") or die("Failed to fetch row!");
while ($data = $query->fetchArray()) {

    // Customer Details
    $cusNameFirst = $data[1];
    $cusNameSecond = $data[2];
    $cusAddress = $data[3];
    $cusEmail = $data[4];
    $cusPhone = $data[5];

    // Product Quantities
    $prod1Quantity = $data[6];
    $prod2Quantity = $data[7];
    $prod3Quantity = $data[8];
    $prod4Quantity = $data[9];
    $prod5Quantity = $data[10];
}

//echo "Loaded Data: " . $cusNameFirst . $cusNameSecond . $cusAddress . $cusEmail . $cusPhone . $prodQuantity1 . $prodQuantity2 . $prodQuantity3 . $prodQuantity4 . $prodQuantity5;

$prod1ItemCost = 3.4;
$prod2ItemCost = 5.0;
$prod3ItemCost = 12.54;
$prod4ItemCost = 19.77;
$prod5ItemCost = 1.01;

$prod1SubTotal = $prod1Quantity * $prod1ItemCost;
$prod2SubTotal = $prod2Quantity * $prod2ItemCost;
$prod3SubTotal = $prod3Quantity * $prod3ItemCost;
$prod4SubTotal = $prod4Quantity * $prod4ItemCost;
$prod5SubTotal = $prod5Quantity * $prod5ItemCost;
$invoiceTotal = $prod1SubTotal + $prod2SubTotal + $prod3SubTotal + $prod4SubTotal + $prod5SubTotal;


?>
<h1>Invoice</h1>
<p>Customer Name : <b><?= $cusNameFirst ?> <?= $cusNameSecond ?></b></p>
<p>Address : <b><?= $cusAddress ?> </b></p>
<p>Email : <b><?= $cusEmail ?> </b></p>
<p>Phone : <b><?= $cusPhone ?> </b></p>
<h2>Products</h2>
<table border="1" width="100%">
    <tr>
        <th>Product Name</th>
        <th>Item Cost</th>
        <th>Quantity</th>
        <th>Sub total</th>
    </tr>
    <tr>
        <td> Product 1:</td>
        <td>$<?= $prod1ItemCost ?></td>
        <td><?= $prod1Quantity ?></td>
        <td>$<?= $prod1SubTotal ?>    </td>
    </tr>
    <tr>
        <td> Product 2:</td>
        <td>$<?= $prod1ItemCost ?></td>
        <td><?= $prod2Quantity ?></td>
        <td>$<?= $prod2SubTotal ?>     </td>
    </tr>
    <tr>
        <td> Product 3:</td>
        <td>$<?= $prod3ItemCost ?></td>
        <td><?= $prod3Quantity ?></td>
        <td>$<?= $prod3SubTotal ?>    </td>
    </tr>
    <tr>
        <td> Product 4:</td>
        <td>$<?= $prod4ItemCost ?></td>
        <td><?= $prod4Quantity ?></td>
        <td>$<?= $prod4SubTotal ?>     </td>
    </tr>
    <tr>
        <td> Product 5:</td>
        <td>$<?= $prod5ItemCost ?></td>
        <td><?= $prod5Quantity ?></td>
        <td>$<?= $prod5SubTotal ?>     </td>
    </tr>
    <tr>
        <td colspan="3">Total:</td>
        <td>$<?= $invoiceTotal ?></td>
    </tr>

</table>


<script src="../../Downloads/Assessment_03_Starting_Template/Assessment_03_Starting_Template/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>

</body>
?>



<div id="page-wrap">
    <textarea id="header">INVOICE</textarea>
    <div id="identity">

        <textarea id="address">
