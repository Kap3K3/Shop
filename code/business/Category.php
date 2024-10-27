<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
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
        }
        main {
            display: flex;
            flex: 1;
            padding: 2rem;
        }
        .form-container {
            flex: 1;
            padding-right: 2rem;
        }
        .table-container {
            flex: 1;
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
        }
        button {
            background-color: #333;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
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
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Danh mục sản phẩm</h1>
    </header>
    <nav>
        <ul>
            <li><a href="Category.php">Danh mục sản phẩm</a></li>
            <li><a href="Product.php">Sản phẩm</a></li>
            <li><a href="Supplier.php">Nhà cung cấp</a></li>
        </ul>
    </nav>
    <main>
        <form action="php_category/them.php" method="post">
            <div class="form-container">
                <h2>Chi tiết danh mục</h2>
                <label for="categoryName">Tên danh mục:</label>
                <input type="text" id="categoryName" placeholder="Nhập tên danh mục..." name="name">
                <button id="btn_them" type="submit">Thêm</button>
            </div>
        </form>

        <div class="table-container">
            <h2>Danh sách danh mục</h2>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên danh mục</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once 'php_category/ketnoi.php';
                        $sql = "SELECT * FROM product_catagory";
                        $result = mysqli_query($connect, $sql);
                        if (!$connect) 
                            echo "Failed Connect";
                        else {
                            if (mysqli_num_rows($result) > 0) {
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row["name"]; ?></td>
                                        <td>
                                            <a href="php_category/sua.php?sid=<?php echo $row['id']; ?>&name=<?php echo $row['name'] ?>" class="btn btn-warning" >Sửa</a>
                                            <a href="php_category/xoa.php?sid=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?');" class="btn btn-danger">Xóa</a>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                            } else {
                                echo "<tr><td colspan='3'>No data</td></tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    Thêm thành công
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
