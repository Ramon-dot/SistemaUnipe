const mainContent = document.getElementById('main-content');
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const menuButtons = document.querySelectorAll('.menu-btn');

// Função para trocar conteúdo com animação
function trocarConteudo(pagina) {
  const template = document.getElementById(`template-${pagina}`);
  if (!template) return;

  // Animação fade-out
  mainContent.style.opacity = 0;
  setTimeout(() => {
    mainContent.innerHTML = template.innerHTML;

    // Ativa botão correto
    menuButtons.forEach(btn => btn.classList.remove('active'));
    const ativo = document.querySelector(`.menu-btn[data-page="${pagina}"]`);
    if (ativo) ativo.classList.add('active');

    // Breadcrumbs com clique
    const links = mainContent.querySelectorAll('.breadcrumb-link');
    links.forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        trocarConteudo(link.dataset.page);
      });
    });

    // Fade-in
    mainContent.style.opacity = 1;
  }, 200);
}

// Botões da sidebar
menuButtons.forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    trocarConteudo(btn.dataset.page);
  });
});

// Toggle da sidebar
sidebarToggle.addEventListener('click', () => {
  sidebar.classList.toggle('closed');
  mainContent.style.marginLeft = sidebar.classList.contains('closed') ? '0' : '80px';
});

// Inicializa página home
trocarConteudo('home');