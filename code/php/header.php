<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Bắt đầu phiên làm việc 
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true; 
$username = isset($_SESSION['username']) ? $_SESSION['username'] : ''; 
?>
<header>
    <span></span>
    <span class="name-shop">My Shop</span>
    <div>
        <?php if ($is_logged_in): ?> 
            <div class="dropdown">
                <button class="custom-button"><?php echo htmlspecialchars($username); ?></button>
                <div class="dropdown-content">
                    <a href="../user/profile.php">Thông tin cá nhân</a>
                    <a href="../user/cart.php">Giỏ hàng</a>
                    <a href="../user/order.php">Đơn hàng</a>
                    <a href="../php/logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?> 
            <button onclick="window.location.href='../user/login.php'" class="custom-button btn-6 login-button"><span>Login</span></button> 
        <?php endif; ?>
    </div>
    
</header>
<link rel="stylesheet" href="../css/btn_login.css">
<link rel="stylesheet" href="../css/dropdown.css">

