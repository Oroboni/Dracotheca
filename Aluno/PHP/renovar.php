<?php
include __DIR__. '/conecta_DB.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo "<script>alert('Sessão expirada. Faça login novamente.'); window.location.href = './login.php';</script>";
    exit();
}

$idAluno = $_SESSION['id'];
$idLivro = $_GET['id'];

$queryCheck = "SELECT ID_EMPREST, FK_TOMBO_LIV, DT_DEVOLUCAO FROM emprestimos 
WHERE FK_ID_ALUNO = ? AND FK_TOMBO_LIV = ? AND ID_EMPREST NOT IN (SELECT ID_EMPREST FROM devolucao)";
$stmt = mysqli_prepare($conn, $queryCheck);
mysqli_stmt_bind_param($stmt, "ii", $idAluno, $idLivro);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$emprestimo = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$emprestimo) {
    echo "<script>alert('Nenhum empréstimo válido encontrado para este livro.'); window.history.back();</script>";
    exit();
}

$idEmprestimo = intval($emprestimo['ID_EMPREST']);
$dataDevolucaoAtual = new DateTime($emprestimo['DT_DEVOLUCAO']);

$dataAtual = new DateTime();
$novaDevolucao = clone $dataDevolucaoAtual;

$diferenca = $dataDevolucaoAtual->diff($dataAtual)->days;
if ($diferenca <= 7) {
    $novaDevolucao->modify('+7 days');
    if ($dataAtual->diff($novaDevolucao)->days > 7) {
        $novaDevolucao = $dataAtual->modify('+7 days');
    }
} else {
    echo "<script>alert('Não é possível renovar o prazo. Já passou do limite de 7 dias.'); window.history.back();</script>";
    exit();
}

$queryAtualizar = "UPDATE emprestimos SET DT_DEVOLUCAO = ? WHERE ID_EMPREST = ?";
$stmt = mysqli_prepare($conn, $queryAtualizar);
$novaDataFormatada = $novaDevolucao->format('Y-m-d');
mysqli_stmt_bind_param($stmt, "si", $novaDataFormatada, $idEmprestimo);
$sucesso = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if ($sucesso) {
    $queryRegistrar = "INSERT INTO renovacao (ID_ALUNO, ID_EMPREST, DT_RENOVACAO) VALUES (?, ?, CURDATE())";
    $stmt = mysqli_prepare($conn, $queryRegistrar);
    mysqli_stmt_bind_param($stmt, "ii", $idAluno, $idEmprestimo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "<script>alert('Livro renovado com sucesso! Novo prazo de devolução: $novaDataFormatada'); window.history.back();</script>";
} else {
    echo "<script>alert('Erro ao renovar o livro. Tente novamente.'); window.history.back();</script>";
}
exit();
