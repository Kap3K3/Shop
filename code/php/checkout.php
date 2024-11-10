<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập']);
    exit;
}

$user_id = $_SESSION['id_user'];
$data = json_decode(file_get_contents('php://input'), true);
$selectedItems = $data['selectedItems'] ?? [];

if (empty($selectedItems)) {
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
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Bắt đầu transaction
$conn->begin_transaction();

try {
    // Tính tổng giá trị đơn hàng và kiểm tra số lượng sản phẩm
    $totalPrice = 0;
    $outOfStockItems = [];
    foreach ($selectedItems as $itemId) {
        $stmt = $conn->prepare("SELECT ci.quantity, p.price, p.quantity as product_quantity, p.name FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.cart_item_id = ?");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if ($row['product_quantity'] < $row['quantity']) {
                $outOfStockItems[] = $row['name'];
            } else {
                $totalPrice += $row['quantity'] * $row['price'];
            }
        }
        $stmt->close();
    }

    if (!empty($outOfStockItems)) {
        throw new Exception("Các sản phẩm đã hết hàng: " . implode(", ", $outOfStockItems));
    }

    // Tạo đơn hàng mới
    $stmt = $conn->prepare("INSERT INTO orders (id_cust, date, total_price) VALUES (?, NOW(), ?)");
    $stmt->bind_param("ii", $user_id, $totalPrice);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Thêm chi tiết đơn hàng và xóa khỏi giỏ hàng
    foreach ($selectedItems as $itemId) {
        // Lấy thông tin sản phẩm từ giỏ hàng
        $stmt = $conn->prepare("SELECT product_id, quantity FROM cart_items WHERE cart_item_id = ?");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Thêm vào chi tiết đơn hàng
            $stmt = $conn->prepare("INSERT INTO order_details (id_prod, id_order, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $row['product_id'], $orderId, $row['quantity']);
            $stmt->execute();
            $stmt->close();

            // Giảm số lượng sản phẩm trong bảng products
            $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
            $stmt->bind_param("ii", $row['quantity'], $row['product_id']);
            $stmt->execute();
            $stmt->close();

            // Xóa khỏi giỏ hàng
            $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_item_id = ?");
            $stmt->bind_param("i", $itemId);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Thanh toán thành công']);
} catch (Exception $e) {
    // Rollback transaction nếu có lỗi
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
