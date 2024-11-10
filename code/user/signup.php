<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body style="background: #949494">
    <div class="box signup">
        <div class="form">
            <h2>Sign Up</h2>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Nhận dữ liệu từ form
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $name = $_POST['name'];
                $phone = $_POST['phone'];

                // Kiểm tra mật khẩu xác nhận
                if ($password !== $confirm_password) {
                    echo "<p style='color: red;'>Password and Confirm Password do not match.</p>";
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

                        echo "<p style='color: green;'>Registration successful!</p>";
                    } catch (Exception $e) {
                        // Rollback transaction nếu có lỗi
                        $conn->rollback();
                        echo "<p style='color: red;'>Có lỗi xảy ra: " . $e->getMessage() . "</p>";
                    }

                    $conn->close();
                }
            }
            ?>
            <form action="" method="POST">
                <div class="inputbox">
                    <input type="text" name="name" required="required">
                    <span>Name</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input type="text" name="phone" required="required">
                    <span>Phone</span>
                    <i></i>
                </div>
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
                <div class="inputbox">
                    <input type="password" name="confirm_password" required="required">
                    <span>Confirm Password</span>
                    <i></i>
                </div>
                
                <div class="links">
                    <a href="./login.php">Sign in</a>
                </div>
                <input type="submit" value="Sign Up">
            </form>
        </div>
    </div>
</body>
</html>
