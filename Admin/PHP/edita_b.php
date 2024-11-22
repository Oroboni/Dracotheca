<?php
include 'conecta_DB.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Erro: ID não fornecido.";
    exit;
}

$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$genero = $_POST['genero'] ?? '';
$dtnasc = $_POST['dtnasc'] ?? '';
$email = $_POST['email'] ?? '';
$sen = $_POST['senha'] ?? '';
$turno = $_POST['turno'] ?? '';

if (!empty($sen)) {
    $hashed_senha = password_hash($sen, PASSWORD_DEFAULT);
    
    $sql = "UPDATE bibliotecaria SET NOME_BIBLIOT = ?, CPF_BIBLIOT = ?, GEN_BIBLIOT = ?, DTNASC_BIBLIOT = ?, EMAIL_BIBLIOT = ?, SEN_BIBLIOT = ?, TURNO_BIBLIOT = ? WHERE ID_BIBLIOT = ?";
    
} else {
    $sql = "UPDATE bibliotecaria SET NOME_BIBLIOT = ?, CPF_BIBLIOT = ?, GEN_BIBLIOT = ?, DTNASC_BIBLIOT = ?, EMAIL_BIBLIOT = ?, TURNO_BIBLIOT = ? WHERE ID_BIBLIOT = ?";
}

$stmt = mysqli_prepare($conn, $sql);

if (!empty($sen)) {
    mysqli_stmt_bind_param($stmt, "sssssssi", $nome, $cpf, $genero, $dtnasc, $email, $hashed_senha, $turno, $id);
} else {
    mysqli_stmt_bind_param($stmt, "ssssssi", $nome, $cpf, $genero, $dtnasc, $email, $turno, $id);
}

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Bibliotecário atualizado com sucesso!";
    } else {
        echo "Nenhuma alteração realizada. Verifique os dados.";
    }
} else {
    echo "Erro ao atualizar bibliotecário: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header("Location: ../bibliotecarios.php");
exit();