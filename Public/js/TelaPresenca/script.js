document.addEventListener("DOMContentLoaded", function() {
    
    const tabelaPresenca = document.getElementById('lista-presenca'); // Use o ID que você deu à sua tabela no Presenca.php
    const inputBusca = document.getElementById('busca-aluno'); // ID do campo de busca
    const formBusca = document.getElementById('form-busca-aluno'); // ID do formulário de busca
    const btnSalvar = document.getElementById('btn-salvar-presencas'); // ID do botão salvar

    // 1. Lógica para trocar presença e falta (APENAS VISUAL)
    if (tabelaPresenca) {
        tabelaPresenca.addEventListener('click', function(e) {
            // .btn-acao é uma classe que você deve adicionar aos botões de Presente/Falta
            const target = e.target.closest('button.btn-acao'); 
            if (!target) return; // Sai se não clicou em um botão de ação

            const tr = target.closest('tr');
            
            // Se clicou em PRESENTE
            if (target.classList.contains('btn-presente')) {
                target.classList.remove('btn-presente');
                target.classList.add('btn-falta');
                target.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> Falta';
                tr.dataset.status = '0'; // 0 para Falta

            // Se clicou em FALTA
            } else if (target.classList.contains('btn-falta')) {
                target.classList.remove('btn-falta');
                target.classList.add('btn-presente');
                target.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Presente';
                tr.dataset.status = '1'; // 1 para Presente
            }
            
            // Não mexemos na contagem de faltas (ex: 6 / 15).
            // Isso só será atualizado quando a página recarregar.
        });
    }

    // 2. Lógica de busca/filtro (se não quiser usar o GET do PHP)
    // Seu formulário de busca já submete a página via GET, 
    // então a lógica de filtro JS abaixo não é estritamente necessária,
    // mas se quiser filtrar em tempo real, use-a.
    if (inputBusca) {
        inputBusca.addEventListener('keyup', function() {
            const termoBusca = inputBusca.value.toLowerCase();
            const linhas = tabelaPresenca.querySelectorAll('tbody tr');

            linhas.forEach(linha => {
                const nomeAluno = linha.querySelector('.aluno-nome').textContent.toLowerCase();
                if (nomeAluno.includes(termoBusca)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    }

    // 3. Lógica para Salvar Presenças (FUNCIONAL)
    if (btnSalvar) {
        btnSalvar.addEventListener('click', function() {
            const dadosParaSalvar = [];
            const linhas = tabelaPresenca.querySelectorAll('tbody tr'); 

            linhas.forEach(linha => {
                const matricula_id = linha.dataset.matriculaId; // Pega o ID da matrícula do HTML
                let status = linha.dataset.status; // Pega o status (0 ou 1)
                
                // Se o status não foi alterado (o usuário não clicou), 
                // pega o status original do botão
                if (status === undefined) {
                    status = linha.querySelector('.btn-presente') ? '1' : '0';
                }
                
                dadosParaSalvar.push({ 
                    matricula_id: matricula_id, 
                    status: status 
                });
            });

            console.log('Enviando dados:', dadosParaSalvar);

            // Envia os dados para o novo método do controller
            // Certifique-se que sua rota 'presenca_salvar' aponte para PresencaController::salvarTodasPresencas
            fetch('index.php?rota=presenca_salvar', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ alunos: dadosParaSalvar })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Recarrega a página para ver os totais de faltas atualizados
                    window.location.reload(); 
                } else {
                    alert('Erro: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro no fetch:', error);
                alert('Ocorreu um erro de conexão.');
            });
        });
    }
});