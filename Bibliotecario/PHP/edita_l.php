<?php
include 'conecta_DB.php';

$id = $_GET['id'];

$query = "SELECT FOTO_LIV FROM livro WHERE TOMBO_LIV = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $img);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$pasta = "../../src/img/books/";
$filePath = $pasta . $img;

if ($img && file_exists($filePath)) {
    unlink($filePath);
}

$titu = $_POST['titulo'];
$autor = $_POST['autor'];
$edi = $_POST['edicao'];
$disp = $_POST['disponivel'];
$gen = $_POST['genero'];
$editora = $_POST['editora'];
$dtLanc = $_POST['dtLanc'];
$palavras = $_POST['palavras'];
$dtAqu = $_POST['dtAqu'];
$fornecedor = $_POST['fornecedor'];
$status = $_POST['status'];
$complemento = $_POST['complemento'];
$observacao = $_POST['observacao'];
$tipoAqu = $_POST['tipoAqu'];
$curso = $_POST['curso'];
$valor = $_POST['valor'];

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
    $img = basename($_FILES['imagem']['name']);
    $folder = $pasta . $img;

    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $folder)) {
        echo "Erro ao mover o arquivo enviado.";
        exit;
    }
} else {
    echo "Nenhuma imagem foi enviada ou houve um erro no upload.";
    exit;
}

$sql = "UPDATE livro SET TITULO_LIV = ?, AUTOR_LIV = ?, EDICAO_LIV = ?, DISPON_LIV = ?, GENERO_LIV = ?, DTLANCAM_LIV = ?, PALAVCHAVE_LIV = ?, DTAQUISICAO_LIV = ?, FORNECEDOR_LIV = ?, STATUS_LIV = ?, COMPLEM_LIV = ?, OBS_LIV = ?, TPAQUISICAO_LIV = ?, CURSO_LIV = ?, VALOR_LIV = ?, FOTO_LIV = ?, EDITORA_LIV = ? WHERE TOMBO_LIV = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "sssssssssssssssssi", $titu, $autor, $edi, $disp, $gen, $dtLanc, $palavras, $dtAqu, $fornecedor, $status, $complemento, $observacao, $tipoAqu, $curso, $valor, $img, $editora, $id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Livro editado com sucesso!";
    } else {
        echo "Nenhuma linha foi atualizada. Verifique os dados.";
    }
} else {
    echo "Erro ao editar o livro: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirecionar após a execução
header("Location: ../livros.php");
exit;
?>