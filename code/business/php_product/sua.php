<?php
       require_once 'ketnoi.php';
    $id = $_GET['id'];
    $name = $_GET['name'];
    $des = $_GET['des'];
    $cate = $_GET['cate'];
    $supp = $_GET['supp'];
    $image = $_GET['img'];
    $price = $_GET['price'];
    $id_supp = $_GET['id_supp'];
    $id_prod=$_GET['id_prodcate'];
    $quan=$_GET['quantity'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name2 = $_POST['productName'];
        $des2 = $_POST['productDescription'];
        $cate2 = $_POST['productCategory'];
        $supp2 = $_POST['productSupplier'];
        $image2 = $_POST['productImage'];
        $price2 = $_POST['productPrice'];
        $quan2=$_POST['productQuantity'];
        $updateQuery = "UPDATE `product` 
                        SET `name`='$name2',`price`='$price2',`id_supplier`=' $id_supp',`id_prodcate`=$id_prod,`image`='$image2',`description`='$des2',`quantity`='$quan2' 
                        WHERE id = $id";
        mysqli_query($connect, $updateQuery);
        header("Location: ../Product.php");
    
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
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Chỉnh sửa sản phẩm</h2>
        <form action="" method="POST">
            <h3>Product Details</h3>

            <div class="form-group">
                <label for="productName">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="Nhập tên sản phẩm..." value="<?php echo ($name); ?>" required>
            </div>

            <div class="form-group">
                <label for="productPrice">Giá:</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Nhập giá sản phẩm..." value="<?php echo ($price); ?>" required>
            </div>

            <div class="form-group">
                <label for="productCategory">Danh mục:</label>
                <select class="form-control" id="productCategory" name="productCategory" required>
                    <option value="" disabled>Chọn danh mục</option>
                    <?php
                    require_once 'ketnoi.php';
                    $sql = "SELECT * FROM product_catagory";
                    $result = mysqli_query($connect, $sql);
                    if (!$result) {
                        die("Lỗi truy vấn: " . mysqli_error($connect));
                    }
                    while ($category = mysqli_fetch_assoc($result)):
                    ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $cate) ? 'selected' :''; ?>><?php echo ($category['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="productSupplier">Nhà cung cấp:</label>
                <select class="form-control" id="productSupplier" name="productSupplier" required>
                    <option value="" disabled>Chọn nhà cung cấp</option>
                    <?php
                    $sql = "SELECT * FROM SUPPLIER";
                    $result = mysqli_query($connect, $sql);
                    if (!$result) {
                        die("Lỗi: " . mysqli_error($connect));
                    }
                    while ($Supplier = mysqli_fetch_assoc($result)):
                    ?>
                        <option value="<?php echo $Supplier['id']; ?>" <?php echo ($Supplier['id'] == $supp) ? 'selected' : ''; ?>><?php echo ($Supplier['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="fileImage">Chọn ảnh:</label>
                <input type="file" class="form-control-file" id="fileImage" name="FileImage" onchange="getFileName()">
            </div>

            <div class="form-group">
                <label for="ProductDescription">Mô tả:</label>
                <textarea class="form-control" id="ProductDescription" name="productDescription" rows="4" placeholder="Thông số kỹ thuật - mô tả"><?php echo htmlspecialchars($des); ?></textarea>
            </div>
            <div>
    <label for="productQuantity">Số lượng:</label> <br>
    <input type="number" id="productQuantity" name="productQuantity" value="<?php echo $quan; ?>" required> <br>
            </div>

            <br>
            <input type="text" id="productImage" name="productImage" value = <?php echo "$image"?>  >  <br><br>
            <button id="addBtn" type="submit" class="btn btn-primary">Sửa</button>
        </form>
    </div>
</body>
<script>
        function getFileName() {
            var fileInput = document.getElementById('fileImage');
            var fileName = fileInput.files[0] ? fileInput.files[0].name : 'Chưa chọn file';
            document.getElementById('productImage').value = fileName; 

        }
    </script>
</html>
