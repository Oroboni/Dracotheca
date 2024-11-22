<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 1.0    
    *   @file notificacoes.php
    *   @description Tela de notificações do bibliotecário.
    *   A estrutura de notificação permite ao bibliotecário ver atualizações sobre prazos de entrega de livros, incluindo quem está em posse destes.
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
    <link rel="stylesheet" href="../src/css/notificacoes.css">

    <title>Dracotheca</title>
    <link rel="icon" href="./src/img/logo.png" type="image/png">
</head>
<body> 
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container-notificacoes">
        <div class="titulo">
            <h1>Notificações</h1>
        </div>

        <div class="container">
            <h4 class="sem-notificacoes">Sem notificações</h4>

            <div class="notif-expirando">
                <button>
                    <img src="./src/img/icons/danger.png" class="status status-prazo">
                    <div class="info">
                        <h4>Prazo de Entrega Expirando</h4>
                        <p class="data">02/08/2024 - 13:50:23</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-disponivel">
                <button>
                    <img src="./src/img/icons/book-not.png" class="status status-disp">
                    <div class="info">
                        <h4>Livro Disponível</h4>
                        <p class="data">29/07/2024 - 15:13:59</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-expirando">
                <button>
                    <img src="./src/img/icons/danger.png" class="status status-prazo">
                    <div class="info">
                        <h4>Prazo de Entrega Expirando</h4>
                        <p class="data">02/08/2024 - 13:50:23</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-disponivel">
                <button>
                    <img src="./src/img/icons/book-not.png" class="status status-disp">
                    <div class="info">
                        <h4>Livro Disponível</h4>
                        <p class="data">29/07/2024 - 15:13:59</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-expirando">
                <button>
                    <img src="./src/img/icons/danger.png" class="status status-prazo">
                    <div class="info">
                        <h4>Prazo de Entrega Expirando</h4>
                        <p class="data">02/08/2024 - 13:50:23</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-expirado">
                <button>
                    <img src="./src/img/icons/info-circle.png" class="status status-exp">
                    <div class="info">
                        <h4>Prazo Expirado</h4>
                        <p class="data">26/04/2024 - 13:27:03</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-expirando">
                <button>
                    <img src="./src/img/icons/danger.png" class="status status-prazo">
                    <div class="info">
                        <h4>Prazo de Entrega Expirando</h4>
                        <p class="data">02/08/2024 - 13:50:23</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-disponivel">
                <button>
                    <img src="./src/img/icons/book-not.png" class="status status-disp">
                    <div class="info">
                        <h4>Livro Disponível</h4>
                        <p class="data">29/07/2024 - 15:13:59</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-disponivel">
                <button>
                    <img src="./src/img/icons/book-not.png" class="status status-disp">
                    <div class="info">
                        <h4>Livro Disponível</h4>
                        <p class="data">29/07/2024 - 15:13:59</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
            <div class="notif-disponivel">
                <button>
                    <img src="./src/img/icons/book-not.png" class="status status-disp">
                    <div class="info">
                        <h4>Livro Disponível</h4>
                        <p class="data">29/07/2024 - 15:13:59</p>
                    </div>
                    <img src="./src/img/icons/enter.png" class="enter">
                </button>
            </div>
        </div>

        <div class="container-expand">
            <div class="expand-content">
                <div class="info-expand">
                    <img src="" class="status-expand">
                    <div>
                        <h4></h4>
                        <p class="data-expand">02/08/2024 - 13:50:23</p>
                    </div>
                </div>
                
                <!-- Caso a notificação for de prazo expirando/expirado -->
                <div class="content-expirando-expirado">
                    <div class="livro">
                        <img src="./src/img/books/book3.jpg" alt="Livro">
                        <div class="info-livro">
                            <h4>Livro:</h4>
                            <p>Entendendo Algorítmos</p>
                            <h4>Data de Retirada:</h4>
                            <p>29/07/2024</p>
                            <h4>Prazo de Entrega:</h4>
                            <p>05/08/2024</p>
                        </div>
                    </div>
                    <p>Devolva o livro ou peça a renovação do prazo de entrega:</p>
                    <button type="button" class="btn renovar" data-bs-toggle="modal" data-bs-target="#naoRenovar">
                        Renovar
                    </button>
                </div>

                <!-- Caso a notificação for de disponibilidade do livro -->
                <div class="content-disponibilidade">
                    <div class="livro">
                        <img src="./src/img/books/book3.jpg" alt="Livro">
                        <div class="info-livro">
                            <h4>Livro:</h4>
                            <p>Entendendo Algorítmos</p>
                        </div>
                    </div>
                    <p>Livro disponível para empréstimo, vá até a biblioteca para retirada.</p>
                </div>
            </div>
        </div>

        <!-- Modal - Sucesso -->
        <div class="modal fade" id="renovarPrazo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-custom">
                <div class="modal-content">
                    <div class="text-center">
                        <h3 id="titRenovar">Prazo renovado com <span>sucesso</span>!</h3>
                        <h3 id="prazoFila">Novo prazo: 19/08/24</h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn-modal-ok ok mx-2" data-bs-dismiss="modal">
                            OK <img src="./src/img/icons/verify.png" alt="Renovar" class="btn-icon">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal - Não foi possível -->
        <div class="modal fade" id="naoRenovar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-custom">
                <div class="modal-content">
                    <div class="naoRenovar">
                        <h3 id="titRenovar">Não é possível renovar o prazo <img src="./src/img/icons/sademoji.png" alt="Renovar" class="btn-icon"></h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn-modal-ok nao-ok mx-2" data-bs-dismiss="modal">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    
    <script src="./src/javascript/notificacoes.js"></script>
</body>
</html>