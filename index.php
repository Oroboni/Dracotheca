<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file index.php
    *   @description Tela inicial.
    *   Nesta tela, o bibliotecário consegue acessar os livros populares e recomendados, podendo fazer pesquisas com filtros, alem de poder navegar entre as outras telas através da sidebar.
    */
-->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./src/css/bootstrap.min.css">
    <link rel="stylesheet" href="./src/css/index.css">
    <meta charset="ISO-8859-1">
    <title>Dracotheca</title>

    <link rel="icon" href="./src/img/logo.png" type="image/png">

    <?php
    if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION)) {
    session_destroy();
    $_SESSION = [];
    } 

    include __DIR__ . '/conecta_DB.php';

    $query = "SELECT * FROM livro";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livros = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query = "SELECT l.*, COUNT(e.ID_EMPREST) AS emprestimos FROM livro l
        LEFT JOIN emprestimos e ON l.TOMBO_LIV = e.FK_TOMBO_LIV
        GROUP BY l.TOMBO_LIV ORDER BY emprestimos DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livrosPopulares = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    if (isset($_SESSION['curso'])) {
        $query = "SELECT * FROM livro WHERE CURSO_LIV = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['curso']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $Curso_livros = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
    }

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
                Olá, <span class="name">bem-vindo</span>
            </h1>
        </div>

        <div class="books-container">
            <div class="section popular">
                <div class="section-header">
                    <h2>Populares</h2>
                    <a href="./populares.php" class="see-more">Ver mais</a>
                </div>
                <div class="books-row">
                    <?php $i = 0;
                    foreach ($livrosPopulares as $livrosPopulare): ?>
                        <a href="./detalhesLivro.php?id=<?php echo $livrosPopulare['TOMBO_LIV']; ?>" class="book">
                            <img id="imgPreview" src="<?php echo !empty($livrosPopulare['FOTO_LIV']) && $livrosPopulare['FOTO_LIV'] != './src/img/books/capa.png' && file_exists('./src/img/books/' . $livrosPopulare['FOTO_LIV']) ? './src/img/books/' . $livrosPopulare['FOTO_LIV'] : './src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                            <p><?php echo htmlspecialchars($livrosPopulare['TITULO_LIV'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </a>
                    <?php if ($i++ > 4) {
                            break;
                        }
                    endforeach; ?>
                </div>
            </div>

            <div class="section recomt">
                <div class="section-header">
                    <h2>Recomendados</h2>
                    <a href="./recomendados.php" class="see-more">Ver mais</a>
                </div>
                <div class="books-row">
                    <?php $i = 0;
                    foreach ($livros as $livro): ?>
                        <a href="./detalhesLivro.php?id=<?php echo $livro['TOMBO_LIV']; ?>" class="book">
                            <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != './src/img/books/capa.png' && file_exists('./src/img/books/' . $livro['FOTO_LIV']) ? './src/img/books/' . $livro['FOTO_LIV'] : './src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                            <p><?php echo $livro['TITULO_LIV']; ?></p>
                        </a>
                    <?php if ($i++ > 4) {
                            break;
                        }
                    endforeach; ?>
                </div>
            </div>

            <div class="section curso">
                <div class="section-header">
                    <h2>Curso</h2>
                    <a href="./Curso.php" class="see-more">Ver mais</a>
                </div>
                <div class="books-row">
                    <?php $i = 0;
                    foreach ($livros as $livro): ?>
                        <a href="./detalhesLivro.php?id=<?php echo $livro['TOMBO_LIV']; ?>" class="book">
                            <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != './src/img/books/capa.png' && file_exists('./src/img/books/' . $livro['FOTO_LIV']) ? './src/img/books/' . $livro['FOTO_LIV'] : './src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                            <p><?php echo $livro['TITULO_LIV']; ?></p>
                        </a>
                    <?php if ($i++ > 4) {
                            break;
                        }
                    endforeach; ?>
                </div>
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


                <div>
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
                                <?php if (!empty($livro['EDITORA_LIV'])): ?>
                                    <input type="radio" id="<?php echo htmlspecialchars($livro['EDITORA_LIV']); ?>" name="editora" value="<?php echo htmlspecialchars($livro['EDITORA_LIV']); ?>">
                                    <label for="<?php echo htmlspecialchars($livro['EDITORA_LIV']); ?>"><?php echo htmlspecialchars($livro['EDITORA_LIV']); ?></label><br>
                                <?php endif; ?>
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
                            <?php
                            $cursos = array_unique(array_column($livros, 'CURSO_LIV'));
                            foreach ($cursos as $curso):
                            ?>
                                <?php if (!empty($curso)): ?>
                                    <input type="radio" id="curso_<?php echo htmlspecialchars($curso); ?>" name="curso" value="<?php echo htmlspecialchars($curso); ?>">
                                    <label for="curso_<?php echo htmlspecialchars($curso); ?>"><?php echo htmlspecialchars($curso); ?></label><br>
                                <?php endif; ?>
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
                                <?php if (!empty($livrosano['ano'])): ?>
                                    <input type="radio" id="<?php echo htmlspecialchars($livrosano['ano']); ?>" name="data" value="<?php echo htmlspecialchars($livrosano['ano']); ?>">
                                    <label for="autor<?php echo htmlspecialchars($livrosano['ano']); ?>"><?php echo htmlspecialchars($livrosano['ano']); ?></label><br>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="./src/javascript/script.js"></script>
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
            img.src = livro.FOTO_LIV ? `./src/img/books/${livro.FOTO_LIV}` : './src/img/books/capa.png';
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
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(text => {
                console.log('Raw response:', text);

                if (!text) {
                    throw new Error('Empty response received');
                }

                try {
                    const data = JSON.parse(text);
                    console.log('Parsed data:', data);

                    if (!Array.isArray(data) && !data.error) {
                        throw new Error('Invalid response format');
                    }

                    renderBooks(data);
                } catch (jsonError) {
                    console.error('JSON Parsing Error:', jsonError);
                    throw new Error('Invalid JSON response');
                }
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