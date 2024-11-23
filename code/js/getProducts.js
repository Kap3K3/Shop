document.addEventListener('DOMContentLoaded', async function() {
    try {
        const response = await fetch('../php/getProducts.php');
        const data = await response.json();
        const productsContainer = document.getElementById('products');
        
        data.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.className = 'product';
            productDiv.innerHTML = `
                <img src="${product.image}" alt="">
                <h2>${product.name}</h2>
                <p>Giá: ${product.price} VND</p>
                <div class="divBtn">
                    <button class="custom-button btn-7 buy-button" data-product-id="${product.id}" data-product-name="${product.name}"><span>Mua</span></button>
                    <div class="cart-button" data-product-id="${product.id}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-text">Thêm vào giỏ hàng</span>
                    </div>
                </div>
            `;
            productsContainer.appendChild(productDiv);
        
            // Add event listener to the productDiv
            productDiv.addEventListener('click', () => {
                window.location.href = `product.php?id=${product.id}`;
            });
        
            // Add event listener to the buy button
            const buyButton = productDiv.querySelector('.buy-button');
            buyButton.addEventListener('click', (event) => {
                event.stopPropagation();
                // Add your buy button logic here
                console.log(`Buying product: ${product.name}`);
            });
        
            // Add event listener to the cart button
            const cartButton = productDiv.querySelector('.cart-button');
            cartButton.addEventListener('click', (event) => {
                event.stopPropagation();
                // Add your cart button logic here
                console.log(`Adding product to cart: ${product.name}`);
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
                        document.querySelectorAll('#quantity').forEach(function(element) {
                            element.value=1;
                        });
                    }
                    if (event.target == notificationModal) {
                        notificationModal.style.display = 'none';
                        document.querySelectorAll('#quantity').forEach(function(element) {
                            element.value=1;
                        });
                    }
                    
                };
            });
        });
    } catch (error) {
        console.error('Lỗi:', error);
    }
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
