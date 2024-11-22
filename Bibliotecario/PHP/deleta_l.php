<?php
include 'conecta_DB.php';

$id = intval($_POST['id']); 

$query = "SELECT COUNT(*) FROM emprestimos WHERE FK_TOMBO_LIV = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $emprestado);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($emprestado > 0) {
    echo "<script>alert('Erro: Não é possível apagar um livro que está emprestado!'); window.history.back();</script>";
    exit();
}

$query = "SELECT FOTO_LIV FROM livro WHERE TOMBO_LIV = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $img);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$pasta = "../../src/img/books/";
$filePath = $pasta . $img;

if ($img && file_exists($filePath)) {
    unlink($filePath);
}

$sql = "DELETE FROM livro WHERE TOMBO_LIV = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($conn);

header("Location: ../livros.php");
exit();