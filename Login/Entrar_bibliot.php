<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file Entrar_bibliot.php
    *   @description Arquivo PHP para entrar como bibliotecário.
    *   O script PHP realiza a autenticação do bibliotecário no sistema. Ele verifica se o login e a senha fornecida correspondem aos dados no banco de dados. Se o login for bem-sucedido, as informações do bibliotecário são armazenadas na sessão e ele é redirecionado para a página inicial da área do bibliotecário. Se houver qualquer erro, uma mensagem de erro é exibida e o bibliotecário é redirecionado para corrigir a entrada.
    */ 
-->

<?php
session_start();
include 'conecta_DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = trim($_POST['uname']);
    $pass = trim($_POST['password']);

    $sql = "SELECT NOME_BIBLIOT, SEN_BIBLIOT, DTCADASTRO_BIBLIOT, CPF_BIBLIOT, ID_BIBLIOT 
            FROM bibliotecaria WHERE NOME_BIBLIOT = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($pass, $row['SEN_BIBLIOT'])) {
                $_SESSION['login_b'] = true;
                $_SESSION['user_name'] = $row['NOME_BIBLIOT'];
                $_SESSION['data'] = $row['DTCADASTRO_BIBLIOT'];
                $_SESSION['cpf'] = $row['CPF_BIBLIOT'];
                $_SESSION['id'] = $row['ID_BIBLIOT'];

                header("Location: ../bibliotecario/index.php");
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
        echo "<script>alert('Erro encontrado, entre em contato com o desenvolvedor!'); window.history.back();</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}