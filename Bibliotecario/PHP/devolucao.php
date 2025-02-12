<?php
include __DIR__. '/conecta_DB.php';

// Captura os dados do formulário
$tombo = $_POST['tombo'] ?? null;
$ra = $_POST['ra'] ?? null;
$penalidade = isset($_POST['penalidade']) ? strtolower($_POST['penalidade']) : null;
$diasSuspensao = $_POST['dias'] ?? 0;
$reserva = isset($_POST['reserva']) ? strtolower($_POST['reserva']) : null;
$renovar = isset($_POST['renovar']) ? strtolower($_POST['renovar']) : null;
$obs = $_POST['obs'] ?? null;

// Verificar se o aluno existe
$queryAluno = "SELECT ID_ALUNO FROM aluno WHERE RA_ALUNO = ?";
$stmtAluno = mysqli_prepare($conn, $queryAluno);
mysqli_stmt_bind_param($stmtAluno, "i", $ra);
mysqli_stmt_execute($stmtAluno);
$resultAluno = mysqli_stmt_get_result($stmtAluno);

if (mysqli_num_rows($resultAluno) === 0) {
    echo "<script>alert('Erro: RA do aluno não encontrado.'); window.history.back();</script>";
    exit();
}

$aluno = mysqli_fetch_assoc($resultAluno);
$idAluno = $aluno['ID_ALUNO'];
mysqli_stmt_close($stmtAluno);

// Verificar se o livro existe
$queryLivro = "SELECT TOMBO_LIV, DISPON_LIV FROM livro WHERE TOMBO_LIV = ?";
$stmtLivro = mysqli_prepare($conn, $queryLivro);
mysqli_stmt_bind_param($stmtLivro, "i", $tombo);
mysqli_stmt_execute($stmtLivro);
$resultLivro = mysqli_stmt_get_result($stmtLivro);

if (mysqli_num_rows($resultLivro) === 0) {
    echo "<script>alert('Erro: Livro não encontrado no sistema.'); window.history.back();</script>";
    exit();
}

$livro = mysqli_fetch_assoc($resultLivro);
mysqli_stmt_close($stmtLivro);

// Verificar se há empréstimo ativo para o aluno e o livro
$queryEmprestimo = "SELECT ID_EMPREST FROM emprestimos WHERE FK_ID_ALUNO = ? AND FK_TOMBO_LIV = ? AND DEVOLVIDO = 'n'";
$stmtEmprestimo = mysqli_prepare($conn, $queryEmprestimo);
mysqli_stmt_bind_param($stmtEmprestimo, "ii", $idAluno, $tombo);
mysqli_stmt_execute($stmtEmprestimo);
$resultEmprestimo = mysqli_stmt_get_result($stmtEmprestimo);

if (mysqli_num_rows($resultEmprestimo) === 0) {
    echo "<script>alert('Erro: Não há empréstimos ativos para este aluno e livro.'); window.history.back();</script>";
    exit();
}

$emprestimo = mysqli_fetch_assoc($resultEmprestimo);
$idEmprest = $emprestimo['ID_EMPREST'];
mysqli_stmt_close($stmtEmprestimo);

mysqli_begin_transaction($conn);

try {
    $queryDevolucao = "INSERT INTO devolucao (ID_EMPREST, DT_DEVOL, PENALIDADE_DEVOL, SUSPENSAO_DEVOL, RESERVAR_DEVOL, RENOVAR_DEVOL, OBS_DEVOL)
                       VALUES (?, NOW(), ?, ?, ?, ?, ?)";
    $stmtDevolucao = mysqli_prepare($conn, $queryDevolucao);
    if (!$stmtDevolucao) {
        throw new Exception("Erro ao preparar a query de devolução.");
    }
    mysqli_stmt_bind_param($stmtDevolucao, "isssss", $idEmprest, $penalidade, $diasSuspensao, $reserva, $renovar, $obs);
    if (!mysqli_stmt_execute($stmtDevolucao)) {
        throw new Exception("Erro ao registrar a devolução.");
    }
    mysqli_stmt_close($stmtDevolucao);

    $queryUpdateEmprestimo = "UPDATE emprestimos SET DEVOLVIDO = 's' WHERE ID_EMPREST = ?";
    $stmtUpdateEmprestimo = mysqli_prepare($conn, $queryUpdateEmprestimo);
    mysqli_stmt_bind_param($stmtUpdateEmprestimo, "i", $idEmprest);
    if (!mysqli_stmt_execute($stmtUpdateEmprestimo)) {
        throw new Exception("Erro ao atualizar o status do empréstimo.");
    }
    mysqli_stmt_close($stmtUpdateEmprestimo);

    $queryUpdateLivro = "UPDATE livro SET DISPON_LIV = 'd' WHERE TOMBO_LIV = ?";
    $stmtUpdateLivro = mysqli_prepare($conn, $queryUpdateLivro);
    mysqli_stmt_bind_param($stmtUpdateLivro, "i", $tombo);
    if (!mysqli_stmt_execute($stmtUpdateLivro)) {
        throw new Exception("Erro ao atualizar a disponibilidade do livro.");
    }
    mysqli_stmt_close($stmtUpdateLivro);

    mysqli_commit($conn);

    echo "<script>alert('Devolução registrada com sucesso!'); window.location.href='../devolucao.php';</script>";
    exit();
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Erro: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    exit();
} finally {
    mysqli_close($conn);
}
