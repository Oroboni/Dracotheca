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
    <link rel="stylesheet" href="../src/css/detalhesLivro.css">

    <title>Dracotheca</title>
    <link rel="icon" href="./src/img/logo.png" type="image/png">

    <?php
    include 'conecta_DB.php';

    session_start();

    $id = $_GET['id'];

    $query = "SELECT * FROM livro WHERE TOMBO_LIV = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livro = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $disponibilidade = $livro['DISPON_LIV'];

    $idAluno = intval($_SESSION['id']);
    $queryEmprestimo = "SELECT * FROM emprestimos WHERE FK_ID_ALUNO = ? AND FK_TOMBO_LIV = ? AND DT_DEVOLUCAO >= NOW()";
    $stmtEmprestimo = mysqli_prepare($conn, $queryEmprestimo);
    mysqli_stmt_bind_param($stmtEmprestimo, "ii", $idAluno, $id);
    mysqli_stmt_execute($stmtEmprestimo);
    $resultEmprestimo = mysqli_stmt_get_result($stmtEmprestimo);
    $emprestimoAtual = mysqli_fetch_assoc($resultEmprestimo);
    mysqli_stmt_close($stmtEmprestimo);

    $queryCheckFila = "SELECT * FROM fila WHERE TOMBO_LIV = ? AND ID_ALUNO = ?";
    $stmtCheckFila = mysqli_prepare($conn, $queryCheckFila);
    mysqli_stmt_bind_param($stmtCheckFila, "ii", $livro['TOMBO_LIV'], $idAluno);
    mysqli_stmt_execute($stmtCheckFila);
    $resultCheckFila = mysqli_stmt_get_result($stmtCheckFila);
    $jaNaFila = mysqli_fetch_assoc($resultCheckFila);
    mysqli_stmt_close($stmtCheckFila);

    $posicao = null;
    if ($jaNaFila) {
        $queryPosicaoFila = "SELECT COUNT(*) + 1 AS posicao FROM fila WHERE TOMBO_LIV = ? AND ID_ALUNO < ?";
        $stmtPosicaoFila = mysqli_prepare($conn, $queryPosicaoFila);
        mysqli_stmt_bind_param($stmtPosicaoFila, "ii", $livro['TOMBO_LIV'], $idAluno);
        mysqli_stmt_execute($stmtPosicaoFila);
        $resultPosicaoFila = mysqli_stmt_get_result($stmtPosicaoFila);
        $posicao = mysqli_fetch_assoc($resultPosicaoFila)['posicao'];
        mysqli_stmt_close($stmtPosicaoFila);
    }
    ?>
</head>

<body>
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container-detalhes">
        <div class="titulo">
            <button type="button" class="voltar" onclick="history.back()">
                <img src="./src/img/icons/retornar.png" alt="voltar">
            </button>
            <h1>Detalhes</h1>
        </div>

        <div class="background1">
            <div class="background2">
                <div class="background3">
                    <div class="container">
                        <div class="row">
                            <div class="col btns">
                                <!-- Disponibilidade - Botões -->
                                <?php if ($disponibilidade === 'Disponível'): ?>
                                    <a href="./PHP/emprestimo.php?idLivro=<?php echo $livro['TOMBO_LIV']; ?>" class="btn dispo disponivel">
                                        Realizar Empréstimo <img src="./src/img/icons/emoji-happy.png" alt="Disponível" class="btn-icon">
                                    </a>
                                <?php elseif ($emprestimoAtual): ?>
                                    <button class="btn dispo posse" disabled>
                                        Em Posse <img src="./src/img/icons/book-saved.png" alt="Em Posse" class="btn-icon">
                                    </button>
                                <?php elseif ($jaNaFila): ?>
                                    <button class="btn dispo fila" disabled>
                                        Já na Fila <img src="./src/img/icons/tick-circle.png" alt="Já na Fila" class="btn-icon">
                                    </button>
                                <?php else: ?>
                                    <a href="./PHP/fila.php?idLivro=<?php echo $livro['TOMBO_LIV']; ?>" class="btn dispo fila">
                                        Entrar na Fila <img src="./src/img/icons/heart-fila.png" alt="Fila" class="btn-icon">
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                        <?php if ($emprestimoAtual): ?>
                            <hr>
                            <div class="row esp">
                                <div class="col">
                                    <h3>Dt. de Empréstimo</h3>
                                    <p><?php echo date('d/m/Y', strtotime($emprestimoAtual['DT_EMPREST'])); ?></p>
                                </div>
                                <div class="col">
                                    <h3>Dt. de Devolução</h3>
                                    <p><?php echo date('d/m/Y', strtotime($emprestimoAtual['DT_DEVOLUCAO'])); ?></p>
                                </div>
                            </div>
                            <hr>
                        <?php endif; ?>
                        <div class="row esp">
                            <!-- O que aparece quando o usuário entra na fila -->
                            <?php if ($disponibilidade === 'Indisponivel'): ?>
                                <div class="col">
                                    <h3>Posição na fila</h3>
                                    <p><?php echo $posicao ? $posicao . 'º' : 'N/A'; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row esp">
                            <div class="col">
                                <h3>Autor(a)</h3>
                                <p><?php echo htmlspecialchars($livro['AUTOR_LIV']); ?></p>
                            </div>
                            <div class="col">
                                <h3>Tombo</h3>
                                <p><?php echo htmlspecialchars($livro['TOMBO_LIV']); ?></p>
                            </div>
                        </div>
                        <div class="row esp">
                            <div class="col">
                                <h3>Gênero</h3>
                                <p><?php echo htmlspecialchars($livro['GENERO_LIV']); ?></p>
                            </div>
                            <div class="col">
                                <h3>Dt. Lançamento</h3>
                                <p><?php echo date('d/m/Y', strtotime($livro['DTLANCAM_LIV']));; ?></p>
                            </div>
                        </div>
                        <div class="row esp">
                            <div class="col">
                                <h3>Editora</h3>
                                <p><?php echo htmlspecialchars($livro['EDITORA_LIV']); ?></p>
                            </div>
                            <div class="col">
                                <h3>Edição</h3>
                                <p><?php echo htmlspecialchars($livro['EDICAO_LIV']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="capa" alt="capa">

                <div class="content">
                    <h2><?php echo trim($livro['TITULO_LIV']); ?></h2>
                    <h3>Palavras-chave</h3>
                    <p><?php echo trim($livro['PALAVCHAVE_LIV']); ?></p>
                </div>
            </div>
        </div>

        <!-- Modal - Sucesso -->
        <div class="modal fade" id="renovarPrazo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-custom">
                <div class="modal-content">
                    <div class="text-center">
                        <h3 id="titRenovar">Prazo renovado com <span>sucesso</span>!</h3>
                        <h3 id="prazoFila">Novo prazo: 19/08/24</h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn-modal-ok ok mx-2" data-bs-dismiss="modal">
                            OK <img src="./src/img/icons/verify.png" alt="Renovar" class="btn-icon">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal - Não foi possível -->
        <div class="modal fade" id="naoRenovar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-custom">
                <div class="modal-content">
                    <div class="naoRenovar">
                        <h3 id="titRenovar">Não é possível renovar o prazo<img src="./src/img/icons/sademoji.png" alt="Renovar" class="btn-icon"></h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn-modal-ok nao-ok mx-2" data-bs-dismiss="modal">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../src/javascript/script.js"></script>
</body>

</html>