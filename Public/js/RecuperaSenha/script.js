document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('forgotPasswordForm');
  const emailInput = document.getElementById('email');
  const statusMessage = document.getElementById('statusMessage');
  const statusIcon = document.getElementById('statusIcon');
  const statusText = document.getElementById('statusText');
  const submitBtn = document.getElementById('submitBtn');
  const buttonText = document.getElementById('buttonText');
  const buttonSpinner = document.getElementById('buttonSpinner');

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  function showStatus(message, type) {
    statusMessage.classList.remove('d-none', 'alert-success', 'alert-danger');

    if (type === 'success') {
      statusMessage.classList.add('alert-success');
      statusIcon.className = 'bi bi-check-circle-fill text-success me-2';
    } else {
      statusMessage.classList.add('alert-danger');
      statusIcon.className = 'bi bi-exclamation-circle-fill text-danger me-2';
    }
    statusText.textContent = message;
  }

  // Processar envio do formulário
  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    form.classList.remove('was-validated');

    if (!emailInput.value || !isValidEmail(emailInput.value)) {
      showStatus('Por favor, digite um e-mail válido', 'error');
      form.classList.add('was-validated');
      return;
    }

    // Desabilita botão e mostrar spinner
    submitBtn.disabled = true;
    buttonText.textContent = 'Enviando...';
    buttonSpinner.classList.remove('d-none');

    try {
      const response = await fetch('index.php?rota=recuperar_senha_submit', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ email: emailInput.value })
      });

      const result = await response.json();

      if (result.success) {
        showStatus('Código enviado! Redirecionando...', 'success');
        
        // Redireciona para a Página 2
        setTimeout(() => {
          window.location.href = 'index.php?rota=resetar_senha_form';
        }, 2000);

      } else {
        // ERRO "E-mail não cadastrado"
        showStatus(result.message, 'error');
        submitBtn.disabled = false;
        buttonText.textContent = 'Enviar Código de Recuperação';
        buttonSpinner.classList.add('d-none');
      }

    } catch (error) {
      // Erro de rede/conexão
      showStatus('Erro de conexão. Tente novamente.', 'error');
      submitBtn.disabled = false;
      buttonText.textContent = 'Enviar Código de Recuperação';
      buttonSpinner.classList.add('d-none');
    }
  });

  emailInput.addEventListener('input', function () {
    if (statusMessage.classList.contains('alert-danger')) {
      statusMessage.classList.add('d-none');
    }
  });
});