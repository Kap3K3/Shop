<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Khách Hàng</title>
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

        .table-container {
            flex: 1;
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
        <h1>Khách Hàng</h1>
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
            <h2>Danh sách khách hàng</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã Khách Hàng</th>
                        <th>Tên Khách Hàng</th>
                        <th>Số Điện Thoại</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    require_once 'php_category/ketnoi.php';
                    $sql = "SELECT id, name, phone FROM customer";

                    $result = mysqli_query($connect, $sql);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="3" class="alert alert-warning">Không có khách hàng nào.</td></tr>';
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
