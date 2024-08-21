<?php
require_once('./includes/basehead.html');
require_once('header.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

$cart_id = $_SESSION['cart']['id'];

// delete cart items
$q = "DELETE FROM `cart_item` WHERE (`cart_id` = '$cart_id')";
$r =  mysqli_query($conn, $q) or trigger_error("Query: $q\b<br/>MySQL Error: " . mysqli_error($conn));

mysqli_close($conn);
header("Location: cart.php?s=del");
exit();
