<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

    <?php
    session_start(); // Khởi tạo phiên làm việc
    // Kiểm tra trạng thái đăng nhập từ phiên
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header("Location: ../user/index.php"); 
        exit();
    }
    ?>

    <div class="box">
        <form class="form" action="" method="POST">
            <h2>Sign In</h2>
            <div class="inputbox">
                <input type="text" name="username" required="required">
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputbox">
                <input type="password" name="password" required="required">
                <span>Password</span>
                <i></i>
            </div>
            <div class="links">
                <a href="#">Forget Password?</a>
                <a href="./signup.php">Signup</a>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>

    <!-- Modal thông báo -->
    <div id="modal-overlay" class="modal-overlay"></div>
    <div id="modal" class="modal">
        <h2 id="modal-message"></h2>
        <button id="closeNotif" onclick="closeModal()">Close</button>
    </div>

    <?php
    $show_modal = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $dbname = "db_qllinhkien";

        // Tạo kết nối
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Lấy dữ liệu từ form đăng nhập
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Truy vấn để kiểm tra thông tin đăng nhập
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $message="hello!";

        if ($result->num_rows > 0) {
            // Đăng nhập thành công
            $user_data = $result->fetch_assoc();

            if (password_verify($pass, $user_data['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user;
                $_SESSION['id_user'] = $user_data['id'];
                $_SESSION['permission'] =$user_data['permission'];
                // Lưu trạng thái đăng nhập vào phiên
                $message = "Đăng nhập thành công!";
                $login_success = true;
            } else {
                // Mật khẩu không đúng
                $message = "Tên đăng nhập hoặc mật khẩu không đúng!";
                $login_success = false;
            }
        } else {
            // Tên đăng nhập không tồn tại
            $message = "Tên đăng nhập hoặc mật khẩu không đúng!!!";
            $login_success = false;
        }

        $stmt->close();
        $conn->close();

        // Đặt biến để hiển thị modal
        $show_modal = true;
        $json_message = json_encode($message);
        $json_login_success = json_encode($login_success);
        echo "<script> 
            const message = $json_message; 
            document.getElementById('modal-message').innerText = message; 
            document.getElementById('modal').style.display = 'flex'; 
            document.getElementById('modal-overlay').style.display = 'block'; 
            if ($json_login_success) { 
                document.getElementById('modal').setAttribute('data-loggedin', 'true'); 
            } else { 
                document.getElementById('modal').setAttribute('data-loggedin', 'false'); 
            } 
        </script>";
    }
    ?>

    <script>
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('modal-overlay').style.display = 'none';
            if (document.getElementById('modal').getAttribute('data-loggedin') === 'true') {
                // Nếu đăng nhập thành công, chuyển hướng về trang chính hoặc trang người dùng đã đăng nhập
                window.location.href = 'index.php'; // Thay đổi thành URL trang chính của bạn nếu cần
            }
        }

        // Chỉ hiển thị modal khi có biến show_modal được đặt là true
        <?php if ($show_modal): ?>
        document.getElementById('modal').style.display = 'flex';
        document.getElementById('modal-overlay').style.display = 'block';
        <?php endif; ?>
    </script>
</body>
</html>
