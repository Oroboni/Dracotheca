<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file sidebar.php
    *   @description Barra lateral que fica em todas as telas (sidebar)
    *   Com ela, é possível navegar pelas telas do sistema.
    */
-->

<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login_b']) || $_SESSION['login_b'] !== true) {
    echo "<script>
        alert('Você precisa estar logado para acessar esta página.');
        window.location.href = '../login/login_pai.html';
    </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="../src/css/index.css">
    <title>Dracotheca</title>
    <?php session_start(); ?>
    <script>
        // /*
        // *   Aplica a classe selected ao item da barra lateral correspondente à página atual, assim é possível destacar visualmente o item ativo.
        // */
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname.split("/").pop();
            const sideItems = document.querySelectorAll('#side_itens .side-item a');

            sideItems.forEach(item => {
                const itemPath = item.getAttribute('href').split("/").pop();
                if (itemPath === currentPath) {
                    item.parentElement.classList.add('selected');
                }
            });
        });
    </script>
</head>

<body>
    <nav id="sidebar">
        <div id="sidebar_content">
            <div id="user">
                <p id="sidebar_infos">
                    <span class="sidebar-title">
                        Dracotheca
                    </span>
                </p>
                <img src="../src/img/avatar_teste.jpg" id="user_avatar" alt="avatar">
            </div>

            <ul id="side_itens">
                <li class="side-item-title">
                    <h5>Descobrir</h5>
                </li>
                <li class="side-item">
                    <a href="index.php">
                        <img src="./src/img/icons/home.png" alt="home">
                        Home
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
                        <img src="./src/img/icons/notification.png" alt="notificacoes">
                        Notificações
                    </a>
                </li>

                <li class="side-item-title segundo">
                    <h5>Gerenciar</h5>
                </li>
                <li class="side-item">
                    <a href="./livros.php">
                        <img src="./src/img/icons/bookmark.png" alt="ger-livro">
                        Gerenciar livro
                    </a>
                </li>
                <li class="side-item">
                    <a href="./alunos.php">
                        <img src="./src/img/icons/teacher.png" alt="ger-aluno">
                        Gerenciar aluno
                    </a>
                </li>
                <li class="side-item">
                    <a href="./vincular.php">
                        <img src="./src/img/icons/paperclip-2.png" alt="vincular">
                        Vincular
                    </a>
                </li>
                <li class="side-item">
                    <a href="./devolucao.php">
                        <img src="./src/img/icons/devolucao.png" alt="devolucao">
                        Devolução do livro
                    </a>
                </li>

                <li class="side-item-title segundo">
                    <h5>Library</h5>
                </li>
                <li class="side-item">
                    <a href="./contaBibliotecaria.php">
                        <img src="./src/img/icons/user-square.png" alt="conta">
                        Acessar conta
                    </a>
                </li>
                <li class="side-item">
                    <a href="./configuracaoBibliotecario.php">
                        <img src="./src/img/icons/setting-2.png" alt="config">
                        Configurações
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>

<!-- // /*
        // *   Personalização da conta baseada em cookies.
    // */ 
-->
<script>
    // /*
    //     *  Função que recupera o valor de um cookie específico. Ela separa os cookies em um array, divide cada item em nome e valor, compara o nome com o desejado e retorna o valor decodificado ou 'null' se não encontrar.
    // */ 
    function getCookie(name) {
        const cookieArr = document.cookie.split(';');
        for (let cookie of cookieArr) {
            const [key, value] = cookie.trim().split('=');
            if (key === name) return decodeURIComponent(value);
        }
        return null;
    }

    // /*
    // *   Verifica se o cookie profile_image existe, e, se existir, altera o src do elemento com ID user_avatar.
    // */ 
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

    // /*
    // *   Altera as cores e outros estilos de vários elementos da página com base no tema armazenado no cookie theme_image.
    // */ 
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
        const color = document.querySelectorAll('.color');
        const colorp = document.querySelector('.color-pri');
        const day = document.querySelector('.selected-day');
        const renovar = document.querySelector('.renovar');
        const activeButton = document.querySelector('.container button.active');
        const btnModal = document.querySelector('.btn-modal');
        const spanModal = document.querySelector('.text-end');
        const iconDanger = document.querySelectorAll('.status-prazo');
        const bookNot = document.querySelectorAll('.status-disp');
        const infoCircle = document.querySelectorAll('.status-exp');
        const btnCad = document.querySelector('.cadastrar');
        const btnVis = document.querySelectorAll('.visualizar');
        const btnEdit = document.querySelectorAll('.editar');
        const forms = document.querySelector('.form');
        const fundo = document.querySelectorAll('.fundo');
        const btnConf = document.querySelector('.confirmar');
        const btnVin = document.querySelector('.vincular');
        const btnSalvar = document.querySelector('.salvar');
        const bg = document.querySelectorAll('.background');
        const bg1 = document.querySelectorAll('.background1');
        const bg2 = document.querySelectorAll('.background2');

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
            color.forEach(c => c.style.backgroundColor = '#91AA67');
            if (colorp) colorp.style.backgroundColor = '#91AA67';
            if (day) day.style.backgroundColor = '#91AA67';
            if (btnModal) btnModal.style.backgroundColor = '#7C8849';
            if (spanModal) spanModal.style.color = '#7C8849';
            if (renovar) renovar.style.backgroundColor = '#7C8849';
            if (btnCad) btnCad.style.backgroundColor = '#E5E8DB';
            btnVis.forEach(v => v.style.backgroundColor = '#B7BDAD');
            btnEdit.forEach(e => e.style.backgroundColor = '#ACC87C');
            bg.forEach(b => b.style.backgroundColor = '#C9DBBF');
            bg1.forEach(a => a.style.backgroundColor = '#DBE1D6');
            bg2.forEach(k => k.style.backgroundColor = '#fcfbf7f8');
            if (forms) forms.style.backgroundColor = '#DBE1D6';
            fundo.forEach(u => u.style.backgroundColor = '#BCCCB2');
            if (btnConf) btnConf.style.backgroundColor = '#91AA67';
            if (btnVin) btnVin.style.backgroundColor = '#91AA67';
            if (btnSalvar) btnSalvar.style.backgroundColor = '#ACC87D';
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