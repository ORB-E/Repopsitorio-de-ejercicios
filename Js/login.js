document.addEventListener("DOMContentLoaded", () => {
  document.getElementById('loginForm').addEventListener('submit', (e) => {
      e.preventDefault();
      // Aquí iría la lógica de autenticación
      alert('Login functionality to implement');
  });

  document.querySelector('.toggle-password').addEventListener('click', togglePassword);
});

function togglePassword() {
  const passwordField = document.getElementById('password');
  const eyeIcon = document.querySelector('.eye-icon');
  
  passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
  eyeIcon.classList.toggle('visible');
}