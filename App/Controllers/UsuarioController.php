<?php

class UsuarioController
{
    /**
     * Lista todos os usuários de um determinado tipo (Aluno ou Professor).
     */
    public function listar($tipo)
    {
        if ($tipo !== 'Aluno' && $tipo !== 'Professor') {
            // Redireciona ou mostra erro se o tipo for inválido
            header('Location: ' . BASE_URL . '/index.php?rota=home');
            exit;
        }

        $pdo = dbConnect();
        $sql = "
            SELECT u.id, u.nome, u.sobrenome, u.email, u.status, 
                   CASE 
                       WHEN u.tipo_usuario = 'Aluno' THEN a.rg
                       ELSE p.cpf
                   END as documento
            FROM Usuarios u
            LEFT JOIN Alunos a ON u.id = a.usuario_id AND u.tipo_usuario = 'Aluno'
            LEFT JOIN Professores p ON u.id = p.usuario_id AND u.tipo_usuario = 'Professor'
            WHERE u.tipo_usuario = :tipo
            ORDER BY u.nome ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':tipo' => $tipo]);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Define o título da página dinamicamente
        $titulo = ($tipo === 'Aluno') ? 'Gerenciar Alunos' : 'Gerenciar Professores';

        $data = [
            'titulo' => $titulo,
            'usuarios' => $usuarios,
            'tipo' => $tipo,
            'styles' => ['usuarios/style.css'],
            'scripts' => []
        ];

        render_view(__DIR__ . '/../Views/usuarios/listar.php', $data);
    }

    public function editar($id)
    {
        $pdo = dbConnect();
        $sql = "
            SELECT 
                u.*,
                a.cpf as aluno_cpf, a.rg, a.data_nascimento, a.genero, a.telefone as aluno_telefone, a.cep, a.endereco, a.numero, a.complemento, a.bairro, a.cidade, a.estado,
                p.cpf as prof_cpf, p.telefone as prof_telefone, p.qualificacao
            FROM Usuarios u
            LEFT JOIN Alunos a ON u.id = a.usuario_id
            LEFT JOIN Professores p ON u.id = p.usuario_id
            WHERE u.id = :id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $usuario_raw = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario_raw) {
            $_SESSION['flash_error'] = "Usuário não encontrado.";
            header('Location: ' . BASE_URL . '/index.php?rota=home');
            exit;
        }

        // Unifica os campos de CPF e telefone
        $usuario = $usuario_raw;
        if ($usuario['tipo_usuario'] === 'Aluno') {
            $usuario['cpf'] = $usuario['aluno_cpf'];
            $usuario['telefone'] = $usuario['aluno_telefone'];
        } else {
            $usuario['cpf'] = $usuario['prof_cpf'];
            $usuario['telefone'] = $usuario['prof_telefone'];
        }

        $data = [
            'titulo' => 'Editar Usuário',
            'usuario' => $usuario,
            'styles' => ['usuarios/style.css'],
            'scripts' => []
        ];

        render_view(__DIR__ . '/../Views/usuarios/editar.php', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?rota=home');
            exit;
        }

        // Coleta de dados
        $id = $_POST['id'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $email = $_POST['email'];
        $status = $_POST['status'];

        $pdo = dbConnect();
        try {
            $pdo->beginTransaction();

            // Atualiza a tabela Usuarios
            $sqlUsuario = "UPDATE Usuarios SET nome = :nome, sobrenome = :sobrenome, email = :email, status = :status WHERE id = :id";
            $stmtUsuario = $pdo->prepare($sqlUsuario);
            $stmtUsuario->execute([
                ':nome' => $nome,
                ':sobrenome' => $sobrenome,
                ':email' => $email,
                ':status' => $status,
                ':id' => $id
            ]);

            // Lógica para atualizar senha (se fornecida)
            if (!empty($_POST['senha'])) {
                if ($_POST['senha'] !== $_POST['confirmarSenha']) {
                    throw new Exception("As novas senhas não conferem.");
                }
                $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                $stmtSenha = $pdo->prepare("UPDATE Usuarios SET senha_hash = :senha_hash WHERE id = :id");
                $stmtSenha->execute([':senha_hash' => $senha_hash, ':id' => $id]);
            }

            // Atualiza a tabela específica (Alunos ou Professores)
            // ... (lógica de UPDATE para Alunos ou Professores aqui)

            $pdo->commit();
            $_SESSION['flash_success'] = "Usuário atualizado com sucesso!";

        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['flash_error'] = "Erro ao atualizar usuário: " . $e->getMessage();
        }

        // Redireciona de volta para a lista correta
        $redirect_rota = ($tipo_usuario === 'Aluno') ? 'listar_alunos' : 'listar_professores';
        header('Location: ' . BASE_URL . '/index.php?rota=' . $redirect_rota);
        exit;
    }

    public function excluir($id)
    {
        // Lógica para excluir um usuário
    }
}