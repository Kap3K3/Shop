<?php
 require_once 'ketnoi.php';
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $sql = "INSERT INTO supplier(name,phone,address) VALUES ('$name','$phone','$address')";
    // echo $sql; exit;
    if (mysqli_query($connect,$sql))
        header("Location: ../Supplier.php");
?>