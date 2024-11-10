


<?php
require_once 'ketnoi.php';
$id = $_GET['sid'];

$sql = "SELECT COUNT(*) as count FROM products WHERE id_prodcate='$id'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    echo "<script>
            alert('Không thể xóa nhà danh mục này vì có sản phẩm đang liên kết');
            window.location.href = '../Category.php'; // Trở về trang danh sách nhà cung cấp
          </script>";
} else {
    $xoasql="DELETE FROM PRODUCT_CATEGORY WHERE id=$id";
    if (mysqli_query($connect,$xoasql))
    header("Location: ../Category.php");
   }

?>
