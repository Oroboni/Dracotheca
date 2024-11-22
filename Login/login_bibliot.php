<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file login_bibliot.php
    *   @description Arquivo PHP visual para entrar como bibliotecário.
    *   Este código cria uma página de login onde o bibliotecário pode entrar na biblioteca utilizando seu login e senha.
    */ 
-->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dracotheca</title>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" type="text/css" href="../src/css/Login_adm.css">
</head>

<body>
    <h1 class="dracotheca1" id="dragon">Dracotheca</h1>
    <main>
        <a href="login_pai.html">
            <button class="back"><i class="fas fa-chevron-left"></i></button>
        </a>
        <section class="welcome-section">
            <p class="tamanho">Você escolheu entrar como Bibliotecario</p>
            <h2>Seja bem vindo!</h2>
            <p>Entre com seu login para acessar a biblioteca</p>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['error']; ?>
                </div>
            <?php endif; ?>
            <form action="./Entrar_bibliot.php" method="post">
                <input class="input-group-text input" type="text" placeholder="Username" name="uname">
                <div class="password-container">
                    <input id="password" class="input-group-text input" type="password" placeholder="password" name="password">
                </div>
                <button class="student-button" type="submit">Entrar como Bibliotecário</button>
            </form>

            <div class="request-access">
                <p>não tem uma conta?</p>
                <button class="email-access-button">peça acesso pelo email</button>
            </div>
        </section>
        <footer>
            <p>Fatec Sorocaba</p>
        </footer>
    </main>

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