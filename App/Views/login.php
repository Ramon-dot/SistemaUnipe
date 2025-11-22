    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12 col-md-6 col-lg-4 d-flex flex-column justify-content-center align-items-center mx-auto">
                <div class="login-card">

                    <h1 class="h3 mb-2 text-center">Bem-vindo de volta</h1>
                    <p class="text-muted text-center mb-4">Entre com suas credenciais para acessar sua conta</p>

                    <?php
                    if (isset($_SESSION['flash_error'])): ?>
                        <div class="alert alert-danger small p-2 text-center">
                            <?php
                            echo htmlspecialchars($_SESSION['flash_error']);
                            unset($_SESSION['flash_error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo BASE_URL; ?>/index.php?rota=login_submit">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label">Senha</label>
                                <a href="<?php echo BASE_URL; ?>/index.php?rota=recuperar_senha" class="form-text text-decoration-none small">Esqueceu a senha?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="sua senha" required>
                                <!--<button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye-slash"></i>
                                </button>-->
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>

                        <div class="d-flex align-items-center my-4">
                            <hr class="flex-grow-1">
                            <span class="px-3 text-muted small">OU CONTINUE COM</span>
                            <hr class="flex-grow-1">
                        </div>

                        <div class="row g-2">
                            <div class="col">
                                <a href="#" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-google me-2"></i> Google
                                </a>
                            </div>
                            <div class="col">
                                <a href="https://github.com/Ramon-dot/sistemaunipe" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-github me-2"></i> GitHub
                                </a>
                            </div>
                        </div>
                    </form>

                    <p class="mt-4 text-center text-muted">
                        Não tem uma conta? <a href="<?php echo BASE_URL; ?>/index.php?rota=cadastro_form" class="text-decoration-none">Cadastre-se</a>
                    </p>
                </div>
            </div>
        </div>
    </div>