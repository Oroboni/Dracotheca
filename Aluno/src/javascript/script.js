// transição da barra de pesquisa e filtro (box-search)
document.getElementById('open_btn').addEventListener('click', function() {
    const search = document.querySelector('.search');
    search.classList.toggle('active');
});

// alterar entre os ícones da sidebar de pesquisa
document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('open_btn');
    const boxSearch = document.querySelector('.box-search');
    const buttonIcon = document.getElementById('open_btn_icon');

    openBtn.addEventListener('click', function() {
        const isHidden = boxSearch.classList.toggle('hidden');

        if (isHidden) {
            buttonIcon.classList.remove('fa-magnifying-glass');
            buttonIcon.classList.add('fa-angle-right');
        } else {
            buttonIcon.classList.remove('fa-angle-right');
            buttonIcon.classList.add('fa-magnifying-glass');
        }
    });
});

// filtros - alternar visibilidade das opções
function toggleFilter(event) {
    const filter = event.currentTarget.parentElement;
    const icon = filter.querySelector('.filter-header i');
    const options = filter.querySelector('.filter-options');
    
    const isOpen = options.style.display === 'block';
    
    document.querySelectorAll('.filter-options').forEach(option => {
        option.style.display = 'none';
    });
    document.querySelectorAll('.filter-header i').forEach(ic => {
        ic.style.transform = 'rotate(0deg)';
    });
    
    if (!isOpen) {
        options.style.display = 'block';
        icon.style.transform = 'rotate(90deg)';
    }
}

// ativar/desativar o botão de aplicar filtro
document.addEventListener('DOMContentLoaded', function () {
    const filters = document.querySelectorAll('.filter-options input[type="radio"]');
    const applyButton = document.getElementById('apply-filters-button');

    function activateApplyButton() {
        applyButton.disabled = false;
        applyButton.classList.add('active');
    }

    filters.forEach(filter => {
        filter.addEventListener('change', function () {
            activateApplyButton();
        });
    });

    applyButton.addEventListener('click', function (event) {
        event.preventDefault();
        const form = document.getElementById('search-form');
        form.submit();
    });
});