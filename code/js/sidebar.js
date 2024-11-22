document.getElementById('more').addEventListener('click', () => { 
    const sidebar = document.getElementById('sidebar'); 
    sidebar.classList.toggle('show'); 
    const sideText = document.querySelectorAll('.sideText'); 
    const showText = document.querySelectorAll('.showText');
    sideText.forEach(element => {
        element.classList.toggle('show');
    });
    showText.forEach(element => {
        element.classList.toggle('show');
    });
    
});

document.getElementById('home').addEventListener('click', () => {
    window.location.href = 'index.php';
    
});

document.getElementById('management').addEventListener('click', () => {
    window.location.href = '../business/Category.php';
    
});