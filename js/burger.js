// gestion menu burger
const burger = document.querySelector('.burger');
const menu = document.querySelector('.menuLinkMobile');
const menuLink = document.querySelectorAll('.menuLinkMobile a');

burger.addEventListener('click', () => {
  burger.classList.toggle('active');
  menu.classList.toggle('active');
});

menuLink.forEach((link) => {
  link.addEventListener('click', () => {
    burger.classList.toggle('active');
    menu.classList.toggle('active');
  });
});

console.log("menu burger JS chargé")