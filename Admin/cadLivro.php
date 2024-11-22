<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file cadLivro.php
    *   @description Página PHP para cadastro de Livros com um formulário de entrada de dados.
    *   O formulário HTML utiliza o método POST para enviar os dados ao arquivo PHP (envia_l.php), que processa as informações e as insere no banco.
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
    <!-- Link do FontAwesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <!-- Importa o Bootstrap (CSS) para estilização -->
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <!-- Inclui CSS personalizado para a página de cadastro de livros -->
    <link rel="stylesheet" href="../src/css/cadLivro.css">

    <title>Dracotheca</title>

    <style>
        .form {
            background-color: #e3d8e9;
        }
    </style>

    <?php
    // /*
    // *   Consulta o maior número de tombo registrado no banco e define o próximo como esse valor incrementado em 1, ou 0 se nenhum tombo  existir.
    // */
    include 'conecta_DB.php';

    $query = "SELECT MAX(TOMBO_LIV) AS TOMBO_LIV FROM livro";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tombo_liv = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    if ($tombo_liv['TOMBO_LIV'] !== null || $tombo_liv['TOMBO_LIV'] > 0) {
        $novoTombo = $tombo_liv['TOMBO_LIV'] + 1;
    } else {
        $novoTombo = 0;
    }
    ?>
</head>

<body class="fundo">
    <nav id="sidebar">
        <?php
        include "sidebar.php";
        ?>
    </nav>

    <div class="container">
        <div class="titulo">
            <button type="button" class="voltar" onclick="history.back()">
                <img src="./src/img/icons/retornar.png" alt="voltar">
            </button>
            <h1>Cadastrar Livro</h1>
        </div>

        <div class="container-form">
            <div class="rounded form">
                <form method="POST" action="./PHP/envia_l.php" enctype="multipart/form-data">
                    <div class="row align-items-start">
                        <!-- Primeira coluna com os campos principais -->
                        <div class="col-md-9">
                            <!-- Campo para o título do livro -->
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título do livro</label>
                                <input id="titulo" name="titulo" type="text" class="form-control"
                                    placeholder="Título do livro" required>
                            </div>
                            <!-- Campo para o autor -->
                            <div class="mb-3">
                                <label for="autor" class="form-label">Autor(a)</label>
                                <input id="autor" name="autor" type="text" class="form-control"
                                    placeholder="Autor(a) do livro" required>
                            </div>

                            <!-- Linha com os campos para Tombo e Gênero -->
                            <div class="row g-3">
                                <div class="col">
                                    <label for="tombo" class="form-label">Tombo</label>
                                    <input type="text" class="form-control" placeholder="<?php echo $novoTombo; ?>"
                                        disabled>
                                </div>

                                <div class="col">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <input type="text" id="genero" name="genero" class="form-control"
                                        placeholder="Gênero do livro" required>
                                </div>
                            </div>

                            <!-- Campo para palavras-chave -->
                            <div class="mb-3 segundos">
                                <label for="palavras" class="form-label">Palavras-chave</label>
                                <input id="palavras" name="palavras" type="text" class="form-control"
                                    placeholder="Palavras chave do livro" required>
                            </div>

                            <!-- Linha com campos de Edição e Editora -->
                            <div class="row g-3">
                                <div class="col">
                                    <label for="edicao" class="form-label">Edição</label>
                                    <input type="text" id="edicao" name="edicao" class="form-control"
                                        placeholder="Edição do livro" required>
                                </div>
                                <div class="col">
                                    <label for="editora" class="form-label">Editora</label>
                                    <input type="text" id="editora" name="editora" class="form-control"
                                        placeholder="Editora do livro" required>
                                </div>
                            </div>

                            <!-- Linha com campos de Data de lançamento e Curso -->
                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="dtLanc" class="form-label">Data de lançamento</label>
                                    <input type="date" id="dtLanc" name="dtLanc" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="curso" class="form-label">Curso</label>
                                    <input id="curso" name="curso" type="text" class="form-control"
                                        placeholder="Curso relacionado" required>
                                </div>
                            </div>

                            <hr>

                            <!-- Linha com campos de Data e Tipo de aquisição -->
                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="dtAqu" class="form-label">Data de aquisição</label>
                                    <input type="date" id="dtAqu" name="dtAqu" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="tipoAqu" class="form-label">Tipo de aquisição</label>
                                    <select id="tipoAqu" name="tipoAqu" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <option value="C">Compra</option>
                                        <option value="M">Comodato</option>
                                        <option value="P">Permuta</option>
                                        <option value="D">Doação</option>
                                        <option value="X">Desconhecida</option>
                                        <option value="O">Outra</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Linha com campos de Fornecedor e Valor -->
                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="fornecedor" class="form-label">Fornecedor</label>
                                    <input type="text" id="fornecedor" name="fornecedor" class="form-control"
                                        placeholder="Fornecedor do livro" required>
                                </div>
                                <div class="col">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input type="text" id="valor" name="valor" class="form-control"
                                        placeholder="Valor do livro" required>
                                </div>
                            </div>

                            <!-- Linha com campos de Disponibilidade e Status -->
                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="disponivel" class="form-label">Disponibilidade</label>
                                    <select id="disponivel" name="disponivel" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <option value="Disponível">Disponível</option>
                                        <option value="Indisponível">Indisponível</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <option value="Circulante">Circulante</option>
                                        <option value="Consulta Local">Consulta Local</option>
                                        <option value="Indisponível">Indisponível</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Campo para complemento -->
                            <div class="mb-3 segundos">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input id="complemento" name="complemento" type="text" class="form-control"
                                    placeholder="Complemento" required>
                            </div>
                            <!-- Campo para observação -->
                            <div class="mb-3 segundos">
                                <label for="observacao" class="form-label">Observação</label>
                                <textarea name="observacao" id="observacao" class="form-control"
                                    placeholder="Digite sua observação" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="image">
                                <img id="imgPreview" src="../src/img/books/capa.png" class="rounded img-fluid"
                                    alt="img-perfil">
                                <input type="file" id="imageInput" name="imagem" accept="image/*"
                                    style="display: none;">
                                <button type="button" class="btn btn-primary mt-2" id="uploadButton">
                                    <img src="./src/img/icons/cloud-plus.png" alt="Upload" class="btn-icon"> Alterar
                                    Capa
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="btns">
                        <button type="button" class="btn cancelar" onclick="history.back()">
                            Cancelar <img src="./src/img/icons/slash.png" alt="Cancelar" class="btn-icon">
                        </button>
                        <button type="submit" class="btn salvar">
                            Salvar <img src="./src/img/icons/save-2.png" alt="Salvar" class="btn-icon">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inclui scripts de funcionalidade -->
    <script src="../src/javascript/livros.js"></script>
    <script src="../src/javascript/script.js"></script>
</body>

</html>