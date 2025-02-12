<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file login_alun.php
    *   @description Arquivo PHP visual para entrar como aluno.
    *   Este código cria uma página de login onde o aluno pode entrar na biblioteca utilizando seu RA e senha.
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
    <link rel="stylesheet" type="text/css" href="../src/css/Login_alun.css">

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
                <p class="tamanho">Você escolheu entrar como aluno</p>
                <h2>Seja bem vindo!</h2>
                <p>Entre com seu RA para acessar a biblioteca</p>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_GET['error']; ?>
                    </div>
                <?php endif; ?>
                <form action="./Entrar_alun.php" method="post">
                <input class="input-group-text input" type="text" placeholder="0001603294900" name="uname">
                <div class="password-container">
                    <input id="password" class="input-group-text input" type="password" placeholder="password" name="password">
                </div>
                    <button class="student-button" type="submit">Faça login com o RA</button>
                </form>

                <!-- <div class="request-access">
                    <p>não tem uma conta?</p>
                    <button class="email-access-button">peça acesso pelo email</button>
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
        function a() {
            var width = window.innerWidth;
            var x = document.getElementById("dragon");

            if (width < 760) {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }

        console.log(window.innerWidth);

        window.onload = a;
        window.onresize = a;
    </script>
</body>

</html>