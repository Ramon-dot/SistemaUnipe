<?php
class CadastroController
{
    /**
     * Exibe a página de formulário de cadastro.
     * Mapeado para a rota 'cadastro_form'
     */
    public function showCadastroForm()
    {
        $pdo = dbConnect();
        $stmt = $pdo->query("SELECT id, nome_curso FROM Cursos WHERE nome_curso != '' ORDER BY nome_curso ASC");
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'titulo' => 'Novo Cadastro',
            'cursos' => $cursos,
            'styles' => ['TelaCadastro/style.css'], 
            'scripts' => ['TelaCadastro/script.js', 'TelaCadastro/cadastro_dinamico.js']
        ];

        // Renderiza a view
        render_view(__DIR__ . '/../Views/cadastro_form.php', $data);
    }

    /**
     * Processa os dados do formulário de cadastro.
     * Mapeado para a rota 'cadastro_process'
     */
    public function processCadastro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?rota=cadastro_form');
            exit;
        }

        // DADOS DE ACESSO
        $tipo_usuario = $_POST['tipo_usuario'] ?? null;
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;
        $confirmarSenha = $_POST['confirmarSenha'] ?? null;

        // DADOS PESSOAIS COMUNS
        $nome = $_POST['nome'] ?? null;
        $sobrenome = $_POST['sobrenome'] ?? null;
        $cpf = $_POST['cpf'] ?? null;
        $rg = $_POST['rg'] ?? null;
        $data_nascimento = $_POST['data_nascimento'] ?? null;
        $genero = $_POST['genero'] ?? null;
        $telefone = $_POST['telefone'] ?? null;

        // DADOS DE ENDEREÇO ALUNO
        $cep = $_POST['cep'] ?? null;
        $endereco = $_POST['endereco'] ?? null;
        $numero = $_POST['numero'] ?? null;
        $complemento = $_POST['complemento'] ?? null;
        $bairro = $_POST['bairro'] ?? null;
        $cidade = $_POST['cidade'] ?? null;
        $estado = $_POST['estado'] ?? null;
        
        // DADO DO CURSO ALUNO
        $curso_id = $_POST['curso_id'] ?? null;

        // Validação
        if (empty($tipo_usuario) || $tipo_usuario === 'Selecione' || empty($nome) || empty($email) || empty($senha) || empty($cpf) || empty($data_nascimento)) {
            $_SESSION['flash_error'] = 'Todos os campos obrigatórios (*) devem ser preenchidos.';
            header('Location: ' . BASE_URL . '/index.php?rota=cadastro_form');
            exit;
        }

        // Validação de curso só se for aluno
        if ($tipo_usuario === 'Aluno' && (empty($curso_id) || $curso_id === 'Selecione um curso')) {
            $_SESSION['flash_error'] = 'Você deve selecionar um curso para o aluno.';
            header('Location: ' . BASE_URL . '/index.php?rota=cadastro_form');
            exit;
        }

        if ($senha !== $confirmarSenha) {
            $_SESSION['flash_error'] = 'As senhas não conferem.';
            header('Location: ' . BASE_URL . '/index.php?rota=cadastro_form');
            exit;
        }

        try {
            $pdo = dbConnect(); 
            $pdo->beginTransaction();

            // 1. Inserir na tabela Usuarios comum a todos
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $sqlUser = "INSERT INTO Usuarios (nome, sobrenome, email, senha_hash, tipo_usuario, status) 
                        VALUES (:nome, :sobrenome, :email, :senha_hash, :tipo_usuario, 'Ativo')";
            
            $stmtUser = $pdo->prepare($sqlUser);
            $stmtUser->execute([
                ':nome' => $nome,
                ':sobrenome' => $sobrenome,
                ':email' => $email,
                ':senha_hash' => $senha_hash,
                ':tipo_usuario' => $tipo_usuario
            ]);
            $usuario_id = $pdo->lastInsertId();

            // Inseri na tabela específica Alunos ou Professores
            if ($tipo_usuario === 'Aluno') {
                
                $sqlAluno = "INSERT INTO Alunos (
                                 usuario_id, cpf, rg, data_nascimento, genero, telefone, 
                                 cep, endereco, numero, complemento, bairro, cidade, estado
                             ) 
                             VALUES (
                                 :usuario_id, :cpf, :rg, :data_nascimento, :genero, :telefone,
                                 :cep, :endereco, :numero, :complemento, :bairro, :cidade, :estado
                             )";
                
                $stmtAluno = $pdo->prepare($sqlAluno);
                $stmtAluno->execute([
                    ':usuario_id' => $usuario_id,
                    ':cpf' => $cpf,
                    ':rg' => $rg,
                    ':data_nascimento' => $data_nascimento,
                    ':genero' => $genero,
                    ':telefone' => $telefone,
                    ':cep' => $cep,
                    ':endereco' => $endereco,
                    ':numero' => $numero,
                    ':complemento' => $complemento,
                    ':bairro' => $bairro,
                    ':cidade' => $cidade,
                    ':estado' => $estado
                ]);
                
                $aluno_id = $pdo->lastInsertId(); 

                // Bloco para GERAR E SALVAR O RGM AUTOMÁTICO
                $ano_rgm = date('y');
                $curso_id_rgm = str_pad(substr($curso_id, -2), 2, '0', STR_PAD_LEFT);
                $aluno_id_rgm = str_pad(substr($aluno_id, -4), 4, '0', STR_PAD_LEFT);
                
                $rgm_gerado = $ano_rgm . $curso_id_rgm . $aluno_id_rgm;
                
                $sqlRGM = "UPDATE Alunos SET rgm = :rgm WHERE id = :aluno_id";
                $stmtRGM = $pdo->prepare($sqlRGM);
                $stmtRGM->execute([
                    ':rgm' => $rgm_gerado,
                    ':aluno_id' => $aluno_id
                ]);
                
                // Cria a Matrícula
                $sqlMatricula = "INSERT INTO Matriculas (aluno_id, curso_id, data_matricula, status)
                                 VALUES (:aluno_id, :curso_id, CURDATE(), 'Ativa')";
                $stmtMatricula = $pdo->prepare($sqlMatricula);
                $stmtMatricula->execute([
                    ':aluno_id' => $aluno_id,
                    ':curso_id' => $curso_id
                ]);

            } elseif ($tipo_usuario === 'Professor') {
                
                // Bloco de inserção do Professor
                $sqlProfessor = "INSERT INTO Professores (usuario_id, cpf, telefone) 
                                 VALUES (:usuario_id, :cpf, :telefone)";
                
                $stmtProfessor = $pdo->prepare($sqlProfessor);
                $stmtProfessor->execute([
                    ':usuario_id' => $usuario_id,
                    ':cpf' => $cpf,
                    ':telefone' => $telefone
                ]);
            }

            // Se tudo deu certo, comitar a transação
            $pdo->commit();

            // Lógica de redirecionamento
            if (isset($_SESSION['user_id'])) {
                $_SESSION['flash_success'] = 'Usuário cadastrado com sucesso!';
                header('Location: ' . BASE_URL . '/index.php?rota=cadastro_form');
            } else {
                // Se foi um auto-cadastro
                $_SESSION['flash_success'] = 'Cadastro realizado com sucesso! Faça o login.';
                header('Location: ' . BASE_URL . '/index.php?rota=login');
            }
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            if ($e->errorInfo[1] == 1062) { 
                $_SESSION['flash_error'] = 'Este e-mail ou CPF já está cadastrado. Verifique os dados.';
            } else {
                // Mostra o erro exato para depuração
                $_SESSION['flash_error'] = 'Erro ao cadastrar: ' . $e->getMessage();
            }
            header('Location: ' . BASE_URL . '/index.php?rota=cadastro_form');
            exit;
        }
    }
}