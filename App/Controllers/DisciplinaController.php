<?php

class DisciplinaController
{
    /**
     * Exibe a lista de disciplinas/cursos disponíveis.
     * Mapeado para a rota 'disciplinas'.
     */
    public function index()
    {
        $pdo = dbConnect();
        $cursos = [];

        try {
            // Busca todos os cursos e contar quantos alunos ativos estão em cada um.
            $stmt = $pdo->query("
                SELECT 
                    c.id, 
                    c.nome_curso, 
                    c.descricao,
                    (SELECT COUNT(*) FROM Matriculas m WHERE m.curso_id = c.id AND m.status = 'Ativa') as total_alunos
                FROM Cursos c
                ORDER BY c.nome_curso
            ");
            
            $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Se houver um erro (ex: tabelas não encontradas), exibe o erro na página
            $_SESSION['flash_error'] = 'Erro ao buscar cursos: ' . $e->getMessage();
        }

        // Passa os dados para a View
        $data = [
            'titulo' => 'Disciplinas',
            'cursos' => $cursos,
            'styles' => ['TelaDisciplinas/style.css'],
            'scripts' => []
        ];

        // 3. Renderizar a view
        render_view(__DIR__ . '/../Views/Disciplinas.php', $data);
    }
}