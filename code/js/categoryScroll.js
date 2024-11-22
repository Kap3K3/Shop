const categories = document.getElementById('categories');

let isDown = false;
let startX;
let scrollLeft;

categories.addEventListener('mousedown', (e) => {
  isDown = true;
  categories.classList.add('active');
  startX = e.pageX - categories.offsetLeft;
  scrollLeft = categories.scrollLeft;
});

categories.addEventListener('mouseleave', () => {
  isDown = false;
  categories.classList.remove('active');
});

categories.addEventListener('mouseup', () => {
  isDown = false;
  categories.classList.remove('active');
});

categories.addEventListener('mousemove', (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - categories.offsetLeft;
  const walk = (x - startX) * 1; // Tốc độ cuộn
  categories.scrollLeft = scrollLeft - walk;
});
