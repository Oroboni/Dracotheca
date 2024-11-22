<?php
include 'conecta_DB.php';

$pasta = '../src/img/';
$nome = trim($_POST['nome']);
$cpf = trim($_POST['cpf']);
$genero = $_POST['genero'];
$dtnasc = $_POST['dtnasc'];
$email = trim($_POST['email']);
$curso = $_POST['curso'];
$ra = $_POST['ra'];
$dt_cad = date("Y-n-j");
$senha = 123;
$foto = $_FILES['foto']['name'] ?? '';
$folder = $pasta . basename($foto);
$senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO aluno (NOME_ALUNO, CPF_ALUNO, GEN_ALUNO, DTNASC_ALUNO, EMAIL_ALUNO, CURSO_ALUNO, RA_ALUNO, DTCADASTRO_ALUNO, SEN_ALUNO) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssssssss", $nome, $cpf, $genero, $dtnasc, $email, $curso, $ra, $dt_cad, $senha_hashed);

    if ($stmt->execute()) {
        echo "Novo aluno cadastrado com sucesso!";
        header("Location: ../alunos.php");
        exit();
    } else {
        echo "Erro ao executar a instrução: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erro ao preparar a consulta: " . $conn->error;
}

$conn->close();