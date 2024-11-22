<?php
include 'conecta_DB.php';
session_start();

$userId = $_SESSION['id'];

$query = "SELECT e.ID_EMPREST AS id, l.TITULO_LIV AS title,
    CASE 
        WHEN e.DT_DEVOLUCAO < NOW() THEN 'Prazo Expirado'
        WHEN e.DT_DEVOLUCAO BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 2 DAY) THEN 'Prazo de Entrega Expirando'
        ELSE 'Livro Disponível'
    END AS type,
    e.DT_DEVOLUCAO AS timestamp
    FROM emprestimos e
    JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
    WHERE e.FK_ID_ALUNO = ?";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die('Erro na preparação da consulta: ' . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'message' => $row['type'] === 'Livro Disponível'
            ? "O livro \"{$row['title']}\" está disponível para retirada."
            : "O prazo de entrega do livro \"{$row['title']}\" está próximo ou expirou.",
        'timestamp' => $row['timestamp'],
        'type' => strtolower(str_replace(' ', '_', $row['type'])),
    ];
}

$notifications[] = [
    "id" => 1,
    "title" => "O Senhor dos Anéis",
    "message" => "O livro \"O Senhor dos Anéis\" está disponível para retirada.",
    "timestamp" => "2024-11-21 10:00:00",
    "type" => "livro_disponivel"
];

header('Content-Type: application/json');
echo json_encode($notifications);