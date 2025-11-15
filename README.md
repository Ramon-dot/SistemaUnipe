Portal Acadêmico (Sistema UNIPÊ)

Este é um projeto de sistema de gerenciamento acadêmico desenvolvido em PHP, seguindo uma arquitetura MVC (Model-View-Controller) básica. O sistema inclui gerenciamento de usuários (Alunos e Professores), controle de presença, autenticação e um fluxo completo de recuperação de senha com envio de e-mail.

✨ Funcionalidades Principais

    Autenticação Segura: Login de usuários com senhas hasheadas (password_hash).

    Controle de Acesso: Rotas públicas e privadas (usuários precisam estar logados para acessar o painel).

    Gerenciamento de Usuários (CRUD):

        Listar Alunos e Professores.

        Editar usuários existentes.

        Excluir usuários (lógica do controller).

    Cadastro de Usuários: Formulário de cadastro dinâmico para Alunos e Professores.

    Recuperação de Senha:

        Fluxo completo de "Esqueci minha senha".

        Validação de e-mail via AJAX (sem recarregar a página).

        Geração de token seguro de 6 dígitos com tempo de expiração.

        Envio do token por e-mail usando PHPMailer e SMTP.

        Formulário para redefinição da senha.

    Controle de Presença:

        Listagem de alunos por disciplina/curso.

        Cálculo de faltas e limite.

        Registro de presença/falta (individual e em lote).

    Segurança:

        Proteção contra Session Fixation (session_regenerate_id).

        Uso de htmlspecialchars para prevenir XSS.

        Uso de Prepared Statements (PDO) para prevenir SQL Injection.

        Credenciais de banco e e-mail armazenadas fora do código (arquivo .env).

🛠️ Tecnologias e Bibliotecas

    Backend: PHP 8+

    Banco de Dados: MySQL (com PDO)

    Frontend: HTML5, CSS3, Bootstrap 5, JavaScript (com fetch para AJAX)

    Dependências (via Composer):

        vlucas/phpdotenv: Para carregar variáveis de ambiente (senhas, chaves de API).

        phpmailer/phpmailer: Para envio de e-mails transacionais (recuperação de senha).

🚀 Instalação e Configuração

Siga estes passos para configurar o ambiente de desenvolvimento localmente.

1. Pré-requisitos

    Um ambiente de desenvolvimento PHP (como Laragon, XAMPP ou WAMP).

    Composer (Gerenciador de dependências do PHP).

    Um cliente de banco de dados (como HeidiSQL, DBeaver ou o terminal mysql).

2. Baixar e Instalar

    Clone este repositório (ou baixe os arquivos) para sua pasta de projetos (ex: C:\laragon\www\sistemaunipe).

    Abra um terminal na pasta raiz do projeto.

    Instale as dependências do PHP (PHPMailer e DotEnv):
    Bash

    composer install

3. Configurar o Banco de Dados

    Abra seu cliente de banco de dados e crie uma nova database chamada unipe_db.
    SQL

    CREATE DATABASE unipe_db;

    Importe a estrutura do banco. O arquivo SQL está em: C:\laragon\www\sistemaunipe\Config\Database\unipe_db.sql

4. Configurar Variáveis de Ambiente

    Na pasta raiz, crie uma cópia do arquivo .env.example e renomeie-a para .env.

    Abra o arquivo .env e preencha as variáveis com suas credenciais:
    Ini, TOML

    # URL do seu projeto (para o Laragon)
    app.baseURL="http://sistemaunipe.test"

    # Credenciais do Banco de Dados
    DB_HOST=127.0.0.1
    DB_NAME=unipe_db
    DB_USER=root
    DB_PASS=sua_senha_do_mysql

    # Credenciais do SMTP (para envio de e-mail)
    # Use uma "Senha de Aplicativo" gerada pelo Gmail
    SENDER_EMAIL_USER="seu-email@gmail.com"
    SENDER_EMAIL_PASS="sua-senha-de-aplicativo"

5. Configurar o Host Virtual (Laragon)

    Certifique-se de que o Laragon esteja apontando para a URL definida em app.baseURL.

    O Laragon geralmente faz isso automaticamente com base no nome da pasta. Se sua pasta se chama sistemaunipe, a URL http://sistemaunipe.test deve funcionar.

📁 Estrutura do Projeto (Simplificada)

<img width="590" height="433" alt="image" src="https://github.com/user-attachments/assets/c5c19ed2-acc5-46ae-bf55-5ea97b434c84" />
