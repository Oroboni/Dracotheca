<?php
include 'conecta_DB.php';

header('Content-Type: application/json');

$query = "SELECT e.ID_EMPREST AS id, l.TITULO_LIV AS book, e.DT_EMPREST AS start_date, e.DT_DEVOLUCAO AS end_date,
          CASE 
              WHEN e.DT_DEVOLUCAO < NOW() THEN 'Atraso na devolução'
              WHEN e.DT_DEVOLUCAO BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 2 DAY) THEN 'Urgente'
              ELSE 'Devolvido'
          END AS situation
          FROM emprestimos e
          JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV";

$result = $conn->query($query);
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['id'],
        'book' => $row['book'],
        'start_date' => $row['start_date'],
        'end_date' => $row['end_date'],
        'situation' => $row['situation']
    ];
}

echo json_encode($events);