<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/index.css">
    <title>Dracotheca</title>

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include __DIR__. '/conecta_DB.php';

    $queryEmprestados = "SELECT DISTINCT l.GENERO_LIV, l.AUTOR_LIV, l.CURSO_LIV FROM emprestimos e INNER JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV WHERE e.FK_ID_ALUNO = ?";
    $stmtEmprestados = mysqli_prepare($conn, $queryEmprestados);
    mysqli_stmt_bind_param($stmtEmprestados, "i", $_SESSION['id']);
    mysqli_stmt_execute($stmtEmprestados);
    $resultEmprestados = mysqli_stmt_get_result($stmtEmprestados);
    $caracteristicasEmprestados = mysqli_fetch_all($resultEmprestados, MYSQLI_ASSOC);
    mysqli_stmt_close($stmtEmprestados);

    if (!empty($caracteristicasEmprestados)) {
        $queryRelacionados = "SELECT DISTINCT l.* FROM livro l
        WHERE 
            (l.GENERO_LIV IN (
                SELECT GENERO_LIV 
                FROM emprestimos e 
                INNER JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
                WHERE e.FK_ID_ALUNO = ?
            ) OR 
            l.AUTOR_LIV IN (
                SELECT AUTOR_LIV 
                FROM emprestimos e 
                INNER JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
                WHERE e.FK_ID_ALUNO = ?
            ) OR 
            l.CURSO_LIV IN (
                SELECT CURSO_LIV 
                FROM emprestimos e 
                INNER JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
                WHERE e.FK_ID_ALUNO = ?
            ))
            AND l.TOMBO_LIV NOT IN (
                SELECT FK_TOMBO_LIV 
                FROM emprestimos 
                WHERE FK_ID_ALUNO = ?
            )
        ORDER BY l.DTLANCAM_LIV DESC";
        $stmtRelacionados = mysqli_prepare($conn, $queryRelacionados);
        mysqli_stmt_bind_param(
            $stmtRelacionados,
            "iiii",
            $_SESSION['id'],
            $_SESSION['id'],
            $_SESSION['id'],
            $_SESSION['id']
        );
        mysqli_stmt_execute($stmtRelacionados);
        $resultRelacionados = mysqli_stmt_get_result($stmtRelacionados);
        $livrosRelacionados = mysqli_fetch_all($resultRelacionados, MYSQLI_ASSOC);
        mysqli_stmt_close($stmtRelacionados);
    } else {
        $queryTodosLivros = "SELECT * FROM livro ORDER BY DTLANCAM_LIV DESC";
        $stmtTodosLivros = mysqli_prepare($conn, $queryTodosLivros);
        mysqli_stmt_execute($stmtTodosLivros);
        $resultTodosLivros = mysqli_stmt_get_result($stmtTodosLivros);
        $livrosRelacionados = mysqli_fetch_all($resultTodosLivros, MYSQLI_ASSOC);
        mysqli_stmt_close($stmtTodosLivros);
    }
    $queryLivrosAnos = "SELECT DISTINCT YEAR(DTLANCAM_LIV) AS ano FROM livro ORDER BY ano";
    $stmtLivrosAnos = mysqli_prepare($conn, $queryLivrosAnos);
    mysqli_stmt_execute($stmtLivrosAnos);
    $resultLivrosAnos = mysqli_stmt_get_result($stmtLivrosAnos);
    $livrosanos = mysqli_fetch_all($resultLivrosAnos, MYSQLI_ASSOC);
    mysqli_stmt_close($stmtLivrosAnos);
    ?>
</head>

