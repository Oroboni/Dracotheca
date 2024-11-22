<?php
include 'conecta_DB.php';
session_start();

$idLivro = $_GET['idLivro'];
$idAluno = $_SESSION['id'];

$queryCheckFila = "SELECT * FROM fila WHERE TOMBO_LIV = ? AND ID_ALUNO = ?";
$stmtCheckFila = mysqli_prepare($conn, $queryCheckFila);
mysqli_stmt_bind_param($stmtCheckFila, "ii", $idLivro, $idAluno);
mysqli_stmt_execute($stmtCheckFila);
$resultCheckFila = mysqli_stmt_get_result($stmtCheckFila);
$jaNaFila = mysqli_fetch_assoc($resultCheckFila);
mysqli_stmt_close($stmtCheckFila);

if ($jaNaFila) {
    header("Location: ../detalhesLivro.php?id=$idLivro&msg=jaNaFila");
    exit();
}

$queryPosicao = "SELECT COUNT(*) + 1 AS proxima_posicao FROM fila WHERE TOMBO_LIV = ?";
$stmtPosicao = mysqli_prepare($conn, $queryPosicao);
mysqli_stmt_bind_param($stmtPosicao, "i", $idLivro);
mysqli_stmt_execute($stmtPosicao);
$resultPosicao = mysqli_stmt_get_result($stmtPosicao);
$posicao = mysqli_fetch_assoc($resultPosicao)['proxima_posicao'];
mysqli_stmt_close($stmtPosicao);

$queryFila = "INSERT INTO fila (TOMBO_LIV, ID_ALUNO, QUANT_ALUNO, POSICAO_ALUNO, DT_RESERVA, DT_EXPIRACAO) 
              VALUES (?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY))";
$stmtFila = mysqli_prepare($conn, $queryFila);
mysqli_stmt_bind_param($stmtFila, "iiii", $idLivro, $idAluno, $posicao, $posicao);
$success = mysqli_stmt_execute($stmtFila);
mysqli_stmt_close($stmtFila);

header("Location: ../detalhesLivro.php?id=$idLivro&msg=sucesso");
exit();