<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="box signup">
        <div class="form">
            <h2>ĐĂNG KÝ</h2>
            <?php
            $showModal = false;
            $modalMessage = '';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Nhận dữ liệu từ form
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $name = $_POST['name'];
                $phone = $_POST['phone'];

                // Kiểm tra mật khẩu xác nhận
                if ($password !== $confirm_password) {
                    $showModal = true;
                    $modalMessage = "Password and Confirm Password do not match.";
                } else {
                    // Kết nối cơ sở dữ liệu
                    $servername = "localhost";
                    $db_username = "root";
                    $db_password = "";
                    $dbname = "db_qllinhkien";

                    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

                    // Kiểm tra kết nối
                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    // Bắt đầu transaction
                    $conn->begin_transaction();

                    try {
                        // Thêm vào bảng customer
                        $stmt = $conn->prepare("INSERT INTO customer (name, phone) VALUES (?, ?)");
                        $stmt->bind_param("ss", $name, $phone);
                        $stmt->execute();
                        $customer_id = $stmt->insert_id;
                        $stmt->close();

                        // Mã hóa mật khẩu
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        // Thêm vào bảng users
                        $stmt = $conn->prepare("INSERT INTO users (username, password, id_cust) VALUES (?, ?, ?)");
                        $stmt->bind_param("ssi", $username, $hashed_password, $customer_id);
                        $stmt->execute();
                        $stmt->close();

                        // Commit transaction
                        $conn->commit();

                        $showModal = true;
                        $modalMessage = "Đăng ký thành công!";
                    } catch (Exception $e) {
                        // Rollback transaction nếu có lỗi
                        $conn->rollback();
                        $showModal = true;
                        $modalMessage = "Có lỗi xảy ra: Đăng ký thất bại!";
                    }

                    $conn->close();
                }
            }
            ?>


            <form action="" method="POST">
                <div class="inputbox">
                    <input type="text" name="name" required="required">
                    <span>Tên</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input type="text" name="phone" required="required">
                    <span>Số điện thoại</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input type="text" name="username" required="required">
                    <span>Tên dăng nhập</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input type="password" name="password" required="required">
                    <span>Mật khẩu</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input type="password" name="confirm_password" required="required">
                    <span>Xác nhận mật khẩu</span>
                    <i></i>
                </div>
                
                <div class="links">
                    <a href="./login.php">Đăng nhập</a>
                </div>
                <input type="submit" value="Đăng ký">
            </form>
        </div>
    </div>
    <!-- Modal thông báo -->
    <div id="modal-overlay" class="modal-overlay"></div>
    <div id="modal" class="modal">
        <h2 id="modal-message"></h2>
        <button id="closeNotif" onclick="closeModal()">Đóng</button>
    </div>

</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var showModal = <?php echo json_encode($showModal); ?>;
    var modalMessage = <?php echo json_encode($modalMessage); ?>;

    if (showModal) {
        var modalOverlay = document.getElementById('modal-overlay');
        var modal = document.getElementById('modal');
        var message = document.getElementById('modal-message');

        message.innerText = modalMessage;
        modalOverlay.style.display = 'block';
        modal.style.display = 'flex';
    }
});

function closeModal() {
    var modalOverlay = document.getElementById('modal-overlay');
    var modal = document.getElementById('modal');
    modalOverlay.style.display = 'none';
    modal.style.display = 'none';
}
</script>

</html>
