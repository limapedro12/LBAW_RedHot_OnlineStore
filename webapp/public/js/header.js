// Sou trolha e preciso de ajuda a por isto numa função para não estar a repetir código
const menu_pop = document.querySelector('#menu-bars');
const navbar = document.querySelector('.headerBar .navbar');


if (menu_pop != null) {
    menu_pop.addEventListener('click', () => {
        console.log('click');
        menu_pop.classList.toggle('fa-times');
        navbar.classList.toggle('active');
    });
}