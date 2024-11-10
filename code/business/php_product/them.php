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
    `products` (`name`, `price`, `id_supplier`, `id_prodcate`, `image`, `description`, `quantity`)
    VALUES ('$name','$price','$id_supp','$id_cata','$image','$des','$quan')";
    // echo "$sql"; exit;
    if (mysqli_query($connect,$sql))
    header("Location: ../Product.php");

    
?>
<!-- INSERT INTO 
    `products` (`name`, `price`, `id_supplier`, `id_prodcate`, `image`, `description`, `quantity`)
VALUES 
    ('Linh kiện A', 100, 1, 6, 'image/linhkienA.jpg', 'Linh kiện chất lượng cao', 50); -->
