<?php
include 'conecta_DB.php';

$id = intval($_GET['id']); 

$sql = "DELETE FROM aluno WHERE ID_ALUNO = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($conn);

header("Location: ../alunos.php");
exit();