<!-- 
    /**
    *  @author Camila Inocencio e Matheus Cuero 
    *  @version 2.0
    *  @file gerLivro.php
    *  @description Esta é uma tela de visualizar, nela a bibliotecária poderá ver todos os dados do livro, além de poder editar e excluir.
    *  Aqui, é possível gerenciar o livro selecionado na tela de livros.php, através de um formulário que busca e exibi informações sobre o livro a partir do banco de dados, utilizando o id do livro obtido na URL ($_GET['tombo']).
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
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/gerAluno.css">
    <link rel="stylesheet" href="../src/css/cadLivro.css">

    <title>Dracotheca</title>
    <?php
    // /*
        // *   O valor do parâmetro id é passado via URL, então o código prepara e executa uma consulta SQL para buscar os detalhes do livro na tabela livro onde o TOMBO_LIV corresponde ao valor de id, assim, os dados do livro são armazenados na variável $livro como um array associativo.
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
        <div class="titulo">
            <button type="button" class="voltar" onclick="history.back()">
                <img src="./src/img/icons/retornar.png" alt="voltar">
            </button>
            <h1>Gerenciar Livro</h1>
        </div>

        <!-- Formulário de cadastro de livro -->
        <div class="container-form">
            <div class="rounded form">
                <form method="POST" enctype="multipart/form-data"
                    action="./PHP/edita_l.php?id=<?php echo $livro['TOMBO_LIV']; ?>">
                    <div class="row align-items-start">
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="titLivro" class="form-label">Título do livro</label>
                                <input id="titLivro" name="titulo" type="text" class="form-control" disabled
                                    placeholder="Título do livro" value="<?php echo $livro['TITULO_LIV']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="autor" class="form-label">Autor(a)</label>
                                <input id="autor" name="autor" type="text" class="form-control"
                                    value="<?php echo $livro['AUTOR_LIV']; ?>" disabled>
                            </div>

                            <div class="row g-3">
                                <div class="col">
                                    <label for="tombo" class="form-label">Tombo</label>
                                    <input type="text" id="tombo" name="tombo" class="form-control"
                                        value="<?php echo $livro['TOMBO_LIV']; ?>" disabled>
                                </div>
                                <div class="col">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <input type="text" id="genero" name="genero" class="form-control"
                                        value="<?php echo $livro['GENERO_LIV']; ?>" disabled>
                                </div>
                            </div>

                            <div class="mb-3 segundos">
                                <label for="palavras" class="form-label">Palavras-chave</label>
                                <input id="palavras" name="palavras" type="text" class="form-control"
                                    placeholder="Palavras chave do livro"
                                    value="<?php echo $livro['PALAVCHAVE_LIV']; ?>" disabled>
                            </div>

                            <div class="row g-3">
                                <div class="col">
                                    <label for="edicao" class="form-label">Edição</label>
                                    <input type="text" id="edicao" name="edicao" class="form-control" disabled
                                        placeholder="Edição do livro" value="<?php echo $livro['EDICAO_LIV']; ?>">
                                </div>
                                <div class="col">
                                    <label for="editora" class="form-label">Editora</label>
                                    <input type="text" id="editora" name="editora" class="form-control" disabled
                                        placeholder="Editora do livro" value="<?php echo $livro['EDITORA_LIV']; ?>">
                                </div>
                            </div>

                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="dtLanc" class="form-label">Data de lançamento</label>
                                    <input type="date" id="dtLanc" name="dtLanc" class="form-control" disabled
                                        value="<?php echo $livro['DTLANCAM_LIV']; ?>">
                                </div>
                                <div class="col">
                                    <label for="curso" class="form-label">Curso</label>
                                    <input id="curso" name="curso" type="text" class="form-control" disabled
                                        value="<?php echo $livro['CURSO_LIV']; ?>">
                                </div>
                            </div>

                            <hr>

                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="dtAqu" class="form-label">Data de aquisição</label>
                                    <input type="date" id="dtAqu" name="dtAqu" class="form-control" disabled
                                        value="<?php echo $livro['DTAQUISICAO_LIV']; ?>">
                                </div>
                                <div class="col">
                                    <label for="tipoAqu" class="form-label">Tipo de aquisição</label>
                                    <select id="tipoAqu" name="tipoAqu" class="form-select" disabled>
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

                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="forne" class="form-label">Fornecedor</label>
                                    <input type="text" id="forne" name="fornecedor" class="form-control"
                                        placeholder="Fornecedor do livro" disabled
                                        value="<?php echo $livro['FORNECEDOR_LIV']; ?>">
                                </div>
                                <div class="col">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input type="text" id="valor" name="valor" class="form-control" disabled
                                        placeholder="Valor do livro" value="<?php echo $livro['VALOR_LIV']; ?>">
                                </div>
                            </div>

                            <div class="row g-3 seg">
                                <div class="col">
                                    <label for="dispo" class="form-label">Disponibilidade</label>
                                    <select id="dispo" name="disponivel" disabled class="form-select">
                                        <option selected disabled value="">Selecione</option>
                                        <option <?php echo ($livro['DISPON_LIV'] == 'Disponível') ? 'selected' : ''; ?>>
                                        Disponível</option>
                                        <option <?php echo ($livro['DISPON_LIV'] == 'Indisponív') ? 'selected' : ''; ?>>
                                            Indisponível</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select disabled" disabled>
                                        <option selected disabled value="">Selecione</option>
                                        <option <?php echo ($livro['STATUS_LIV'] == 'Novo') ? 'selected' : ''; ?>>
                                        Novo</option>
                                        <option <?php echo ($livro['STATUS_LIV'] == 'Usado') ? 'selected' : ''; ?>>Usado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 segundos">
                                <label for="comp" class="form-label">Complemento</label>
                                <input id="comp" name="complemento" type="text" class="form-control" disabled
                                    placeholder="Complemento" value="<?php echo $livro['COMPLEM_LIV']; ?>">
                            </div>

                            <div class="mb-3 segundos">
                                <label for="obs" class="form-label">Observação</label>
                                <textarea name="observacao" id="obs" class="form-control" disabled
                                    placeholder="Digite sua observação"><?php echo $livro['OBS_LIV']; ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="image">
                            <img id="imgPreview" src=" <?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                                <input type="file" id="imageInput" name="imagem" accept="image/*"
                                    style="display: none;">
                                <button type="button" class="btn btn-primary mt-2" id="uploadButton"
                                    style="display: none;">
                                    <img src="./src/img/icons/cloud-plus.png" alt="Upload" class="btn-icon"> Alterar
                                    Capa
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="btns">
                        <button type="button" class="btn cancelar" onclick="history.back()">
                            Voltar  
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                        <button type="button" class="btn editar" id="editarBtn" onclick="editar()">
                            Editar <img src="./src/img/icons/edit-2.png" alt="Editar" class="btn-icon">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../src/javascript/livros.js"></script>
</body>

</html>
<script>
    // /*
        // *   Alterna o estado de um formulário, permitindo editar campos no primeiro clique e submeter no segundo. O botão de "Editar" muda para "Salvar" e o botão de upload fica visível durante a edição.
    // */
    let clickCounter = 0;

    function editar() {
        clickCounter++;

        if (clickCounter === 1) {
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach((input) => {
                input.disabled = false;
            });
            document.getElementById('tombo').disabled = true;

            const uploadButton = document.getElementById('uploadButton');
            uploadButton.style.display = 'block';

            const editarBtn = document.getElementById('editarBtn');
            editarBtn.innerHTML = 'Salvar <img src="./src/img/icons/save-2.png" alt="Salvar" class="btn-icon">';
        }
        else if (clickCounter === 2) {

            const editarBtn = document.getElementById('editarBtn');
            editarBtn.setAttribute('type', 'submit');
            document.querySelector('form').submit();
        }
    }

    window.onload = function () {
        const uploadButton = document.getElementById('uploadButton');
        uploadButton.style.display = 'none';
    };
</script>