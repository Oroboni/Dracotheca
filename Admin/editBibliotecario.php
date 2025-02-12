<!-- 
    /**
    *  @author Camila Inocencio
    *  @version 1.0
    *  @file geraluno.php
    *  @description Esta é a tela de Visualizar, nela a Bibliotecaria podera ver todos os dados do aluno
    *  dos alunos. Também tem dois botões que permitem editar e excluir o aluno.
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

    <?php
    include __DIR__. '/conecta_DB.php';



    $id = $_GET['id'];

    $query = "SELECT * FROM bibliotecaria WHERE ID_BIBLIOT = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $bibliotecario = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
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
                <form method="POST" action="./PHP/edita_b.php?id=<?php echo $bibliotecario['ID_BIBLIOT']; ?>"
                    enctype="multipart/form-data">
                    <div class="row align-items-start">
                        <div class="col-md-3">
                            <img id="imgPreview" src="<?php echo !empty($bibliotecario['FOTO_BIBLIOT']) && file_exists($bibliotecario['FOTO_BIBLIOT']) && $bibliotecario['FOTO_BIBLIOT'] != '../src/img/books/capa.png'? '../src/img/books/' . $bibliotecario['FOTO_BIBLIOT'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome completo</label>
                                <input  id="nome" name="nome" type="text" class="form-control"
                                    placeholder="Nome completo" aria-label="Name"
                                    value="<?php echo $bibliotecario['NOME_BIBLIOT']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input  id="email" name="email" type="text" class="form-control"
                                    placeholder="email@example.com" aria-label="E-mail"
                                    value="<?php echo $bibliotecario['EMAIL_BIBLIOT']; ?>">
                            </div>
                            <div class="row g-3">
                                <div class="col">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input  type="text" id="cpf" name="cpf" class="form-control"
                                        placeholder="000.000.000-00" aria-label="CPF"
                                        value="<?php echo $bibliotecario['CPF_BIBLIOT']; ?>">
                                </div>
                                <div class="col">
                                    <label for="turno" class="form-label">Turno</label>
                                    <select id="turno" name="turno" class="form-select" >
                                        <option value="M" <?php if ($bibliotecario['TURNO_BIBLIOT'] == 'M')
                                                                echo 'selected'; ?>>Matutino</option>
                                        <option value="V" <?php if ($bibliotecario['TURNO_BIBLIOT'] == 'V')
                                                                echo 'selected'; ?>>Vespertino</option>
                                        <option value="N" <?php if ($bibliotecario['TURNO_BIBLIOT'] == 'N')
                                                                echo 'selected'; ?>>Noturno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 segundos">
                                <div class="col">
                                    <label for="dtnasc" class="form-label">Data de Nascimento</label>
                                    <input  type="date" id="dtnasc" name="dtnasc" class="form-control"
                                        aria-label="DtNasc" value="<?php echo $bibliotecario['DTNASC_BIBLIOT']; ?>">
                                </div>
                                <div class="col">
                                    <label for="genero" class="form-label">Gênero</label>
                                    <select  id="genero" name="genero" class="form-select">
                                        <option value="M" <?php if ($bibliotecario['GEN_BIBLIOT'] == 'M')
                                                                echo 'selected'; ?>>Masculino</option>
                                        <option value="F" <?php if ($bibliotecario['GEN_BIBLIOT'] == 'F')
                                                                echo 'selected'; ?>>Feminino</option>
                                        <option value="N" <?php if ($bibliotecario['GEN_BIBLIOT'] == 'N')
                                                                echo 'selected'; ?>>Não-binário</option>
                                        <option value="P" <?php if ($bibliotecario['GEN_BIBLIOT'] == 'P')
                                                                echo 'selected'; ?>>Prefiro não dizer</option>
                                        <option value="O" <?php if ($bibliotecario['GEN_BIBLIOT'] == 'O')
                                                                echo 'selected'; ?>>Outro</option>
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

</body>

</html>