<nav id="sidebar">
    <div class="sidebar-top">
        <div class="sidebar-header">
            <div>
                <span class="menu-text">BEM VINDO</span>
                <h5 class="menu-text"><?php echo htmlspecialchars($_SESSION['user_nome'] ?? 'Visitante'); ?></h5>
            </div>
        </div>
    </div>
    <hr>
    <ul class="sidebar-menu">
        <li class="sidebar-title menu-text">MENU INTERATIVO</li>
        <li class="sidebar-item">
            <a href="<?php echo BASE_URL; ?>/index.php?rota=home" class="sidebar-link">
                <i class="bi bi-house"></i>
                <span class="menu-text">Home Page</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo BASE_URL; ?>/index.php?rota=presenca" class="sidebar-link">
                <i class="bi bi-file-earmark-text"></i>
                <span class="menu-text">Presença</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#cadastroSubmenu" data-bs-toggle="collapse" class="sidebar-link dropdown-toggle">
                <i class="bi bi-bar-chart"></i>
                <span class="menu-text">Cadastros</span>
            </a>
            <ul class="collapse list-unstyled submenu" id="cadastroSubmenu">
                <li class="sidebar-item"><a href="<?php echo BASE_URL; ?>/index.php?rota=listar_alunos" class="sidebar-link"><span class="menu-text">Listar Alunos</span></a></li>
                <li class="sidebar-item"><a href="<?php echo BASE_URL; ?>/index.php?rota=listar_professores" class="sidebar-link"><span class="menu-text">Listar Professores</span></a></li>
                <li class="sidebar-item"><a href="<?php echo BASE_URL; ?>/index.php?rota=cadastro_form" class="sidebar-link"><span class="menu-text">Novo Cadastro</span></a></li>
                <li class="sidebar-item"><a href="<?php echo BASE_URL; ?>/index.php?rota=disciplinas" class="sidebar-link"><span class="menu-text">Disciplinas</span></a></li>
            </ul>
        </li>
    </ul>
    <hr>
    <ul class="sidebar-menu" style="flex-grow: 0;">
        <li class="sidebar-title menu-text">CONFIGURAÇÕES</li>
        <li class="sidebar-item">
             <a href="#settingsSubmenu" data-bs-toggle="collapse" class="sidebar-link dropdown-toggle">
                <i class="bi bi-gear"></i>
                <span class="menu-text">Settings</span>
            </a>
            <ul class="collapse list-unstyled submenu" id="settingsSubmenu"></ul>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="<?php echo BASE_URL; ?>/index.php?rota=logout">
            <i class="bi bi-box-arrow-right"></i>
            <span class="menu-text">Logout Account</span>
        </a>
    </div>
</nav>