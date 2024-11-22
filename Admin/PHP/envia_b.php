<?php
include 'conecta_DB.php';

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$genero = $_POST['genero'];
$dtnasc = $_POST['dtnasc'];
$email = $_POST['email'];
$turno = $_POST['turno'];
$dt_cad = date("Y-m-d");
$sen = password_hash("123", PASSWORD_DEFAULT);

$sqlCheck = "SELECT COUNT(*) FROM bibliotecaria WHERE CPF_BIBLIOT = ?";
$stmtCheck = mysqli_prepare($conn, $sqlCheck);
mysqli_stmt_bind_param($stmtCheck, "s", $cpf);
mysqli_stmt_execute($stmtCheck);
mysqli_stmt_bind_result($stmtCheck, $count);
mysqli_stmt_fetch($stmtCheck);
mysqli_stmt_close($stmtCheck);

if ($count > 0) {
    echo "<script>alert('Erro: CPF já cadastrado.'); window.history.back();</script>";
    exit();
}

$sqlCheck = "SELECT COUNT(*) FROM bibliotecaria WHERE EMAIL_BIBLIOT  = ?";
$stmtCheck = mysqli_prepare($conn, $sqlCheck);
mysqli_stmt_bind_param($stmtCheck, "s", $email);
mysqli_stmt_execute($stmtCheck);
mysqli_stmt_bind_result($stmtCheck, $count);
mysqli_stmt_fetch($stmtCheck);
mysqli_stmt_close($stmtCheck);

if ($count > 0) {
    echo "<script>alert('Erro: EMAIL já cadastrado.'); window.history.back();</script>";
    exit();
}

$sql = "INSERT INTO BIBLIOTECARIA 
        (NOME_BIBLIOT, CPF_BIBLIOT, GEN_BIBLIOT, DTNASC_BIBLIOT, DTCADASTRO_BIBLIOT, EMAIL_BIBLIOT, SEN_BIBLIOT, TURNO_BIBLIOT) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssssss", $nome, $cpf, $genero, $dtnasc, $dt_cad, $email, $sen, $turno);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Novo bibliotecário inserido com sucesso!'); window.location.href='../bibliotecarios.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao executar a instrução: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Erro ao preparar a consulta: " . mysqli_error($conn) . "'); window.history.back();</script>";
}

mysqli_close($conn);
?>