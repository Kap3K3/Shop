<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Information</title>
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
            align-items: center; /* Căn giữa theo chiều dọc */
        }

        .input-group input {
            width: 250px; /* Điều chỉnh chiều rộng của input */
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px; /* Bo tròn góc trái */
        }

        .input-group-append button {
            background-color: #007bff; /* Màu xanh dương */
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 0 5px 5px 0; /* Bo tròn góc phải */
        }

        .btn-primary {
            background-color: #007bff; /* Màu xanh dương */
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            cursor: pointer;
            margin-top: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0069d9; /* Màu xanh dương đậm hơn */
        }
    </style>
    <script>
        function validateForm() {
            var supplierName = document.getElementById("supplierName").value.trim();
            var supplierAddress = document.getElementById("supplierAddress").value.trim();
            var supplierPhone = document.getElementById("supplierPhone").value.trim();

            // Kiểm tra ô Tên nhà cung cấp
            if (supplierName === "") {
                alert("Tên nhà cung cấp không được để trống.");
                return false; // Ngăn gửi form
            }

            // Kiểm tra ô Địa chỉ
            if (supplierAddress === "") {
                alert("Địa chỉ không được để trống.");
                return false; // Ngăn gửi form
            }

            // Kiểm tra ô Số điện thoại
            if (supplierPhone === "") {
                alert("Số điện thoại không được để trống.");
                return false; // Ngăn gửi form
            }
            // Kiểm tra nếu số điện thoại chứa ký tự không phải số
            if (!/^\d+$/.test(supplierPhone)) {
                alert("Số điện thoại chỉ được chứa số.");
                return false; // Ngăn gửi form
            }

            return true; // Cho phép gửi form nếu tất cả hợp lệ
        }
    </script>
</head>
<body>
    <header>
        <h1>Nhà cung cấp</h1>
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
        <form action="php_supplier/them.php" method="POST" onsubmit="return validateForm();">
            <div class="form-container">
                <h2>Chi tiết nhà cung cấp</h2>
                <label for="supplierName">Tên nhà cung cấp:</label>
                <input type="text" id="supplierName" name="name" placeholder="Nhập tên nhà cung cấp...">
                
                <label for="supplierAddress">Địa chỉ:</label>
                <input type="text" id="supplierAddress" name="address" placeholder="Nhập địa chỉ...">
                
                <label for="supplierPhone">Số điện thoại:</label>
                <input type="text" id="supplierPhone" name="phone" placeholder="Nhập số điện thoại...">
                
                <button id="addBtn" type="submit">Thêm</button>
            </div>
        </form>
        
        <div class="table-container">
            <h2>Danh sách nhà cung cấp</h2>

            <!-- Thêm form tìm kiếm -->
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm nhà cung cấp..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên nhà cung cấp</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    require_once 'php_supplier/ketnoi.php';
                    
                    // Kiểm tra có từ khóa tìm kiếm không
                    $search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
                    $sql = "SELECT * FROM Supplier WHERE name LIKE '%$search%'";
                    
                    $result = mysqli_query($connect, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row["name"]; ?></td>      
                                <td><?php echo $row["address"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td class="action-icons">
                                    <a href="php_supplier/sua.php?sid=<?php echo $row['id']; ?>&name=<?php echo $row['name']; ?>&phone=<?php echo $row['phone']; ?>&address=<?php echo $row['address'];?>" class="btn btn-warning">Sửa</a>
                                    <a href="php_supplier/xoa.php?sid=<?php echo $row['id'];?>" onclick="return confirm('Bạn có muốn xóa');" class="btn btn-danger">Xóa</a>
                                </td>
                            </tr>
                        <?php $i++;  
                        }
                    } else {
                        echo "<tr><td colspan='5'>Không có dữ liệu.</td></tr>";
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
