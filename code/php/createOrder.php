<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập']);
    exit;
}

$user_id = $_SESSION['id_user'];
$data = json_decode(file_get_contents('php://input'), true);

if (is_null($data) || !isset($data['productId']) || !isset($data['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu yêu cầu không hợp lệ.']);
    exit;
}

$productId = $data['productId'];
$quantity = $data['quantity'];

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

// Truy vấn để lấy id_cust từ bảng users
$sql = "SELECT id_cust FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $id_cust = $user['id_cust'];
}

// Bắt đầu transaction
$conn->begin_transaction();

try {
    // Tính tổng giá trị đơn hàng
    $stmt = $conn->prepare("SELECT p.price FROM products p WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $totalPrice = 0;
    if ($row = $result->fetch_assoc()) {
        $totalPrice = $quantity * $row['price'];
    } else {
        throw new Exception("Sản phẩm không tồn tại.");
    }
    $stmt->close();

    // Tạo đơn hàng mới
    $stmt = $conn->prepare("INSERT INTO orders (id_cust, date, total_price) VALUES (?, NOW(), ?)");
    $stmt->bind_param("ii", $user_id, $totalPrice);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Thêm vào chi tiết đơn hàng
    $stmt = $conn->prepare("INSERT INTO order_details (id_prod, id_order, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $productId, $orderId, $quantity);
    $stmt->execute();
    $stmt->close();

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Thanh toán thành công']);
} catch (Exception $e) {
    // Rollback transaction nếu có lỗi
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại.', 'error' => $e->getMessage()]);
}

$conn->close();
?>
