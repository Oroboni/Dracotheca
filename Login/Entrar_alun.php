<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file Entrar_alun.php
    *   @description Arquivo PHP para entrar como aluno.
    *   O script realiza a autenticação do aluno no sistema. Ele verifica a matrícula (RA_ALUNO) e a senha fornecida, validando-as contra os dados armazenados no banco de dados. Se o aluno for autenticado com sucesso, ele é redirecionado para a área restrita do sistema. Se houver qualquer problema, uma mensagem de erro é exibida, e o usuário é instruído a corrigir a entrada.
    */ 
-->

<?php
session_start();
include 'conecta_DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = trim($_POST['uname']); 
    $pass = trim($_POST['password']); 

    $sql = "SELECT ID_ALUNO, RA_ALUNO , NOME_ALUNO, SEN_ALUNO, DTCADASTRO_ALUNO, CPF_ALUNO FROM aluno WHERE RA_ALUNO = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            
            if (password_verify($pass, $row['SEN_ALUNO'])) {
                $_SESSION['login_a'] = true;
                $_SESSION['user_name'] = $row['NOME_ALUNO'];
                $_SESSION['data'] = $row['DTCADASTRO_ALUNO'];
                $_SESSION['cpf'] = $row['CPF_ALUNO'];
                $_SESSION['id'] = $row['ID_ALUNO'];
                header("Location: ../Aluno/index.php");
                exit();
            } else {
                echo "<script>alert('Usuário ou senha incorretos!'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Usuário não encontrado!'); window.history.back();</script>";
            exit();
        }

    } else {
            echo "<script>alert('Erro encontrado, entre em contado com o desenvolvedor!'); window.history.back();</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}