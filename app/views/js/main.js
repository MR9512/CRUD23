document.addEventListener('DOMContentLoaded', () => {
  // Se activa cuando el contenido del DOM ha sido completamente cargado
  // Obtiene todos los elementos con la clase "navbar-burger"
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
  // Agrega un evento de clic a cada uno de ellos
  $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {
          // Obtiene el objetivo del atributo "data-target"
          const target = el.dataset.target;
          const $target = document.getElementById(target);
          // Alterna la clase "is-active" tanto en "navbar-burger" como en "navbar-menu"
          el.classList.toggle('is-active');
          $target.classList.toggle('is-active');

      });
  });
});
