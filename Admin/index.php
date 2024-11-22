<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file index.php
    *   @description Tela inicial.
    *   Nesta tela, o bibliotecário consegue acessar os livros populares e recomendados, podendo fazer pesquisas com filtros, alem de poder navegar entre as outras telas através da sidebar.
    */
-->
<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/index.css">
    <title>Dracotheca</title>

    <link rel="icon" href="./src/img/logo.png" type="image/png">

    <?php
    // /*
        // *   O código PHP realiza duas consultas ao banco de dados MySQL, a primeira consulta os 5 livros mais recentes, obtendo todos os dados da tabela livro e armazenando-os em um array $livros, e asegunda consulta dos anos de lançamento distintos dos livros, ordenados de forma crescente, e armazena os resultados em $livrosanos.
        // Dessa forma é possível exibir livros e anos na interface.
    // */
    include 'conecta_DB.php';

    $query = "SELECT * FROM livro LIMIT 5";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livros = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query = "SELECT DISTINCT YEAR(DTLANCAM_LIV) AS ano FROM livro ORDER BY ano";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livrosanos = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                    <h2>Populares</h2>
                    <a href="livros.php" class="see-more">Ver mais</a>
                </div>
                <div class="books-row">
                    <?php foreach ($livros as $livro): ?>
                        <a href="./gerLivro.php?id=<?php echo $livro['TOMBO_LIV']; ?>" class="book">
                            <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                            <p><?php echo $livro['TITULO_LIV']; ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="section recomt">
                <div class="section-header">
                    <h2>Recomendados</h2>
                    <a href="#" class="see-more">Ver mais</a>
                </div>
                <div class="books-row">
                    <a href="#" class="book">
                        <img src="../src/img/books/book2.jpg" alt="Livro 2">
                        <p>Sobre histórias</p>
                    </a>
                    <a href="#" class="book">
                        <img src="../src/img/books/book4.jpg" alt="Livro 8">
                        <p>Modelo Toyota</p>
                    </a>
                    <a href="#" class="book">
                        <img src="../src/img/books/book6.jpg" alt="Livro 9">
                        <p>Introdução à logística</p>
                    </a>
                    <a href="#" class="book">
                        <img src="../src/img/books/book1.jpg" alt="Livro 10">
                        <p>Programming Python</p>
                    </a>
                    <a href="#" class="book last">
                        <img src="../src/img/books/book2.jpg" alt="Livro 12">
                    </a>
                </div>
            </div>

            <div class="section curso">
                <div class="section-header">
                    <h2>Curso</h2>
                    <a href="#" class="see-more">Ver mais</a>
                </div>
                <div class="books-row">
                    <a href="#" class="book">
                        <img src="../src/img/books/book3.jpg" alt="Livro 13">
                        <p>Entendendo algoritimos</p>
                    </a>
                    <a href="#" class="book">
                        <img src="../src/img/books/book5.jpg" alt="Livro 14">
                        <p>Como fazer amigos e influenciar pessoas</p>
                    </a>
                    <a href="#" class="book">
                        <img src="../src/img/books/book2.jpg" alt="Livro 15">
                        <p>Sobre histórias</p>
                    </a>
                    <a href="#" class="book">
                        <img src="../src/img/books/book1.jpg" alt="Livro 16">
                        <p>Programming Python</p>
                    </a>
                    <a href="#" class="book last">
                        <img src="../src/img/books/book3.jpg" alt="Livro 18">
                    </a>
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
    // /*
        // *   Quando o usuário digita no campo de pesquisa (#search-input), o script envia uma requisição para o servidor com o termo de busca. Se o campo estiver vazio, a lista de livros é limpa. Caso contrário, ele exibe os livros correspondentes, usando a função renderBooks.
    // */
    document.getElementById('search-input').addEventListener('input', function() {
        const searchTerm = this.value.trim();

        if (searchTerm === '') {
            renderBooks([]);
            return;
        }

        fetch(`search.php?query=${searchTerm}`)
            .then(response => response.json())
            .then(data => renderBooks(data))
            .catch(error => {
                console.error('Erro ao buscar livros:', error);
            });
    });

    // /*
        // *   A função renderBooks recebe uma lista de livros e os exibe na página. Caso não haja resultados, exibe uma mensagem informando que nenhum livro foi encontrado.
    // */
    function renderBooks(livros) {
        const booksContainer = document.querySelector('.books-container');
        booksContainer.innerHTML = '';

        if (livros.length === 0) {
            booksContainer.innerHTML = '<p>Nenhum livro encontrado.</p>';
            return;
        }

        const titleElement = `<h2>Resultado da Pesquisa</h2>`;
        booksContainer.innerHTML += titleElement;

        livros.forEach(livro => {
            const bookElement = `
            <div class="books-container">
            <div class="section popular">
                <div class="books-row">
            <a href="./gerLivro.php?id=${livro.TOMBO_LIV}" class="book">
                <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) && file_exists($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                <p>${livro.TITULO_LIV}</p>
            </a>
            </div>
            </div>
            </div>`;
            booksContainer.innerHTML += bookElement;
        });
    }

    // /*
        // *   Ao clicar no botão de aplicar filtros (#apply-filters-button), o script captura os valores dos filtros (autor, editora, categoria, ano) e faz uma nova requisição ao servidor com esses parâmetros, atualizando a lista de livros exibida.
    // */
    document.getElementById('apply-filters-button').addEventListener('click', function(event) {
        event.preventDefault();

        const author = document.querySelector('input[name="author"]:checked')?.value || '';
        const editora = document.querySelector('input[name="editora"]:checked')?.value || '';
        const categoria = document.querySelector('input[name="categoria"]:checked')?.value || '';
        const ano = document.querySelector('input[name="ano"]:checked')?.value || '';

        fetch(`search.php?author=${encodeURIComponent(author)}&editora=${encodeURIComponent(editora)}&categoria=${encodeURIComponent(categoria)}&ano=${encodeURIComponent(ano)}`)
            .then(response => response.json())
            .then(data => renderBooks(data))
            .catch(error => {
                console.error('Erro ao buscar livros:', error);
            });
    });

    // /*
        // *   O botão de aplicar filtros é habilitado sempre que o usuário seleciona ou altera um filtro.
    // */
    document.querySelectorAll('.filter-options input').forEach(input => {
        input.addEventListener('change', () => {
            const applyFiltersButton = document.getElementById('apply-filters-button');
            applyFiltersButton.disabled = false;
        });
    });
</script>