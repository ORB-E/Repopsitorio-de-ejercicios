document.addEventListener("DOMContentLoaded", () => {
  // Manejar el formulario
  document.getElementById('loginForm')?.addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Login functionality to implement');
  });

  // Manejar el toggle de contraseña
  const toggleBtn = document.querySelector('.toggle-password');
  const passwordField = document.getElementById('password');
  
  if (toggleBtn && passwordField) {
      toggleBtn.addEventListener('click', () => {
          // Cambiar tipo de input
          passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
          
          // Cambiar iconos
          toggleBtn.classList.toggle('visible');
      });
  }
});