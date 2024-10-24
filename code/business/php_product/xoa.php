<?php
    require_once 'ketnoi.php';
    $id=$_GET['id'];
    $xoasql="DELETE FROM PRODUCT WHERE id=$id";
    if (mysqli_query($connect,$xoasql))
    header("Location: ../Product.php");




?>