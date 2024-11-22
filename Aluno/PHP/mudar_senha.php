<?php
include '../conecta_DB.php';
session_start();

$id = $_SESSION['id'];
$senha_atual = trim($_POST['senha_atual']);
$senha_nova = trim($_POST['senha_nova']);
$senha_nova_confirma = trim($_POST['senha_nova_confirma']);

if ($senha_nova !== $senha_nova_confirma) {
    echo "<script>alert('Senhas não coincidem!'); window.history.back();</script>";
    exit();
}


$sql = "SELECT SEN_ALUNO FROM aluno WHERE ID_ALUNO = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($senha_atual, $row['SEN_ALUNO'])) {
        $senha_nova_hash = password_hash($senha_nova, PASSWORD_DEFAULT);

        $update_sql = "UPDATE aluno SET SEN_ALUNO = ? WHERE ID_ALUNO = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $senha_nova_hash, $id);

        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>alert('Senha alterada com sucesso!'); window.history.back();</script>";
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar a senha!'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Erro ao atualizar a senha!'); window.history.back();</script>";
        header("Location: ../configuracoes.php?error=Senha atual incorreta");
        exit();
    }
} else {
    header("Location: ../configuracoes.php?error=Usuário não encontrado");
    exit();
}