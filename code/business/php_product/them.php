<?php
require_once 'ketnoi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productCategory = $_POST['productCategory'];
    $productSupplier = $_POST['productSupplier'];
    $productDescription = $_POST['productDescription'];
    $productQuantity = $_POST['productQuantity'];
    $productImage = $_FILES['FileImage']['name'];

    // Xử lý upload ảnh
    if ($_FILES['FileImage']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["FileImage"]["name"]);
        move_uploaded_file($_FILES["FileImage"]["tmp_name"], $targetFile);
    }   
    $chuoi = "../src/img/";
    // Thêm dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO products (name, price, id_prodcate, id_supplier, description, quantity, image)
            VALUES ('$productName', '$productPrice', '$productCategory', '$productSupplier', '$productDescription', '$productQuantity', '$chuoi$productImage')";

    if (mysqli_query($connect, $sql)) {
        echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href='Product.php';</script>";
        header("Location: ../Product.php");
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($connect) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
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






        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 210px;
        }
</style>
<body>
    <header>
        <h1 class="text-center my-4">Thêm sản phẩm mới</h1>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="../Category.php">Danh mục sản phẩm</a></li>
            <li class="nav-item"><a class="nav-link" href="../Product.php">Sản phẩm</a></li>
            <li class="nav-item"><a class="nav-link" href="../Supplier.php">Nhà cung cấp</a></li>
        </ul>
    </nav>

    <div class="container mt-5">
        <form action="them.php" method="POST" enctype="multipart/form-data">
            <h3>Chi tiết sản phẩm</h3>

            <div class="form-group">
                <label for="productName">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="Nhập tên sản phẩm..." required>
            </div>

            <div class="form-group">
                <label for="productPrice">Giá:</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Nhập giá sản phẩm..." required>
            </div>

            <div class="form-group">
                <label for="productCategory">Danh mục:</label>
                <select class="form-control" id="productCategory" name="productCategory" required>
                    <option value="" disabled>Chọn danh mục</option>
                    <?php
                    $sql = "SELECT * FROM product_category";
                    $result = mysqli_query($connect, $sql);
                    while ($category = mysqli_fetch_assoc($result)):
                    ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="productSupplier">Nhà cung cấp:</label>
                <select class="form-control" id="productSupplier" name="productSupplier" required>
                    <option value="" disabled>Chọn nhà cung cấp</option>
                    <?php
                    $sql = "SELECT * FROM supplier";
                    $result = mysqli_query($connect, $sql);
                    while ($supplier = mysqli_fetch_assoc($result)):
                    ?>
                        <option value="<?php echo $supplier['id']; ?>"><?php echo htmlspecialchars($supplier['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fileImage">Chọn ảnh:</label>
                <input type="file" class="form-control-file" id="fileImage" name="FileImage">
            </div>

            <div class="form-group">
                <label for="ProductDescription">Mô tả:</label>
                <textarea class="form-control" id="ProductDescription" name="productDescription" rows="4" placeholder="Thông số kỹ thuật - mô tả"></textarea>
            </div>

            <div class="form-group">
                <label for="productQuantity">Số lượng:</label>
                <input type="number" class="form-control" id="productQuantity" name="productQuantity" required>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                <a href="Product.php" class="btn btn-secondary ml-2">Hủy</a>
            </div>
        </form>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
