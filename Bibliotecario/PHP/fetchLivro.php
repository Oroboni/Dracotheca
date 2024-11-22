<?php
include 'conecta_DB.php';

if (isset($_GET['tombo'])) {
    $tombo = intval($_GET['tombo']);

    $query = "SELECT TITULO_LIV, EDICAO_LIV FROM livro WHERE TOMBO_LIV = ?";
    $query = "SELECT TITULO_LIV, EDICAO_LIV, FOTO_LIV FROM livro WHERE TOMBO_LIV = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $tombo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livro = mysqli_fetch_assoc($result);

    if ($livro) {
        echo json_encode([
            "success" => true,
            "titulo" => $livro['TITULO_LIV'],
            "edicao" => $livro['EDICAO_LIV'],
            "foto" => !empty($livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'
        ]);
    } else {
        echo json_encode(["success" => false]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}