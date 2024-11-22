<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login_a']) || $_SESSION['login_a'] !== true) {
    echo "<script>
        alert('Você precisa estar logado para acessar esta página.');
        window.location.href = '../login/login_pai.html';
    </script>";
    exit();
}
?>

<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="../src/css/index.css">
    <title>Dracotheca</title>
    <link rel="icon" href="./src/img/logo.png" type="image/png">


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname.split("/").pop();
            const sideItems = document.querySelectorAll('#side_itens .side-item');

            sideItems.forEach(item => item.classList.remove('selected'));

            sideItems.forEach(item => {
                const itemPath = item.querySelector('a').getAttribute('href').split("/").pop();
                if (itemPath === currentPath) {
                    item.classList.add('selected');
                }
            });
        });
    </script>
</head>

<body onload="cores()">
    <nav id="sidebar">
        <div id="sidebar_content">
            <div id="user">
                <p id="sidebar_infos">
                    <span class="sidebar-title">
                        Dracotheca
                    </span>
                </p>
                <img src="../src/img/tema/xavier-avatar.png" id="user_avatar" alt="avatar">
            </div>

            <ul id="side_itens">
                <li class="side-item-title">
                    <h5>Descobrir</h5>
                </li>
                <li class="side-item selected">
                    <a href="index.php">
                        <img src="./src/img/icons/home.png" alt="home">
                        Home
                    </a>
                </li>
                <li class="side-item">
                    <a href="./populares.php">
                        <img src="./src/img/icons/trend-up.png" alt="popular">
                        Populares
                    </a>
                </li>
                <li class="side-item">
                    <a href="./recomendados.php">
                        <img src="./src/img/icons/star.png" alt="recomendado">
                        Recomendados
                    </a>
                </li>
                <li class="side-item">
                    <a href="./calendario.php">
                        <img src="./src/img/icons/calendar.png" alt="calendario">
                        Calendário
                    </a>
                </li>
                <li class="side-item">
                    <a href="./notificacoes.php">
                        <img src="./src/img/icons/notification.png" alt="notificacao">
                        Notificações
                    </a>
                </li>

                <li class="side-item-title segundo">
                    <h5>Library</h5>
                </li>
                <li class="side-item">
                    <a href="./contaAluno.php">
                        <img src="./src/img/icons/user-square.png" alt="conta">
                        Acessar conta
                    </a>
                </li>
                <li class="side-item">
                    <a href="./carteirinha.php">
                        <img src="./src/img/icons/personalcard.png" alt="carteirinha">
                        Minha carteirinha
                    </a>
                </li>
                <li class="side-item">
                    <a href="estante.php">
                        <img src="./src/img/icons/heart.png" alt="estante">
                        Minha estante
                    </a>
                </li>
                <li class="side-item">
                    <a href="./historicoLivros.php">
                        <img src="./src/img/icons/book-sidebar.png" alt="historico">
                        Histórico de livros
                    </a>
                </li>
                <li class="side-item">
                    <a href="./configuracao.php">
                        <img src="./src/img/icons/setting-2.png" alt="config">
                        Configurações
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>

<script>
    function getCookie(name) {
        const cookieArr = document.cookie.split(';');
        for (let cookie of cookieArr) {
            const [key, value] = cookie.trim().split('=');
            if (key === name) return decodeURIComponent(value);
        }
        return null;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const profileImage = getCookie('profile_image');
        if (profileImage) {
            const avatarElement = document.getElementById('user_avatar');
            if (avatarElement) {
                avatarElement.src = profileImage;
            } else {
                console.error("Elemento 'user_avatar' não encontrado.");
            }
        }
    });

    function cores() {
    const selectedTheme = getCookie('theme_image') || '';
    const sideItem = document.querySelector('.side-item.selected');
    const filters = document.querySelectorAll('.filter-options label');
    const nome = document.querySelector('.name');
    const openBtn = document.querySelector('#open_btn');
    const seeMoreLinks = document.querySelectorAll('.see-more');
    const detailsHeader = document.querySelector('.details h2');
    const info = document.querySelector('.info-aluno');
    const renovarButtons = document.querySelectorAll('.renew-button');
    const tema = document.querySelectorAll('.temas');
    const foto = document.querySelectorAll('.fotos');
    const btnfoto = document.querySelectorAll('.btn-editar');
    const dados = document.querySelector('.dados');
    const color = document.querySelector('.color');
    const colorp = document.querySelector('.color-pri');
    const day = document.querySelector('.selected-day');
    const renovar = document.querySelector('.renovar');
    const activeButton = document.querySelector('.container button.active');
    const btnModal = document.querySelector('.btn-modal');
    const spanModal = document.querySelector('.text-end');
    const iconDanger = document.querySelectorAll('.status-prazo');
    const bookNot = document.querySelectorAll('.status-disp');
    const infoCircle = document.querySelectorAll('.status-exp');

    if (selectedTheme === './src/img/tema/bg-tema_miku.png') {
        if (sideItem) sideItem.style.backgroundColor = '#9bbe5f9c';
        filters.forEach(filter => filter.style.backgroundColor = '#99AA7B');
        if (nome) nome.style.color = '#88A27C';
        if (openBtn) openBtn.style.backgroundColor = '#88A27C';
        seeMoreLinks.forEach(see => see.style.color = '#88A27C');
        if (detailsHeader) detailsHeader.style.backgroundColor = '#809b508d';
        if (info) info.style.backgroundColor = '#C4D3A9';
        tema.forEach(t => t.style.backgroundColor = '#E2EAD3');
        btnfoto.forEach(bf => bf.style.backgroundColor = '#E2EAD3');
        foto.forEach(f => f.style.backgroundColor = '#E2EAD3');
        if (dados) dados.style.backgroundColor = '#E4EDD3';
        if (color) color.style.backgroundColor = '#91AA67';
        if (colorp) colorp.style.backgroundColor = '#91AA67';
        if (day) day.style.backgroundColor = '#91AA67';
        if (btnModal) btnModal.style.backgroundColor = '#7C8849';
        if (spanModal) spanModal.style.color = '#7C8849';
        if (renovar) renovar.style.backgroundColor = '#7C8849';
        renovar.onmouseover = () => renovar.style.backgroundColor = '#6e7840';
        renovar.onmouseout = () => renovar.style.backgroundColor = '#7C8849';
        iconDanger.forEach(icon => icon.src = './src/img/icons/danger-verde.png');
        bookNot.forEach(book => book.src = './src/img/icons/book-verde.png');
        infoCircle.forEach(info => info.src = './src/img/icons/info-circle-verde.png');
    } else {
        if (sideItem) sideItem.style.backgroundColor = '#C3ACD0';
        filters.forEach(filter => filter.style.backgroundColor = '#b5a1c2');
        if (nome) nome.style.color = '#000';
        if (info) info.style.backgroundColor = '#C3ACD0';
        tema.forEach(t => t.style.backgroundColor = '#ede6f1');
        btnfoto.forEach(bf => bf.style.backgroundColor = '#ede6f1');
        foto.forEach(f => f.style.backgroundColor = '#ede6f1');
    }
}

document.addEventListener('DOMContentLoaded', cores);
</script>