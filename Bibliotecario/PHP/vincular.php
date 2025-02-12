<?php
include __DIR__ . '/conecta_DB.php';

session_start();

// Validação inicial das entradas
if (empty($_POST['idAluno']) || empty($_POST['idLivro']) || empty($_SESSION['id'])) {
    echo "<script>alert('Dados inválidos! Certifique-se de preencher todos os campos.'); window.history.back();</script>";
    exit();
}

$raAluno = $_POST['idAluno'];
$idLivro = $_POST['idLivro'];
$idBibliot = $_SESSION['id'];

// Verifica a conexão com o banco de dados
if (!$conn) {
    echo "<script>alert('Erro ao conectar ao banco de dados!'); window.history.back();</script>";
    exit();
}

// Verifica se o aluno existe
$query = "SELECT ID_ALUNO FROM aluno WHERE RA_ALUNO = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo "<script>alert('Erro ao preparar consulta de aluno!'); window.history.back();</script>";
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $raAluno);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && $aluno = mysqli_fetch_assoc($result)) {
    $idAluno = $aluno['ID_ALUNO'];
} else {
    echo "<script>alert('Aluno não encontrado com o RA fornecido!'); window.history.back();</script>";
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}
mysqli_stmt_close($stmt);

// Verifica se o livro existe e está disponível
$query = "SELECT DISPON_LIV FROM livro WHERE TOMBO_LIV = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo "<script>alert('Erro ao preparar consulta de livro!'); window.history.back();</script>";
    mysqli_close($conn);
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $idLivro);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Insere o empréstimo
$query = "INSERT INTO emprestimos (FK_ID_ALUNO, FK_RA_ALUNO, FK_ID_BIBLIOT, FK_TOMBO_LIV, DT_EMPREST, DT_DEVOLUCAO)
          VALUES (?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo "<script>alert('Erro ao preparar inserção de empréstimo!'); window.history.back();</script>";
    mysqli_close($conn);
    exit();
}

mysqli_stmt_bind_param($stmt, "iiii", $idAluno, $raAluno, $idBibliot, $idLivro);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    // Atualiza a disponibilidade do livro
    $queryUpdateLivro = "UPDATE livro SET DISPON_LIV = 'Indisponível' WHERE TOMBO_LIV = ?";
    $stmtUpdateLivro = mysqli_prepare($conn, $queryUpdateLivro);

    if ($stmtUpdateLivro) {
        mysqli_stmt_bind_param($stmtUpdateLivro, "i", $idLivro);
        mysqli_stmt_execute($stmtUpdateLivro);

        if (mysqli_stmt_affected_rows($stmtUpdateLivro) > 0) {
            echo "<script>alert('Empréstimo registrado e livro atualizado com sucesso!'); window.history.back();</script>";
        } else {
            echo "<script>alert('Empréstimo registrado, mas erro ao atualizar o livro!'); window.history.back();</script>";
        }

        mysqli_stmt_close($stmtUpdateLivro);
    } else {
        echo "<script>alert('Erro ao preparar a atualização do livro!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Erro ao registrar o empréstimo!'); window.history.back();</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
exit();