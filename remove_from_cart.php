<?php
session_start();
include "bdconnect.php";

if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($link, "DELETE FROM orders WHERE id = $id");
}

header("Location: cart.php");
exit();
?> 