<?php
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_qllinhkien";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product data
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $product = $result->fetch_assoc();
} else {
    echo "No product found";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/modalConfirmCart.css">
    <link rel="stylesheet" href="../css/product.css">
    
</head>
<body>
    <?php include '../php/header.php'; ?>
    <?php include '../php/side.php'; ?>
    <?php include '../php/search.php'; ?>
    <?php include '../php/footer.php'; ?>
    <div class="main">
        <div class="product-show">
            <?php if (isset($product)) { ?>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <hr>
                <h2><?php echo $product['name']; ?></h2>
                <p class="price"><?php echo $product['price']; ?> VND</p>
                <p class="description"><?php echo !empty($product['description']) ? $product['description'] : 'Chưa có thông tin mô tả cho sản phẩm này.'; ?></p>
                <div class="quantity-container">
                    <button id="decreaseQuantity" class="quantity-button">-</button>
                    <input type="text" id="quantity" value="1" disabled>
                    <button id="increaseQuantity" class="quantity-button">+</button>
                </div>
                <button class="buy-button">Mua ngay</button>
                <div class="cart-button" data-product-id="<?php echo $product['id']; ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-text">Thêm vào giỏ hàng</span>
                </div>
            <?php } else { ?>
                <p>Không tìm thấy sản phẩm</p>
            <?php } ?>
        </div>
    </div>

    <!-- Modal for notifications -->
    <div id="notificationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Thông báo</h2>
            <p id="notificationMessage"></p>
        </div>
    </div>

</body>
<script src="../js/btnIncDec.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buyButton = document.querySelector('.buy-button');
    const cartButton = document.querySelector('.cart-button');
    const quantityInput = document.getElementById('quantity');
    const errorModal = document.getElementById('notificationModal');
    const errorMessage = document.getElementById('notificationMessage');
    const closeModal = document.querySelector('.close');

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
                throw new Error(`Có lỗi xảy ra: ${data.message}`);
            }

            return data;
        } catch (error) {
            throw error;
        }
    }

    async function addToCart(productId,quantity) {
        try {
            const response = await fetch('../php/addToCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ productId,quantity })
            });

            if (!response.ok) {
                throw new Error('Phản hồi mạng không ổn');
            }

            const data = await response.json();
            if (!data.success) {
                showModal(`Có lỗi xảy ra: ${data.message}`);
            } else {
                showModal('Sản phẩm đã được thêm vào giỏ hàng!');
            }
        } catch (error) {
            console.error('Error:', error);
            showModal('Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    function showModal(message) {
        const modal = document.getElementById('notificationModal');
        const messageElement = document.getElementById('notificationMessage');
        messageElement.innerText = message;
        modal.style.display = 'block';
    }

    buyButton.addEventListener('click', async function() {
        const quantity = quantityInput.value;
        const productId = <?php echo $product_id; ?>;

        try {
            const result = await createOrder(productId, quantity);
            console.log(result);
            showModal('Mua sản phẩm thành công!');
            // Redirect to a confirmation or order page if needed
            // window.location.href = 'orderConfirmation.php';
        } catch (error) {
            console.error('Error:', error);
            showModal(error.message);
        }
    });

    cartButton.addEventListener('click', async function() {
        const productId = <?php echo $product_id; ?>;
        const quantity = quantityInput.value;
        try {
            await addToCart(productId,quantity);
        } catch (error) {
            console.error('Error:', error);
            showModal(error.message);
        }
    });

    // Close the modal
    closeModal.addEventListener('click', function() {
        errorModal.style.display = 'none';
    });

    // Close the modal if the user clicks outside of the modal
    window.addEventListener('click', function(event) {
        if (event.target == errorModal) {
            errorModal.style.display = 'none';
        }
    });
});
</script>
</html>
