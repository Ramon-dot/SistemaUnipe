<?php

/**
 * Renderiza uma view dentro do layout principal.
 *
 * Esta função utiliza o output buffering para capturar o conteúdo de um arquivo de view,
 * injeta esse conteúdo e outras variáveis (como título, CSS e JS) no template de layout principal.
 *
 * @param string $view_path O caminho absoluto para o arquivo da view.
 * @param array $data Um array associativo de dados a serem extraídos e disponibilizados para a view e o layout.
 */
function render_view(string $view_path, array $data = []): void
{
    extract($data);

    ob_start();
    require $view_path;
    $conteudo = ob_get_clean();

    require __DIR__ . '/Views/layout.php';
}