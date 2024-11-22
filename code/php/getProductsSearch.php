<?php
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

// Lấy từ khóa tìm kiếm từ POST
$input = json_decode(file_get_contents('php://input'), true);
$keyword = isset($input['keyword']) ? $input['keyword'] : '';

$product = [];
if ($keyword) {
    // Truy vấn tìm kiếm sản phẩm gần đúng
    $sql = "SELECT id, name, price, image FROM products WHERE name LIKE '%$keyword%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product[] = $row;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($product);
$conn->close();

// Debugging: Log the response
error_log(json_encode($product));
?>
