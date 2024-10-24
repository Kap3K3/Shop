


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
</head>
<body>

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


</body>
</html>



