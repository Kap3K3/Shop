

<?php
    require_once 'ketnoi.php';
    $id=$_GET['sid'];
    $xoasql="DELETE FROM PRODUCT_CATAGORY WHERE id=$id";
    if (mysqli_query($connect,$xoasql))
    header("Location: ../Category.php");

?>
