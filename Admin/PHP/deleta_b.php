<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file deleta_a.php
    *   @description O código exclui um bibliotecário do banco de dados com base no ID_BIBLIOT recebido via URL (GET). Após excluir o registro, ele fecha a conexão com o banco de dados e redireciona o usuário para a página de bibliotecários.
    */ 
-->

<?php
include 'conecta_DB.php';

$id = intval($_POST['id']); 

$sql = "DELETE FROM bibliotecaria WHERE ID_BIBLIOT = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($conn);


header("Location: ../bibliotecarios.php");
exit();