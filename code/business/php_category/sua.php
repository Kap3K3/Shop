<?php
// Kết nối đến cơ sở dữ liệu
require_once 'ketnoi.php';

// Kiểm tra xem có id của danh mục trong URL không
    $id=$_GET['sid'];
    $name = $_GET['name'];



// Kiểm tra xem có yêu cầu POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updateQuery = "UPDATE product_catagory SET name='{$_POST['namecansua']}' WHERE id='$id'";
    mysqli_query($connect, $updateQuery);
    header("Location: ../Category.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa danh mục</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Chỉnh sửa danh mục</h2>
        <form method="post">
            <div class="form-group">
                <label for="categoryName">Tên danh mục:</label>
                <input type="text" class="form-control" id="categoryName" name="namecansua" value="<?php echo $name; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</body>
</html>
