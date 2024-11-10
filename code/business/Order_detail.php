<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Hóa Đơn</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        header {
            background-color: #333;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }
        .table-container {
            padding: 2rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Chi Tiết Hóa Đơn</h1>
    </header>
    <div class="table-container">
        <?php
            // Kết nối đến cơ sở dữ liệu
            require_once 'php_category/ketnoi.php';

            // Kiểm tra kết nối
            if (!$connect) {
                echo "Failed Connect";
                exit;
            }

            // Lấy ID hóa đơn từ URL
            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

            // Kiểm tra nếu ID hóa đơn hợp lệ
            if ($order_id <= 0) {
                echo "ID hóa đơn không hợp lệ.";
                exit;
            }

            // Truy vấn lấy thông tin chi tiết hóa đơn
            $sql = "SELECT 
                        order_details.id AS OrderDetailID,
                        products.name AS ProductName,
                        products.price AS ProductPrice,
                        order_details.quantity AS Quantity,
                        (products.price * order_details.quantity) AS TotalProductPrice
                    FROM 
                        order_details
                    JOIN 
                        products ON order_details.id_prod = products.id
                    WHERE 
                        order_details.id_order = $order_id";

            $result = mysqli_query($connect, $sql);

            // Kiểm tra xem có dữ liệu không
            if (mysqli_num_rows($result) > 0) {
                echo "<h2>Chi Tiết Hóa Đơn #$order_id</h2>";
                echo "<table class='table table-bordered'>";
                echo "<thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Giá Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Tổng Giá Trị</th>
                        </tr>
                      </thead>
                      <tbody>";

                $i = 1;
                $totalInvoicePrice = 0; // Biến để tính tổng giá trị hóa đơn
                while ($row = mysqli_fetch_assoc($result)) {
                    $totalProductPrice = $row['TotalProductPrice'];
                    $totalInvoicePrice += $totalProductPrice; // Cộng dồn vào tổng hóa đơn
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row["ProductName"]; ?></td>
                        <td><?php echo number_format($row["ProductPrice"], 0, ',', '.'); ?> VND</td>
                        <td><?php echo $row["Quantity"]; ?></td>
                        <td><?php echo number_format($totalProductPrice, 0, ',', '.'); ?> VND</td>
                    </tr>
                    <?php
                    $i++;
                }

                echo "<tr>
                        <td colspan='4' align='right'><strong>Tổng Hóa Đơn:</strong></td>
                        <td><strong>" . number_format($totalInvoicePrice, 0, ',', '.') . " VND</strong></td>
                      </tr>";
                echo "</tbody></table>";
            } else {
                echo "<p>Không có dữ liệu cho hóa đơn này.</p>";
            }
        ?>
        <a href="Order.php" class="btn btn-secondary">Quay lại</a> <!-- Thay thế 'Order.php' bằng trang danh sách hóa đơn -->
    </div>
    <footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
