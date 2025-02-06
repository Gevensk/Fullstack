document.querySelector('.hamburger-button button').onclick = () => {
    document.getElementById('menu-list').classList.toggle('hidden');
};

const leftBtn = document.getElementById('leftBtn');
const rightBtn = document.getElementById('rightBtn');
const cardWrapper = document.getElementById('cardWrapper');
 
 leftBtn.addEventListener('click', () => {
   cardWrapper.scrollBy({
     left: -250, 
     behavior: 'smooth'
   });
 });
 
 rightBtn.addEventListener('click', () => {
   cardWrapper.scrollBy({
     left: 250, 
     behavior: 'smooth'
   });
 });

 const slider = document.getElementById('cardWrapper');

 let isDown = false; // Mengetahui apakah mouse sedang ditekan
 let startX; // Posisi awal X mouse
 let scrollLeft; // Posisi scroll awal
 
 slider.addEventListener('mousedown', (e) => {
     isDown = true; 
     slider.classList.add('active'); 
     startX = e.pageX - slider.offsetLeft; 
     scrollLeft = slider.scrollLeft;
 });
 
 slider.addEventListener('mouseleave', () => {
     isDown = false; 
     slider.classList.remove('active');
 });
 
 slider.addEventListener('mouseup', () => {
     isDown = false; 
     slider.classList.remove('active');
 });
 
 slider.addEventListener('mousemove', (e) => {
     if (!isDown) return;
     e.preventDefault();
     const x = e.pageX - slider.offsetLeft;
     const walk = (x - startX) * 1.5; 
     slider.scrollLeft = scrollLeft - walk;
 });
 
//  Buat Game 

const leftBtnGame = document.getElementById('leftBtnGame');
const rightBtnGame = document.getElementById('rightBtnGame');
const cardWrapperGame = document.getElementById('cardWrapperGame');

leftBtnGame.addEventListener('click', () => {
    cardWrapperGame.scrollBy({
        left: -250,
        behavior: 'smooth'
    });
});

rightBtnGame.addEventListener('click', () => {
    cardWrapperGame.scrollBy({
        left: 250,
        behavior: 'smooth'
    });
});

const sliderGame = document.getElementById('cardWrapperGame');

let isDownGame = false; // Mengetahui apakah mouse sedang ditekan
let startXGame; // Posisi awal X mouse
let scrollLeftGame; // Posisi scroll awal

sliderGame.addEventListener('mousedown', (e) => {
    isDownGame = true;
    sliderGame.classList.add('active');
    startXGame = e.pageX - sliderGame.offsetLeft;
    scrollLeftGame = sliderGame.scrollLeft;
});

sliderGame.addEventListener('mouseleave', () => {
    isDownGame = false;
    sliderGame.classList.remove('active');
});
sliderGame.addEventListener('mouseup', () => {
    isDownGame = false;
    sliderGame.classList.remove('active');
});

sliderGame.addEventListener('mousemove', (e) => {
    if (!isDownGame) return;
    e.preventDefault();
    const x = e.pageX - cardWrapperGame.offsetLeft;
    const walk = (x - startXGame) * 1.5;
    cardWrapperGame.scrollLeft = scrollLeftGame - walk;
});

