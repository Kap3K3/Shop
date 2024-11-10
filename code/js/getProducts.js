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
                <p>Price: ${product.price} VND</p>
                <div class="divBtn">
                <button class="custom-button btn-7 buy-button" data-product-id="${product.id}" data-product-name="${product.name}"><span>Mua</span></button>
                <div class="cart-button" data-product-id="${product.id}">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                </div>
            `;
            productsContainer.appendChild(productDiv);
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

                document.getElementById('selectedProduct').innerText = `Sản phẩm: ${productName}, Số lượng: 1`;
                confirmModal.style.display = 'block';

                confirmButton.onclick = async function() {
                    try {
                        await createOrder(productId, 1); // Gọi hàm để tạo đơn hàng cho sản phẩm với số lượng 1
                        confirmModal.style.display = 'none'; // Ẩn modal xác nhận sau khi xác nhận

                        // Hiển thị modal thông báo
                        document.getElementById('notificationMessage').innerText = `Đơn hàng cho sản phẩm ${productName} đã được tạo thành công!`;
                        notificationModal.style.display = 'block';

                    } catch (error) {
                        confirmModal.style.display = 'none'; // Ẩn modal xác nhận sau khi xác nhận
                        document.getElementById('notificationMessage').innerText = 'Có lỗi xảy ra, vui lòng thử lại. Chi tiết lỗi: ' + error.message;
                        notificationModal.style.display = 'block';
                    }
                };

                closeModal.onclick = function() {
                    confirmModal.style.display = 'none';
                };

                const closeNotificationModal = document.querySelector('.close-notification');
                

                closeNotificationModal.onclick = function() {
                    notificationModal.style.display = 'none';
                };

                window.onclick = function(event) {
                    if (event.target == confirmModal) {
                        confirmModal.style.display = 'none';
                    }
                    if (event.target == notificationModal) {
                        notificationModal.style.display = 'none';
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
