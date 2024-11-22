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
    <link rel="stylesheet" href="../src/css/contaAluno.css">

    <title>Dracotheca</title>
    <link rel="icon" href="./src/img/logo.png" type="image/png">

    <?php
    include 'conecta_DB.php';

    session_start();

    $id = $_SESSION['id'];

    $query = "SELECT * FROM aluno WHERE ID_ALUNO = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $aluno = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $sql = "SELECT e.ID_EMPREST, l.TOMBO_LIV, l.TITULO_LIV, l.FOTO_LIV, e.DT_EMPREST, e.DT_DEVOLUCAO
        FROM emprestimos e
        JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
        WHERE e.FK_ID_ALUNO = ? ORDER BY e.DT_EMPREST DESC LIMIT 5";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $emprestimos = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $emprestimos[] = $row;
        }
    } ?>
</head>

<body onload="cores()">
    <nav id="sidebar">
        <?php
        include "./sidebar.php";
        ?>
    </nav>

    <div class="container-conta">
        <div class="titulo">
            <h1>Minha conta</h1>
        </div>
        <div class="banner">
            <img src="./src/img/tema/bg-tema_xavier.png" alt="Banner Xavier" class="banner-tema">
        </div>
    </div>

    <div class="container-info">
        <div class="info-aluno">
            <div class="aluno">
                <div class="fundo">
                    <img src="./src/img/aluno.png" alt="Fundo Aluno" class="fundo-img">
                </div>
                <div class="foto-aluno">
                    <img src="./src/img/tema/xavier-avatar.png" alt="Foto do Aluno" class="foto-aluno-perfil">
                </div>
                <div class="quem">
                    <h1><?php echo $_SESSION["user_name"] ?></h1>
                    <h2><?php echo $aluno['CURSO_ALUNO'] ?></h2>
                </div>
            </div>

            <div class="info">
                <div class="container cont-info">
                    <div class="row">
                        <div class="col-4">
                            <h4>RA</h4>
                        </div>
                        <div class="col-6">
                            <p id="s"><?php echo $aluno['RA_ALUNO'] ?>-SP</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <img src="./src/img/icons/email.png" alt="E-mail" class="info-icon">
                        </div>
                        <div class="col-6 spa">
                            <p><?php echo $aluno['EMAIL_ALUNO'] ?></p>
                        </div>
                    </div>
                    <div class="row d">
                        <div class="col-4">
                            <img src="./src/img/icons/dt-entrada.png" alt="Dt. de Entrada" class="info-icon">
                        </div>
                        <div class="col-6">
                            <p><?php $data = DateTime::createFromFormat('Y-m-d', $_SESSION['data']);
                                echo $data->format('d/m/Y'); ?></p>
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
                    <br>
                    <br>
                </form>
                <hr>
                <div class="row">
                    <div class="col-10">
                        <div class="tit">
                            <h4>Empréstimos Recentes</h4>
                        </div>
                        <div class="livros">
                            <?php if (count($emprestimos) > 0): ?>
                                <?php foreach ($emprestimos as $emprestimo): ?>
                                    <a href="./detalhesLivro.php?id=<?php echo $emprestimo['TOMBO_LIV']; ?>">
                                        <img id="imgPreview" src="<?php echo !empty($emprestimo['FOTO_LIV']) && $emprestimo['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $emprestimo['FOTO_LIV']) ? '../src/img/books/' . $emprestimo['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Você ainda não realizou empréstimos.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../src/javascript/contaAluno.js"></script>
</body>

</html>

<script>
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

    function changeProfileImage(imgElement) {
        const profileImage = document.querySelector('.foto-aluno-perfil');
        if (profileImage && imgElement) {
            profileImage.src = imgElement.src;
            setCookie('profile_image', imgElement.src, 3000);
        }
    }

    function selectThemeImage(imgElement) {
        const bannerImage = document.querySelector('.banner-tema');
        const sideItem = document.querySelector('.side-item.selected');
        const filter = document.querySelector('.filter-options label');
        if (bannerImage && imgElement && sideItem) {
            const themeName = imgElement.alt.split(' ')[1].toLowerCase();
            const themePath = `./src/img/tema/bg-tema_${themeName}.png`;
            bannerImage.src = themePath;

            setCookie('theme_image', themePath, 3000);
            cores();
        } else {
            console.error('Elemento necessário não encontrado.');
        }
    }

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