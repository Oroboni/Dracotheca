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
    <link rel="stylesheet" href="../src/css/cadBibliotecario.css">
    <link rel="stylesheet" href="../src/css/gerBibliotecario.css">
    
    <title>Dracotheca</title>
</head>
<body> 
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container">
        <div class="titulo">
            <button type="button" class="voltar" onclick="history.back()">
                <img src="./src/img/icons/retornar.png" alt="voltar">
            </button>
            <h1>Cadastrar Bibliotecário</h1>
        </div>

        <div class="container-form">
            <div class="rounded form">
                <form method="POST" action="PHP/envia_b.php" enctype="multipart/form-data">
                    <div class="row align-items-start">
                        <div class="col-md-3">
                            <div class="image">
                                <img src="./src/img/sem-imagem.png" class="rounded img-fluid" alt="img-perfil">
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome completo</label>
                                <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome completo" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input id="email" name="email" type="email" class="form-control" placeholder="email@email.com" required>
                            </div>

                            <div class="row g-3">
                                <div class="col">
                                    <label for="cpf" class="form-label">CPF</label> 
                                    <input type="number" id="cpf" name="cpf" min="0" class="form-control" placeholder="000.000.000-00" required>
                                </div>
                                <div class="col">
                                    <label for="turno" class="form-label">Turno</label>
                                    <select id="turno" name="turno" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <option value="M">Matutino</option>
                                        <option value="V">Vespertino</option>
                                        <option value="N">Noturno</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col">
                                    <label for="dtnasc" class="form-label">Data de Nascimento</label> 
                                    <input type="date" id="dtnasc" name="dtnasc" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <select id="genero" name="genero" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Feminino</option>
                                        <option value="N">Não-binário</option>
                                        <option value="P">Prefiro não dizer</option>
                                        <option value="O">Outro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btns mt-4">
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