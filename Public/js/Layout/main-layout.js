document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const menuToggle = document.getElementById('menu-toggle');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            // Alterna a classe 'collapsed' na sidebar e no conteúdo principal
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');

            // Salva o estado da sidebar no localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });
    }

    // Verifica o estado da sidebar no localStorage ao carregar a página
    // Isso mantém a sidebar aberta ou fechada entre as páginas
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('collapsed');
    }
});