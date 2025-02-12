<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Access-Control-Allow-Origin: *');

include __DIR__. '/conecta_DB.php';

try {
    $tombo = intval($_GET['tombo']);

    $query = "SELECT TITULO_LIV, EDICAO_LIV, FOTO_LIV FROM livro WHERE TOMBO_LIV = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $tombo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livro = mysqli_fetch_assoc($result);

    $emprestado = false;
    $query = "SELECT DT_EMPREST FROM emprestimos e LEFT JOIN devolucao d ON e.ID_EMPREST = d.ID_EMPREST WHERE e.FK_TOMBO_LIV = ? AND d.ID_EMPREST IS NULL ORDER BY e.DT_EMPREST DESC  LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $tombo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $emprestimo = mysqli_fetch_assoc($result);

    if ($livro) {
        echo json_encode([
            "success" => true,
            "titulo" => $livro['TITULO_LIV'],
            "edicao" => $livro['EDICAO_LIV'],
            "foto" => !empty($livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png',
            "emprestado" => $emprestimo ? true : false,
            "dataEmprestimo" => $emprestimo ? $emprestimo['DT_EMPREST'] : null
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Livro não encontrado"]);
    }

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) mysqli_stmt_close($stmt);
    if (isset($conn)) mysqli_close($conn);
}