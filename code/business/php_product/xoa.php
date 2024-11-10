<?php
    require_once 'ketnoi.php';
    $id = $_GET['id'];
    $xoasql = "DELETE FROM PRODUCTS WHERE id = $id";
    
    if (mysqli_query($connect, $xoasql)) {
        header("Location: ../Product.php");
    } else {
        echo "Lỗi khi xóa sản phẩm: " . mysqli_error($connect);
    }
?>
