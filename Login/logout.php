<!-- 
    /*
    *   @author Matheus Cuero
    *   @version 1.0    
    *   @file logout.php
    *   @description Arquivo PHP para logout de uma sessão.
    *   Esse código é usado para garantir que o usuário saia completamente de sua conta, encerrando qualquer estado persistente relacionado à sessão.
    */ 
-->

<?php 
session_unset();
session_destroy();
header("Location: ../index.php");