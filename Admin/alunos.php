<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file alunos.php
    *   @description Arquivo PHP para gerenciar alunos do sistema.
    *   O código busca dados no banco de dados com base em um termo de pesquisa ou exibe todos os alunos através de uma tabela que os apresenta com opções para visualizar, editar e excluir. Além disso, é possível cadastrar outros alunos pelo botão cadastrar, que abre o formulário do arquivo cadAluno.php
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="../src/javascript/editAlunos.js"></script>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/alunos.css">

    <title>Dracotheca</title>

    <?php
    // /*
    // *   O código busca alunos no banco de dados, retornando todos os registros ou filtrando por ID ou nome com base no termo fornecido na URL via `GET`.
    // */

    include 'conecta_DB.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if ($search) {
        $query = "SELECT ID_ALUNO, NOME_ALUNO FROM aluno WHERE ID_ALUNO LIKE ? OR NOME_ALUNO LIKE ?";
        $stmt = mysqli_prepare($conn, $query);
        $searchTerm = '%' . $search . '%';
        mysqli_stmt_bind_param($stmt, 'ss', $searchTerm, $searchTerm);
    } else {
        $query = "SELECT ID_ALUNO, NOME_ALUNO FROM aluno";
        $stmt = mysqli_prepare($conn, $query);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $alunos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
</head>

<body class="fundo">
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container">
        <div class="titulo">
            <h1>Gerenciar Alunos</h1>
        </div>

        <div class="search">
            <!-- Botão para abrir a barra de busca -->
            <button id="open_btn">
                <i id="open_btn_icon" class="fa-solid fa-magnifying-glass"></i> <!-- Ícone de lupa -->
            </button>
            <!-- Caixa de pesquisa -->
            <div class="box-search">
                <!-- Formulário para realizar buscas -->
                <form id="search-form" method="get" action="alunos.php">
                    <div class="search-bar">
                        <input type="text" id="search-input" name="search" placeholder="Pesquisar...">
                        <button type="submit" id="search-button">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="background1">
            <div class="background2">
                <div class="tabela">
                    <div class="cad">
                        <a href="./cadAluno.php" class="btn cadastrar">
                            Cadastrar <img src="./src/img/icons/user-edit.png" alt="Cadastrar" class="btn-icon">
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <colgroup>
                                <col style="width: 20%;">
                                <col style="width: 40%;">
                                <col style="width: 40%;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Gerenciar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alunos as $aluno): ?>
                                    <tr>
                                        <th scope="row"><?php echo $aluno['ID_ALUNO']; ?></th>
                                        <td><?php echo $aluno['NOME_ALUNO']; ?></td>
                                        <td>
                                            <div class="btns">
                                                <a href="./gerAluno.php?id=<?php echo $aluno['ID_ALUNO']; ?>"
                                                    class="btn visualizar">
                                                    Visualizar <img src="./src/img/icons/eye.png" alt="Visualizar"
                                                        class="btn-icon">
                                                </a>
                                                <a href="./editAluno.php?id=<?php echo $aluno['ID_ALUNO']; ?>"
                                                    class="btn editar">
                                                    Editar <img src="./src/img/icons/edit-2.png" alt="Editar"
                                                        class="btn-icon">
                                                </a>
                                                <button type="button" class="btn excluir" data-bs-toggle="modal"
                                                    data-bs-target="#excluirLivro<?php echo $aluno['ID_ALUNO']; ?>"
                                                    data-id="<?php echo $aluno['ID_ALUNO']; ?>">
                                                    Excluir <img src="./src/img/icons/trash.png" alt="Excluir" class="btn-icon">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="excluirLivro<?php echo $aluno['ID_ALUNO']; ?>"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-custom">
                                            <div class="modal-content">
                                                <div class="pergunta text-center">
                                                    <h3 id="titPergunta">Deseja mesmo <span>excluir</span> esse livro?</h3>
                                                    <h4 id="subPergunta">*Esta ação é <span>irreversível</span></h4>
                                                </div>
                                                <form action="./php/deleta_a.php" method="POST">
                                                    <div class="btns-pergunta d-flex justify-content-center align-items-center">
                                                        <input type="hidden" name="id" value="<?php echo $aluno['ID_ALUNO']; ?>">
                                                        <button type="button" class="btn btn-modal-cancelar cancelar mx-2"
                                                            data-bs-dismiss="modal">
                                                            Cancelar <img src="./src/img/icons/slash.png" alt="Cancelar" class="btn-icon">
                                                        </button>
                                                        <button type="submit" class="btn btn-modal-excluir excluir mx-2">
                                                            Excluir <img src="./src/img/icons/trash.png" alt="Excluir" class="btn-icon">
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../src/javascript/script.js"></script>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn.excluir');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alunoId = button.getAttribute('data-id');
                console.log(`Aluno selecionado para exclusão: ${alunoId}`);
            });
        });
    });
</script>