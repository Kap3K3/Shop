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
            margin-top: 550px;
        }

        

        
    </style>
<body>
    <header>
        <h1>Chỉnh sửa danh mục</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../Category.php">Danh mục sản phẩm</a></li>
            <li><a href="../Product.php">Sản phẩm</a></li>
            <li><a href="../Supplier.php">Nhà cung cấp</a></li>
        </ul>
    </nav>

    <div class="container mt-5">
        <h2>Chi tiết danh mục</h2>
        <form method="post">
            <div class="form-group">
                <label for="categoryName">Tên danh mục:</label>
                <input type="text" class="form-control" id="categoryName" name="namecansua" value="<?php echo $name; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>

    <footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
