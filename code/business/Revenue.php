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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav ul li a:hover {
            background-color: #007bff;
            color: #fff;
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

        .chart-container {
            flex: 1;
            padding: 1rem;
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
            <h2>Thống Kê Doanh Thu</h2>
            <form method="POST" class="mb-3">
                <div class="form-row">
                    <div class="col">
                        <label for="startMonth">Chọn Tháng Bắt Đầu:</label>
                        <select name="startMonth" id="startMonth" class="form-control" required>
                            <?php 
                                $currentMonth = date('m');  // Lấy tháng hiện tại
                                for ($m = 1; $m <= 12; $m++): 
                            ?>
                                <option value="<?php echo $m; ?>" <?php echo ($m == $currentMonth) ? 'selected' : ''; ?>>
                                    <?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="endMonth">Chọn Tháng Kết Thúc:</label>
                        <select name="endMonth" id="endMonth" class="form-control" required>
                            <option value="<?php echo $currentMonth; ?>" selected>
                                <?php echo str_pad($currentMonth, 2, '0', STR_PAD_LEFT); ?>
                            </option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="year">Chọn Năm:</label>
                        <select name="year" id="year" class="form-control" required>
                            <?php 
                                $currentYear = date("Y");
                                for ($y = $currentYear - 5; $y <= $currentYear; $y++): ?>
                                    <option value="<?php echo $y; ?>" <?php echo ($y == $currentYear) ? 'selected' : ''; ?>>
                                        <?php echo $y; ?>
                                    </option>
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
                    require_once 'php_category/ketnoi.php';

                    $startMonth = isset($_POST['startMonth']) ? $_POST['startMonth'] : $currentMonth;
                    $endMonth = isset($_POST['endMonth']) ? $_POST['endMonth'] : $currentMonth;
                    $selectedYear = isset($_POST['year']) ? $_POST['year'] : date('Y');

                    // Truy vấn dữ liệu theo tháng từ đến
                    $sql = "SELECT 
                                DATE_FORMAT(orders.date, '%Y-%m') AS MonthYear,
                                SUM(IFNULL(products.price * order_details.quantity, 0)) AS TotalInvoicePrice
                            FROM 
                                orders
                            LEFT JOIN 
                                order_details ON orders.id = order_details.id_order
                            LEFT JOIN 
                                products ON order_details.id_prod = products.id
                            WHERE 
                                MONTH(orders.date) BETWEEN $startMonth AND $endMonth AND YEAR(orders.date) = $selectedYear
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

        <div class="chart-container">
            <h2>Biểu Đồ Doanh Thu</h2>
            <canvas id="revenueChart"></canvas>
        </div>
    </main>

    <footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>

    <script>
        // Cập nhật tháng kết thúc khi chọn tháng bắt đầu
        document.getElementById('startMonth').addEventListener('change', function() {
            var startMonth = parseInt(this.value);
            var endMonthSelect = document.getElementById('endMonth');
            
            // Cập nhật giá trị của tháng kết thúc
            endMonthSelect.innerHTML = '';  // Xóa tất cả các tùy chọn hiện có
            for (var m = startMonth; m <= 12; m++) {
                var option = document.createElement('option');
                option.value = m;
                option.innerHTML = (m < 10 ? '0' : '') + m;
                endMonthSelect.appendChild(option);
            }

            // Cập nhật tháng kết thúc mặc định nếu tháng bắt đầu không phải tháng 12
            if (startMonth <= 12) {
                endMonthSelect.value = startMonth;
            }
        });

        <?php
            // Fetch the data to generate the chart
            $chartData = [];
            $chartLabels = [];
            $sql = "SELECT 
                        DATE_FORMAT(orders.date, '%Y-%m') AS MonthYear,
                        SUM(IFNULL(products.price * order_details.quantity, 0)) AS TotalInvoicePrice
                    FROM 
                        orders
                    LEFT JOIN 
                        order_details ON orders.id = order_details.id_order
                    LEFT JOIN 
                        products ON order_details.id_prod = products.id
                    WHERE 
                        MONTH(orders.date) BETWEEN $startMonth AND $endMonth AND YEAR(orders.date) = $selectedYear
                    GROUP BY 
                        MonthYear
                    ORDER BY 
                        MonthYear DESC";
            $result = mysqli_query($connect, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $chartData[] = $row['TotalInvoicePrice'];
                $chartLabels[] = date("m-Y", strtotime($row["MonthYear"]));
            }
        ?>
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chartLabels); ?>,
                datasets: [{
                    label: 'Doanh Thu',
                    data: <?php echo json_encode($chartData); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Doanh Thu Theo Tháng'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw.toLocaleString() + ' VND';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
