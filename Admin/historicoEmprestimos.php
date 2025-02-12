<!-- 
    /*
    *   @author Luís Glauser e Matheus Cuero
    *   @version 1.0    
    *   @file historicoEmprestimos.php
    *   @description Tela de histórico de empréstimos realizados pela bibliotecária.
    *    O código exibe o histórico de empréstimos de livros, recuperando informações do banco de dados usando PHP com consultas seguras. Os dados, como título, datas e status de devolução, são apresentados em botões, e a navegação é gerenciada com Bootstrap. O PHP manipula a lógica de exibição e interatividade com o banco de dados.
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/historicoLivros.css">

    <title>Dracotheca</title>
</head>
<body>
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>
    
    <div class="container">
        <div class="tituloH">
            <h1>Histórico de empréstimos</h1>
        </div>

       <button class="container-livro row-align-items-start" onclick="location.href='./detalhesLivro.php'">
            <h1 class="col-2" href="./index.php"> <img class="bookH" src="./src/img/books/book1.jpg" alt="capa"> </h1>
            <div class="col-7"> 
                <h3 class="subtitulo ">Programming Python</h3>
                <div class=" col-7">
                    <p class="subtitulo-2">Pego em: 31/10/2024</p>
                    <p class="subtitulo-2">Prazo de entrega: 07/11/2024</p>
                    <p class="subtitulo-2">Pego por: Luís Felipe Glauser Lucas</p>
                </div>
            </div>
            <div class="col-6 align-self-center">
                <h2 class="subtitulo-4 col-6"><img class="estadoImg col-2" src="./src/img/icons/naoDevol.png" alt="capa"> Não Devolvido</h2>
            </div>
       </button>

       <button class="container-livro row-align-items-start" onclick="location.href='./detalhesLivro.php'">
            <a class="col-2" href="./index.php"> <img class="bookH" src="./src/img/books/book4.jpg" alt="capa"> </a>
            <div class="col-7"> 
                <h3 class="subtitulo ">O Modelo Toyota</h3>
                <div class="subtitulo-2 col-7">
                    <p>Pego em: 21/08/2024</p>
                    <p>Prazo de entrega: 28/08/2024</p>
                    <p>Pego por: Matheus Cuero Silva</p>
                </div>
            </div>
            <div class="col-6 align-self-center">
                <h2 class="subtitulo-4 col-6"><img class="estadoImg col-2" src="./src/img/icons/histAlert.png" alt="capa"> Em atraso</h2>
            </div>
       </button>

       <button class="container-livro row-align-items-start" onclick="location.href='./detalhesLivro.php'">
            <a class="col-2" href="./index.php"> <img class="bookH" src="./src/img/books/book2.jpg" alt="capa"> </a>
            <div class="col-7"> 
                <h3 class="subtitulo ">Sobre história</h3>
                <div class="subtitulo-2 col-7">
                    <p>Pego em: 19/04/2024</p>
                    <p>Prazo de entrega: 26/04/2024</p>
                    <p>Pego por: Bruna Elisa Prestes de Almeida</p>
                </div>
            </div>
            <div class="col-6 align-self-center">
                <h2 class="subtitulo-4 col-6"><img class="estadoImg col-2" src="./src/img/icons/histDevol.png" alt="capa">Devolvido </h2>
                <p class="subtitulo-2">devolvido em: <br> 24/04/2024</p>
            </div>
       </button>
    </div>
</body>