document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    // Verifica se os elementos existem antes de adicionar o evento
    if (togglePassword && password) {
        const icon = togglePassword.querySelector('i');
        
        togglePassword.addEventListener('click', function () {
            // Método mais direto - igual ao da tela de resetar senha
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    }
});