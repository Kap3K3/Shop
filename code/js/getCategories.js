document.addEventListener('DOMContentLoaded', function() {
    fetch('../php/getCategories.php')
        .then(response => response.json())
        .then(data => {
            const cateContainer = document.getElementById('categories');
            data.forEach(cate => {
                const cateDiv = document.createElement('div');
                cateDiv.className = 'cate_item';
                cateDiv.setAttribute('data-category', cate.name);
                cateDiv.innerHTML = `<a href="#" class="cate-link">${cate.name}</a>`;
                cateContainer.appendChild(cateDiv);
            });

            // Thêm sự kiện click vào các thẻ div với class cate_item
            const cateItems = document.querySelectorAll('.cate_item');
            cateItems.forEach(item => {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const category = this.getAttribute('data-category');

                    // Redirect to productsSearch.php with the selected category
                    window.location.href = `cateSearch.php?category=${encodeURIComponent(category)}`;
                });
            });
        })
        .catch(error => console.error('Error:', error));
});
