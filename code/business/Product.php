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
        input, select {
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
            text-align: left;
        }
        .action-icons {
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <header>
        <h1>Product Management</h1>
    </header>
    <nav>
        <ul>
            <li><a href="Category.php">Category</a></li>
            <li><a href="Product.php">Product</a></li>
            <li><a href="Supplier.php">Supplier</a></li>
        </ul>
    </nav>
    <main>
        <div class="form-container">
            <form action="php_product/them.php" method="POST">
                <h2>Product Details</h2>
                <label for="productName">Tên sản phẩm:</label>
                <input type="text" id="productName" name="productName" placeholder="Nhập tên sản phẩm..." required>

                <label for="productPrice">Giá:</label>
                <input type="number" id="productPrice" name="productPrice" placeholder="Nhập giá sản phẩm..." required>

                <!-- Hiển thị Select danh mục -->
                <?php
                    require_once 'php_product/ketnoi.php';
                    $sql = "SELECT * FROM product_catagory";
                    $result = mysqli_query($connect, $sql);
                    if (!$result) {
                        die("Lỗi truy vấn: " . mysqli_error($connect));
                    }
                    $categories = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $categories[] = $row;
                    }
                ?>
                <label for="productCategory">Danh mục:</label>
                <select id="productCategory" name="productCategory" required>
                    <option value="" disabled selected>Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <?php
                    $sql = "SELECT * FROM SUPPLIER";
                    $result = mysqli_query($connect, $sql);
                    if (!$result) {
                        die("Lỗi: " . mysqli_error($connect));
                    }
                    $sup = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sup[] = $row;
                    }
                ?>
                <label for="productSupplier">Nhà cung cấp:</label>
                <select id="productSupplier" name="productSupplier" required>
                    <option value="" disabled selected>Chọn nhà cung cấp</option>
                    
                    <?php foreach ($sup as $Supplier): ?>
                        <option value="<?php echo $Supplier['id']; ?>"><?php echo $Supplier['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <button id="addBtn" type="submit">Thêm</button>
            </form>
        </div>
        <div class="table-container">
            <h2>Product List</h2>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th>Nhà cung cấp</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        require_once 'php_product/ketnoi.php';
                        $sql = "SELECT * FROM product";
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
                                        <td><?php echo $row["price"]; ?></td>
                                        <td> </td>
                                        <td> </td>
                                        <td>
                                            <a href="php_product/sua.php?sid=<?php echo $row['id']; ?>&name=<?php echo $row['name'] ?>" class="btn btn-warning" >Sửa</a>
                                            <a href="php_product/xoa.php?sid=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?');" class="btn btn-danger">Xóa</a>
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
</body>
</html>