<body>
    <nav class="navbar" id="sidebar">
        <?php
        include "sidebar.php"
        ?>
    </nav>

    <main class="content">
        <div class="welcome">
            <h1>
                <img src="./src/img/nuvem.png" alt="icone" class="icon">
                Olá, <span class="name"><?php echo $_SESSION["user_name"] ?></span>
            </h1>
        </div>

        <div class="books-container">
            <div class="section popular">
                <div class="section-header">
                    <h2>Recomendados</h2>
                </div>
                <div class="books-row">
                    <?php if (!empty($livrosRelacionados)): ?>
                        <?php foreach ($livrosRelacionados as $livroRelacionado): ?>
                            <a href="./detalhesLivro.php?id=<?php echo $livroRelacionado['TOMBO_LIV']; ?>" class="book">
                                <img id="imgPreview" src="<?php echo !empty($livroRelacionado['FOTO_LIV']) && $livroRelacionado['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $livroRelacionado['FOTO_LIV']) ? '../src/img/books/' . $livroRelacionado['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                                <p><?php echo htmlspecialchars($livroRelacionado['TITULO_LIV']); ?></p>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($livros as $livro): ?>
                            <a href="./detalhesLivro.php?id=<?php echo $livro['TOMBO_LIV']; ?>" class="book">
                                <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                                <p><?php echo $livro['TITULO_LIV']; ?></p>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
    </main>

    <div class="search">
        <button id="open_btn">
            <i id="open_btn_icon" class="fa-solid fa-magnifying-glass"></i>
        </button>
        <div class="box-search">
            <form id="search-form" method="get">
                <div class="search-bar">
                    <input type="text" id="search-input" placeholder="Pesquisar...">
                    <button type="submit" id="search-button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <!-- filtros -->
                <div class="btn-filter">
                    <button class="filter-aplic" id="apply-filters-button" disabled>
                        <span>Aplicar filtros</span>
                        <img src="./src/img/icons/filter.png" alt="filtro" class="btn-filter-icon">
                    </button>
                </div>


                <div class="filter">
                    <div class="filter-header" onclick="toggleFilter(event)">
                        <div class="icon-filter">
                            <img src="./src/img/icons/user-edit.png" alt="autores">
                        </div>
                        <span class="title-filter">Autores</span>
                        <i id="filter-icon-autores" class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="filter-options" id="filter-options-autores">
                        <?php foreach ($livros as $livro): ?>
                            <input type="radio" id="autor_<?php echo $livro['AUTOR_LIV']; ?>" name="author" value="<?php echo $livro['AUTOR_LIV']; ?>">
                            <label for="autor_<?php echo $livro['AUTOR_LIV']; ?>"><?php echo $livro['AUTOR_LIV']; ?></label><br>
                        <?php endforeach; ?>
                    </div>
                </div>


                <div class="filter">
                    <div class="filter-header" onclick="toggleFilter(event)">
                        <div class="icon-filter">
                            <img src="./src/img/icons/book.png" alt="editora">
                        </div>
                        <span class="title-filter">Editora</span>
                        <i id="filter-icon" class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="filter-options" id="filter-options">
                        <?php foreach ($livros as $livro): ?>
                            <input type="radio" id="<?php echo $livro['EDITORA_LIV']; ?>" name="editora" value="<?php echo $livro['EDITORA_LIV']; ?>">
                            <label for="autor1"><?php echo $livro['EDITORA_LIV']; ?></label><br>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="filter">
                    <div class="filter-header" onclick="toggleFilter(event)">
                        <div class="icon-filter">
                            <img src="./src/img/icons/note.png" alt="categoria">
                        </div>
                        <span class="title-filter">Categoria</span>
                        <i id="filter-icon" class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="filter-options" id="filter-options">
                        <?php foreach ($livros as $livro): ?>
                            <input type="radio" id="<?php echo $livro['CURSO_LIV']; ?>" name="curso" value="<?php echo $livro['CURSO_LIV']; ?>">
                            <label for="<?php echo $livro['CURSO_LIV']; ?>"><?php echo $livro['CURSO_LIV']; ?></label><br>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="filter">
                    <div class="filter-header" onclick="toggleFilter(event)">
                        <div class="icon-filter">
                            <img src="./src/img/icons/clock.png" alt="ano">
                        </div>
                        <span class="title-filter">Ano de publicação</span>
                        <i id="filter-icon" class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="filter-options" id="filter-options">
                        <?php foreach ($livrosanos as $livrosano): ?>
                            <input type="radio" id="<?php echo $livrosano['ano']; ?>" name="data" value="<?php echo $livrosano['ano']; ?>">
                            <label for="autor<?php echo $livrosano['ano']; ?>"><?php echo $livrosano['ano']; ?></label><br>
                        <?php endforeach; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../src/javascript/script.js"></script>
