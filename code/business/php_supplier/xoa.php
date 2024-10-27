<?php
require_once 'ketnoi.php';
$id = $_GET['sid'];

$sql = "SELECT COUNT(*) as count FROM product WHERE id_supplier='$id'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    echo "<script>
            alert('Không thể xóa nhà cung cấp này vì có sản phẩm đang liên kết');
            window.location.href = '../Supplier.php'; // Trở về trang danh sách nhà cung cấp
          </script>";
} else {
    $sql = "DELETE FROM Supplier WHERE id=$id";
    if (mysqli_query($connect, $sql)) {
        header("Location: ../Supplier.php");
        exit; // Dừng thực thi script sau khi chuyển hướng
    }
}
?>
