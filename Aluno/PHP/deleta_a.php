<?php
include 'conecta_DB.php';

$id = intval($_POST['id']); 

$checkLoanQuery = "SELECT COUNT(*) as total FROM emprestimos WHERE FK_ID_ALUNO = ?";
$stmtCheckLoan = mysqli_prepare($conn, $checkLoanQuery);
mysqli_stmt_bind_param($stmtCheckLoan, "i", $id);
mysqli_stmt_execute($stmtCheckLoan);
$resultCheckLoan = mysqli_stmt_get_result($stmtCheckLoan);
$row = mysqli_fetch_assoc($resultCheckLoan);
mysqli_stmt_close($stmtCheckLoan);

if ($row['total'] > 0) {
    echo "<script>alert('Você não pode excluir sua conta enquanto possui livros emprestados!'); window.history.back();</script>";
    mysqli_close($conn);
    exit();
}

$deleteQueueQuery = "DELETE FROM fila WHERE ID_ALUNO = ?"; 
$stmtDeleteQueue = mysqli_prepare($conn, $deleteQueueQuery);
mysqli_stmt_bind_param($stmtDeleteQueue, "i", $id);
mysqli_stmt_execute($stmtDeleteQueue);
mysqli_stmt_close($stmtDeleteQueue);

$deleteAlunoQuery = "DELETE FROM aluno WHERE ID_ALUNO = ?";
$stmtDeleteAluno = mysqli_prepare($conn, $deleteAlunoQuery);
mysqli_stmt_bind_param($stmtDeleteAluno, "i", $id);
mysqli_stmt_execute($stmtDeleteAluno);
mysqli_stmt_close($stmtDeleteAluno);

mysqli_close($conn);

echo "<script>alert('Conta excluída com sucesso!'); window.location.href = '../../index.php';</script>";
header("Location: ../../index.php");
exit();