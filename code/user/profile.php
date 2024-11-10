<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header("Location: ../user/login.php");
//     exit;
// }

// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_qllinhkien";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy user_id từ session
$user_id = $_SESSION['id_user'];

// Truy vấn để lấy thông tin customer dựa trên user_id
$sql = "SELECT customer.name, customer.phone FROM customer
        JOIN users ON customer.id = users.id_cust
        WHERE users.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$customer = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <?php 
    include "../php/header.php";
    include '../php/side.php';
    include '../php/footer.php';
    ?>
    <div class="main">
        <h2>Thông tin cá nhân</h2>
        <table>
            <tr>
                <th>Tên</th>
                <td><?php echo htmlspecialchars($customer['name']); ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
