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
    <link rel="stylesheet" href="../src/css/historicoLivros.css">

    <title>Dracotheca</title>

    <style>
        .container-livro:hover{
            display: flex;
            width: 95%;
            height: auto;
            background-color: rgba(208, 172, 172, 0.653) !important;
            transition: 0.5s;
            color: #000;
            align-content: center;
            padding: 20px;
            margin-bottom: 2%;
            margin-left: 14px;
            border: 1px solid #000;
            border-radius: 10px;
            text-align: left;
        }

        .subtitulo{
            color: #221134;
            font-family: Poppins;
            font-size: 36px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            margin-left: 50px;
            margin-left: 30px;
        }
    </style>

    <?php
    include 'conecta_DB.php';
    session_start();

    $idAluno = $_SESSION['id'];

    $query = "SELECT l.TOMBO_LIV, l.TITULO_LIV AS titulo, l.FOTO_LIV, e.DT_EMPREST AS dataEmprestimo, e.DT_DEVOLUCAO AS prazoEntrega, d.DT_DEVOL AS dataDevolucao,
        CASE 
            WHEN d.DT_DEVOL IS NOT NULL THEN 'Devolvido'
            WHEN e.DT_DEVOLUCAO < NOW() THEN 'Em atraso'
            ELSE 'Não devolvido'
        END AS estado
    FROM emprestimos e
    JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
    LEFT JOIN devolucao d ON e.ID_EMPREST = d.ID_EMPREST
    WHERE e.FK_ID_ALUNO = ?
    ORDER BY e.DT_EMPREST DESC";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idAluno);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $historico = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $historico[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    ?>
</head>

<body>
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container">
        <div class="tituloH">
            <h1>Histórico de livros</h1>
        </div>

        <?php foreach ($historico as $livro): ?>
            <button class="container-livro row-align-items-start" onclick="location.href='./detalhesLivro.php?id=<?php echo $livro['TOMBO_LIV']?>'">
                <h1 class="col-2">
                <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                </h1>
                <div class="col-7"> 
                    <h3 class="subtitulo"><?php echo htmlspecialchars($livro['titulo']); ?></h3>
                    <div>
                        <p class="subtitulo-2">Pego em: <?php echo date('d/m/Y', strtotime($livro['dataEmprestimo'])); ?></p>
                        <p class="subtitulo-2">Prazo de entrega: <?php echo date('d/m/Y', strtotime($livro['prazoEntrega'])); ?></p>
                        <?php if ($livro['estado'] === 'Devolvido'): ?>
                            <p class="subtitulo-3">Devolvido em: <?php echo date('d/m/Y', strtotime($livro['dataDevolucao'])); ?></p>
                        <?php endif; ?>
                    </div>                
                </div>
                <div class="col-6 align-self-center">
                    <h2 class="subtitulo-4 col-6">
                        <?php if ($livro['estado'] === 'Devolvido'): ?>
                            <img class="estadoImg col-2" src="./src/img/icons/histDevol.png" alt="Devolvido">
                            Devolvido
                        <?php elseif ($livro['estado'] === 'Em atraso'): ?>
                            <img class="estadoImg col-2" src="./src/img/icons/histAlert.png" alt="Em Atraso">
                            Em atraso
                        <?php else: ?>
                            <img class="estadoImg col-2" src="./src/img/icons/naoDevol.png" alt="Não Devolvido">
                            Não devolvido
                        <?php endif; ?>
                    </h2>
                </div>
            </button>
        <?php endforeach; ?>
    </div>
</div>

</body>
