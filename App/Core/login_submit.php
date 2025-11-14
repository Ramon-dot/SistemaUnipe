<?php

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
    $pdo = dbConnect(); // A função de conection.php retorna o objeto PDO

    $stmt = $pdo->prepare('SELECT * FROM Usuarios WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    // Verifica se o usuário existe e se a senha está correta
    if ($user && password_verify($senha, $user['senha_hash'])) {

        // Login bem-sucedido!
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];

        header('Location: ' . BASE_URL . '/index.php?rota=home');
        exit;

    } else {
        // Credenciais inválidas
        $_SESSION['flash_error'] = 'Erro: Verifique as credenciais e tente novamente.';
        header('Location: ' . BASE_URL . '/index.php?rota=login');
        exit;
    }

} catch (PDOException $e) {
    die('Erro ao processar login: ' . $e->getMessage());
}