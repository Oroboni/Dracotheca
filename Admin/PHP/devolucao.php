<?php
include 'conecta_DB.php';

$tombo = $_POST['tombo'] ?? null;
$ra = $_POST['ra'] ?? null;
$penalidade = isset($_POST['penalidade']) ? strtolower($_POST['penalidade']) : null;
$diasSuspensao = $_POST['dias'] ?? 0;
$reserva = isset($_POST['reserva']) ? strtolower($_POST['reserva']) : null;
$renovar = isset($_POST['renovar']) ? strtolower($_POST['renovar']) : null;
$obs = $_POST['obs'] ?? null;

// Verificar se todos os campos obrigatórios foram preenchidos
if (!$tombo || !$ra || !$penalidade || !$reserva || !$renovar) {
    echo "<script>
        alert('Erro: Todos os campos obrigatórios devem ser preenchidos!');
        window.history.back();
    </script>";
    exit();
}

// Verificar se o aluno existe
$queryAluno = "SELECT 1 FROM aluno WHERE RA_ALUNO = ?";
$stmtAluno = mysqli_prepare($conn, $queryAluno);
mysqli_stmt_bind_param($stmtAluno, "i", $ra);
mysqli_stmt_execute($stmtAluno);
$resultAluno = mysqli_stmt_get_result($stmtAluno);

if (mysqli_num_rows($resultAluno) === 0) {
    echo "<script>
        alert('Erro: Aluno não encontrado no sistema.');
        window.history.back();
    </script>";
    exit();
}
mysqli_stmt_close($stmtAluno);

// Verificar se o livro existe
$queryLivro = "SELECT 1 FROM livro WHERE TOMBO_LIV = ?";
$stmtLivro = mysqli_prepare($conn, $queryLivro);
mysqli_stmt_bind_param($stmtLivro, "i", $tombo);
mysqli_stmt_execute($stmtLivro);
$resultLivro = mysqli_stmt_get_result($stmtLivro);

if (mysqli_num_rows($resultLivro) === 0) {
    echo "<script>
        alert('Erro: Livro não encontrado no sistema.');
        window.history.back();
    </script>";
    exit();
}
mysqli_stmt_close($stmtLivro);

// Lógica principal caso aluno e livro existam
mysqli_begin_transaction($conn);

try {
    $queryDevolucao = "INSERT INTO devolucao (ID_EMPREST, DT_DEVOL, PENALIDADE_DEVOL, SUSPENSAO_DEVOL, RESERVAR_DEVOL, RENOVAR_DEVOL, OBS_DEVOL)
                SELECT e.ID_EMPREST, NOW(), ?, ?, ?, ?, ?
                FROM emprestimos e
                JOIN aluno a ON e.FK_ID_ALUNO = a.ID_ALUNO AND a.RA_ALUNO = ?
                WHERE e.FK_TOMBO_LIV = ?
                LIMIT 1";

    $stmtDevolucao = mysqli_prepare($conn, $queryDevolucao);
    if (!$stmtDevolucao) {
        throw new Exception("Erro ao preparar a query de devolução.");
    }

    mysqli_stmt_bind_param($stmtDevolucao, "sssssss", $penalidade, $diasSuspensao, $reserva, $renovar, $obs, $ra, $tombo);
    if (!mysqli_stmt_execute($stmtDevolucao)) {
        throw new Exception("Erro ao registrar a devolução.");
    }
    mysqli_stmt_close($stmtDevolucao);

    $queryUpdateLivro = "UPDATE livro SET DISPON_LIV = 'Disponível' WHERE TOMBO_LIV = ?";
    $stmtUpdateLivro = mysqli_prepare($conn, $queryUpdateLivro);
    if (!$stmtUpdateLivro) {
        throw new Exception("Erro ao preparar a query de atualização do livro.");
    }

    mysqli_stmt_bind_param($stmtUpdateLivro, "i", $tombo);
    if (!mysqli_stmt_execute($stmtUpdateLivro)) {
        throw new Exception("Erro ao atualizar a disponibilidade do livro.");
    }
    mysqli_stmt_close($stmtUpdateLivro);

    $queryDeleteEmprestimo = "DELETE FROM emprestimos WHERE FK_TOMBO_LIV = ? AND FK_ID_ALUNO = (SELECT ID_ALUNO FROM aluno WHERE RA_ALUNO = ?)";
    $stmtDeleteEmprestimo = mysqli_prepare($conn, $queryDeleteEmprestimo);
    if (!$stmtDeleteEmprestimo) {
        throw new Exception("Erro ao preparar a query de remoção do empréstimo.");
    }

    mysqli_stmt_bind_param($stmtDeleteEmprestimo, "ii", $tombo, $ra);
    if (!mysqli_stmt_execute($stmtDeleteEmprestimo)) {
        throw new Exception("Erro ao remover o empréstimo.");
    }
    mysqli_stmt_close($stmtDeleteEmprestimo);

    mysqli_commit($conn);

    echo "<script>
        alert('Devolução registrada com sucesso!');
        window.location.href='../devolucao.php';
    </script>";
    exit();

} catch (Exception $e) {
    mysqli_rollback($conn);

    echo "<script>
        alert('Erro: " . addslashes($e->getMessage()) . "');
        window.history.back();
    </script>";
    exit();
}