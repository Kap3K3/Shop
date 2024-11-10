<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "Bạn cần đăng nhập để xem đơn hàng.";
    exit;
}

// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
 $dbname = "db_qllinhkien";
//$dbname = 'cu2_qllinhkien';

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$user_id = $_SESSION['id_user'];

// Truy vấn đơn hàng và chi tiết đơn hàng của người dùng
$sql = "SELECT o.id AS order_id, o.date, o.total_price, 
               od.id_prod, od.quantity, 
               p.name AS product_name, p.price AS product_price
        FROM orders o
        JOIN order_details od ON o.id = od.id_order
        JOIN products p ON od.id_prod = p.id
        WHERE o.id_cust = ?
        ORDER BY o.date DESC, o.id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[$row['order_id']]['date'] = $row['date'];
    $orders[$row['order_id']]['total_price'] = $row['total_price'];
    $orders[$row['order_id']]['details'][] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Hàng Của Tôi</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/order.css">
</head>
<body>
    <?php include '../php/header.php'; ?>
    <?php include '../php/side.php'; ?>
    <div class="main">
        <h2>Thông Tin Đơn Hàng</h2>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order_id => $order): ?>
                <div class="order">
                    <p>Ngày Đặt Hàng: <?php echo htmlspecialchars($order['date']); ?></p>
                    <p>Tổng Giá: <?php echo htmlspecialchars($order['total_price']); ?> VND</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Tên Sản Phẩm</th>
                                <th>Số Lượng</th>
                                <th>Giá</th>
                                <th>Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['details'] as $detail): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($detail['product_name']); ?></td>
                                    <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($detail['product_price']); ?> VND</td>
                                    <td><?php echo htmlspecialchars($detail['quantity'] * $detail['product_price']); ?> VND</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>
    </div>
    <?php include '../php/footer.php'; ?>
</body>
</html>
