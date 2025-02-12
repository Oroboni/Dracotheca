<?php
include __DIR__. '/conecta_DB.php';

session_start();

try {
    $queryEmprestimos = "SELECT e.ID_EMPREST, l.TITULO_LIV, e.DT_EMPREST, e.DT_DEVOLUCAO, e.FK_TOMBO_LIV, e.FK_ID_ALUNO, l.FOTO_LIV FROM emprestimos e JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV";
    $stmtEmprestimos = mysqli_prepare($conn, $queryEmprestimos);
    mysqli_stmt_execute($stmtEmprestimos);
    $resultEmprestimos = mysqli_stmt_get_result($stmtEmprestimos);

    if (!$resultEmprestimos) {
        throw new Exception("Erro na consulta de empréstimos: " . $conn->error);
    }

    $notifications = [];
    while ($emprestimo = $resultEmprestimos->fetch_assoc()) {
        $idEmprestimo = $emprestimo['ID_EMPREST'];

        $queryDevolucao = "SELECT ID_EMPREST FROM devolucao WHERE ID_EMPREST = ?";
        $stmtDevolucao = mysqli_prepare($conn, $queryDevolucao);
        mysqli_stmt_bind_param($stmtDevolucao, "i", $idEmprestimo);
        mysqli_stmt_execute($stmtDevolucao);
        $resultDevolucao = mysqli_stmt_get_result($stmtDevolucao);
        $devolucao = mysqli_fetch_assoc($resultDevolucao);
        mysqli_stmt_close($stmtDevolucao);

        $isDevolvido = $devolucao !== null;
        $dataAtual = new DateTime();
        $dataDevolucao = new DateTime($emprestimo['DT_DEVOLUCAO']);
        $intervalo = $dataAtual->diff($dataDevolucao)->days;
        $situacao =  null;


        if (!$isDevolvido) {
            if ($dataDevolucao < $dataAtual) {
                $situacao = 'expirado';
            } elseif ($dataDevolucao >= $dataAtual && $intervalo == 2) {
                $situacao = 'expirando';
            }
        }

        if ($situacao !== null) {
            $notifications[] = [
                'situacao' => $situacao,
                'titulo' => $emprestimo['TITULO_LIV'],
                'data' => date('d/m/Y - H:i:s', strtotime($emprestimo['DT_DEVOLUCAO'])),
                'foto' => $emprestimo['FOTO_LIV'],
                'data_emprestimo' => date('d/m/Y', strtotime($emprestimo['DT_EMPREST'])),
                'data_devolucao' => date('d/m/Y', strtotime($emprestimo['DT_DEVOLUCAO']))
            ];
        }
    }
} catch (Exception $e) {
    $notifications = [];
    $error = $e->getMessage();
}