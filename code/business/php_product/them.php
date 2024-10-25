<?php
    require_once "ketnoi.php";
    $id_supp=$_POST["productSupplier"];
    $id_cata=$_POST["productCategory"];
    $name=$_POST["productName"];
    $price=$_POST["productPrice"];
    $image=$_POST["productImage"];
    $des=$_POST["productDescription"];
    $quan=$_POST["productQuantity"];
    $sql = "INSERT INTO 
    `product`( `name`, `price`, `id_supplier`, `id_prodcate`,`image`,`description`,`quantity`) 
    VALUES ('$name','$price','$id_supp','$id_cata','$image','$des','$quan')";
    // echo "$sql"; exit;
    if (mysqli_query($connect,$sql))
    header("Location: ../Product.php");

    
?>
