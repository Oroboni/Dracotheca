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