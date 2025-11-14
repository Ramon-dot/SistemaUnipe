<?php

class PresencaController
{
    /**
     * Exibe a lista de presença de uma disciplina.
     * Mapeado para a rota 'presenca'.
     */
    public function index()
    {
        // Pega os parâmetros da URL. A página de presença agora depende de um curso.
        $termoBusca = $_GET['busca'] ?? '';
        $curso_id = $_GET['curso_id'] ?? '1';

        $alunosParaExibir = [];
        $pdo = dbConnect();

        // Consulta SQL para buscar todos os dados necessários.
        $sql = "
            SELECT 
                u.nome,
                a.rgm AS rgm,
                m.id as matricula_id,
                c.limite_faltas,
                (SELECT COUNT(*) * 3 FROM ListaPresenca lp WHERE lp.matricula_id = m.id AND lp.presente = 0) as total_faltas,
                (SELECT MAX(lp.data_aula) FROM ListaPresenca lp WHERE lp.matricula_id = m.id) as ultima_aula_data,
                (SELECT lp.presente FROM ListaPresenca lp WHERE lp.matricula_id = m.id ORDER BY lp.data_aula DESC LIMIT 1) as ultimo_status_presente
            FROM Usuarios u
            JOIN Alunos a ON u.id = a.usuario_id
            JOIN Matriculas m ON a.id = m.aluno_id
            JOIN Cursos c ON m.curso_id = c.id
            WHERE m.curso_id = :curso_id
              AND m.status = 'Ativa'
        ";

        // Adiciona o filtro de busca se ele existir
        if (!empty($termoBusca)) {
            $sql .= " AND (u.nome LIKE :busca OR a.rgm LIKE :busca)";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':curso_id', $curso_id, PDO::PARAM_INT);
        if (!empty($termoBusca)) {
            $stmt->bindValue(':busca', '%' . $termoBusca . '%');
        }
        $stmt->execute();
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Formata os dados para a View
        foreach ($alunos as $aluno) {
            $atingiu_limite = $aluno['total_faltas'] >= $aluno['limite_faltas'];

            $alunosParaExibir[] = [
                'nome' => $aluno['nome'],
                'rgm' => $aluno['rgm'],
                'matricula_id' => $aluno['matricula_id'],
                'data' => $aluno['ultima_aula_data'] ? date('d/m/Y', strtotime($aluno['ultima_aula_data'])) : 'N/A',
                'faltas' => $aluno['total_faltas'] . ' / ' . $aluno['limite_faltas'],
                'presente' => (bool)$aluno['ultimo_status_presente'],
                'reprovado' => $atingiu_limite
            ];
        }

        // Define os dados para a view e o layout
        $data = [
            'titulo' => 'Lista de Presença',
            'alunosParaExibir' => $alunosParaExibir,
            'termoBusca' => $termoBusca,
            'styles' => ['TelaPresenca/style.css'],
            'scripts' => ['TelaPresenca/script.js']
        ];

        render_view(__DIR__ . '/../Views/Presenca.php', $data);
    }

    /**
     * Processa o registro de presença ou falta de um aluno.
     */
    public function registrarPresenca()
    {
        // Validação inicial e coleta de dados
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?rota=presenca');
            exit;
        }

        $matricula_id = filter_input(INPUT_POST, 'matricula_id', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 1]]);

        // Se os dados forem inválidos, interrompe a execução.
        if ($matricula_id === false || $status === false) {
            $_SESSION['flash_error'] = 'Dados inválidos para registrar a presença.';
            header('Location: ' . BASE_URL . '/index.php?rota=presenca');
            exit;
        }

        $pdo = dbConnect();
        $curso_id = null;

        try {
            // Precisamos do curso_id para redirecionar de volta para a página correta.
            $stmt_curso = $pdo->prepare("SELECT curso_id FROM Matriculas WHERE id = :matricula_id");
            $stmt_curso->execute([':matricula_id' => $matricula_id]);
            $curso_id = $stmt_curso->fetchColumn();

            if (!$curso_id) {
                throw new Exception("Matrícula não encontrada.");
            }

            // Inseri o novo registro de presença/falta
            $sql = "INSERT INTO ListaPresenca (matricula_id, data_aula, presente) VALUES (:matricula_id, CURDATE(), :presente)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':matricula_id' => $matricula_id,
                ':presente' => $status
            ]);

            $_SESSION['flash_success'] = 'Status de presença atualizado com sucesso!';
        } catch (PDOException $e) {
            // Trata erros de duplicidade para tentar registrar presença para o mesmo aluno no mesmo dia
            if ($e->errorInfo[1] == 1062) {
                $_SESSION['flash_error'] = 'A presença para este aluno já foi registrada hoje.';
            } else {
                $_SESSION['flash_error'] = 'Erro ao registrar presença: ' . $e->getMessage();
            }
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Ocorreu um erro: ' . $e->getMessage();
        }

        // Redireciona de volta para a página de presença do curso
        $redirect_url = BASE_URL . '/index.php?rota=presenca' . ($curso_id ? '&curso_id=' . $curso_id : '');
        header('Location: ' . $redirect_url);
        exit;
    }
}
