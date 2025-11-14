<?php

class Logout{
    public function index(){

        //Limpa todas as variáveis da sessão
        $_SESSION = [];

        //Destrói a sessão
        session_destroy();

        //Redireciona para a página de login usando a URL base
        header('Location: ' . BASE_URL . '/index.php?rota=login');
        exit();
    }
}