<?php
// Certifique-se que não há saída antes deste ponto
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Limpa qualquer saída anterior
ob_clean();

// Define os headers corretos
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Access-Control-Allow-Origin: *');

try {
    include 'conecta_DB.php';

    if (!isset($_GET['ra'])) {
        throw new Exception('RA não fornecido');
    }

    $ra = intval($_GET['ra']);
    
    if ($ra <= 0) {
        throw new Exception('RA inválido');
    }

    $query = "SELECT NOME_ALUNO, CURSO_ALUNO FROM aluno WHERE RA_ALUNO = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        throw new Exception('Erro ao preparar query: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $ra);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Erro ao executar query: ' . mysqli_stmt_error($stmt));
    }
    
    $result = mysqli_stmt_get_result($stmt);
    $aluno = mysqli_fetch_assoc($result);

    if ($aluno) {
        $response = [
            "success" => true,
            "nome" => $aluno['NOME_ALUNO'],
            "curso" => $aluno['CURSO_ALUNO']
        ];
    } else {
        $response = ["success" => false, "message" => "Aluno não encontrado"];
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) mysqli_stmt_close($stmt);
    if (isset($conn)) mysqli_close($conn);
}
?>