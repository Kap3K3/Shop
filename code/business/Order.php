<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
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

        .form-container {
            flex: 1;
            padding-right: 2rem;
        }

        .table-container {
            flex: 1;
        }

        h2 {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-top: 1rem;
        }

        input {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #333;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            margin-top: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #555;
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

        .action-icons {
            display: flex;
            justify-content: space-around;
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
        <h1>Hóa Đơn</h1>
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

    <div class="table-container">
        <h2>Danh sách hóa đơn</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã Hóa Đơn</th>
                    <th>Tên Khách Hàng</th>
                    <th>Ngày Đặt</th>
                    <th>Tổng Giá Trị Hóa Đơn</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
            <?php
                require_once 'php_category/ketnoi.php';

                // Truy vấn lấy thông tin hóa đơn
                $sql = "SELECT 
                            orders.id AS OrderID,
                            customer.name AS CustomerName,
                            orders.date AS OrderDate,
                            SUM(IFNULL(products.price * order_details.quantity, 0)) AS TotalInvoicePrice
                        FROM 
                            orders
                        LEFT JOIN 
                            customer ON orders.id_cust = customer.id
                        LEFT JOIN 
                            order_details ON orders.id = order_details.id_order
                        LEFT JOIN 
                            products ON order_details.id_prod = products.id
                        GROUP BY 
                            orders.id, customer.name, orders.date
                        HAVING 
                            TotalInvoicePrice > 0
                        ORDER BY 
                            orders.date DESC";

                $result = mysqli_query($connect, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $formattedDate = date("d-m-Y", strtotime($row["OrderDate"]));
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row["OrderID"]; ?></td>
                            <td><?php echo $row["CustomerName"]; ?></td>
                            <td><?php echo $formattedDate; ?></td>
                            <td><?php echo number_format($row["TotalInvoicePrice"], 0, ',', '.'); ?> VND</td>
                            <td>
                                <a href="Order_detail.php?order_id=<?php echo $row['OrderID']; ?>" class="btn btn-primary">Xem Chi Tiết</a>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                } else {
                    echo '<tr><td colspan="6" class="alert alert-warning">Không có hóa đơn nào.</td></tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
