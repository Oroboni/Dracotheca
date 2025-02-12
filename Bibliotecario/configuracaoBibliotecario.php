<!-- 
    /*
    *   @author Luís Glauser e Matheus Cuero
    *   @version 1.0    
    *   @file configuracaoBibliotcario.php
    *   @description Arquivo de configurações do bibliotecário.
    *    A tela permite que o bibliotecário gerencie informações pessoais e ajustes, além de funções como saída da conta.
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
  <link rel="stylesheet" href="../src/css/configuracao.css">

  <title>Dracotheca</title>
  
  <style>
    .titulo {
      font-family: Poppins;
    }
  </style>
</head>

<body>
  <nav class="navbar" id="sidebar">
    <?php include "sidebar.php"; ?>
  </nav>

  <div class="containerConfig">
    <div class="titulo">
      <h1>Configurações</h1>
    </div>
    <h2 class="subtitulo">Configurações da sua conta</h2>

    <div class="row-align-items-start menu-config">
      <p class="col-3 subtitulo2">Data de Entrada</p>
      <div class="col-4-align-self-end"><?php
                                        if (!empty($_SESSION['data'])) {
                                          $data = DateTime::createFromFormat('Y-m-d', $_SESSION['data']);
                                          echo $data->format('d/m/Y');
                                        } else {
                                          echo 'Data não fornecida';
                                        }
                                        ?></div>
      <div class="col"></div>
    </div>

    <div class="menu-config">
      <p class="col-3 subtitulo2">CPF</p>
      <p class="col-4"><?php
                        // /*
                          // *   O código verifica se há um CPF armazenado na sessão. Se existir, exibe os primeiros três e os dois últimos dígitos, mascarando o restante com '***.***'. Caso contrário, exibe "CPF não fornecido".
                        // */
                        if (!empty($_SESSION['cpf'])) {
                          $cpf = $_SESSION['cpf'];
                          echo substr($cpf, 0, 3) . '.***.***-' . substr($cpf, -2);
                        } else {
                          echo 'CPF não fornecido';
                        }
                        ?></p>
    </div>

    <div class="row-align-items-start menu-config">
      <p class="col-3 subtitulo2">Notificações</p>
      <p class="col-6 ">Ativar/Desativar as notificações</p>
      <label class="col-3 switch">
        <input type="checkbox">
        <span class="slider round"></span>
      </label>

    </div>
    <div class="row-align-items-start">
      <button class="menu-config" onclick="togglePrivacidade()">
        <p class="col-3 subtitulo2">Privacidade</p>
        <p class="col-6"> Mudar Senha, Email</p> <img class="col-1 " src="./src/img/icons/setaD.png" alt="seta">
      </button>
      <div class="row-align-items-start menu-content" id="menuPrivacidade">
        <Button class="sub-menu-config" data-bs-toggle="modal" data-bs-target="#MudarSenhaB">
          <p class="col-6">Mudar Senha</p> <img class="col-1" src="./src/img/icons/setaD.png" alt="seta">
        </Button>
      </div>
    </div>
    <div class="row-align-items-start">
      <button class="menu-config" onclick="toggleZona()">
        <p class="col-3 subtitulo2">Zona Perigosa</p> <span id="spanR">Sair</span>
      </button>
      <div class="menu-content" id="menuZona">
        <Button type="button" class="sub-menu-config" data-bs-toggle="modal" data-bs-target="#SairB"> <span id="spanR">Sair</span> </Button>
      </div>
    </div>

    <div class="modal fade" id="MudarSenhaB" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="row-align-items-start">
            <h1 class="subtituloModal w-100 text-center"><img src="./src/img/icons/Xavier.png" class="col-1" alt="dragao">Mudar senha<img src="./src/img/icons/miku.png" class="col-1" alt="rato"></h1>
          </div>

          <form action="PHP/mudar_senha.php" method="post">
            <div class="form-group">
              <label for="senhaAtual">Senha Atual</label>
              <input type="password" class="form-control inputModal" placeholder="Digite sua senha atual" required name="senha_atual">

            </div>
            <div class="form-group">
              <label for="senhaNova">Nova senha</label>
              <input type="password" class="form-control inputModal" placeholder="Digite a nova senha" required name="senha_nova">
            </div>
            <div class="form-group">
              <label for="senhaNovaC">Confirmar nova senha</label>
              <input type="password" class="form-control inputModal" placeholder="Digite a nova senha novamente" required name="senha_nova_confirma">
              <a href="#recuperarSenha" class="d-block text-end" data-bs-dismissal="modal" data-bs-toggle="modal"><span id="spanRoxo">esqueci minha senha</span></a>
            </div>
            <div class="form-group d-flex justify-content-center">
              <button type="submit" class="btn btn-modal">Mudar senha </button>

            </div>
          </form>

        </div>
      </div>
    </div>

    <div class="modal fade" id="SairB" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="row-align-items-start">
            <h1 class="subtituloModalSair w-100 text-center">Deseja mesmo <span class="subtituloModalSair" id="spanR">sair</span> da sua conta?</h1>
          </div>
          <form action="../Login/logout.php">
            <div class="form-group d-flex justify-content-center">
              <button type="submit" class="btn btn-sair">Sim, quero sair.</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</body>

<script>
  // /*
    //   *   O código define duas funções JavaScript que alternam (ativam/desativam) a classe `active` em elementos HTML específicos, identificados pelos IDs `menuPrivacidade` e `menuZona`, para alterar seu estado ou estilo dinamicamente.
  // */
  function togglePrivacidade() {
    const menuContent = document.getElementById('menuPrivacidade');
    menuContent.classList.toggle('active');
  }

  function toggleZona() {
    const menuContent = document.getElementById('menuZona');
    menuContent.classList.toggle('active');
  }
</script>