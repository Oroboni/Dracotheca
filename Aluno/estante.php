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
    <link rel="stylesheet" href="../src/css/estante.css">

    <title>Dracotheca</title>
    <link rel="icon" href="./src/img/logo.png" type="image/png">
    
    <?php
    include 'conecta_DB.php';
    session_start();

    $idAluno = intval($_SESSION['id']);

    $queryLendoAgora = "SELECT l.TITULO_LIV, l.FOTO_LIV, e.FK_TOMBO_LIV
    FROM emprestimos e
    INNER JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
    WHERE e.FK_ID_ALUNO = ? AND e.DT_DEVOLUCAO >= NOW()";

    $stmtLendoAgora = mysqli_prepare($conn, $queryLendoAgora);
    mysqli_stmt_bind_param($stmtLendoAgora, "i", $idAluno);
    mysqli_stmt_execute($stmtLendoAgora);
    $resultLendoAgora = mysqli_stmt_get_result($stmtLendoAgora);
    $lendoAgora = mysqli_fetch_all($resultLendoAgora, MYSQLI_ASSOC);
    mysqli_stmt_close($stmtLendoAgora);

    $queryFila = "SELECT l.TITULO_LIV, l.FOTO_LIV, f.TOMBO_LIV
    FROM fila f
    INNER JOIN livro l ON f.TOMBO_LIV = l.TOMBO_LIV
    WHERE f.ID_ALUNO = ?";

    $stmtFila = mysqli_prepare($conn, $queryFila);
    mysqli_stmt_bind_param($stmtFila, "i", $idAluno);
    mysqli_stmt_execute($stmtFila);
    $resultFila = mysqli_stmt_get_result($stmtFila);
    $filaEspera = mysqli_fetch_all($resultFila, MYSQLI_ASSOC);
    mysqli_stmt_close($stmtFila);

    $queryDevolvidos = "SELECT l.TITULO_LIV, l.FOTO_LIV, e.FK_TOMBO_LIV
    FROM devolucao d
    INNER JOIN emprestimos e ON d.ID_EMPREST = e.ID_EMPREST
    INNER JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
    WHERE e.FK_ID_ALUNO = ?";

    $stmtDevolvidos = mysqli_prepare($conn, $queryDevolvidos);
    mysqli_stmt_bind_param($stmtDevolvidos, "i", $idAluno);
    mysqli_stmt_execute($stmtDevolvidos);
    $resultDevolvidos = mysqli_stmt_get_result($stmtDevolvidos);
    $livrosDevolvidos = mysqli_fetch_all($resultDevolvidos, MYSQLI_ASSOC);
    mysqli_stmt_close($stmtDevolvidos);
    ?>
</head>

<body>
    <div>
        <nav class="navbar" id="sidebar">
            <?php include "sidebar.php"; ?>
        </nav>
    </div>
    <div class="">
        <div class="titulo">
            <h1>Minha Estante</h1>
        </div>
    </div>
    <div class="estanteContainer">
        <!-- Lendo Agora -->
        <div class="section">
            <div class="section-header">
                <h2 class="subtitulo">Lendo agora</h2>
            </div>
            <div class="books-row">
                <?php foreach ($lendoAgora as $livro): ?>
                    <a href="./detalhesLivro.php?id=<?php echo $livro['FK_TOMBO_LIV']; ?>" class="bookEstante">
                        <img src="<?php echo !empty($livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" alt="<?php echo htmlspecialchars($livro['TITULO_LIV']); ?>">
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="retangulo"></div>
        </div>

        <!-- Fila de Espera -->
        <div class="section">
            <div class="section-header">
                <h2 class="subtitulo">Fila de Espera</h2>
            </div>
            <div class="books-row">
                <?php foreach ($filaEspera as $livro): ?>
                    <a href="./detalhesLivro.php?id=<?php echo $livro['TOMBO_LIV']; ?>" class="bookEstante">
                        <img src="<?php echo !empty($livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" alt="<?php echo htmlspecialchars($livro['TITULO_LIV']); ?>">
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="retangulo"></div>
        </div>

        <!-- Livros Devolvidos -->
        <div class="section">
            <div class="section-header">
                <h2 class="subtitulo">Livros Devolvidos</h2>
            </div>
            <div class="books-row">
                <?php foreach ($livrosDevolvidos as $livro): ?>
                    <a href="./detalhesLivro.php?id=<?php echo $livro['FK_TOMBO_LIV']; ?>" class="bookEstante">
                        <img src="<?php echo !empty($livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" alt="<?php echo htmlspecialchars($livro['TITULO_LIV']); ?>">
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="retangulo"></div>
        </div>
    </div>
    </div>
</body>