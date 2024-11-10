<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_qllinhkien";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, price, image FROM products limit 20";
$result = $conn->query($sql);

$product = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $product[] = $row;
    }
}

echo json_encode($product);

$conn->close();
?>
