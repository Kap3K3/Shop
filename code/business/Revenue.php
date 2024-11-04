<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Doanh Thu</title>
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

        nav {
            background-color: #444;
            color: white;
            padding: 1rem 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        nav ul li {
            display: inline-block;
            margin: 0 1rem;
        }

        nav ul li a {
            color: #fff; /* Màu chữ ban đầu */
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s; 
        }

        nav ul li a:hover {
            background-color: #007bff; /* Màu nền khi hover */
            color: #fff; /* Màu chữ khi hover */
        }

        main {
            display: flex;
            flex: 1;
            padding: 2rem;
            gap: 2rem;
        }

        .table-container {
            flex: 1;
        }

        h2 {
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 0.5rem;
            text-align: center;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Doanh Thu</h1>
    </header>
    <nav>
        <ul>
        <li><a href="Category.php">Danh mục sản phẩm</a></li>
            <li><a href="Product.php">Sản phẩm</a></li>
            <li><a href="Supplier.php">Nhà cung cấp</a></li>
            <li><a href="Order.php">Hóa đơn</a></li>
            <li><a href="Customer.php">Khách hàng</a></li>
            <li><a href="Revenue.php">Thống kê</a></li>

        </ul>
    </nav>

    <main>
        <div class="table-container">
            <h2>Thống Kê Doanh Thu Theo Tháng</h2>
            <form method="POST" class="mb-3">
                <div class="form-row">
                    <div class="col">
                        <label for="month">Chọn Tháng:</label>
                        <select name="month" id="month" class="form-control" required>
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?php echo $m; ?>"><?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="year">Chọn Năm:</label>
                        <select name="year" id="year" class="form-control" required>
                            <?php 
                            $currentYear = date("Y");
                            for ($y = $currentYear - 5; $y <= $currentYear; $y++): ?>
                                <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Thống Kê</button>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tháng-Năm</th>
                        <th>Tổng Giá Trị Hóa Đơn</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    require_once 'php_category/ketnoi.php'; // Kết nối đến cơ sở dữ liệu

                    // Lấy giá trị tháng và năm từ form
                    $selectedMonth = isset($_POST['month']) ? $_POST['month'] : date('n');
                    $selectedYear = isset($_POST['year']) ? $_POST['year'] : date('Y');

                    // Câu truy vấn SQL để lấy dữ liệu
                    $sql = "SELECT 
                                DATE_FORMAT(orders.date, '%Y-%m') AS MonthYear,
                                SUM(IFNULL(product.price * order_detail.quantity, 0)) AS TotalInvoicePrice
                            FROM 
                                orders
                            LEFT JOIN 
                                order_detail ON orders.id = order_detail.id_order
                            LEFT JOIN 
                                product ON order_detail.id_prod = product.id
                            WHERE 
                                MONTH(orders.date) = $selectedMonth AND YEAR(orders.date) = $selectedYear
                            GROUP BY 
                                MonthYear
                            HAVING 
                                TotalInvoicePrice > 0
                            ORDER BY 
                                MonthYear DESC";

                    $result = mysqli_query($connect, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Chuyển đổi MonthYear sang định dạng tháng và năm
                            $formattedMonthYear = date("m-Y", strtotime($row["MonthYear"]));
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $formattedMonthYear; ?></td>
                                <td><?php echo number_format($row["TotalInvoicePrice"], 0, ',', '.'); ?> VND</td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else {
                        echo '<tr><td colspan="3" class="alert alert-warning">Không có hóa đơn nào.</td></tr>';
                    }
                ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
