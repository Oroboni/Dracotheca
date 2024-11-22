<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file editBibliotecario.php
    *   @description Tela de edição das informações dos bibliotecários.
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
    <link rel="stylesheet" href="../src/css/gerBibliotecario.css">

    <title>Dracotheca</title>

    <?php
    include 'conecta_DB.php';

    $id = $_GET['id'] ?? null;
    $bibliotecario = null;

    if ($id) {
        $sql = "SELECT * FROM bibliotecaria WHERE ID_BIBLIOT = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $bibliotecario = mysqli_fetch_assoc($result);
        } else {
            echo "<p class='text-danger'>Erro: Bibliotecário não encontrado.</p>";
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<p class='text-danger'>Erro: ID não fornecido.</p>";
        exit;
    }
    ?>
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
            <h1>Gerenciar Bibliotecário</h1>
        </div>
        <div class="container-form">
            <div class="rounded form">
                <form method="POST" action="./php/edita_b.php?id=<?php echo htmlspecialchars($id); ?>">
                    <div class="row align-items-start">
                        <div class="col-md-3">
                            <div class="image">
                                <img src="./src/img/sem-imagem.png" class="rounded img-fluid" alt="img-perfil">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome completo</label>
                                <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome completo"
                                    value="<?php echo htmlspecialchars($bibliotecario['NOME_BIBLIOT'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input id="email" name="email" type="email" class="form-control" placeholder="email@email.com"
                                    value="<?php echo htmlspecialchars($bibliotecario['EMAIL_BIBLIOT'] ?? ''); ?>" required>
                            </div>

                            <div class="row g-3">
                                <div class="col">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control" placeholder="000.000.000-00"
                                        value="<?php echo htmlspecialchars($bibliotecario['CPF_BIBLIOT'] ?? ''); ?>" required>
                                </div>
                                <div class="col">
                                    <label for="turno" class="form-label">Turno</label>
                                    <select id="turno" name="turno" class="form-select" required>
                                        <option value="">Selecione...</option>
                                        <option value="M" <?php echo (isset($bibliotecario['TURNO_BIBLIOT']) && $bibliotecario['TURNO_BIBLIOT'] == 'M') ? 'selected' : ''; ?>>Matutino</option>
                                        <option value="V" <?php echo (isset($bibliotecario['TURNO_BIBLIOT']) && $bibliotecario['TURNO_BIBLIOT'] == 'V') ? 'selected' : ''; ?>>Vespertino</option>
                                        <option value="N" <?php echo (isset($bibliotecario['TURNO_BIBLIOT']) && $bibliotecario['TURNO_BIBLIOT'] == 'N') ? 'selected' : ''; ?>>Noturno</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Data de Nascimento e Gênero -->
                            <div class="row g-3 segundos">
                                <div class="col">
                                    <label for="dtnasc" class="form-label">Data de Nascimento</label>
                                    <input type="date" id="dtnasc" name="dtnasc" class="form-control"
                                        value="<?php echo htmlspecialchars($bibliotecario['DTNASC_BIBLIOT'] ?? ''); ?>" required>
                                </div>
                                <div class="col">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <select id="genero" name="genero" class="form-select">
                                        <option value="">Selecione...</option>
                                        <option value="M" <?php echo (isset($bibliotecario['GEN_BIBLIOT']) && $bibliotecario['GEN_BIBLIOT'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                                        <option value="F" <?php echo (isset($bibliotecario['GEN_BIBLIOT']) && $bibliotecario['GEN_BIBLIOT'] == 'F') ? 'selected' : ''; ?>>Feminino</option>
                                        <option value="N" <?php echo (isset($bibliotecario['GEN_BIBLIOT']) && $bibliotecario['GEN_BIBLIOT'] == 'N') ? 'selected' : ''; ?>>Não-binário</option>
                                        <option value='P' <?php echo (isset($bibliotecario['GEN_BIBLIOT']) && $bibliotecario['GEN_BIBLIOT'] == 'P') ? 'selected' : ''; ?>>Prefiro não dizer</option>
                                        <option value='O' <?php echo (isset($bibliotecario['GEN_BIBLIOT']) && $bibliotecario['GEN_BIBLIOT'] == 'O') ? 'selected' : ''; ?>>Outro</option>
                                    </select>
                                </div>
                            </div>

                        </div> <!-- Fim da coluna -->
                    </div> <!-- Fim da linha -->

                    <!-- Botões de ação -->
                    <div class='btns'>
                        <button type='button' class='btn cancelar' onclick='history.back()'>
                            Cancelar 
                            <img src='./src/img/icons/slash.png' alt='Cancelar' class='btn-icon'>
                        </button>
                        <button type='submit' class='btn salvar'>
                            Salvar 
                            <img src='./src/img/icons/save-2.png' alt='Salvar' class='btn-icon'>
                        </button>
                    </div>

                </form> <!-- Fim do formulário -->
            </div> <!-- Fim da div form -->
        </div> <!-- Fim da div container-form -->
    </div> <!-- Fim da div container -->

    <script src="../src/javascript/editBibliotecario.js"></script>

</body>

</html>