<?php
    require_once "ketnoi.php";
    $id_supp=$_POST["productSupplier"];
    $id_cata=$_POST["productCategory"];
    $name=$_POST["productName"];
    $price=$_POST["productPrice"];
    $sql = "INSERT INTO `product`( `name`, `price`, `id_supplier`, `id_prodcate`) VALUES ('$name','$price','$id_supp','$id_cata')";
    if (mysqli_query($connect,$sql))
    header("Location: ../Product.php");

    
?>
