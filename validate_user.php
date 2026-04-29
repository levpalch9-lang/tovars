<?php
session_start();
include "bdconnect.php";
$id_user=-1;
if (isset($_SESSION["logged"]) && $_SESSION["logged"]=="1") {
    $id_user=$_SESSION["userid"];
    $user_query=mysqli_query($link,"SELECT * FROM users WHERE id='".$id_user."'");
}
$user=mysqli_fetch_array($user_query);
?>