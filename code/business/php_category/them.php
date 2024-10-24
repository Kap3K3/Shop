

<?php
        require_once 'ketnoi.php';
    $name=$_POST["name"];
    $sql = " INSERT INTO product_catagory(name) VALUES ('$name') ";
    if (mysqli_query($connect,$sql))
        header("Location: ../Category.php");




?>
