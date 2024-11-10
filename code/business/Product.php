<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
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
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
            background-color: #444;
        }
        nav ul li {
            display: inline-block;
            margin: 0 1rem;
        }
        nav ul li a {
            color: white;
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
            margin-top: 0.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 2rem;
            gap: 2rem;
        }
        .form-container {
            flex: 1;
            padding-right: 2rem;
            max-width: 400px;
        }
        .table-container {
            flex: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            display: block;
            margin-top: 1rem;
        }
        input, select {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.5rem;
            box-sizing: border-box;
        }
        button {
            background-color: #333;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            margin-top: 1rem;
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
            padding: 0.75rem;
            text-align: left;
        }
        .action-icons {
            display: flex;
            justify-content: space-around;
        }
        .no-wrap {
            max-height: 50px;
            overflow: hidden;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        table, th, td {
            text-align: center;
            vertical-align: middle;
        }
        .add-button {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .add-button button {
            width: fit-content;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
        }

        .out-of-stock {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Sản phẩm</h1>
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
        <div class="form-container">
        </div>
        <div class="table-container">
            <h2>Danh sách sản phẩm</h2>
            <div class="add-button">
                <a href="php_product/them.php">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Thêm
                </button>
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th>Nhà cung cấp</th>
                        <th>Hình ảnh</th>
                        <th>Mô tả</th>
                        <th>Số lượng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'php_product/ketnoi.php';

                    if (!$connect) {
                        die("Lỗi kết nối cơ sở dữ liệu: " . mysqli_connect_error());
                    }

                    $sql = "SELECT
                                 p.quantity AS quan,
                                p.id_supplier AS id_supp,
                                p.id_prodcate AS id_prodcate,
                                p.description AS prodDes,
                                p.id AS id,
                                p.name AS prodName,
                                p.price AS price,
                                pc.name AS prodcateName,
                                s.name AS suppName,
                                p.image AS imageURL
                            FROM products p
                            JOIN supplier s ON p.id_supplier=s.id
                            JOIN product_category pc ON p.id_prodcate=pc.id
                            ORDER BY p.id ASC";

                    $result = mysqli_query($connect, $sql);

                    if (!$result) {
                        die("Lỗi truy vấn: " . mysqli_error($connect));
                    } else {
                        if (mysqli_num_rows($result) > 0) {
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row["prodName"]; ?></td>
                                    <td><?php echo $row["price"]; ?></td>
                                    <td><?php echo $row["prodcateName"]; ?></td>
                                    <td><?php echo $row["suppName"]; ?></td>
                                    <td>
                 
                                    <img src="<?php echo $row['imageURL']; ?>" alt="" style="width: 100px; height: auto;">
                                    </td>
                                    <td class="no-wrap"><?php echo $row["prodDes"]; ?></td>
                                    <td>
                                        <?php if ($row["quan"] == 0): ?>
                                            <div class="out-of-stock">Hết hàng</div>
                                        <?php else: ?>
                                            <?php echo $row["quan"]; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="php_product/sua.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['prodName']; ?>&des=<?php echo $row['prodDes']; ?>&cate=<?php echo $row['id_prodcate']; ?>&supp=<?php echo $row['id_supp']; ?>&img=<?php echo $row['imageURL']; ?>&price=<?php echo $row['price']; ?>&quantity=<?php echo $row['quan']; ?>" class="btn btn-warning">
                                            Sửa
                                        </a>
                                        <a href="php_product/xoa.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                            <?php
                            $i++;
                            }
                        } else {
                            echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                        }
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
<script>
    function getFileName() {
        var fileInput = document.getElementById('fileImage');
        var fileName = fileInput.files[0] ? fileInput.files[0].name : 'Chưa chọn file';
        document.getElementById('productImage').value = fileName;
    }
</script>
</html>
