const headerOpen = document.getElementById("header-open");
headerOpen.addEventListener('click', () => {
  const menu = document.getElementById("menu");
  menu.classList.toggle('show');
});

const headerClose = document.getElementById("header-close");
headerClose.addEventListener('click',() => {
  const menu = document.getElementById("menu");
  menu.classList.toggle('show');
});