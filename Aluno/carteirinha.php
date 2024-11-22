<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/carteirinha.css">

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
    ?>
</head>

<body>
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container-carteirinha">
        <div class="container-conta">
            <div class="titulo">
                <h1>Minha carteirinha</h1>
            </div>
            <div class="banner">
                <img src="./src/img/tema/bg-tema_xavier.png" alt="Banner Xavier" id="theme_image" class="banner-tema">
            </div>

        </div>

        <div class="container">
            <div class="row dados">
                <div class="col">
                    <div class="carteirinha">
                        <div class="color-pri"></div>
                        <div class="row g-3 d-flex justify-content-between">
                            <div class="col-md-3">
                                <div class="image">
                                    <img src="./src/img/tema/xavier-avatar.png" class="rounded img-fluid" alt="Perfil" id="user-avatar">
                                    <img src="./src/img/selo-dracotheca.png" class="img-fluid" alt="Selo Dracotheca" id="selo">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-4 ">
                                    <div class="col quem">
                                        <h1><?php echo $_SESSION["user_name"] ?></h1>
                                        <h2><?php echo $aluno['CURSO_ALUNO'] ?></h2>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col top">
                                        <h4>RA</h4>
                                        <p><?php echo $aluno["RA_ALUNO"] ?></p>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col top">
                                        <h4>CPF</h4>
                                        <p><?php echo $aluno["CPF_ALUNO"] ?></p>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col top">
                                        <h4>Emissão</h4>
                                        <p>
                                            <?php
                                            if (!empty($aluno["DTCADASTRO_ALUNO"])) {
                                                $data = DateTime::createFromFormat('Y-m-d', $aluno["DTCADASTRO_ALUNO"]);
                                                echo $data->format('d/m/Y');
                                            } else {
                                                echo 'Data não fornecida';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="info-livro">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode($aluno['RA_ALUNO']); ?>&amp;" alt="QR Code" id="qrcode">
                        <div class="color">
                            <img src="./src/img/capa-carteirinha.png" alt="Dracotheca" id="capa-carteirinha">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            const bannerImage = getCookie('theme_image');

            console.log('Banner Image Cookie:', bannerImage);
            if (profileImage) {
                const avatarElement = document.getElementById('user-avatar');
                if (avatarElement) {
                    avatarElement.src = profileImage;
                } else {
                    console.error("Elemento 'user-avatar' não encontrado.");
                }
            }

            if (bannerImage) {
                const bannerElement = document.getElementById('theme_image');
                bannerElement.src = bannerImage;
            }
        });
    </script>
</body>

</html>