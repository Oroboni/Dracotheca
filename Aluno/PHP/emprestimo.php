<?php
include 'conecta_DB.php';
session_start();
$idLivro = intval($_GET['idLivro']);
$idAluno = $_SESSION['id'];

$queryCheck = "SELECT DISPON_LIV FROM livro WHERE TOMBO_LIV = ?";
$stmtCheck = mysqli_prepare($conn, $queryCheck);
mysqli_stmt_bind_param($stmtCheck, "i", $idLivro);
mysqli_stmt_execute($stmtCheck);
$result = mysqli_stmt_get_result($stmtCheck);
$livro = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmtCheck);

if ($livro['DISPON_LIV'] === 'Indisponível') {
    echo "Erro: O livro já está indisponível.";
    exit();
}

$queryRA = "SELECT RA_ALUNO FROM aluno WHERE ID_ALUNO = ?";
$stmtRA = mysqli_prepare($conn, $queryRA);
mysqli_stmt_bind_param($stmtRA, "i", $idAluno);
mysqli_stmt_execute($stmtRA);
$resultRA = mysqli_stmt_get_result($stmtRA);
$alunoRA = mysqli_fetch_assoc($resultRA);
$raAluno = $alunoRA['RA_ALUNO'];

$queryEmprestimo = "INSERT INTO emprestimos (FK_ID_ALUNO, FK_RA_ALUNO, FK_TOMBO_LIV, DT_EMPREST, DT_DEVOLUCAO)
                    VALUES (?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))";
$stmtEmprestimo = mysqli_prepare($conn, $queryEmprestimo);
mysqli_stmt_bind_param($stmtEmprestimo, "iii", $idAluno, $raAluno, $idLivro);
mysqli_stmt_execute($stmtEmprestimo);
mysqli_stmt_close($stmtEmprestimo);

$queryUpdate = "UPDATE livro SET DISPON_LIV = 'Indisponível' WHERE TOMBO_LIV = ?";
$stmtUpdate = mysqli_prepare($conn, $queryUpdate);
mysqli_stmt_bind_param($stmtUpdate, "i", $idLivro);
mysqli_stmt_execute($stmtUpdate);
mysqli_stmt_close($stmtUpdate);

$queryCheckFila = "SELECT COUNT(*) AS count FROM fila WHERE TOMBO_LIV = ? AND ID_ALUNO = ?";
$stmtCheckFila = mysqli_prepare($conn, $queryCheckFila);
mysqli_stmt_bind_param($stmtCheckFila, "ii", $idLivro, $idAluno);
mysqli_stmt_execute($stmtCheckFila);
$resultCheckFila = mysqli_stmt_get_result($stmtCheckFila);
$fila = mysqli_fetch_assoc($resultCheckFila);
mysqli_stmt_close($stmtCheckFila);

if ($fila['count'] > 0) {
    $queryDeleteFila = "DELETE FROM fila WHERE TOMBO_LIV = ? AND ID_ALUNO = ?";
    $stmtDeleteFila = mysqli_prepare($conn, $queryDeleteFila);
    mysqli_stmt_bind_param($stmtDeleteFila, "ii", $idLivro, $idAluno);
    mysqli_stmt_execute($stmtDeleteFila);
    mysqli_stmt_close($stmtDeleteFila);
}

mysqli_commit($conn);
header("Location: ../estante.php");
exit(); 