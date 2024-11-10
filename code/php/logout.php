<?php
session_start();
session_unset();
session_destroy();
header("Location: ../user/index.php"); // Chuyển hướng về trang chủ sau khi đăng xuất
exit;
?>
