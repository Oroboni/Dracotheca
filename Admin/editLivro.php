<!--
    /* 
    *   @author Camila Inocencio e Matheus Cuero 
    *   @version 2.0
    *   @file editLivro.php
    *   @description Esta é uma tela de editar, nela a bibliotecária poderá alterar todos os dados do livro, além de poder excluir.
    *  Aqui, é possível editar o livro selecionado na tela de livros.php, através de um formulário que recupera um registro de livro específico com base no id passado na URL ($_GET['id']). 
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
    <!-- Inclui o JavaScript do Bootstrap para funcionalidades interativas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <!-- Importa o Bootstrap (CSS) para estilização -->
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <!-- Inclui o CSS personalizado para a página de gerenciamento de alunos -->
    <link rel="stylesheet" href="../src/css/gerAluno.css">
    <!-- Inclui o CSS personalizado para a página de cadastro de livros -->
    <link rel="stylesheet" href="../src/css/cadLivro.css">

    <title>Dracotheca</title> <!-- Título da página -->
    <?php
    // /*
        // *    O código pega o tombo passado via URL, prepara e executa uma consulta SQL para buscar os detalhes desse livro na tabela livro, e armazena o resultado na variável $livro.
    // */
    include 'conecta_DB.php';

    $id = $_GET['id'];

    $query = "SELECT * FROM livro WHERE TOMBO_LIV = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livro = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    ?>
</head>

