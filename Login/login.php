<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file login.php
    *   @description Esse código PHP implementa uma lógica de autenticação de usuário com conexão ao banco de dados.
    */ 
-->

<?php
// Configurações de conexão com o banco de dados
$sname = "localhost";
$unmae = "root";
$password = "";
$db_name = "login";

// Estabelecendo a conexão com o banco de dados
$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Verifica se o formulário foi submetido corretamente
if (isset($_POST['uname']) && isset($_POST['password'])) {

    // Função para validar e sanitizar os dados de entrada
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($uname)) {
        header("Location: index.php?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Consulta SQL para verificar se o usuário e a senha correspondem a um registro no banco de dados
        $sql = "SELECT * FROM usuarios WHERE login='$uname' AND senha='$pass'";
        $result = mysqli_query($conn, $sql);

        // Verifica se a consulta retornou algum resultado
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            // Verifica se os dados retornados correspondem aos dados fornecidos
            if ($row['login'] === $uname && $row['senha'] === $pass) {
                echo "Logged in!";
                $_SESSION['user_name'] = $row['login'];
                $_SESSION['name'] = $row['name'] ?? ''; // Verifica se existe um campo 'name' e o armazena na sessão
                $_SESSION['id'] = $row['ID'];
                header("Location: home.php");
                exit();
            } else {
                header("Location: index.php?error=Incorrect User name or password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect User name or password");
            exit();
        }
    }
} else {
    header("Location: ../index.html");
    exit();
}