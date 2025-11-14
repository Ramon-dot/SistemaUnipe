<div class="content-area">
    <div class="presence-card">
        <div class="presence-header d-flex justify-content-between align-items-center">
            <h2>Formulário de Cadastro</h2>
        </div>
        
        <div class="p-3">

            <?php
            // Exibir mensagens flash (Sucesso ou Erro)
            if (isset($_SESSION['flash_success'])) {
                echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_SESSION['flash_success']) . '</div>';
                unset($_SESSION['flash_success']);
            }
            if (isset($_SESSION['flash_error'])) {
                echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_SESSION['flash_error']) . '</div>';
                unset($_SESSION['flash_error']);
            }
            ?>

            <form action="<?php echo BASE_URL; ?>/index.php?rota=cadastro_process" method="POST">
    
                <h5 class="mt-2">Dados de Acesso</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_usuario" class="form-label">Tipo de Usuário</label>
                        <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
                            <option value="Selecione">Selecione</option>
                            <option value="Aluno">Aluno</option>
                            <option value="Professor">Professor</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="curso-field" style="display: none;">
                        <label for="curso_id" class="form-label">Curso*</label>
                        <select id="curso_id" name="curso_id" class="form-select">
                            <option value="Selecione um curso">Selecione um curso</option>
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?php echo $curso['id']; ?>">
                                    <?php echo htmlspecialchars($curso['nome_curso']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="col-md-6">
                        <label for="confirmarSenha" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" required>
                    </div>
                </div>

                <hr>

                <h5>Dados Pessoais</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sobrenome" class="form-label">Sobrenome</label>
                        <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                    </div>
                    <div class="col-md-4">
                        <label for="rg" class="form-label">RG</label>
                        <input type="text" class="form-control" id="rg" name="rg">
                    </div>
                    <div class="col-md-4">
                        <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="dataNascimento" name="data_nascimento" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="genero" class="form-label">Gênero</label>
                        <select class="form-select" id="genero" name="genero">
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone">
                    </div>
                </div>

                <hr>

                <h5>Endereço</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep">
                    </div>
                    <div class="col-md-7">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco">
                    </div>
                    <div class="col-md-2">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="complemento" class="form-label">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento">
                    </div>
                    <div class="col-md-4">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro">
                    </div>
                    <div class="col-md-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade">
                    </div>
                    <div class="col-md-1">
                        <label for="estado" class="form-label">UF</label>
                        <input type="text" class="form-control" id="estado" name="estado">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>