document.addEventListener("DOMContentLoaded", () => {
  // Agregar eventos a los botones
  document.querySelectorAll(".toggle-btn").forEach(button => {
      button.addEventListener("click", () => {
          const targetDiv = button.getAttribute("data-div");
          mostrarDiv(targetDiv);
      });
  });
});

function mostrarDiv(divId) {
  // Ocultar todos los divs
  document.querySelectorAll(".hidden-div").forEach(div => {
      div.classList.remove("active");
  });
  
  // Mostrar el div seleccionado
  const divAMostrar = document.getElementById(divId);
  divAMostrar.classList.add("active");
}