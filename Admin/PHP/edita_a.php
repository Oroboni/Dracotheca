<?php
include 'conecta_DB.php';

$id = $_GET['id'];

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$genero = $_POST['genero'];
$dtnasc = $_POST['dtnasc'];
$email = $_POST['email'];
$curso = $_POST['curso'];
$ra = $_POST['ra'];
$senha = $_POST['senha'];

if (!empty($senha)) {
    $senha = password_hash($senha, PASSWORD_ARGON2I);
} else {
    $query = "SELECT SEN_ALUNO FROM aluno WHERE ID_ALUNO = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $senha);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

$sql = "UPDATE aluno
            SET NOME_ALUNO = ?, CPF_ALUNO = ?, GEN_ALUNO = ?, DTNASC_ALUNO = ?, EMAIL_ALUNO = ?, CURSO_ALUNO = ?, RA_ALUNO = ?, SEN_ALUNO = ?
            WHERE ID_ALUNO = ?";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssssssi", $nome, $cpf, $genero, $dtnasc, $email, $curso, $ra, $senha, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Aluno editado com sucesso!";
        } else {
            echo "Nenhuma linha foi atualizada. Verifique os dados.";
        }
    } else {
        echo "Erro ao editar o aluno: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Erro ao preparar a consulta: " . mysqli_error($conn);
}

mysqli_close($conn);
header("Location: ../alunos.php");
exit();