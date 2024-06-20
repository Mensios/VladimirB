<?php
sesssion_start();
include ("../../connect_db.php");
$id = $_SESSION['id'];

$query = "SELECT * FROM Users WHERE id_user='$id'";
$res = mysqli_query($link, $query);
$user = mysqli_fetch_assoc()
