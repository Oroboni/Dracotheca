<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file cadAluno.php
    *   @description Formulário para cadastrar novos alunos no sistema.
    *   Os dados são enviados via POST para o script PHP envia_a.php, responsável por processar o cadastro.
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
    <link rel="stylesheet" href="../src/css/cadAluno.css">
    <link rel="stylesheet" href="../src/css/gerAluno.css">

    <title>Dracotheca</title>

    <style>
        .form {
            background-color: #e3d8e9;
        }
    </style>
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
            <h1>Cadastrar Aluno</h1>
        </div>

        <div class="container-form">
            <div class="rounded form">
                <form method="POST" action="./PHP/envia_a.php" enctype="multipart/form-data">
                    <div class="row align-items-start">
                        <div class="col-md-3">
                            <div class="image">
                                <img id="imgPreview" src="../src/img/books/capa.png" class="rounded img-fluid"
                                    alt="img-perfil">
                                <input type="file" id="imageInput" name="imagem" accept="image/*"
                                    style="display: none;">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome completo</label>
                                <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome completo" aria-label="Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input id="email" name="email" type="email" class="form-control" placeholder="email@email.com" aria-label="E-mail" required>
                            </div>
                            <div class="mb-3">
                                <label for="curso" class="form-label">Curso</label>
                                <select id="curso" name="curso" class="form-select" required>
                                    <option selected disabled value="">Selecione</option>
                                    <option value="Desenvolvimento de Sistemas">Desenvolvimento de Sistemas</option>
                                    <option value="Eletrônica Automotiva">Eletrônica Automotiva</option>
                                    <option value="Logística">Logística</option>
                                </select>
                            </div>
                            <div class="row g-3">
                                <div class="col">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00" aria-label="CPF" required>
                                </div>
                                <div class="col">
                                    <label for="ra" class="form-label">RA</label>
                                    <input type="text" id="ra" name="ra" class="form-control" placeholder="Digite seu RA" aria-label="RA" required>
                                </div>
                            </div>
                            <div class="row g-3 segundos">
                                <div class="col">
                                    <label for="dtnasc" class="form-label">Data de Nascimento</label>
                                    <input type="date" id="dtnasc" name="dtnasc" class="form-control" aria-label="DtNasc" required>
                                </div>
                                <div class="col">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <select id="genero" name="genero" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Feminino">Feminino</option>
                                        <option value="Não-binário">Não-binário</option>
                                        <option value="Prefiro não dizer">Prefiro não dizer</option>
                                        <option value="Outro">Outro</option>
                                    </select>
                                </div>
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

    <script src="../src/javascript/script.js"></script>
</body>

</html>