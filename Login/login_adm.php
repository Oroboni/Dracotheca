<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file login_adm.php
    *   @description Arquivo PHP visual para entrar como bibliotecário.
    *   É o layout de uma página de login para administradores, onde eles podem inserir suas credenciais (RA e senha) para acessar o sistema Dracotheca.
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
            <p class="tamanho">Você escolheu entrar como Administrador</p>
            <h2>Seja bem vindo!</h2>
            <p>Entre com seu login para acessar a biblioteca</p>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['error']; ?>
                </div>
            <?php endif; ?>

            <form action="./Entrar_adm.php" method="post">
                <input class="input-group-text input" type="text" placeholder="Username" name="uname" required>
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
