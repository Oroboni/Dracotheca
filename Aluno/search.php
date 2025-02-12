<?php
include __DIR__. '/conecta_DB.php';

$query = $_GET['query'] ?? '';
$author = $_GET['author'] ?? '';
$editora = $_GET['editora'] ?? '';
$curso = $_GET['curso'] ?? '';
$ano = $_GET['data'] ?? '';

$sql = "SELECT TOMBO_LIV, TITULO_LIV, FOTO_LIV, AUTOR_LIV, EDITORA_LIV, CURSO_LIV, YEAR(DTLANCAM_LIV) AS ANO_PUBLICACAO FROM livro WHERE 1=1";
$conditions = [];
$params = [];
$types = '';

if (!empty($query)) {
    $conditions[] = "TITULO_LIV LIKE ?";
    $params[] = "%$query%";
    $types .= 's';
}

if (!empty($author)) {
    $conditions[] = "AUTOR_LIV = ?";
    $params[] = $author;
    $types .= 's';
}

if (!empty($editora)) {
    $conditions[] = "EDITORA_LIV = ?";
    $params[] = $editora;
    $types .= 's';
}

if (!empty($curso)) {
    $conditions[] = "CURSO_LIV = ?";
    $params[] = $curso;
    $types .= 's';
}

if (!empty($ano)) {
    $conditions[] = "YEAR(DTLANCAM_LIV) = ?";
    $params[] = $ano;
    $types .= 's';
}

if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}
$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {
    $bindResult = mysqli_stmt_bind_param($stmt, $types, ...$params);
}

$executeResult = mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$livros = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($livros);
exit();