<body class="fundo">
    <!-- Menu de navegação lateral incluído a partir de um commando PHP -->
    <nav id="sidebar">
        <?php
        include "sidebar.php";
        ?>
    </nav>

    <div class="container">
        <!-- Seção do título e botão de voltar -->
        <div class="titulo">
            <button type="button" class="voltar" onclick="history.back()">
                <img src="./src/img/icons/retornar.png" alt="voltar"> <!-- Botão com ícone de voltar -->
            </button>
            <h1>Gerenciar Livro</h1> <!-- Título da página -->
        </div>

        <!-- Formulário de cadastro de livro -->
        <div class="container-form">
            <div class="rounded form">
                <form method="POST" enctype="multipart/form-data"
                    action="./PHP/edita_l.php?id=<?php echo $livro['TOMBO_LIV']; ?>">
                    <div class="row align-items-start">
                        <!-- Coluna para os campos de texto -->
                        <div class="col-md-9">
                            <!-- Campo para o título do livro -->
                            <div class="mb-3">
                                <label for="titLivro" class="form-label">Título do livro</label>
                                <input required id="titLivro" name="titulo" type="text" class="form-control"
                                    placeholder="Título do livro" value="<?php echo $livro['TITULO_LIV']; ?>">
                            </div>

                            <!-- Campo para o nome do autor -->
                            <div class="mb-3">
                                <label for="autor" class="form-label">Autor(a)</label>
                                <input required id="autor" name="autor" type="text" class="form-control"
                                    value="<?php echo $livro['AUTOR_LIV']; ?>">
                            </div>

                            <div class="row g-3">
                                <div class="col">
                                    <label for="tombo" class="form-label">Tombo</label>
                                    <input required type="text" id="tombo" name="tombo" class="form-control"
                                        value="<?php echo $livro['TOMBO_LIV']; ?>" disabled>
                                </div>
                                <div class="col">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <input required type="text" id="genero" name="genero" class="form-control"
                                        value="<?php echo $livro['GENERO_LIV']; ?>">
                                </div>
                            </div>

                            <!-- Campo para palavras-chave -->
                            <div class="mb-3 segundos">
                                <label for="palavras" class="form-label">Palavras-chave</label>
                                <input required id="palavras" name="palavras" type="text" class="form-control"
                                    placeholder="Palavras chave do livro"
                                    value="<?php echo $livro['PALAVCHAVE_LIV']; ?>">
                            </div>

                            <!-- Linha com campos para Edição e Editora -->
                            <div class="row g-3">
                                <div class="col">
                                    <label for="edicao" class="form-label">Edição</label>
                                    <input required type="text" id="edicao" name="edicao" class="form-control"
                                        placeholder="Edição do livro" value="<?php echo $livro['EDICAO_LIV']; ?>">
                                </div>
                                <div class="col">
                                    <label for="editora" class="form-label">Editora</label>
                                    <input required type="text" id="editora" name="editora" class="form-control"
                                        placeholder="Editora do livro" value="<?php echo $livro['EDITORA_LIV']; ?>">
                                </div>
                            </div>

                            <!-- Linha com campos para Data de Lançamento e Curso -->
                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="dtLanc" class="form-label">Data de lançamento</label>
                                    <input required type="date" id="dtLanc" name="dtLanc" class="form-control"
                                        value="<?php echo $livro['DTLANCAM_LIV']; ?>">
                                </div>
                                <div class="col">
                                    <label for="curso" class="form-label">Curso</label>
                                    <input required id="curso" name="curso" type="text" class="form-control"
                                        value="<?php echo $livro['CURSO_LIV']; ?>">
                                </div>
                            </div>

                            <hr>

                            <!-- Linha com campos para Data de Aquisição e Tipo de Aquisição -->
                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="dtAqu" class="form-label">Data de aquisição</label>
                                    <input required type="date" id="dtAqu" name="dtAqu" class="form-control"
                                        value="<?php echo $livro['DTAQUISICAO_LIV']; ?>">
                                </div>
                                <div class="col">
                                    <label for="tipoAqu" class="form-label">Tipo de aquisição</label>
                                    <select id="tipoAqu" name="tipoAqu" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <option value="C" <?php echo ($livro['TPAQUISICAO_LIV'] == 'C') ? 'selected' : ''; ?>>Compra</option>
                                        <option value="M" <?php echo ($livro['TPAQUISICAO_LIV'] == 'M') ? 'selected' : ''; ?>>Comodato</option>
                                        <option value="P" <?php echo ($livro['TPAQUISICAO_LIV'] == 'P') ? 'selected' : ''; ?>>Permuta</option>
                                        <option value="D" <?php echo ($livro['TPAQUISICAO_LIV'] == 'D') ? 'selected' : ''; ?>>Doação</option>
                                        <option value="X" <?php echo ($livro['TPAQUISICAO_LIV'] == 'X') ? 'selected' : ''; ?>>Desconhecida</option>
                                        <option value="O" <?php echo ($livro['TPAQUISICAO_LIV'] == 'O') ? 'selected' : ''; ?>>Outra</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Linha com campos para Fornecedor e Valor -->
                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="forne" class="form-label">Fornecedor</label>
                                    <input required type="text" id="forne" name="fornecedor" class="form-control"
                                        placeholder="Fornecedor do livro"
                                        value="<?php echo $livro['FORNECEDOR_LIV']; ?>">
                                </div>
                                <div class="col">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input required type="text" id="valor" name="valor" class="form-control"
                                        placeholder="Valor do livro" value="<?php echo $livro['VALOR_LIV']; ?>">
                                </div>
                            </div>

                            <!-- Linha com campos para Disponibilidade e Status -->
                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="dispo" class="form-label">Disponibilidade</label>
                                    <select id="dispo" name="disponivel" required class="form-select">
                                        <option selected disabled value="">Selecione</option>
                                        <option <?php echo ($livro['DISPON_LIV'] == 'Disponível') ? 'selected' : ''; ?>>
                                        Disponível</option>
                                        <option <?php echo ($livro['DISPON_LIV'] == 'Indisponív') ? 'selected' : ''; ?>>
                                            Indisponível</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select disabled" required>
                                        <option selected disabled value="">Selecione</option>
                                        <option <?php echo ($livro['STATUS_LIV'] == 'Novo') ? 'selected' : ''; ?>>
                                        Novo</option>
                                        <option <?php echo ($livro['STATUS_LIV'] == 'Usado') ? 'selected' : ''; ?>>Usado</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Campo para complemento -->
                            <div class="mb-3 segundos">
                                <label for="comp" class="form-label">Complemento</label>
                                <input required id="comp" name="complemento" type="text" class="form-control"
                                    placeholder="Complemento" value="<?php echo $livro['COMPLEM_LIV']; ?>">
                            </div>

                            <!-- Campo para observações -->
                            <div class="mb-3 segundos">
                                <label for="obs" class="form-label">Observação</label>
                                <textarea name="observacao" id="obs" class="form-control"
                                    placeholder="Digite sua observação"><?php echo $livro['OBS_LIV']; ?></textarea>
                            </div>
                        </div>

                        <!-- Coluna para imagem da capa do livro -->
                        <div class="col-md-3">
                        <div class="image">
                                <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                                <input type="file" id="imageInput" name="imagem" accept="image/*"
                                    style="display: none;">
                                <button type="button" class="btn btn-primary mt-2" id="uploadButton">
                                    <img src="./src/img/icons/cloud-plus.png" alt="Upload" class="btn-icon"> Alterar
                                    Capa <!-- Botão de upload da imagem -->
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de ação para cancelar ou salvar -->
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

    <!-- Inclui script personalizado para edição de livros -->
    <script src="../src/javascript/livros.js"></script>
</body>

</html>