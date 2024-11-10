<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/btn_buy.css">
    <link rel="stylesheet" href="../css/modalConfirmCart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include '../php/header.php'; ?>
    <?php include '../php/side.php'; ?>
    <?php include '../php/search.php' ?>
    <div class="main">
        <div class="content">
            <div id="categories"></div>
            <h2 id="ftp">Featured Products</h2>
            <div id="products"></div>
            
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
                <span class="close-2">&times;</span>
                <h2>Xác nhận mua sản phẩm</h2>
                <p id="selectedProduct"></p>
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
    </div>
    <?php include '../php/footer.php'; ?>
    
    <script src="../js/getProducts.js"></script>
    <script src="../js/getCategories.js"></script>
    <script src="../js/cart.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>

