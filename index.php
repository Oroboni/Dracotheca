<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 2.0    
    *   @file index.php
    *   @description Tela inicial.
    *   Nesta tela, os usuários conseguem acessar os livros populares e recomendados, podendo fazer pesquisas com filtros, além de poder entrar na conta pessoal.
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
    <link rel="stylesheet" href="./src/css/bootstrap.min.css">
    <link rel="stylesheet" href="./src/css/index.css">
    <title>Dracotheca</title>

    <?php
    include 'conecta_DB.php';

    // Consulta para buscar livros populares
    $query = "SELECT TOMBO_LIV, TITULO_LIV, FOTO_LIV FROM livro LIMIT 5";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livros = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                Olá, <span class="name">Bem Vindo</span>
            </h1>
        </div>

        <div class="books-container">
            <div class="section popular">
                <div class="section-header">
                    <h2>Populares</h2>
                    <a href="./populares.php" class="see-more">Ver mais</a>
                </div>
                <div class="books-row">
                    <?php foreach ($livros as $livro): ?>
                        <a href="./detalhesLivro.php?id=<?php echo $livro['TOMBO_LIV']; ?>" class="book">
                        <img id="imgPreview" src="<?php echo !empty($livro['FOTO_LIV']) ? './src/img/books/'.$livro['FOTO_LIV'] : './src/img/books/capa.png'; ?>" class="rounded img-fluid" alt="img-perfil">
                            <p><?php echo $livro['TITULO_LIV']; ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
    
            <div class="section recomt">
                <div class="section-header">
                    <h2>Recomendados</h2>
                    <a href="./recomendados.php" class="see-more">Ver mais</a>
                </div>
                <div class="books-row">
                    <a href="#" class="book">
                        <img src="./src/img/books/book2.jpg" alt="Livro 2">
                        <p>Sobre histórias</p>
                    </a>
                    <a href="#" class="book">
                        <img src="./src/img/books/book4.jpg" alt="Livro 8">
                        <p>Modelo Toyota</p>
                    </a>
                    <a href="#" class="book">
                        <img src="./src/img/books/book6.jpg" alt="Livro 9">
                        <p>Introdução à logística</p>
                    </a>
                    <a href="#" class="book">
                        <img src="./src/img/books/book1.jpg" alt="Livro 10">
                        <p>Programming Python</p>
                    </a>
                    <a href="#" class="book">
                        <img src="./src/img/books/book4.jpg" alt="Livro 2">
                        <p>Modelo Toyota</p>
                    </a>
                    <a href="#" class="book last">
                        <img src="./src/img/books/book2.jpg" alt="Livro 12">
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
                        <img src="./src/img/books/book3.jpg" alt="Livro 13">
                        <p>Entendendo algoritimos</p>
                    </a>
                    <a href="#" class="book">
                        <img src="./src/img/books/book5.jpg" alt="Livro 14">
                        <p>Como fazer amigos e influenciar pessoas</p>
                    </a>
                    <a href="#" class="book">
                        <img src="./src/img/books/book2.jpg" alt="Livro 15">
                        <p>Sobre histórias</p>
                    </a>
                    <a href="#" class="book">
                        <img src="./src/img/books/book1.jpg" alt="Livro 16">
                        <p>Programming Python</p>
                    </a>
                    <a href="#" class="book">
                        <img src="./src/img/books/book4.jpg" alt="Livro 17">
                        <p>Modelo Toyota</p>
                    </a>
                    <a href="#" class="book last">
                        <img src="./src/img/books/book3.jpg" alt="Livro 18">
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
                 <div class="btn-filter"><!-- botão de aplicar filtro -->
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
                        <i id="filter-icon" class="fa-solid fa-chevron-right"></i>
                    </div>
                    <div class="filter-options" id="filter-options">
                        <input type="radio" id="autor1" name="author" value="autor1">
                        <label for="autor1">Autor 1</label><br>
                    
                        <input type="radio" id="autor2" name="author" value="autor2">
                        <label for="autor2">Autor 2</label><br>
                    
                        <input type="radio" id="autor3" name="author" value="autor3">
                        <label for="autor3">Autor 3</label><br>
                    
                        <input type="radio" id="autor4" name="author" value="autor4">
                        <label for="autor4" class="last-radio">Autor 4</label>
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
                        <input type="radio" id="editora1" name="editora" value="editora1">
                        <label for="editora1">Editora 1</label><br>
                    
                        <input type="radio" id="editora2" name="editora" value="editora2">
                        <label for="editora2">Editora 2</label><br>
                    
                        <input type="radio" id="editora3" name="editora" value="editora3">
                        <label for="editora3">Editora 3</label><br>
                    
                        <input type="radio" id="editora4" name="editora" value="editora4">
                        <label for="editora4" class="last-radio">Editora 4</label>
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
                        <input type="radio" id="categoria1" name="categoria" value="categoria1">
                        <label for="categoria1">Categoria 1</label><br>
                    
                        <input type="radio" id="categoria2" name="categoria" value="categoria2">
                        <label for="categoria2">Categoria 2</label><br>
                    
                        <input type="radio" id="categoria3" name="categoria" value="categoria3">
                        <label for="categoria3">Categoria 3</label><br>
                    
                        <input type="radio" id="categoria4" name="categoria" value="categoria4">
                        <label for="categoria4" class="last-radio">Categoria 4</label>
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
                        <input type="radio" id="ano1" name="ano" value="2024">
                        <label for="ano1">2024</label><br>
                    
                        <input type="radio" id="ano2" name="ano" value="2020">
                        <label for="ano2">2020</label><br>
                    
                        <input type="radio" id="ano3" name="ano" value="2012">
                        <label for="ano3">2012</label><br>
                    
                        <input type="radio" id="ano4" name="ano" value="2008">
                        <label for="ano4" class="last-radio">2008</label>
                    </div>
                </div> 
            </form>
        </div>
    </div>       

    <script src="./src/javascript/script.js"></script>
</body>
</html>