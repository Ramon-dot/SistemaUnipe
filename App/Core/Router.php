<?php

class Router
{
    /**
     * Mapeamento de rotas para 'Controller@metodo'.
     * @var array
     */
    private $routes = [
        // Rotas de Autenticação e Cadastro
        'login' => ['LoginController', 'showLoginForm'],
        'login_submit' => ['LoginController', 'processLogin'],
        'logout' => ['LoginController', 'logout'],
        'cadastro_form' => ['CadastroController', 'showCadastroForm'],
        'cadastro_process' => ['CadastroController', 'processCadastro'],

        // Rotas de Gerenciamento de Usuários (CRUD)
        'listar_alunos' => ['UsuarioController', 'listar', 'Aluno'],
        'listar_professores' => ['UsuarioController', 'listar', 'Professor'],
        'usuario_editar' => ['UsuarioController', 'editar'],
        'usuario_update' => ['UsuarioController', 'update'],
        'usuario_excluir' => ['UsuarioController', 'excluir'],

        // Rotas Principais da Aplicação
        'home' => ['HomeController', 'index'],
        'disciplinas' => ['DisciplinaController', 'index'],
        'presenca' => ['PresencaController', 'index'],
        'registrar_presenca' => ['PresencaController', 'registrarPresenca'],
        '404' => ['NotFoundController', 'index'],
    ];

    /**
     * Rotas que não exigem que o usuário esteja logado.
     * @var array
     */
    private $publicRoutes = [
        'login',
        'login_submit',
        'cadastro_form',
        'cadastro_process'
    ];

    public function dispatch(string $route): void
    {
        // Redireciona para home se o usuário logado tentar acessar o login
        if (isset($_SESSION['user_id']) && $route === 'login') {
            $this->redirect('home');
        }

        // Protege rotas que não são públicas
        if (!isset($_SESSION['user_id']) && !in_array($route, $this->publicRoutes)) {
            $this->redirect('login');
        }

        if (isset($this->routes[$route])) {
            $controllerName = $this->routes[$route][0];
            $methodName = $this->routes[$route][1];

            // Inclui o arquivo do controller
            require_once __DIR__ . '/../Controllers/' . $controllerName . '.php';

            $controller = new $controllerName();
            
            // Verifica se há parâmetros extras na rota (para o CRUD)
            if (isset($this->routes[$route][2])) {
                $controller->$methodName($this->routes[$route][2]);
            } else {
                // Verifica se a rota precisa de um ID da URL (ex: editar, excluir)
                if ($route === 'usuario_editar' || $route === 'usuario_excluir') {
                    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                    if ($id) {
                        $controller->$methodName($id);
                    } else {
                        // Se o ID for inválido ou não existir, redireciona para a home
                        $this->redirect('home');
                    }
                } else {
                    $controller->$methodName();
                }
            }
        } else {
            // Rota não encontrada, despacha para 404
            $this->dispatch('404');
        }
    }

    private function redirect(string $route): void
    {
        header('Location: ' . BASE_URL . '/index.php?rota=' . $route);
        exit();
    }
}