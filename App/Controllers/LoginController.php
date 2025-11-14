<?php

class LoginController
{
    /**
     * Exibe a página de formulário de login.
     */
    public function showLoginForm()
    {
        $data = [
            'titulo' => 'Login',
            'scripts' => ['TelaLogin/script.js']
        ];

        // Renderiza a view de login dentro de um layout específico para ela
        ob_start();
        require __DIR__ . '/../Views/login.php';
        $conteudo = ob_get_clean();

        require_once 'login_layout.php';
    }

    /**
     * Processa os dados do formulário de login.
     */
    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?rota=login');
            exit;
        }

        $email = $_POST['email'] ?? null;
        $senha = $_POST['password'] ?? null;

        if (empty($email) || empty($senha)) {
            $_SESSION['flash_error'] = 'Email e senha são obrigatórios.';
            header('Location: ' . BASE_URL . '/index.php?rota=login');
            exit;
        }

        try {
            $pdo = dbConnect();
            $stmt = $pdo->prepare('SELECT id, nome, senha_hash FROM Usuarios WHERE email = :email AND status = "Ativo"');
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($senha, $user['senha_hash'])) {
                // Login bem-sucedido
                session_regenerate_id(true); // Prevenção contra session fixation
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nome'] = $user['nome'];
                
                header('Location: ' . BASE_URL . '/index.php?rota=home');
                exit;
            } else {
                // Credenciais inválidas
                $_SESSION['flash_error'] = 'Email ou senha inválidos.';
                header('Location: ' . BASE_URL . '/index.php?rota=login');
                exit;
            }
        } catch (PDOException $e) {
            // error_log('Erro de login: ' . $e->getMessage());
            $_SESSION['flash_error'] = 'Ocorreu um erro no servidor. Tente novamente mais tarde.';
            header('Location: ' . BASE_URL . '/index.php?rota=login');
            exit;
        }
    }

    /**
     * Realiza o logout do usuário.
     */
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . BASE_URL . '/index.php?rota=login');
        exit();
    }
}