<?php
include 'conecta_DB.php';
session_start();

$idAluno = intval($_SESSION['id']);

$queryCheck = "SELECT ID_EMPREST, FK_TOMBO_LIV FROM emprestimos WHERE FK_ID_ALUNO = ?";
$stmt = mysqli_prepare($conn, $queryCheck);
mysqli_stmt_bind_param($stmt, "i", $idAluno);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$emprestimo = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$idEmprestimo = intval($emprestimo['ID_EMPREST']);
$queryRenovar = "UPDATE emprestimos SET DT_DEVOLUCAO = DATE_ADD(DT_DEVOLUCAO, INTERVAL 7 DAY) WHERE ID_EMPREST = ?";
$stmt = mysqli_prepare($conn, $queryRenovar);
mysqli_stmt_bind_param($stmt, "i", $idEmprestimo);
$success = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$idLivro = intval($_GET['idLivro']);
header("Location: ../detalhesLivro.php?id=$idLivro");
exit();
