<?php
require_once 'ketnoi.php';

// Lấy thông tin từ URL
$id = $_GET['id'];
$name = $_GET['name'];
$des = $_GET['des'];
$cate = $_GET['cate'];  // ID của danh mục
$supp = $_GET['supp'];  // ID của nhà cung cấp
$image = $_GET['img'];
$price = $_GET['price'];
$quan = $_GET['quantity'];

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name2 = $_POST['productName'];
    $des2 = $_POST['productDescription'];
    $cate2 = $_POST['productCategory'];
    $supp2 = $_POST['productSupplier'];
    $image2 = $_POST['productImage'];
    $price2 = $_POST['productPrice'];
    $quan2 = $_POST['productQuantity'];
    
    $updateQuery = "UPDATE `product` 
                    SET `name`='$name2',
                        `price`='$price2',
                        `id_supplier`='$supp2',
                        `id_prodcate`=$cate2,
                        `image`='$image2',
                        `description`='$des2',
                        `quantity`='$quan2' 
                    WHERE id = $id";
    
    mysqli_query($connect, $updateQuery);
    header("Location: ../Product.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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






        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 210px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Chỉnh sửa thông tin sản phẩm</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../Category.php">Danh mục sản phẩm</a></li>
            <li><a href="../Product.php">Sản phẩm</a></li>
            <li><a href="../Supplier.php">Nhà cung cấp</a></li>
        </ul>
    </nav>
    <div class="container mt-5">
        
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Chi tiết sản phẩm</h3>

            <div class="form-group">
                <label for="productName">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="productName" name="productName" 
                       placeholder="Nhập tên sản phẩm..." value="<?php echo htmlspecialchars($name); ?>" required>
            </div>

            <div class="form-group">
                <label for="productPrice">Giá:</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" 
                       placeholder="Nhập giá sản phẩm..." value="<?php echo htmlspecialchars($price); ?>" required>
            </div>

            <div class="form-group">
                <label for="productCategory">Danh mục:</label>
                <select class="form-control" id="productCategory" name="productCategory" required>
                    <option value="" disabled>Chọn danh mục</option>
                    <?php
                    $sql = "SELECT * FROM product_catagory";
                    $result = mysqli_query($connect, $sql);
                    if (!$result) {
                        die("Lỗi truy vấn: " . mysqli_error($connect));
                    }
                    while ($category = mysqli_fetch_assoc($result)):
                    ?>
                        <option value="<?php echo $category['id']; ?>" 
                                <?php echo ($category['id'] == $cate) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
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
                    if (!$result) {
                        die("Lỗi: " . mysqli_error($connect));
                    }
                    while ($supplier = mysqli_fetch_assoc($result)):
                    ?>
                        <option value="<?php echo $supplier['id']; ?>" 
                                <?php echo ($supplier['id'] == $supp) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($supplier['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fileImage">Chọn ảnh:</label>
                <input type="file" class="form-control-file" id="fileImage" name="FileImage" onchange="getFileName()">
                <small class="form-text text-muted">Ảnh hiện tại: <?php echo htmlspecialchars($image); ?></small>
            </div>

            <div class="form-group">
                <label for="ProductDescription">Mô tả:</label>
                <textarea class="form-control" id="ProductDescription" name="productDescription" 
                          rows="4" placeholder="Thông số kỹ thuật - mô tả"><?php echo htmlspecialchars($des); ?></textarea>
            </div>

            <div class="form-group">
                <label for="productQuantity">Số lượng:</label>
                <input type="number" class="form-control" id="productQuantity" name="productQuantity" 
                       value="<?php echo htmlspecialchars($quan); ?>" required>
            </div>

            <input type="hidden" id="productImage" name="productImage" value="<?php echo htmlspecialchars($image); ?>">

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <a href="../Product.php" class="btn btn-secondary ml-2">Hủy</a>
            </div>
        </form>
    </div>

    <script>
        function getFileName() {
            var fileInput = document.getElementById('fileImage');
            var fileName = fileInput.files[0] ? fileInput.files[0].name : 'Chưa chọn file';
            document.getElementById('productImage').value = fileName;
        }
    </script>
        <footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>
</body>
</html>