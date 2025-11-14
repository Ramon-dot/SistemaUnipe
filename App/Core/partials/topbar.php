<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <button class="btn btn-light" id="menu-toggle"><i class="bi bi-list"></i></button>

        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-question-circle-fill me-1"></i> Ajuda</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-gear-fill me-1"></i> Configurações</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://i.pravatar.cc/40?u=carlos" class="rounded-circle me-2" alt="Foto Carlos" width="30" height="30">
                    <?php echo htmlspecialchars($_SESSION['user_nome'] ?? 'Visitante'); ?>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Meu Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>/index.php?rota=logout">Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>