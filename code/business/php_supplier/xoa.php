<?php
    require_once 'ketnoi.php';
    $id = $_GET['sid'];
    $sql = "DELETE from Supplier where id=$id";
    if (mysqli_query($connect,$sql))
    header("Location:../Supplier.php");
?>