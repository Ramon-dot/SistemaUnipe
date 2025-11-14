<?php
class HomeController 
{
    /**
     * Exibe a página inicial (home)
     * Mapeado para a rota home
     */
    public function index()
    {
        // Define os dados a serem passados para a view e o layout
        $data = [
            'titulo' => 'Página Inicial',
            'styles' => ['TelaHome/style.css'],
            'scripts' => []
        ];

        // Renderiza a view dentro do layout principal
        render_view(__DIR__ . '/../Views/home.php', $data);
    }

    /**
     * Exibe a página de erro 404 (Não Encontrado)
     * Mapeado para a rota 404
     */
    public function notFound()
    {
        // Envia o cabeçalho HTTP 404 para o navegador
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/../Views/404.php';
    }
}