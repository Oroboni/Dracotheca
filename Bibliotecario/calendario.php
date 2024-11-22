<!-- 
    /*
    *   @author Camila Inocencio
    *   @version 1.0    
    *   @file calendario.php
    *   @description Tela de calendário interativo para eventos e notificações.
    *   O arquivo implementa um calendário interativo que é feito com a biblioteca FullCalendar 5.x para exibir eventos que ocorreram em cada dia, podendo ser notificações de atraso em devolução, empréstimos e outros.
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/calendario.css">
    <!-- Calendário com a bilioteca js FullCalendar 5.x -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <title>Dracotheca</title>
    <link rel="icon" href="./src/img/logo.png" type="image/png">
</head>
<body> 
    <nav class="navbar" id="sidebar">
        <?php include "sidebar.php"; ?>
    </nav>

    <div class="container-calendario">
        <div class="titulo">
            <h1>Calendário</h1>
        </div>

        <div class="calendario">
            <div class="container" style="margin-top: 90px;">
                <div id="calendar" style="width: 100%;"></div>
                <div class="legendas"></div>
            </div>

            <div class="details" id="eventDetails">
                <h2 id="eventTitle">Detalhes do Evento</h2>
                <p id="eventDescription">Clique em um dia no calendário para ver detalhes.</p>
            </div>
        </div>
    </div>

    <script src="./src/javascript/calendario.js"></script>

    <style>
        .fc .fc-col-header-cell-cushion {
            color: #464040;
        }

        .fc .fc-daygrid-day-number {
            color: #464040;
            cursor: pointer;
        }

        .fc-daygrid-day {
            cursor: pointer;
        }

        .fc-toolbar-title {
            display: inline-block;
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
        }

        .fc-toolbar-chunk:first-child, 
        .fc-toolbar-chunk:last-child {
            display: flex;
            align-items: center;
        }

        .fc-prev-button, 
        .fc-next-button {
            font-size: 1.2em;
            border: none !important;
            background-color: #D2A779 !important;
        }

        .fc-prev-button:hover, 
        .fc-next-button:hover {
            background-color: #B9936B !important;
        }

        .fc-prev-button:focus, 
        .fc-next-button:focus {
            outline: none !important;
        }

        .fc-today-button {
            background-color: #836b5e !important;
        }

        .container-calendario {
            display: flex;
            align-items: flex-start;
            width: 100%;
            overflow-y: auto;
        }

        .calendario {
            display: flex;
            gap: 20px;
            width: 95%;
            padding: 20px;
            max-height: calc(100vh - 130px);
            overflow-y: auto;
        }

        .container {
            width: 90%;
            padding: 20px;
            border-radius: 8px;
        }

        .details {
            width: 70%;
            height: 100%;
            background-color:#f4f4f4;
            padding: 20px;
            border-radius: 15px;
            border: 3px solid #f0f0f0;
            color: #464040;
            margin-top: 90px;
        }

        .details .dropdown-menu {
            width: 100%;
            font-size: 1rem;
            padding: 10px;
        }

        .details .dropdown-toggle {
            font-size: 1.22rem;
            font-weight: 600;
            width: 100%;
            text-align: left;
            padding: 16px;
        }

        .details h2 {
            text-align: center;
            background-color: #b5a1c2c1;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .details p {
            font-size: 1.2rem;
            color: #585858;
        }
        
        .dropdown-devolvido, .dropdown-devolvido:focus {
            background-color: #88A27C;
        }

        .dropdown-devolvido:hover {
            background-color: #9ab38e;
        }

        .dropdown-emprestimo, .dropdown-emprestimo:focus {
            background-color: #9e9e9e33;
        }

        .dropdown-emprestimo:hover {
            background-color: #9e9e9e33;
        }

        .dropdown-atraso, .dropdown-atraso:focus {
            background-color: #ffeb3bae;
        }

        .dropdown-atraso:hover {
            background-color: #ffeb3bcb;
        }

        .dropdown-urgente, .dropdown-urgente:focus {
            background-color: #f44336cb;
        }

        .dropdown-urgente:hover {
            background-color: #f44336e0;
        }

        .dropdown-urgente:focus, .dropdown-urgente:hover {
            color: #000;
        }

        .selected-day {
            background-color: #E1AD76 !important;
        }

        /* Media Screen */
        @media screen and (max-width: 1700px) {
            .fc-toolbar-title {
                font-size: 24px !important;
            }
        }

        @media screen and (max-width: 1600px) {
            .fc-toolbar-title {
                font-size: 22px !important;
            }
        }

        @media screen and (max-width: 1500px) {
            .fc-toolbar-title {
                font-size: 20px !important;
            }
        }
    </style>    
</body>
</html>