


<?php
// Kết nối đến cơ sở dữ liệu
require_once 'ketnoi.php';

// Kiểm tra xem có id của danh mục trong URL không
    $id=$_GET['sid'];
    $name = $_GET['name'];
    $address = $_GET['address'];
    $phone = $_GET['phone'];
    


// Kiểm tra xem có yêu cầu POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name2 = $_POST['name_supplier'];
    $address2 = $_POST['address_supplier'];
    $phone2 = $_POST['phone_supplier'];
    $updateQuery = "UPDATE Supplier 
                    SET name='$name2',address='$address2',phone='$phone2' 
                    WHERE id='$id'";
    mysqli_query($connect, $updateQuery);
    header("Location: ../Supplier.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
            padding: 0.3rem;
            text-align: center;
        }
        .action-icons {
            display: flex;
            justify-content: space-around;
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
        .table-container {
    flex: 1;
    margin-left: 100px; /* Thay đổi giá trị 20px theo ý muốn */
}
footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top:280px
        }
    </style>
</head>
<body>
<header>
        <h1>Chỉnh sửa thông tin nhà cung cấp</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../Category.php">Danh mục sản phẩm</a></li>
            <li><a href="../Product.php">Sản phẩm</a></li>
            <li><a href="../Supplier.php">Nhà cung cấp</a></li>
        </ul>
    </nav>

<div class="container mt-5">
    <form action="" method="POST">
        <div class="form-group">
            <label for="name_supplier">Tên NCC:</label>
            <input type="text" class="form-control" id="name_supplier" value="<?php echo $name; ?>" name="name_supplier">
        </div>
        <div class="form-group">
            <label for="address_supplier">Địa chỉ:</label>
            <input type="text" class="form-control" id="address_supplier" value="<?php echo $address; ?>" name="address_supplier">
        </div>
        <div class="form-group">
            <label for="phone_supplier">SĐT:</label>
            <input type="text" class="form-control" id="phone_supplier" value="<?php echo $phone; ?>" name="phone_supplier">
        </div>
        <button type="submit" class="btn btn-primary">Sửa</button>
    </form>
</div>
<footer>
        <p>© 2023 Company Name. All rights reserved.</p>
    </footer>

</body>
</html>



