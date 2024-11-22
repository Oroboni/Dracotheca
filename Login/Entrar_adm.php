<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file Entrar_adm.php
    *   @description Arquivo PHP para entrar como Administrador.
    *   O script realiza a autenticação de um administrador, validando o nome de usuário e a senha fornecidos. Se as credenciais forem corretas, o administrador é autenticado e redirecionado para o painel de administração. Caso contrário, uma mensagem de erro é exibida, e o administrador é solicitado a tentar novamente.
    */ 
-->

<?php
include 'conecta_DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = $_POST['uname'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM administrador WHERE NOME_ADMIN = ? AND SEN_ADMIN = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['login_adm'] = true;
        $_SESSION['user_name'] = $row['NOME_ADMIN'];
        $_SESSION['id'] = $row['ID_ADMIN'];
        header("Location: ../Admin/index.php");
        exit();
    } else {
        header("Location: login_adm.php?error=Usuário ou senha incorretos");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}