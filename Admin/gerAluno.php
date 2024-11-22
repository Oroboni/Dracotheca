<!-- 
    /**
    *  @author Camila Inocencio e Matheus Cuero 
    *  @version 2.0
    *  @file gerAluno.php
    *  @description Esta é uma tela de visualizar, nela a bibliotecária poderá ver todos os dados do aluno, além de poder editar e excluir.
    *  Aqui, é possível gerenciar o aluno selecionado na tela de alunos.php, através de um formulário que busca e exibi informações sobre o aluno a partir do banco de dados, utilizando o id do aluno obtido na URL ($_GET['id']).
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
    <title>Dracotheca</title>

    <style>
        .form {
            background-color: #e3d8e9;
        }
    </style>

    <?php
    // /*
        // *   Esse código faz uma consulta ao banco de dados para recuperar informações de um aluno.
    // */
    include 'conecta_DB.php';

    $id = $_GET['id'];

    $query = "SELECT * FROM aluno WHERE ID_ALUNO = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $aluno = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    ?>
</head>

<body class="fundo">
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container">
        <div class="titulo">
            <button type="button" class="voltar" onclick="history.back()">
                <img src="./src/img/icons/retornar.png" alt="voltar">
            </button>
            <h1>Gerenciar Aluno</h1>
        </div>

        <div class="container-form">
            <div class="rounded form">
            <form method="POST" enctype="multipart/form-data"
            action="./PHP/edita_a.php?id=<?php echo $aluno['ID_ALUNO']; ?>">
                    <div class="row align-items-start">
                        <div class="col-md-3">
                            <div class="image">
                                <img src="<?php echo !empty($aluno['FOTO_ALUNO']) ? $aluno['FOTO_ALUNO'] : './src/img/sem-imagem.png'; ?>"
                                    class="rounded img-fluid" alt="img-perfil">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome completo</label>
                                <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome completo"
    value="<?php echo $aluno['NOME_ALUNO']; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="email@email.com"
                                    value="<?php echo $aluno['EMAIL_ALUNO']; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="curso" class="form-label">Curso</label>
                                <select id="curso" name="curso" class="form-select" disabled>
                                    <option selected><?php echo $aluno['CURSO_ALUNO']; ?></option>
                                </select>
                            </div>

                            <div class="row g-3">
                                <div class="col">
                                    <label for="ra" class="form-label">RA</label>
                                    <input type="text" id="ra" name="ra" class="form-control" placeholder="Digite seu RA"
                                        value="<?php echo $aluno['RA_ALUNO']; ?>" disabled>
                                </div>
                                <div class="col">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00"
                                        value="<?php echo $aluno['CPF_ALUNO']; ?>" disabled>
                                </div>
                                <div class="col">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <select id="genero" name="genero" class="form-select" disabled>
                                        <option value="M" <?php echo ($aluno['GEN_ALUNO'] == 'M') ? 'selected' : ''; ?>>
                                            Masculino</option>
                                        <option value="F" <?php echo ($aluno['GEN_ALUNO'] == 'F') ? 'selected' : ''; ?>>
                                            Feminino</option>
                                        <option value="N" <?php echo ($aluno['GEN_ALUNO'] == 'N') ? 'selected' : ''; ?>>
                                            Não-binário</option>
                                        <option value="P" <?php echo ($aluno['GEN_ALUNO'] == 'P') ? 'selected' : ''; ?>>
                                            Prefiro não dizer</option>
                                        <option value="O" <?php echo ($aluno['GEN_ALUNO'] == 'O') ? 'selected' : ''; ?>>
                                            Outra</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 segundos">
                                <div class="col">
                                    <label for="dtcad" class="form-label">Dt. de Cadastro</label>
                                    <input type="date" name="dtcad" id="dtcad" class="form-control"
                                        value="<?php echo $aluno['DTCADASTRO_ALUNO']; ?>" disabled>
                                </div>
                                <div class="col">
                                    <label for="dtnasc" class="form-label">Dt. Nascimento</label>
                                    <input type="date" name="dtnasc" id="dtnasc" class="form-control"
                                        value="<?php echo $aluno['DTNASC_ALUNO']; ?>" disabled>
                                </div>
                                <div class="col">
                                    <label for="senha" class="form-label">Senha</label>
                                    <input type="password" name="senha" id="senha" class="form-control"
                                        value="<?php echo $aluno['SEN_ALUNO']; ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btns">
                        <button type="button" class="btn editar" id="editarBtn" onclick="editar()">
                            Editar <img src="./src/img/icons/edit-2.png" alt="Editar" class="btn-icon">
                        </button>
                        <button type="button" class="btn excluir" data-bs-toggle="modal" data-bs-target="#excluirAluno"
                            data-id="<?php echo $aluno['ID_ALUNO']; ?>">
                            Excluir <img src="./src/img/icons/trash.png" alt="Excluir" class="btn-icon">
                        </button>
                    </div>

                </form>
                <div class="modal fade" id="excluirAluno" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-custom">
                        <div class="modal-content">
                            <div class="pergunta text-center">
                                <h3 id="titPergunta">Deseja mesmo <span>excluir</span> esse aluno(a)?</h3>
                                <h4 id="subPergunta">*Esta ação é <span>irreversível</span></h4>
                            </div>
                            <form action="./php/deleta_a.php?id=<?php echo $aluno['ID_ALUNO']; ?>" method="POST">
                            <div class="btns-pergunta d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-modal-cancelar cancelar mx-2"
                                        data-bs-dismiss="modal">
                                        Cancelar <img src="./src/img/icons/slash.png" alt="Cancelar" class="btn-icon">
                                    </button>
                                    <button type="submit" class="btn btn-modal-excluir excluir mx-2"
                                        data-id="<?php echo $aluno['ID_ALUNO']; ?>">
                                        Excluir <img src="./src/img/icons/trash.png" alt="Excluir" class="btn-icon">
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>

<script>
    // /*
        // *   Alternar entre os estados de edição e de envio de um formulário ao clicar em um botão. No primeiro clique, ele habilita os campos para edição, e no segundo clique, ele envia o formulário.
    // */
    let clickCounter = 0;

    function editar() {
    clickCounter++;

    if (clickCounter === 1) {
        // Ativar edição
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach((input) => {
            input.disabled = false;
        });

        const uploadButton = document.getElementById('uploadButton');
        if (uploadButton) {
            uploadButton.style.display = 'block';
        }

        const editarBtn = document.getElementById('editarBtn');
        editarBtn.innerHTML = 'Salvar <img src="./src/img/icons/save-2.png" alt="Salvar" class="btn-icon">';
    }
    else if (clickCounter === 2) {
        // Habilitar todos os inputs antes de submeter
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach((input) => {
            input.disabled = false;
        });

        document.querySelector('form').submit(); // Submeter o formulário
    }
}

</script>