<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file sidebar.php
    *   @description Barra lateral que fica em todas as telas (sidebar)
    *   Aqui, ela fica disponível de forma podada, sendo apenas possível ver a home(index.php) e a opção de acessar a conta.
    */
-->

<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <link rel="stylesheet" href="./src/css/index.css">
    <title>Dracotheca</title>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                <img src="./src/img/avatar_teste.jpg" id="user_avatar" alt="avatar">
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
            
                <li class="side-item-title segundo">
                    <h5>Library</h5>
                </li>
                <li class="side-item">
                    <a href="./Login/login_pai.html">
                        <img src="./src/img/icons/user-square.png" alt="conta">
                        Acessar conta
                    </a>
                </li>
            </ul>            
        </div>
    </nav>
</body>

</html>