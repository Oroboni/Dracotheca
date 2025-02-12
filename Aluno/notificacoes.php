<?php
include __DIR__. '/conecta_DB.php';

session_start();
$idAluno = $_SESSION['id'];

try {
    $queryEmprestimos = "SELECT e.ID_EMPREST, l.TITULO_LIV, e.DT_EMPREST, e.DT_DEVOLUCAO, e.FK_TOMBO_LIV, e.FK_ID_ALUNO, e.FK_TOMBO_LIV, l.FOTO_LIV FROM emprestimos e JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV WHERE e.FK_ID_ALUNO = ?";
    $stmtEmprestimos = mysqli_prepare($conn, $queryEmprestimos);
    mysqli_stmt_bind_param($stmtEmprestimos, "i", $idAluno);
    mysqli_stmt_execute($stmtEmprestimos);
    $resultEmprestimos = mysqli_stmt_get_result($stmtEmprestimos);

    if (!$resultEmprestimos) {
        throw new Exception("Erro na consulta de empréstimos: " . $conn->error);
    }

    $notifications = [];
    while ($emprestimo = $resultEmprestimos->fetch_assoc()) {
        $idEmprestimo = $emprestimo['ID_EMPREST'];

        $queryDevolucao = "SELECT ID_EMPREST FROM devolucao WHERE ID_EMPREST = ?";
        $stmtDevolucao = mysqli_prepare($conn, $queryDevolucao);
        mysqli_stmt_bind_param($stmtDevolucao, "i", $idEmprestimo);
        mysqli_stmt_execute($stmtDevolucao);
        $resultDevolucao = mysqli_stmt_get_result($stmtDevolucao);
        $devolucao = mysqli_fetch_assoc($resultDevolucao);
        mysqli_stmt_close($stmtDevolucao);

        $isDevolvido = $devolucao !== null;
        $dataAtual = new DateTime();
        $dataDevolucao = new DateTime($emprestimo['DT_DEVOLUCAO']);
        $intervalo = $dataAtual->diff($dataDevolucao)->days;
        $situacao =  null;


        if (!$isDevolvido) {
            if ($dataDevolucao < $dataAtual) {
                $situacao = 'expirado';
            } elseif ($dataDevolucao >= $dataAtual && $intervalo == 2) {
                $situacao = 'expirando';
            }
        }

        if ($situacao !== null) {
            $notifications[] = [
                'situacao' => $situacao,
                'titulo' => $emprestimo['TITULO_LIV'],
                'id' => $emprestimo['FK_TOMBO_LIV'],
                'aluno' => $emprestimo['NOME_ALUNO'] ?? 'Não atribuído',
                'data' => date('d/m/Y - H:i:s', strtotime($emprestimo['DT_DEVOLUCAO'])),
                'foto' => $emprestimo['FOTO_LIV'],
                'data_emprestimo' => date('d/m/Y', strtotime($emprestimo['DT_EMPREST'])),
                'data_devolucao' => date('d/m/Y', strtotime($emprestimo['DT_DEVOLUCAO']))
            ];
        }
    }
} catch (Exception $e) {
    $notifications = [];
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/notificacoes.css">

    <title>Dracotheca</title>
    <link rel="icon" href="../src/img/logo.png" type="image/png">
</head>

<body>
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container-notificacoes">
        <div class="titulo">
            <h1>Notificações</h1>
        </div>

        <div class="container">
            <?php if (empty($notifications)): ?>
                <h4 class="sem-notificacoes">Sem notificações</h4>
            <?php else: ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="notif-<?php echo $notification['situacao']; ?>">
                        <button
                            data-situacao="<?php echo $notification['situacao']; ?>"
                            data-titulo="<?php echo htmlspecialchars($notification['titulo']); ?>"
                            data-aluno="<?php echo htmlspecialchars($notification['aluno']); ?>"
                            data-data-emprestimo="<?php echo htmlspecialchars($notification['data_emprestimo']); ?>"
                            data-data-devolucao="<?php echo htmlspecialchars($notification['data_devolucao']); ?>"
                            data-foto="<?php echo htmlspecialchars($notification['foto']); ?>">

                            <?php
                            $iconMap = [
                                'expirando' => './src/img/icons/danger.png',
                                'expirado' => './src/img/icons/info-circle.png',
                                'disponivel' => './src/img/icons/book-not.png'
                            ];
                            ?>
                            <img src="<?php echo $iconMap[$notification['situacao']]; ?>"
                                class="status status-<?php echo $notification['situacao']; ?>">

                            <div class="info">
                                <h4>
                                    <?php
                                    $tituloMap = [
                                        'expirando' => 'Prazo de Entrega Expirando',
                                        'expirado' => 'Prazo Expirado',
                                        'disponivel' => 'Livro Disponível'
                                    ];
                                    echo $tituloMap[$notification['situacao']];
                                    ?>
                                </h4>
                                <p class="data"><?php echo $notification['data']; ?></p>
                            </div>

                            <img src="./src/img/icons/enter.png" class="enter">
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="container-expand">
            <div class="expand-content">
                <div class="info-expand">
                    <img src="" class="status-expand">
                    <div>
                        <h4></h4>
                        <p class="data-expand"></p>
                    </div>
                </div>

                <!-- Caso a notificação for de prazo expirando/expirado -->
                <div class="content-expirando-expirado">
                    <div class="livro">
                        <img src="../src/img/books/book3.jpg" alt="Livro" class="book-image">
                        <div class="info-livro">
                            <h4>Livro:</h4>
                            <p class="book-title"></p>
                            <h4>Data de Retirada:</h4>
                            <p class="data-emprestimo"></p>
                            <h4>Prazo de Entrega:</h4>
                            <p class="data-devolucao"></p>
                            <p>Devolva o livro ou peça a renovação do prazo de entrega:</p>
                            <a href="./PHP/renovar.php?id=<?php echo $notification['id']; ?>" class="btn dispo disponivel">
                                <button type="button" class="btn renovar" data-bs-toggle="modal" data-bs-target="#naoRenovar">
                                    Renovar
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Caso a notificação for de disponibilidade do livro -->
                <div class="content-disponibilidade">
                    <div class="livro">
                        <img src="../src/img/books/book3.jpg" alt="Livro" class="book-image">
                        <div class="info-livro">
                            <h4>Livro:</h4>
                            <p class="book-title"></p>
                        </div>
                    </div>
                    <p>Livro disponível para empréstimo, vá até a biblioteca para retirada.</p>
                </div>
            </div>
        </div>

        <!-- Modal - Sucesso -->
        <div class="modal fade" id="renovarPrazo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-custom">
                <div class="modal-content">
                    <div class="text-center">
                        <h3 id="titRenovar">Prazo renovado com <span>sucesso</span>!</h3>
                        <h3 id="prazoFila">Novo prazo: 19/08/24</h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn-modal-ok ok mx-2" data-bs-dismiss="modal">
                            OK <img src="./src/img/icons/verify.png" alt="Renovar" class="btn-icon">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal - Não foi possível -->
        <div class="modal fade" id="naoRenovar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-custom">
                <div class="modal-content">
                    <div class="naoRenovar">
                        <h3 id="titRenovar">Não é possível renovar o prazo <img src="./src/img/icons/sademoji.png" alt="Renovar" class="btn-icon"></h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn-modal-ok nao-ok mx-2" data-bs-dismiss="modal">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.container-notificacoes button');
            const containerExpand = document.querySelector('.container-expand');
            const contentExpirandoExpirado = document.querySelector('.content-expirando-expirado');
            const contentDisponibilidade = document.querySelector('.content-disponibilidade');
            const bookImage = document.querySelector('.livro .book-image');
            const bookTitle = document.querySelector('.book-title');
            const dataEmprestimo = document.querySelector('.data-emprestimo');
            const dataDevolucao = document.querySelector('.data-devolucao');
            const infoExpandImg = document.querySelector('.info-expand img');
            const infoExpandTitle = document.querySelector('.info-expand h4');
            const searchInput = document.getElementById('searchNotifications');
            const filterSelect = document.getElementById('filterNotifications');
            const noNotificationsMessage = document.querySelector('.sem-notificacoes');

            if (buttons.length === 3) {
                console.log('No buttons found - should show message');
                if (noNotificationsMessage) {
                    noNotificationsMessage.style.display = 'block';
                    noNotificationsMessage.style.visibility = 'visible';
                    noNotificationsMessage.style.opacity = '1';
                }
                if (containerNotificacoes) {
                    containerNotificacoes.style.border = '2px solid #ccc';
                }
            }

            function filterNotifications() {
                const searchTerm = searchInput.value.toLowerCase();
                const filterStatus = filterSelect.value;

                buttons.forEach(button => {
                    const parentDiv = button.closest('.notif-expirando, .notif-expirado');
                    const title = button.querySelector('.info h4').textContent.toLowerCase();
                    const date = button.querySelector('.info .data').textContent.toLowerCase();
                    const status = parentDiv.classList.contains('notif-expirando') ? 'expirando' :
                        parentDiv.classList.contains('notif-expirado') ? 'expirado' : 'disponivel';

                    const matchesSearch = title.includes(searchTerm) || date.includes(searchTerm);
                    const matchesFilter = filterStatus === '' || status === filterStatus;

                    parentDiv.style.display = (matchesSearch && matchesFilter) ? 'block' : 'none';
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterNotifications);
            }
            if (filterSelect) {
                filterSelect.addEventListener('change', filterNotifications);
            }

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    buttons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    const situacao = button.dataset.situacao;
                    const titulo = button.dataset.titulo;
                    const dataEmprestimoValue = button.dataset.dataEmprestimo;
                    const dataDevolucaoValue = button.dataset.dataDevolucao;
                    const foto = button.dataset.foto;

                    bookImage.src = '../src/img/books/' + (foto || 'capa.png');

                    bookTitle.textContent = titulo;
                    dataEmprestimo.textContent = dataEmprestimoValue || '';
                    dataDevolucao.textContent = dataDevolucaoValue || '';

                    const situacaoConfig = {
                        'expirando': {
                            title: 'Prazo de Entrega Expirando',
                            icon: './src/img/icons/danger.png',
                            showExpirandoExpirado: true
                        },
                        'expirado': {
                            title: 'Prazo de Entrega Expirado',
                            icon: './src/img/icons/info-circle.png',
                            showExpirandoExpirado: true
                        },
                        'disponivel': {
                            title: 'Livro Disponível',
                            icon: './src/img/icons/book-not.png',
                            showExpirandoExpirado: false
                        }
                    };

                    const config = situacaoConfig[situacao];
                    infoExpandTitle.textContent = config.title;
                    infoExpandImg.src = config.icon;

                    contentExpirandoExpirado.style.display = config.showExpirandoExpirado ? 'flex' : 'none';
                    contentDisponibilidade.style.display = config.showExpirandoExpirado ? 'none' : 'flex';

                    containerExpand.classList.add('show');
                });
            });

            document.addEventListener('click', event => {
                if (!containerExpand.contains(event.target) && !event.target.closest('.container-notificacoes')) {
                    containerExpand.classList.remove('show');
                    buttons.forEach(btn => btn.classList.remove('active'));
                }
            });
        });
    </script>
</body>

</html>