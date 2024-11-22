document.getElementById('increaseQuantity').addEventListener('click', function() {
    let quantity = document.getElementById('quantity').value;
    quantity = parseInt(quantity) + 1;
    document.getElementById('quantity').value = quantity;
});

document.getElementById('decreaseQuantity').addEventListener('click', function() {
    let quantity = document.getElementById('quantity').value;
    if (quantity > 1) {
        quantity = parseInt(quantity) - 1;
        document.getElementById('quantity').value = quantity;
    }
});
