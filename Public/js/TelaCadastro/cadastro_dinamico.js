document.addEventListener('DOMContentLoaded', function() {
    
    const tipoUsuarioSelect = document.getElementById('tipo_usuario');
    const cursoField = document.getElementById('curso-field');
    const cursoSelect = document.getElementById('curso_id');

    if (!tipoUsuarioSelect || !cursoField || !cursoSelect) {
        // Se os elementos não existirem, não faz nada
        return;
    }

    tipoUsuarioSelect.addEventListener('change', function() {
        if (this.value === 'Aluno') {
            // Se for Aluno, mostra o campo de curso e o torna obrigatório
            cursoField.style.display = 'block';
            cursoSelect.required = true;
        } else {
            // Se for Professor (ou vazio), esconde o campo e remove o 'required'
            cursoField.style.display = 'none';
            cursoSelect.required = false;
        }
    });

});