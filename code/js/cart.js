async function addToCart(productId) {
    fetch('../php/addToCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ productId })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              showModal('Sản phẩm đã được thêm vào giỏ hàng!');
          } else {
              showModal(`Có lỗi xảy ra: ${data.message}`);
          }
      }).catch(error => {
          console.error('Error:', error);
          showModal('Có lỗi xảy ra, vui lòng thử lại.');
      });
}

function showModal(message) {
    const modal = document.getElementById('notificationModal');
    const messageElement = document.getElementById('notificationMessage');
    messageElement.innerText = message;
    modal.style.display = 'block';
}


const notificationModal = document.getElementById('notificationModal');


window.onclick = function(event) {
    if (event.target == notificationModal) {
        notificationModal.style.display = 'none';
    }
};

