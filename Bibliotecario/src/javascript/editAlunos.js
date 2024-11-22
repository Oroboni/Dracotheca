// /*
// *   @author Camila Inocencio
// *   @version 1.0    
// *   @file editAlunos.js
// *   @description Javascript da tela editAluno.php.
// *   Permitir a edição de um formulário, mostrando ou ocultando os botões e habilitando ou desabilitando os campos de input.
// */

function editar() {
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => input.disabled = false);

    document.querySelector('.editar').classList.add('escondido');
    document.querySelector('.excluir').classList.add('escondido');

    document.querySelector('.cancelar').classList.remove('escondido');
    document.querySelector('.salvar').classList.remove('escondido');
}

function cancelarEdit() {
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => input.disabled = true);

    document.querySelector('.cancelar').classList.add('escondido');
    document.querySelector('.salvar').classList.add('escondido');

    document.querySelector('.editar').classList.remove('escondido');
    document.querySelector('.excluir').classList.remove('escondido');
}