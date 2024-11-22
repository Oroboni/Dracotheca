<?php
include 'conecta_DB.php';

$raAluno = $_POST['idAluno'];
$idLivro = $_POST['idLivro']; 
$idBibliot = $_SESSION['id']; 

$query = "SELECT ID_ALUNO FROM aluno WHERE RA_ALUNO = ?";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $raAluno);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && $aluno = mysqli_fetch_assoc($result)) {
    $idAluno = $aluno['ID_ALUNO'];
} else {
    echo "<script>alert('Aluno não encontrado com o RA fornecido!'); window.history.back();</script>";
}
mysqli_stmt_close($stmt);

$query = "INSERT INTO emprestimos (FK_ID_ALUNO, FK_RA_ALUNO, FK_ID_BIBLIOT, FK_TOMBO_LIV, DT_EMPREST, DT_DEVOLUCAO)
          VALUES (?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "iiii", $idAluno, $raAluno, $idBibliot, $idLivro);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    $queryUpdateLivro = "UPDATE livro SET DISPON_LIV = 'Indisponível' WHERE TOMBO_LIV = ?";
    $stmtUpdateLivro = mysqli_prepare($conn, $queryUpdateLivro);

    if (!$stmtUpdateLivro) {
        echo "<script>alert('Erro ao preparar a atualização!'); window.history.back();</script>";
    }

    mysqli_stmt_bind_param($stmtUpdateLivro, "i", $idLivro);
    mysqli_stmt_execute($stmtUpdateLivro);
    mysqli_stmt_close($stmtUpdateLivro);

    echo "<script>alert('Empréstimo registrado com sucesso!'); window.history.back();</script>";
} else {
    echo "<script>alert('Erro ao registrar o empréstimo!'); window.history.back();</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
header("Location: ../vincular.php");
exit();