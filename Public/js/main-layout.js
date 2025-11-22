document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const wrapper = document.querySelector('.wrapper');

    if (sidebar && sidebarToggle && wrapper) {
        sidebarToggle.addEventListener('click', function() {
            // Adiciona ou remove a classe 'collapsed' do elemento pai 'wrapper'
            // O CSS em 'TelaPresenca/style.css' já tem as regras para esta classe.
            wrapper.classList.toggle('collapsed');
        });
    }
});