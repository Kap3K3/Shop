
    
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
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/btn_buy.css">
</head>
<body>
    <?php include '../php/header.php' ?>
    <?php include '../php/side.php' ?>
    <?php include '../php/search.php' ?>
    <?php include '../php/footer.php' ?>
    <div class="main">
    <h2 style="margin: 10px; font-size:30px;">Kết quả tìm kiếm cho: '<?php echo htmlspecialchars($keyword); ?>'</h2>
    <div class="product-list">
        <?php if (!empty($product)): ?>
            <?php foreach ($product as $item): ?>
                <div class="product bg-red-50">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="">
                    <h2><?php echo htmlspecialchars($item["name"]); ?></h2>
                    <p>Giá: <?php echo htmlspecialchars($item["price"]); ?> VND</p>
                    <button class="custom-button btn-7 buy-button"><span>Mua</span></button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không tìm thấy sản phẩm nào.</p>
        <?php endif; ?>
    </div>
    </div>
    
</body>
</html>
