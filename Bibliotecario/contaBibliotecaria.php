<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 1.0    
    *   @file contaBibliotecaria.php
    *   @description Tela de perfil da bibliotecária.
    *    Aqui o é permitido a personalização e visualização de informações conta, como mudança de tema, foto de perfil, e últimos cadastros de livros.
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/contaBibliotecaria.css">
    <title>Dracotheca</title>
    <link rel="icon" href="./src/img/logo.png" type="image/png">

    <?php
    // /*
        // *   O código consulta o banco de dados para: Obter os dados da bibliotecária logada, com base no ID armazenado na sessão (`$_SESSION['id`) e buscar os 6 livros mais recentes cadastrados, ordenados pela data de aquisição, retornando seu tombo, título e foto.
    // */
    include "./conecta_DB.php";
    session_start();

    $id = intval($_SESSION['id']);

    $query = "SELECT * FROM bibliotecaria WHERE ID_BIBLIOT = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $bibliotecaria = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $query = "SELECT TOMBO_LIV, TITULO_LIV, FOTO_LIV FROM livro ORDER BY DTAQUISICAO_LIV DESC LIMIT 6";
    $resultCadastros = mysqli_query($conn, $query);
    ?>
</head>

<body>
    <nav id="sidebar">
        <?php
        include "./sidebar.php";
        ?>
    </nav>

    <div class="container-conta">
        <div class="titulo">
            <h1>Minha Conta</h1>
        </div>
        <div class="banner">
            <img src="./src/img/tema/bg-tema_xavier.png" alt="Banner Xavier" class="banner-tema">
        </div>
    </div>

    <div class="container-info">
        <div class="info-aluno">
            <div class="aluno">
                <div>
                    <img src="./src/img/aluno.png" alt="Fundo Aluno" class="fundo-img">
                </div>
                <div class="foto-aluno">
                    <img src="./src/img/tema/xavier-avatar.png" alt="Foto do Aluno" class="foto-aluno-perfil">
                </div>
                <div class="quem">
                    <h1><?php echo $_SESSION["user_name"] ?></h1>
                    <h2>Bibliotecária</h2>
                </div>
            </div>

            <div class="info">
                <div class="container cont-info">
                    <div class="row">
                        <div class="col-4">
                            <img src="./src/img/icons/email.png" alt="E-mail" class="info-icon">
                        </div>
                        <div class="col-4 spa">
                            <p><?php echo " ", htmlspecialchars($bibliotecaria['EMAIL_BIBLIOT']); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <h4>Turno</h4>
                        </div>
                        <div class="col-6">
                            <p><?php echo htmlspecialchars($bibliotecaria['TURNO_BIBLIOT'] === 'M' ? 'Manhã' : ($bibliotecaria['TURNO_BIBLIOT'] === 'T' ? 'Tarde' : 'Noite')); ?></p>
                        </div>
                    </div>
                    <div class="row d">
                        <div class="col-4">
                            <h4>CPF</h4>
                        </div>
                        <div class="col-6">
                            <p><?php echo substr($bibliotecaria['CPF_BIBLIOT'], 0, 3) . ".***.***-" . substr($bibliotecaria['CPF_BIBLIOT'], -2); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nuvem">
                <img src="./src/img/nuvem-perfil.png" class="fundo-img">
            </div>
        </div>

        <div class="persona">
            <div class="container">
                <form action="#">
                    <div class="row">
                        <div class="col-6">
                            <div class="tit">
                                <h3>Editar foto de perfil</h3>
                            </div>
                            <div class="opcoes">
                                <div class="btns">
                                    <button id="btn-fotos" class="btn-editar active" type="button">Fotos</button>
                                </div>
                            </div>
                            <div class="fotos">
                                <img src="./src/img/tema/miku-avatar.png" alt="Miku" onclick="selectImage(this)">
                                <img src="./src/img/tema/xavier-avatar.png" alt="Xavier" onclick="selectImage(this)">
                                <img src="./src/img/tema/sem-imagem.jpg" alt="Sem foto" onclick="selectImage(this)">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="tit">
                                <h3>Editar Tema</h3>
                            </div>
                            <div class="opcoes">
                                <div class="btns">
                                    <button id="btn-fotos" class="btn-editar active" type="button">
                                        Temas
                                    </button>
                                </div>
                            </div>
                            <div class="temas">
                                <img src="./src/img/tema/miku-tema.png" alt="Tema Miku" onclick="selectThemeImage(this)">
                                <img src="./src/img/tema/xavier-tema.png" alt="Tema Xavier" onclick="selectThemeImage(this)">
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row">
                    <div class="col-10">
                        <div class="tit">
                            <h4>cadastro recentes</h4>
                        </div>
                        <div class="livros">
                            <?php 
                                // /*
                                            // *   O código percorre os resultados da consulta de livros recentes e gera um link clicável para cada livro, redirecionando para uma página específica ('gerLivro.php') com o ID do livro na URL. Cada link exibe uma imagem que mostra a foto do livro, se disponível e válida (não é a padrão e o arquivo existe),e, caso contrário, exibe uma imagem padrão (`capa.png`). 
                                // */
                                while ($livro = mysqli_fetch_assoc($resultCadastros)): ?>
                                <a href="./gerLivro.php?id=<?php echo $livro['TOMBO_LIV']; ?>">
                                    <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists($livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
        </div>
    </div>

    <script src="../src/javascript/contaBibliotecaria.js"></script>
</body>

</html>

<script>
    // /*
        // *   setCookie(name, value, days): Cria ou atualiza um cookie com um nome, valor e duração específica.
        // *   getCookie(name): Recupera o valor de um cookie pelo nome.
    // */
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
    }

    function getCookie(name) {
        const cookieArr = document.cookie.split(';');
        for (let cookie of cookieArr) {
            const [key, value] = cookie.trim().split('=');
            if (key === name) return value;
        }
        return null;
    }

    // /*
        // *   Atualiza a imagem de perfil exibida para a imagem clicada e salva a escolha em um cookie.
    // */
    function changeProfileImage(imgElement) {
        const profileImage = document.querySelector('.foto-aluno-perfil');
        if (profileImage && imgElement) {
            profileImage.src = imgElement.src;
            setCookie('profile_image', imgElement.src, 3000);
            cores();
        }
    }

    // /*
        // *   Atualiza o banner com base na imagem selecionada, ajustando o caminho conforme o nome do tema, e armazena em um cookie.
    // */
    function selectThemeImage(imgElement) {
        const bannerImage = document.querySelector('.banner-tema');
        if (bannerImage && imgElement) {
            const themeName = imgElement.alt.split(' ')[1].toLowerCase();
            const themePath = `./src/img/tema/bg-tema_${themeName}.png`;
            bannerImage.src = themePath;
            setCookie('theme_image', themePath, 3000);
            cores();
        }
    }

    // /*
        // *   Verifica se há cookies salvos para a imagem de perfil e o tema e os aplica automaticamente e adiciona eventos de clique a imagens disponíveis para selecionar perfil ou tema, permitindo que o bibliotecário personalize sua interface.
    // */
    document.addEventListener('DOMContentLoaded', () => {
        const profileImage = getCookie('profile_image');
        const themeImage = getCookie('theme_image');

        if (profileImage) {
            document.querySelector('.foto-aluno-perfil').src = profileImage;
        }
        if (themeImage) {
            document.querySelector('.banner-tema').src = themeImage;
            cores();
        }
    });

    document.querySelectorAll('.fotos img').forEach(img => {
        img.addEventListener('click', () => {
            changeProfileImage(img);
        });
    });

    document.querySelectorAll('.temas img').forEach(img => {
        img.addEventListener('click', () => {
            selectThemeImage(img);
            cores();
        });
    });
</script>