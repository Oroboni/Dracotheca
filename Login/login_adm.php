<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file login_adm.php
    *   @description Arquivo PHP visual para entrar como bibliotecário.
    *   É o layout de uma página de login para administradores, onde eles podem inserir suas credenciais (RA e senha) para acessar o sistema Dracotheca.
    */ 
-->
<?php
if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION)) {
    session_destroy();
    $_SESSION = [];
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dracotheca</title>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" type="text/css" href="../src/css/Login_adm.css">

    <style>
        /* Selo Dracotheca */
        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px; 
            width: 90%;
        }

        .welcome-section {
            flex: 1;
        }

        .side-image {
            width: 600px;
            height: auto;
            margin-left: 100px;
        }

        
        @media screen and (max-width: 1500px) {
            .side-image {
                width: 550px;
                height: auto;
                margin-left: 50px;
            }
        }

        @media screen and (max-width: 1330px) {
            .side-image {
                width: 500px;
                height: auto;
                margin-left: 20px;
            }
        }

        @media screen and (max-width: 1230px) {
            .side-image {
                width: 450px;
                height: auto;
                margin-left: 20px;
            }

            .welcome-section h2 {
                font-size: 1.6em;
            }

            .welcome-section p {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <h1 class="dracotheca1" id="dragon">Dracotheca</h1>
    <div class="container">
        <img src="../src/img/selo-dracotheca.png" alt="Selo Dracotheca" class="side-image">
        <main>
            <a href="login_pai.html">
                <button class="back"><i class="fas fa-chevron-left"></i></button>
            </a>
            <section class="welcome-section">
                <p class="tamanho">Você escolheu entrar como Administrador</p>
                <h2>Seja bem vindo!</h2>
                <p>Entre com seu login para acessar a biblioteca</p>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_GET['error']; ?>
                    </div>
                <?php endif; ?>

                <form action="./Entrar_adm.php" method="post">
                    <input class="input-group-text input" type="text" placeholder="Email" name="uname" required>
                    <div class="password-container">
                        <input id="password" class="input-group-text input" type="password" name="password" placeholder="Senha" required>
                    </div>
                    <button class="student-button">Entrar como Administrador</button>
                </form>

                <!-- <div class="request-access">
                    <p>Não tem uma conta?</p>
                    <button class="email-access-button">Peça acesso pelo email</button>
                </div> -->
            </section>
            <footer>
                <p>Fatec Sorocaba</p>
            </footer>
        </main>
    </div>

    <script>
        // /*
        //     *   Ajusta dinamicamente a visibilidade de um elemento com o ID dragon com base na largura da janela do navegador.
        // */ 
        function adjustVisibility() {
            const width = window.innerWidth;
            const titleElement = document.getElementById("dragon");

            titleElement.style.display = width < 760 ? "none" : "block";
        }

        window.onload = adjustVisibility;
        window.onresize = adjustVisibility;
    </script>
</body>
</html>
