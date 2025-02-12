let clickCounter = 0;

const imgPreview = document.getElementById('imgPreview');
const imageInput = document.getElementById('imageInput');
const uploadButton = document.getElementById('uploadButton');
const editarBtn = document.getElementById('editarBtn');

document.addEventListener('DOMContentLoaded', () => {
    const imgPreview = document.getElementById('imgPreview');
    const imageInput = document.getElementById('imageInput');
    const uploadButton = document.getElementById('uploadButton');

    // Ensure these elements exist
    if (imgPreview && imageInput && uploadButton) {
        uploadButton.addEventListener('click', () => {
            console.log('Upload button clicked');
            imageInput.click();
        });

        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            console.log('File selected:', file);
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('File loaded');
                    imgPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        console.error('One or more elements not found');
    }
});

function editar() {
    clickCounter++;

    if (clickCounter === 1) {
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach((input) => {
            input.disabled = false;
        });
        document.getElementById('tombo').disabled = true;

        uploadButton.style.display = 'block';
        editarBtn.innerHTML = 'Salvar <img src="./src/img/icons/save-2.png" alt="Salvar" class="btn-icon">';
    }
    else if (clickCounter === 2) {
        editarBtn.setAttribute('type', 'submit');
        document.querySelector('form').submit();
    }
}