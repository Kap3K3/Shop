<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_qllinhkien";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Lấy user_id từ phiên
    $user_id = $_SESSION['id_user'];
    
}



// Truy vấn để lấy cart_id từ bảng cart
$sql = "SELECT cart_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cart = $result->fetch_assoc();
    $cart_id = $cart['cart_id'];
    
}

$stmt->close();



$sql = "SELECT 
            cart_items.cart_item_id,
            products.name,
            products.image,
            cart_items.quantity,
            products.price
        FROM 
            cart_items
        JOIN 
            products ON cart_items.product_id = products.id
        WHERE 
            cart_items.cart_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/btn_buy.css">
    <link rel="stylesheet" href="../css/cart.css">
</head>
<body>
    <?php include '../php/header.php'; ?>
    <?php include '../php/side.php'; ?>
    <?php include '../php/footer.php'; ?>
    <div class="main">
        <h1>Giỏ Hàng của Bạn</h1>
        <div class="product-list">
            <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="product bg-red-50">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <h2><?php echo htmlspecialchars($item["name"]); ?></h2>
                        <p>Giá: <?php echo htmlspecialchars($item["price"]*$item["quantity"]); ?> VND</p>
                        <p>Số lượng: <?php echo htmlspecialchars($item["quantity"]); ?></p>
                        <div class="squaredTwo">
                            <input type="checkbox" value="None" id="squaredTwo<?php echo $item['cart_item_id']; ?>" name="check" />
                            <label for="squaredTwo<?php echo $item['cart_item_id']; ?>"></label>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button id="checkoutBtn" class="custom-button btn-7"><span>Thanh toán</span></button>
            <?php else: ?>
                <p>Giỏ hàng của bạn trống.</p>
            <?php endif; ?>
            
        </div>
    <!-- Modal xác nhận thanh toán -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Xác nhận thanh toán</h2>
            <p>Bạn có chắc chắn muốn thanh toán cho các sản phẩm đã chọn không?</p>
            <button id="confirmCheckout" class="custom-button btn-7"><span>Xác nhận</span></button>
        </div>
    </div>

    <div id="notificationModal" class="modalNoti">
        <div class="modal-content">
            <span class="close-notification">&times;</span>
            <h2 id="notificationMessage"></h2>
        </div>
    </div>

    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const checkoutButton = document.getElementById('checkoutBtn');
    const confirmModal = document.getElementById('confirmModal');
    const closeModal = document.querySelector('.close');
    const confirmButton = document.getElementById('confirmCheckout');
    const notificationModal = document.getElementById('notificationModal');
    const closeNotification = document.querySelector('.close-notification');
    const notificationMessage = document.getElementById('notificationMessage');

    checkoutButton.addEventListener('click', () => {
        confirmModal.style.display = 'block';
    });

    closeModal.addEventListener('click', () => {
        confirmModal.style.display = 'none';
    });

    closeNotification.addEventListener('click', () => {
        notificationModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == confirmModal) {
            confirmModal.style.display = 'none';
        }
        if (event.target == notificationModal) {
            notificationModal.style.display = 'none';
        }
    });

    confirmButton.addEventListener('click', () => {
        const selectedItems = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
            .map(checkbox => checkbox.id.replace('squaredTwo', ''));

        if (selectedItems.length > 0) {
            fetch('../php/checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ selectedItems })
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotificationModal(data.message);
                        setTimeout(() => { location.reload(); }, 2000);
                    } else {
                        showNotificationModal(data.message);
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    showNotificationModal('Có lỗi xảy ra, vui lòng thử lại!');
                });
        } else {
            showNotificationModal('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
        }
    });

    function showNotificationModal(message) {
        notificationMessage.innerText = message;
        notificationModal.style.display = 'block';
    }
});


</script>

</body>
</html>
