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

// Lấy danh mục từ GET
$category = isset($_GET['category']) ? $_GET['category'] : '';

$product = [];
if ($category) {
    // Truy vấn tìm kiếm sản phẩm theo danh mục
    $sql = "SELECT id, name, price, image FROM products WHERE id_prodcate =(select id from product_category where name LIKE '%$category%')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/btn_buy.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/modalConfirmCart.css">
</head>
<body>
    <?php include '../php/header.php' ?>
    <?php include '../php/side.php' ?>
    <?php include '../php/search.php' ?>
    <?php include '../php/footer.php' ?>
    <div class="main">
        <h2 style="margin: 10px; font-size:30px;">Sản phẩm thuộc danh mục: '<?php echo htmlspecialchars($category); ?>'</h2>
        <div id="products" class="product-list">
            <?php if (!empty($product)): ?>
                <?php foreach ($product as $item): ?>
                    <div class="product">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="">
                        <h2><?php echo htmlspecialchars($item["name"]); ?></h2>
                        <p>Giá: <?php echo htmlspecialchars($item["price"]); ?> VND</p>
                        <div class="divBtn">
                            <button class="custom-button btn-7 buy-button" data-product-id="<?php echo $item['id']; ?>" data-product-name="<?php echo htmlspecialchars($item['name']); ?>"><span>Mua</span></button>
                            <div class="cart-button" data-product-id="<?php echo $item['id']; ?>">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-text">Thêm vào giỏ hàng</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không tìm thấy sản phẩm nào.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Modal xác nhận -->
    <div id="cartModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Bạn có chắc chắn muốn thêm sản phẩm này vào giỏ hàng?</p>
                <button id="confirmCartButton" class="custom-button btn-7"><span>Xác Nhận</span></button>
            </div>
        </div>
        
        <div id="confirmModal" class="modal">
            <div class="modal-content">
                <span class="close-2">×</span>
                <h2>Xác nhận mua sản phẩm</h2>
                <p id="selectedProduct"></p>
                
                <!-- Thêm phần tử tăng giảm số lượng -->
                <div class="quantity-container">
                    <button id="decreaseQuantity" class="quantity-button">-</button>
                    <input type="text" id="quantity" value="1" disabled>
                    <button id="increaseQuantity" class="quantity-button">+</button>
                </div>
                
                <button id="confirmPurchase" class="custom-button btn-7"><span>Xác nhận</span></button>
            </div>
        </div>


        <!-- Modal thông báo -->
        <div id="notificationModal" class="modal">
            <div class="modal-content">
                <span class="close close-notification">&times;</span>
                <h2>Thông báo</h2>
                <p id="notificationMessage"></p>
            </div>
        </div>
    <script src="../js/cart.js"></script>
    <script src="../js/modal.js"></script>
    <script src="../js/btnIncDec.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productsContainer = document.getElementById('products');

            productsContainer.querySelectorAll('.product').forEach(productDiv => {
                const productId = productDiv.querySelector('.buy-button').getAttribute('data-product-id');
                const productName = productDiv.querySelector('.buy-button').getAttribute('data-product-name');

                // Add event listener to the productDiv
                productDiv.addEventListener('click', () => {
                    window.location.href = `product.php?id=${productId}`;
                });

                // Add event listener to the buy button
                const buyButton = productDiv.querySelector('.buy-button');
                buyButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    // Add your buy button logic here
                    console.log(`Buying product: ${productName}`);
                });

                // Add event listener to the cart button
                const cartButton = productDiv.querySelector('.cart-button');
                cartButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    // Add your cart button logic here
                    console.log(`Adding product to cart: ${productName}`);
                });
            });
            const cartButtons = document.querySelectorAll('.cart-button');
                cartButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.getAttribute('data-product-id');
                        openModal(productId);
                    });
                });

                const buyButtons = document.querySelectorAll('.buy-button');
                buyButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.getAttribute('data-product-id');
                        const productName = this.getAttribute('data-product-name');

                        const confirmModal = document.getElementById('confirmModal');
                        const confirmButton = document.getElementById('confirmPurchase');
                        const closeModal = document.querySelector('.close-2');
                        const notificationModal = document.getElementById('notificationModal');
                        
                        
                        document.getElementById('selectedProduct').innerText = `Sản phẩm: ${productName}`;
                        confirmModal.style.display = 'block';
                        

                        confirmButton.onclick = async function() {
                            try {
                                let quantity = document.getElementById('quantity').value;
                                await createOrder(productId, quantity);
                                confirmModal.style.display = 'none'; // Ẩn modal xác nhận sau khi xác nhận

                                // Hiển thị modal thông báo
                                document.getElementById('notificationMessage').innerText = `Đơn hàng cho sản phẩm ${productName} đã được tạo thành công!`;
                                notificationModal.style.display = 'block';

                            } catch (error) {
                                confirmModal.style.display = 'none'; // Ẩn modal xác nhận sau khi xác nhận
                                document.getElementById('notificationMessage').innerText = 'Có lỗi xảy ra: ' + error.message;
                                notificationModal.style.display = 'block';
                            }
                            document.getElementById('quantity').value=1;
                        };

                        closeModal.onclick = function() {
                            confirmModal.style.display = 'none';
                            document.getElementById('quantity').value=1;
                        };

                        const closeNotificationModal = document.querySelector('.close-notification');

                        closeNotificationModal.onclick = function() {
                            notificationModal.style.display = 'none';
                        };

                        window.onclick = function(event) {
                            if (event.target == confirmModal) {
                                confirmModal.style.display = 'none';
                                document.getElementById('quantity').value=1;
                            }
                            if (event.target == notificationModal) {
                                notificationModal.style.display = 'none';
                            }
                        };
                    });
                });
        });
        async function createOrder(productId, quantity) {
            try {
                const response = await fetch('../php/createOrder.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ productId, quantity })
                });

                if (!response.ok) {
                    throw new Error('Phản hồi mạng không ổn');
                }

                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.message);
                }

                return data;
            } catch (error) {
                throw error;
            }
        }
    </script>
</body>
</html>
