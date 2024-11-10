document.addEventListener('DOMContentLoaded', function() {
    fetch('../php/getCategories.php')
        .then(response => response.json())
        .then(data => {
            const cateContainer = document.getElementById('categories');
            data.forEach(cate => {
                const cateDiv = document.createElement('div');
                cateDiv.className = 'cate_item';
                cateDiv.innerHTML = `<a href="#" class="cate-link">${cate.name}</a>`;
                cateContainer.appendChild(cateDiv);
            });

            // Thêm sự kiện click vào các thẻ a
            const cateLinks = document.querySelectorAll('.cate-link');
            cateLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const catename = this.textContent;
                    const searchInput = document.getElementById('keyword');
                    searchInput.value = catename;

                    // Gửi form tìm kiếm
                    document.getElementById('search-form').submit();
                });
            });
        })
        .catch(error => console.error('Error:', error));
});