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

        .input-group {
            display: flex;
            align-items: center; 
        }

        .input-group input {
            width: 250px; 
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px; 
        }

        .input-group-append button {
            background-color: #007bff; 
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 0 5px 5px 0; 
        }

        .btn-primary {
            background-color: #007bff; 
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            cursor: pointer;
            margin-top: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0069d9; 
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
            <li><a href="Order.php">Hóa đơn</a></li>
            <li><a href="Customer.php">Khách hàng</a></li>
            <li><a href="Revenue.php">Thống kê</a></li>

        </ul>
    </nav>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 form-container">
                    <h2>Thêm danh mục</h2>
                    <form action="php_category/them.php" method="post" onsubmit="return ham();">
                        <div class="form-group">
                            <label for="categoryName">Tên danh mục:</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Nhập tên danh mục..." name="name">
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>

                    <script>
                    function ham() {
                        var categoryName = document.getElementById("categoryName").value; // Lấy giá trị ô nhập liệu
                        if (categoryName.trim() === "") { // Kiểm tra xem ô có rỗng không
                            alert("Tên danh mục không được để trống."); // Thông báo nếu rỗng
                            return false; // Ngăn chặn việc gửi biểu mẫu
                        }
                        return true; // Cho phép gửi biểu mẫu nếu hợp lệ
                    }
                    </script>
                </div>
                <div class="col-md-6 table-container">
                    <h2>Danh sách danh mục</h2>
                    <form method="get" action="">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Tìm kiếm danh mục..." name="search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered">
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
                                $search = isset($_GET['search']) ? $_GET['search'] : '';
                                $sql = "SELECT * FROM product_catagory WHERE name LIKE '%$search%'";
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
                                                    <a href="php_category/sua.php?sid=<?php echo $row['id']; ?>&name=<?php echo $row['name'] ?>" class="btn btn-warning">Sửa</a>
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
            </div>
        </div>
    </main>

    <footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
