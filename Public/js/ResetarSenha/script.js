document.addEventListener('DOMContentLoaded', function () {
  function togglePasswordVisibility(inputId, toggleButtonId) {
    const input = document.getElementById(inputId);
    const toggleButton = document.getElementById(toggleButtonId);
    const icon = toggleButton.querySelector('i');

    toggleButton.addEventListener('click', function () {
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      } else {
        input.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      }
    });
  }

  togglePasswordVisibility('senha', 'toggleSenha');
  togglePasswordVisibility('confirmar_senha', 'toggleConfirmarSenha');
});