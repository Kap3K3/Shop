<?php
session_start();

// Thiết lập xử lý lỗi
error_reporting(E_ALL);
ini_set('display_errors', 0); // Không hiển thị lỗi trên trình duyệt
ini_set('log_errors', 1);
ini_set('error_log', 'path/to/your/error_log.log'); // Ghi lỗi vào file log

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập']);
    exit;
}

$user_id = $_SESSION['id_user'];
$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['productId'] ?? 0;
$quantity = $data['quantity'];

if ($productId == 0) {
    echo json_encode(['success' => false, 'message' => 'Không có sản phẩm nào được chọn']);
    exit;
}

// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_qllinhkien";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    error_log('Database connection error: ' . $conn->connect_error);
    echo json_encode(['success' => false, 'message' => 'Kết nối thất bại']);
    exit;
}

// Kiểm tra nếu giỏ hàng đã tồn tại, nếu chưa thì tạo mới
$sql = "SELECT cart_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log('Prepare statement error: ' . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Prepare statement error']);
    exit;
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cart_id = $row['cart_id'];
} else {
    $stmt = $conn->prepare("INSERT INTO cart (user_id, date_created) VALUES (?, NOW())");
    if (!$stmt) {
        error_log('Prepare statement error: ' . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Prepare statement error']);
        exit;
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->insert_id;
    $stmt->close();
}

// Thêm sản phẩm vào giỏ hàng
$stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, date_added) VALUES (?, ?, $quantity, NOW())");
if (!$stmt) {
    error_log('Prepare statement error: ' . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Prepare statement error']);
    exit;
}
$stmt->bind_param("ii", $cart_id, $productId);
$stmt->execute();
$stmt->close();

$conn->close();

echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng']);
?>
