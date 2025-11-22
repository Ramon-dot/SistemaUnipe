<?php

//Inicio das sessões se inicia aqui
session_start();

// Carrega as configurações principais (URL base, conexão com DB)
require_once __DIR__ . '/../Config/conection.php';

// Carrega funções globais (helpers)
require_once __DIR__ . '/../App/helpers.php';

// Carrega a classe do Roteador
require_once __DIR__ .'/../App/Core/Router.php';

// Pega a rota da URL. Ex: 'login', 'home', 'cadastro'
// O .htaccess deve redirecionar tudo para /index.php?rota=...
$route = $_GET['rota'] ?? 'home';

// Instancia o roteador
$router = new Router();

// O método dispatch encontrará o arquivo correspondente à rota e o incluirá.
// Ele também cuidará da lógica de autenticação e redirecionamento.
$router->dispatch($route);
