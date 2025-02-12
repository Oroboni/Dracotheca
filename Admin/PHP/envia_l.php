<?php
include __DIR__. '/conecta_DB.php';

$pasta = "../../src/img/books/";
$filePath = $pasta . $img;

// Variáveis do formulário
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
}

$sql = "INSERT INTO livro (
    PALAVCHAVE_LIV, DISPON_LIV, STATUS_LIV, TITULO_LIV, 
    DTAQUISICAO_LIV, TPAQUISICAO_LIV, FORNECEDOR_LIV, 
    VALOR_LIV, GENERO_LIV, AUTOR_LIV, EDICAO_LIV, 
    DTLANCAM_LIV, COMPLEM_LIV, CURSO_LIV, OBS_LIV, 
    FOTO_LIV, EDITORA_LIV
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param(
        $stmt, 
        "sssssssssssssssss", 
        $palavras, $disp, $status, $titu, 
        $dtAqu, $tipoAqu, $fornecedor, 
        $valor, $gen, $autor, $edi, 
        $dtLanc, $complemento, $curso, $observacao, 
        $img, $editora
    );

    try {
        if (mysqli_stmt_execute($stmt)) {
            // Redirecionar após sucesso
            header("Location: ../livros.php?success=1");
            exit();
        } else {
            throw new Exception("Erro ao inserir livro: " . mysqli_stmt_error($stmt));
        }
    } catch (Exception $e) {
        // Log do erro
        error_log($e->getMessage());
        
        // Se um arquivo foi enviado, remover
        if ($img && file_exists($pasta . $img)) {
            unlink($pasta . $img);
        }

        // Mensagem de erro
        die("Ocorreu um erro ao cadastrar o livro. Por favor, tente novamente.");
    } finally {
        mysqli_stmt_close($stmt);
    }
} else {
    // Erro na preparação da consulta
    error_log("Erro ao preparar consulta: " . mysqli_error($conn));
    die("Erro interno do sistema. Por favor, tente novamente mais tarde.");
}