// gestion menu burger
console.log("JS menu burger chargé")

const burger = document.querySelector('.burger');
const menu = document.querySelector('.menu');
const menuLink = document.querySelectorAll('.menuLink a');

burger.addEventListener('click', () => {
  burger.classList.toggle('active');
  menu.classList.toggle('mobile');
});

menuLink.forEach((link) => {
  link.addEventListener('click', () => {
    burger.classList.toggle('active');
    menu.classList.toggle('mobile');
  });
});

