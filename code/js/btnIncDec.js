// Lấy tất cả các phần tử có ID 'increaseQuantity' và thêm sự kiện click
document.querySelectorAll('#increaseQuantity').forEach(function(element) {
    element.addEventListener('click', function() {
        let quantity = element.previousElementSibling.value;
        quantity = parseInt(quantity) + 1;
        element.previousElementSibling.value = quantity;
    });
});

// Lấy tất cả các phần tử có ID 'decreaseQuantity' và thêm sự kiện click
document.querySelectorAll('#decreaseQuantity').forEach(function(element) {
    element.addEventListener('click', function() {
        let quantity = element.nextElementSibling.value;
        if (quantity > 1) {
            quantity = parseInt(quantity) - 1;
            element.nextElementSibling.value = quantity;
        }
    });
});
