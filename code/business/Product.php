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
            gap: 2rem; /* Thêm khoảng cách giữa form và bảng */
        }
        .form-container {
            flex: 1;
            padding-right: 2rem;
            max-width: 400px; /* Giới hạn chiều rộng của form */
        }
        .table-container {
            flex: 2; /* Tăng kích thước bảng */
        }
        label {
            display: block;
            margin-top: 1rem;
        }
        input, select {
            width: 100%;
            padding: 0.75rem; /* Tăng độ rộng padding */
            margin-top: 0.5rem;
            box-sizing: border-box;
        }
        button {
            background-color: #333;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem; /* Tăng độ rộng padding của nút */
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
            padding: 0.75rem; /* Tăng độ rộng padding của các ô trong bảng */
            text-align: left;
        }
        .action-icons {
            display: flex;
            justify-content: space-around;
        }

        .no-wrap {
            max-height: 50px; /* Giới hạn chiều cao của ô */
        overflow: hidden; /* Ẩn phần văn bản bị tràn ra ngoài */
        word-wrap: break-word; /* Cho phép xuống dòng nếu cần */
        overflow-wrap: break-word; /* Tương thích tốt hơn với các trình duyệt */
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
            <form action="php_product/them.php" method="POST" enctype="multipart/form-data">
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

                        <label for="fileImage">Hình ảnh:</label>
            <input type="file" id="fileImage" name="FileImage" onchange="getFileName()">

            <label for="ProductDescription">Mô tả:</label>
            <textarea id="ProductDescription" name = "productDescription"rows="4" cols="43" placeholder="Thông số kỹ thuật - mô tả"></textarea>

            <input type="hidden" id="productImage" name="productImage">

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
                        <th>Hình ảnh</th>
                        <th >Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "						SELECT
                            p.id_supplier AS id_supp,
                            p.id_prodcate AS id_prodcate,
                            p.description AS prodDes,
                            p.id AS id,
                            p.name AS prodName,
                            p.price AS price,
                            pc.name AS prodcateName,
                            s.name AS suppName,
                            p.image AS imageURL
                        FROM product p
                        JOIN supplier s ON p.id_supplier=s.id
                        JOIN product_catagory pc ON p.id_prodcate=pc.id";
                
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
                                    <img src="image/<?php echo $row['imageURL']; ?>" alt="" style="width: 100px; height: auto;">
                                </td>
                                <td class="no-wrap"><?php echo $row["prodDes"]; ?></td>
                                <td>
                                    <a href="php_product/sua.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['prodName']; ?>&des=<?php echo $row['prodDes']; ?>&cate=<?php echo $row['prodcateName']; ?>&supp=<?php echo $row['suppName']; ?>&img=<?php echo $row['imageURL']; ?>&price=<?php echo $row['price']; ?>&id_supp=<?php echo $row['id_supp']; ?> &id_prodcate=<?php echo $row['id_prodcate']; ?>  "class="btn btn-primary">Sửa</a>
                                    <a href="php_product/xoa.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Xóa</a>
                                    
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
</body>
<script>
        function getFileName() {
            var fileInput = document.getElementById('fileImage');
            var fileName = fileInput.files[0] ? fileInput.files[0].name : 'Chưa chọn file';
            document.getElementById('productImage').value = fileName; 
        }
    </script>
</html>
