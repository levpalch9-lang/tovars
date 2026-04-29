<?php
session_start();
include "bdconnect.php";

if(isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = (int)$_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];
    if($quantity > 0) {
        mysqli_query($link, "UPDATE orders SET quantity = $quantity WHERE id = $cart_id");
    }
}
header("Location: cart.php");
exit();
?>