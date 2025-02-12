<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Access-Control-Allow-Origin: *');

include __DIR__. '/conecta_DB.php';

try {
    $ra = intval($_GET['ra']);

    $query = "SELECT NOME_ALUNO, CURSO_ALUNO, FOTO_ALUNO FROM aluno WHERE RA_ALUNO = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $ra);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $aluno = mysqli_fetch_assoc($result);

    if ($aluno) {
        $response = [
            "success" => true,
            "nome" => $aluno['NOME_ALUNO'],
            "curso" => $aluno['CURSO_ALUNO'],
            "foto" => !empty($aluno['FOTO_ALUNO']) ? '../src/img/alunos/' . $aluno['FOTO_ALUNO'] : './src/img/sem-imagem.png'
        ];
    } else {
        $response = [
            "success" => false, 
            "message" => "Aluno não encontrado"
        ];
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