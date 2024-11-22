// Função para selecionar a imagem das fotos
function selectImage(selectedImg) {
    const images = document.querySelectorAll(".fotos img");
    images.forEach((img) => {
        img.classList.remove("select");
    });
    selectedImg.classList.add("select");

    enableSaveButton();
}

// Função para selecionar a imagem de tema
function selectThemeImage(selectedThemeImg) {
    const themeImages = document.querySelectorAll(".fotos.temas img");
    themeImages.forEach((img) => {
        img.classList.remove("selected-theme");
    });
    selectedThemeImg.classList.add("selected-theme");

    enableSaveButton();
}

// Função para habilitar o btn-salvar
function enableSaveButton() {
    const saveButton = document.querySelector(".btn-salvar");
    saveButton.disabled = false;
    saveButton.classList.remove("desabled");
}

document.addEventListener("DOMContentLoaded", function() {
    const btnFotos = document.getElementById("btn-fotos");
    const btnSalvar = document.querySelector(".btn-salvar");
    const form = document.querySelector("form");

    // Função para selecionar a imagem das fotos
    function selectImage(selectedImg) {
        const images = document.querySelectorAll(".fotos img");
        images.forEach((img) => {
            img.classList.remove("select");
        });
        selectedImg.classList.add("select");
        enableSaveButton();
    }

    // Função para selecionar a imagem de tema
    function selectThemeImage(selectedThemeImg) {
        const themeImages = document.querySelectorAll(".fotos.temas img");
        themeImages.forEach((img) => {
            img.classList.remove("selected-theme");
        });
        selectedThemeImg.classList.add("selected-theme");
        enableSaveButton();
    }

    // Função para habilitar o btn-salvar
    function enableSaveButton() {
        const selectedImage = document.querySelector(".fotos img.select");
        const selectedThemeImage = document.querySelector(".fotos.temas img.selected-theme");

        if (selectedImage || selectedThemeImage) {
            btnSalvar.classList.remove("desabled");
            btnSalvar.removeAttribute("disabled");
        }
    }

    // Resetar as seleções e desabilitar o botão ao enviar o formulário
    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const selectedImages = document.querySelectorAll(".fotos img.select, .fotos.temas img.selected-theme");
        selectedImages.forEach(img => {
            img.classList.remove("select", "selected-theme");
        });

        btnSalvar.classList.add("desabled");
        btnSalvar.setAttribute("disabled", true);

        form.submit();
    });
});