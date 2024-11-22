// /*
    // *   @author Camila Inocencio
    // *   @version 1.0    
    // *   @file livros.js
    // *   @description Javascript da tela livros.php.
    // *   Gerenciar a interação com a interface de edição de dados, permitindo visualização e alteração de informações com recursos de pré-visualização de imagem e controle de visibilidade de botões de ação (editar, salvar, cancelar, excluir).
// */

const imgPreview = document.getElementById('imgPreview');
const imageInput = document.getElementById('imageInput');
const uploadButton = document.getElementById('uploadButton');

uploadButton.addEventListener('click', () => {
    imageInput.click();
});

imageInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imgPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

function editar() {
    document.getElementById('cancelarBtn').style.display = 'inline-block';
    document.getElementById('salvarBtn').style.display = 'inline-block';
    document.getElementById('editarBtn').style.display = 'none';
    document.getElementById('excluirBtn').style.display = 'none';
    document.getElementById('uploadButton').style.display = 'inline-block';

    const fields = document.querySelectorAll('input, select, textarea');
    fields.forEach(field => {
        if (field.id !== 'tombo') {
            field.removeAttribute('disabled');
        }
    });
}

function cancelarEdit() {
    document.getElementById('cancelarBtn').style.display = 'none';
    document.getElementById('salvarBtn').style.display = 'none';
    document.getElementById('editarBtn').style.display = 'inline-block';
    document.getElementById('excluirBtn').style.display = 'inline-block';
    document.getElementById('uploadButton').style.display = 'none';

    const fields = document.querySelectorAll('input, select, textarea');
    fields.forEach(field => {
        if (field.id !== 'tombo') {
            field.setAttribute('disabled', 'true');
        }
    });
}