<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 1.0    
    *   @file devolucao.php
    *   @description Tela de devolução de livros.
    *    Este arquivo permite que as bibliotecárias registrem a devolução de livros, com detalhes sobre o aluno, o livro, e possíveis penalidades ou observações.
    */
-->

<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/devolucao.css">

    <title>Dracotheca</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .fundo {
            background-color: #C4B9CA;
        }
    </style>

    <script>
        window.onload = function() {
            var input = document.getElementById('tombo');
            input.focus();
            input.select();
            document.getElementById("confirmarBtn").disabled = true;
        }

        function fetchAluno() {
            const ra = document.getElementById("ra").value;
            if (ra) {
                fetch(`./PHP/fetchAluno.php?ra=${ra}`)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            document.getElementById("nome").value = data.nome;
                            document.getElementById("curso").value = data.curso;
                            document.getElementById("confirmarBtn").disabled = false;
                        } else {
                            document.getElementById("nome").value = '';
                            document.getElementById("curso").value = '';
                            alert("Aluno não encontrado.");
                        }
                    })
                    .catch((error) => console.error("Erro ao buscar aluno:", error));
            }
        }

        // /*
        // *   Obtém o tombo do campo de entrada tombo e faz uma requisição ao arquivo fetchLivro.php. Caso os dados sejam retornados com sucesso, preenche os campos titulo, edicao e atualiza a imagem com o ID capa, e se o livro não for encontrado, limpa os campos e exibe um alerta.
        // */

        function resetLivroFields() {
            const titulo = document.getElementById("titulo");
            const edicao = document.getElementById("edicao");
            const emprestimo = document.getElementById("emprestimo");
            const devolvido = document.getElementById("devolvido");
            const capa = document.getElementById("capa");

            if (titulo) titulo.value = '';
            if (edicao) edicao.value = '';
            if (emprestimo) emprestimo.value = '';
            if (devolvido) devolvido.value = '';
            if (capa) capa.src = '../src/img/books/capa.png';
        }


        function fetchLivro() {
            const tombo = document.getElementById("tombo").value;

            resetLivroFields();

            if (tombo) {
                fetch(`./PHP/fetchLivro.php?tombo=${tombo}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const titulo = document.getElementById("titulo");
                            const edicao = document.getElementById("edicao");
                            const capa = document.getElementById("capa");
                            const emprestimo = document.getElementById("emprestimo");

                            if (titulo) titulo.value = data.titulo;
                            if (edicao) edicao.value = data.edicao;
                            if (capa) capa.src = data.foto;

                            if (emprestimo && data.dataEmprestimo) {
                                const formattedDate = new Date(data.dataEmprestimo).toLocaleDateString('pt-BR');
                                emprestimo.value = formattedDate;
                            }
                        } else {
                            alert(data.message || "Livro não encontrado.");
                        }
                    })
                    .catch(error => {
                        console.error("Erro ao buscar livro:", error);
                        alert("Erro ao buscar informações do livro.");
                    });
            }
        }
    </script>
</head>

<body class="fundo">
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="box-container">
        <div class="titulo">
            <h1>Devolução</h1>
        </div>

        <div class="background">
            <div class="container">
                <div class="row dados">
                    <div class="col">
                        <form method="post" action="./PHP/devolucao.php">
                            <div class="dados-aluno">
                                <div class="title">
                                    <h2>Dados do Livro</h2>
                                </div>
                            </div>
                            <div class="carteirinha">
                                <div class="color">
                                    <div class="row g-3 d-flex justify-content-between">
                                        <div class="col-md-3">
                                            <div class="image">
                                                <img src="<?php echo !empty($livro['FOTO_LIV']) && $livro['FOTO_LIV'] != '../src/img/books/capa.png' && file_exists('../src/img/books/' . $livro['FOTO_LIV']) ? '../src/img/books/' . $livro['FOTO_LIV'] : '../src/img/books/capa.png'; ?>" class="rounded img-fluid" id="capa" alt="img-capa">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row g-4">
                                                <div class="col top">
                                                    <label for="tombo" class="form-label">Tombo</label>
                                                    <input id="tombo" name="tombo" type="number" class="form-control" placeholder="Digite o tombo do livro" onchange="fetchLivro()" min="0" required>
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col">
                                                    <label for="titulo" class="form-label">Titulo do Livro</label>
                                                    <input id="titulo" type="text" class="form-control" placeholder="Titulo do Livro" aria-label="Titulo" disabled>
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col top">
                                                    <label for="edicao" class="form-label">Edição</label>
                                                    <input type="text" id="edicao" class="form-control" placeholder="Edição do Livro" aria-label="edicao" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="col">
                        <div class="dados-aluno">
                            <div class="title">
                                <h2>Dados do Aluno</h2>
                            </div>
                        </div>
                        <div class="carteirinha">
                            <div class="color">
                                <div class="row g-3 d-flex justify-content-between">
                                    <div class="col-md-3">
                                        <div class="image">
                                            <img src="./src/img/sem-imagem.png" class="rounded img-fluid" alt="img-perfil" id="foto">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row g-4">
                                            <div class="col top">
                                                <label for="ra" class="form-label">RA</label>
                                                <input id="ra" name="ra" type="number" class="form-control" placeholder="Digite o RA" onchange="fetchAluno()" min="0" required>
                                            </div>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col top">
                                                <label for="emprestimo" class="form-label">Dt. de Empréstimo</label>
                                                <input type="text" id="emprestimo" class="form-control" placeholder="Data de Empréstimo" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col top">
                                                <label for="devolucao" class="form-label">Dt. de Devolução</label>
                                                <input type="date" id="devolucao" class="form-control" value="<?php echo date('Y-m-d'); ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row info-emprest">
                <div class="col emprest">
                    <div class="container-form">

                        <div class="row g-3 d-flex justify-content-between">
                            <div class="col esp">
                                <label for="penalidade" class="form-label">Penalidade</label>
                                <select id="penalidade" name="penalidade" class="form-select" required>
                                    <option selected disabled value="">Selecione</option>
                                    <option value="s">Suspensão</option>
                                    <option value="nenhuma">Nenhuma</option>
                                </select>
                            </div>
                            <div class="col esp">
                                <label for="reserva" class="form-label">Reserva</label>
                                <select id="reserva" name="reserva" class="form-select" required>
                                    <option selected disabled value="">Selecione</option>
                                    <option value="s">Permitir</option>
                                    <option value="n">Não permitir</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 d-flex justify-content-between esp-top">
                            <div class="col esp">
                                <label for="dias" class="form-label">Suspensão</label>
                                <input type="number" id="dias" name="dias" class="form-control" min="1" disabled>
                            </div>
                            <div class="col esp">
                                <label for="renovar" class="form-label">Renovar</label>
                                <select id="renovar" name="renovar" class="form-select" required>
                                    <option selected disabled value="">Selecione</option>
                                    <option value="s">Permitir</option>
                                    <option value="n">Não permitir</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 d-flex justify-content-between esp-top">
                            <div class="col esp">
                                <label for="obs" class="form-label">Observação</label>
                                <textarea required name="obs" id="obs" class="form-control" placeholder="Digite sua observação"></textarea>
                            </div>
                        </div>

                        <div class="btns">
                            <a href="./index.php" class="btn cancelar" id="cancelarBtn">
                                Cancelar <img src="./src/img/icons/slash.png" alt="Cancelar" class="btn-icon">
                            </a>
                            <button type="submit" class="btn confirmar" id="confirmarBtn">
                                Confirmar <img src="./src/img/icons/devolucao.png" alt="Confirmar" class="btn-icon">
                            </button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>

<script type="text/javascript" src="./src/javascript/devolucao.js"></script>

<script>
    // /*
    // *   Personalizar a interface e buscar informações de um livro por meio de requisição assíncrona.
    // */
    function getCookie(name) {
        const cookieArr = document.cookie.split(';');
        for (let cookie of cookieArr) {
            const [key, value] = cookie.trim().split('=');
            if (key === name) return decodeURIComponent(value);
        }
        return null;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const profileImage = getCookie('profile_image');
        if (profileImage) {
            const avatarElement = document.getElementById('foto');
            if (avatarElement) {
                avatarElement.src = profileImage;
            } else {
                console.error("Elemento 'user_avatar' não encontrado.");
            }
        }
    });
</script>