</body>

</html>

<script>
    document.getElementById('search-input').addEventListener('input', function() {
        const searchTerm = this.value.trim();

        if (searchTerm === '') {
            return;
        }

        fetch(`search.php?query=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => renderBooks(data))
            .catch(error => {
                console.error('Erro ao buscar livros:', error);
            });
    });

    function renderBooks(livros) {
        const booksContainer = document.querySelector('.books-container');
        booksContainer.innerHTML = '';

        if (livros.length === 0) {
            booksContainer.innerHTML = '<p>Nenhum livro encontrado.</p>';
            return;
        }

        const titleElement = document.createElement('h2');
        titleElement.textContent = 'Resultado da Pesquisa';
        booksContainer.appendChild(titleElement);

        const resultSection = document.createElement('div');
        resultSection.className = 'section popular';
        const booksRow = document.createElement('div');
        booksRow.className = 'books-row';

        livros.forEach(livro => {
            const bookLink = document.createElement('a');
            bookLink.href = `./detalhesLivro.php?id=${livro.TOMBO_LIV}`;
            bookLink.className = 'book';

            const img = document.createElement('img');
            img.src = livro.FOTO_LIV ? `../src/img/books/${livro.FOTO_LIV}` : '../src/img/books/capa.png';
            img.className = 'rounded img-fluid';
            img.alt = 'Capa do livro';

            const titleP = document.createElement('p');
            titleP.textContent = livro.TITULO_LIV;

            bookLink.appendChild(img);
            bookLink.appendChild(titleP);
            booksRow.appendChild(bookLink);
        });
        const voltar = document.createElement('button');
        voltar.textContent = 'Voltar';
        voltar.className = 'btn btn-secondary mt-3';
        voltar.style.marginBottom = '20px';
        voltar.addEventListener('click', () => {
            window.history.back();
        });
        resultSection.appendChild(voltar);

        resultSection.appendChild(booksRow);
        booksContainer.appendChild(resultSection);
    }

    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const applyButton = document.getElementById('apply-filters-button');
            applyButton.disabled = false;
        });
    });

    document.getElementById('search-input').addEventListener('input', function() {
        const searchTerm = this.value.trim();

        if (searchTerm === '') {
            return;
        }

        performSearch({
            query: searchTerm
        });
    });

    document.getElementById('apply-filters-button').addEventListener('click', function(event) {
        event.preventDefault();

        const author = document.querySelector('input[name="author"]:checked')?.value || '';
        const editora = document.querySelector('input[name="editora"]:checked')?.value || '';
        const curso = document.querySelector('input[name="curso"]:checked')?.value || '';
        const ano = document.querySelector('input[name="data"]:checked')?.value || '';

        performSearch({
            author: author,
            editora: editora,
            curso: curso,
            data: ano
        });
    });

    function getUrlParameters() {
        const params = {};
        const urlParams = new URLSearchParams(window.location.search);

        for (const [key, value] of urlParams.entries()) {
            params[key] = value;
        }

        return params;
    }

    function performSearch(params) {
        console.log('Search Params:', params);
        const queryString = new URLSearchParams(Object.entries(params)).toString();
        console.log('Query String:', queryString);

        fetch(`search.php?${queryString}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                renderBooks(data);
            })
            .catch(error => {
                console.error('Erro ao buscar livros:', error);
                const booksContainer = document.querySelector('.books-container');
                booksContainer.innerHTML = `<p>Erro ao buscar livros: ${error.message}</p>`;
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = getUrlParameters();

        if (Object.keys(urlParams).length > 0) {
            performSearch(urlParams);
        }
    });

    document.getElementById('apply-filters-button').addEventListener('click', function(event) {
        event.preventDefault();

        const author = document.querySelector('input[name="author"]:checked')?.value || '';
        const editora = document.querySelector('input[name="editora"]:checked')?.value || '';
        const curso = document.querySelector('input[name="curso"]:checked')?.value || '';
        const ano = document.querySelector('input[name="data"]:checked')?.value || '';

        performSearch({
            author: author,
            editora: editora,
            curso: curso,
            data: ano
        });
    });
</script>