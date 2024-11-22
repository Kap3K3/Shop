document.addEventListener('DOMContentLoaded', function() {
    const cartModal = document.getElementById('cartModal');
    const closeModal = document.querySelector('.close');
    const confirmCartButton = document.getElementById('confirmCartButton');

    closeModal.addEventListener('click', function() {
        cartModal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == cartModal) {
            cartModal.style.display = 'none';
        }
    });

    confirmCartButton.addEventListener('click', function() {
        const productId = confirmCartButton.getAttribute('data-product-id');
        addToCart(productId);
        cartModal.style.display = 'none';
    });
});

function openModal(productId) {
    const cartModal = document.getElementById('cartModal');
    const confirmCartButton = document.getElementById('confirmCartButton');

    confirmCartButton.setAttribute('data-product-id', productId);
    cartModal.style.display = 'block';
}

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