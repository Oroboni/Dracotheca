<!-- 
    /*
    *   @author Camila Inocencio e Matheus Cuero
    *   @version 1.0    
    *   @file sidebar.php
    *   @description Tela de vincular livro x aluno.
    *   Com ela, a bibliotecária pode realizar o processo de vinculo entre o livro e o aluno, passando as informações da carteirinha e do livro. Depois, há um formulário com as informações do vinculo, como a data em que está sendo realizado o empréstimo e o prazo de devolução, tudo calculado e puxado do banco automaticamente.
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/vincular.css">

    <title>Dracotheca</title>

    <script>
        // /*
        // *   Após os QR Codes serem escaneados, são realizadas buscas e os campos com informações de alunos e livros são preenchidos utilizando fetch. 
        // */
        window.onload = function() {
            var input = document.getElementById('ra');
            input.focus();
            input.select();
        }

        function fetchAluno() {
    const ra = document.getElementById("ra").value;
    console.log('Iniciando fetch para RA:', ra);
    
    // Mostra a URL completa que está sendo chamada
    const url = `./PHP/fetchAluno.php?ra=${ra}`;
    console.log('URL da requisição:', url);

    if (ra) {
        fetch(url)
            .then(response => {
                console.log('Status da resposta:', response.status);
                console.log('Headers da resposta:', Object.fromEntries(response.headers));
                
                return response.text().then(text => {
                    console.log('Resposta bruta:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Erro ao parsear JSON:', e);
                        console.log('Texto que causou o erro:', text);
                        throw e;
                    }
                });
            })
            .then(data => {
                console.log('Dados processados:', data);
                if (data.success) {
                    document.getElementById("nome").value = data.nome;
                    document.getElementById("curso").value = data.curso;
                } else {
                    alert("Aluno não encontrado.");
                }
            })
            .catch(error => {
                console.error("Erro detalhado:", error);
                alert("Erro ao buscar informações do aluno.");
            });
    }
}

        // Add event listeners for both change and input events
        document.addEventListener('DOMContentLoaded', function() {
            const raInput = document.getElementById('ra');

            raInput.addEventListener('change', fetchAluno);
            raInput.addEventListener('input', function() {
                // Optional: Add debounce here if you want to reduce API calls
                if (this.value.length >= 5) { // Only fetch if RA has at least 5 digits
                    fetchAluno();
                }
            });
        });

        function fetchLivro() {
            const tombo = document.getElementById("tombo").value;

            if (tombo) {
                fetch(`./PHP/fetchLivro.php?tombo=${tombo}`)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            document.getElementById("titulo").value = data.titulo;
                            document.getElementById("edicao").value = data.edicao;
                            document.getElementById("capa").value = data.capa;
                        } else {
                            document.getElementById("titulo").value = '';
                            document.getElementById("edicao").value = '';
                            alert("Livro não encontrado.");
                        }
                    })
                    .catch((error) => console.error("Erro ao buscar livro:", error));
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
            <h1>Vincular</h1>
        </div>

        <div class="background">
            <div class="container">
                <form method="post" action="./PHP/vincular.php">
                    <div class="row dados">
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
                                                    <input id="ra" name="idAluno" type="number" class="form-control" placeholder="Digite o RA" onchange="fetchAluno()" min="0" required>
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col">
                                                    <label for="nome" class="form-label">Nome completo</label>
                                                    <input id="nome" type="text" class="form-control" value="" disabled>
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col top">
                                                    <label for="curso" class="form-label">Curso</label>
                                                    <input id="curso" type="text" class="form-control" value="" disabled>
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
                                    <h2>Dados do Livro</h2>
                                </div>
                            </div>
                            <div class="info-livro">
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
                                                    <input id="tombo" name="idLivro" type="number" class="form-control" placeholder="Digite o tombo do livro" onchange="fetchLivro()" min="0" required>
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col">
                                                    <label for="titulo" class="form-label">Título</label>
                                                    <input id="titulo" type="text" class="form-control" value="" disabled>
                                                </div>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col top">
                                                    <label for="edicao" class="form-label">Edição</label>
                                                    <input id="edicao" type="text" class="form-control" value="" disabled>
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
                                <label for="dtEmprest" class="form-label">Data do Empréstimo</label>
                                <input type="date" id="dtEmprest" class="form-control" value="<?php echo date('Y-m-d'); ?>" disabled>
                            </div>
                            <div class="col">
                                <label for="bibliot" class="form-label">Bibliotecária(o)</label>
                                <input id="bibliot" type="text" class="form-control" value="<?php echo $_SESSION["user_name"] ?>" disabled>
                            </div>
                        </div>
                        <div class="row g-3 d-flex justify-content-between esp-top">
                            <div class="col esp">
                                <label for="prazo" class="form-label">Prazo de Devolução</label>
                                <input type="date" id="prazo" class="form-control" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" disabled>
                            </div>
                            <div class="col">
                                <label for="email" class="form-label">E-mail de contato</label>
                                <input id="email" type="text" class="form-control" value="email@email.com" disabled>
                            </div>
                        </div>

                        <div class="btns">
                            <button type="submit" class="btn vincular" id="vincularBtn">
                                Vincular <img src="./src/img/icons/paperclip-2.png" alt="Vincular" class="btn-icon">
                            </button>
                            <a href="./index.php" class="btn cancelar" id="cancelarBtn">
                                Cancelar <img src="./src/img/icons/slash.png" alt="Cancelar" class="btn-icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    </div>

    <script src="../src/javascript/script.js"></script>
</body>

</html>

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