// Mudança de cor no botão selecionado e alternância do conteúdo da notificação
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.container button');
    const contentExpirandoExpirado = document.querySelector('.content-expirando-expirado');
    const contentDisponibilidade = document.querySelector('.content-disponibilidade');
    const infoExpandImg = document.querySelector('.info-expand img');
    const infoExpandTitle = document.querySelector('.info-expand h4');
    const containerExpand = document.querySelector('.container-expand');
    const noNotificationsMessage = document.querySelector('.sem-notificacoes');

    // Função para alternar conteúdo e imagem
    function toggleContent(button, type) {
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        containerExpand.classList.add('show');
    
        const selectedTheme = getCookie('theme_image') || '';
    
        switch (type) {
            case 'disponivel':
                infoExpandTitle.textContent = 'Livro Disponível';
                infoExpandImg.src = selectedTheme === './src/img/tema/bg-tema_miku.png'
                    ? './src/img/icons/book-verde.png'
                    : './src/img/icons/book-not.png';
                contentExpirandoExpirado.style.display = 'none';
                contentDisponibilidade.style.display = 'flex';
                break;
            case 'expirando':
                infoExpandTitle.textContent = 'Prazo de Entrega Expirando';
                infoExpandImg.src = selectedTheme === './src/img/tema/bg-tema_miku.png'
                    ? './src/img/icons/danger-verde.png'
                    : './src/img/icons/danger.png';
                contentExpirandoExpirado.style.display = 'flex';
                contentDisponibilidade.style.display = 'none';
                break;
            case 'expirado':
                infoExpandTitle.textContent = 'Prazo de Entrega Expirado';
                infoExpandImg.src = selectedTheme === './src/img/tema/bg-tema_miku.png'
                    ? './src/img/icons/info-circle-verde.png'
                    : './src/img/icons/info-circle.png';
                contentExpirandoExpirado.style.display = 'flex';
                contentDisponibilidade.style.display = 'none';
                break;
        }
    }
    

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const parentDiv = button.parentElement;
            let type;

            if (parentDiv.classList.contains('notif-expirando')) {
                type = 'expirando';
            } else if (parentDiv.classList.contains('notif-expirado')) {
                type = 'expirado';
            } else {
                type = 'disponivel';
            }

            toggleContent(button, type);
        });
    });

    if (buttons.length === 0) {
        noNotificationsMessage.style.display = 'block';
        document.querySelector('.container').style.border = '2px solid #ccc';
    } else {
        noNotificationsMessage.style.display = 'none';
    }
});