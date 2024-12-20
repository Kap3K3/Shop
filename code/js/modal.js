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
            document.querySelectorAll('#quantity').forEach(function(element) {
                element.value=1;
            });
        }
    });

    confirmCartButton.addEventListener('click', function() {
        const productId = confirmCartButton.getAttribute('data-product-id');
        let quantity = document.getElementById('quantity').value;
        addToCart(productId,quantity);
        cartModal.style.display = 'none';
    });
});

function openModal(productId) {
    const cartModal = document.getElementById('cartModal');
    const confirmCartButton = document.getElementById('confirmCartButton');

    confirmCartButton.setAttribute('data-product-id', productId);
    cartModal.style.display = 'block';
}
