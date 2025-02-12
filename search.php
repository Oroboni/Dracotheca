<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

file_put_contents('search_debug.log', date('[Y-m-d H:i:s] ') . 'Incoming GET: ' . print_r($_GET, true) . "\n", FILE_APPEND);

include 'conecta_DB.php';

mysqli_set_charset($conn, 'utf8mb4');

function sendErrorResponse($message) {
    ob_clean();
    file_put_contents('search_debug.log', date('[Y-m-d H:i:s] ') . 'Error: ' . $message . "\n", FILE_APPEND);
    
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
    exit();
}

$query = isset($_GET['query']) ? trim(strip_tags($_GET['query'])) : '';
$author = isset($_GET['author']) ? trim(strip_tags($_GET['author'])) : '';
$editora = isset($_GET['editora']) ? trim(strip_tags($_GET['editora'])) : '';
$curso = isset($_GET['curso']) ? trim(strip_tags($_GET['curso'])) : '';
$ano = isset($_GET['data']) ? intval($_GET['data']) : '';

file_put_contents('search_debug.log', date('[Y-m-d H:i:s] ') . 'Sanitized Params: ' . 
    "Query: $query, Author: $author, Editora: $editora, Curso: $curso, Ano: $ano\n", FILE_APPEND);

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
    $types .= 'i';
}

if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

file_put_contents('search_debug.log', date('[Y-m-d H:i:s] ') . 'SQL: ' . $sql . "\n", FILE_APPEND);
file_put_contents('search_debug.log', date('[Y-m-d H:i:s] ') . 'Params: ' . print_r($params, true) . "\n", FILE_APPEND);

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    sendErrorResponse('Erro ao preparar a consulta: ' . mysqli_error($conn));
}

if (!empty($params)) {
    $bindResult = mysqli_stmt_bind_param($stmt, $types, ...$params);
    if (!$bindResult) {
        sendErrorResponse('Erro ao vincular parâmetros: ' . mysqli_error($conn));
    }
}

$executeResult = mysqli_stmt_execute($stmt);
if (!$executeResult) {
    sendErrorResponse('Erro ao executar a consulta: ' . mysqli_errno($conn));
}

$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    sendErrorResponse('Erro ao obter resultados: ' . mysqli_error($conn));
}

$livros = mysqli_fetch_all($result, MYSQLI_ASSOC);

array_walk_recursive($livros, function(&$value) {
    if (is_string($value)) {
        $value = mb_convert_encoding($value, 'UTF-8', 'auto');
    }
});

file_put_contents('search_debug.log', date('[Y-m-d H:i:s] ') . 'Results Count: ' . count($livros) . "\n", FILE_APPEND);

mysqli_stmt_close($stmt);
mysqli_close($conn);

ob_clean();

$jsonResponse = json_encode($livros ?: [], JSON_UNESCAPED_UNICODE);

if (json_last_error() !== JSON_ERROR_NONE) {
    sendErrorResponse('Erro ao codificar JSON: ' . json_last_error_msg());
}

echo $jsonResponse;
exit();