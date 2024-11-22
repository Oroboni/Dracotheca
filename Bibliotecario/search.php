<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file search.php
    *   @description Código PHP que realiza uma busca avançada de livros na base de dados com base nos parâmetros fornecidos via URL (query, author, editora, categoria, ano).
    */
-->
<?php
include 'conecta_DB.php';

$query = $_GET['query'] ?? '';
$author = $_GET['author'] ?? '';
$editora = $_GET['editora'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$ano = $_GET['ano'] ?? '';

$sql = "SELECT TOMBO_LIV, TITULO_LIV, FOTO_LIV FROM livro WHERE TITULO_LIV LIKE ?";
$params = ["%$query%"];

if (!empty($author)) {
    $sql .= " AND AUTOR_LIV = ?";
    $params[] = $author;
}
if (!empty($editora)) {
    $sql .= " AND EDITORA_LIV = ?";
    $params[] = $editora;
}
if (!empty($categoria)) {
    $sql .= " AND CURSO_LIV = ?";
    $params[] = $categoria;
}
if (!empty($ano)) {
    $sql .= " AND YEAR(DTLANCAM_LIV) = ?";
    $params[] = $ano;
}

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$livros = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($livros);
exit();