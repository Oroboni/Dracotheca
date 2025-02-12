<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__. '/conecta_DB.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax || (isset($_GET['ajax']) && $_GET['ajax'] === 'true')) {
    header('Content-Type: application/json');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    try {
        $idAluno = $_SESSION['id'];
        $queryEmprestimos = "SELECT e.ID_EMPREST, l.TITULO_LIV, e.DT_EMPREST, e.DT_DEVOLUCAO, e.FK_TOMBO_LIV, e.FK_ID_ALUNO, e.DEVOLVIDO 
            FROM emprestimos e 
            JOIN livro l ON e.FK_TOMBO_LIV = l.TOMBO_LIV
            WHERE e.FK_ID_ALUNO = ?";
        $stmtEmprestimos = mysqli_prepare($conn, $queryEmprestimos);
        mysqli_stmt_bind_param($stmtEmprestimos, "i", $idAluno);
        mysqli_stmt_execute($stmtEmprestimos);
        $resultEmprestimos = mysqli_stmt_get_result($stmtEmprestimos);

        $events = [];

        while ($emprestimo = $resultEmprestimos->fetch_assoc()) {
            $isDevolvido = $emprestimo['DEVOLVIDO'] == 's';
            $dataAtual = new DateTime();
            $dataDevolucao = new DateTime($emprestimo['DT_DEVOLUCAO']);
            $intervalo = $dataAtual->diff($dataDevolucao)->days;

            if ($isDevolvido) {
                $situacao = 'Devolvido';
            } else {
                if ($dataDevolucao < $dataAtual) {
                    $situacao = 'Atrasado';
                } elseif ($intervalo <= 2) {
                    $situacao = 'Urgente';
                } else {
                    $situacao = 'Emprestado';
                }
            }

            $events[] = [
                'id' => $emprestimo['ID_EMPREST'],
                'title' => $emprestimo['TITULO_LIV'],
                'start' => $emprestimo['DT_EMPREST'],
                'end' => $emprestimo['DT_DEVOLUCAO'],
                'book' => $emprestimo['TITULO_LIV'],
                'tombo' => $emprestimo['FK_TOMBO_LIV'],
                'situation' => $situacao
            ];
        }

        echo json_encode($events);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/calendario.css">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {    
        var calendarEl = document.getElementById('calendar');

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            eventSources: [{
                url: window.location.href + '?ajax=true',
                method: 'GET',
                failure: function(error) {
                    console.error('Erro ao carregar eventos:', error);
                    alert('Erro ao carregar eventos');
                }
            }],
            eventDataTransform: function(eventData) {
                return {
                    book: eventData.book,
                    tombo: eventData.tombo,
                    start: eventData.start.split(' ')[0],
                    dateRetirada: formatDate(eventData.start),
                    dateDevolucao: formatDate(eventData.end),
                    situation: eventData.situation,
                    color: function() {
                        switch (eventData.situation) {
                            case 'Devolvido': return '#88A27C';
                            case 'Emprestado': return '#9e9e9e33';
                            case 'Atrasado': return '#ffeb3bae';
                            default: return '#f44336cb';
                        }
                    }()
                };
            },
            dateClick: function(info) {
                document.querySelectorAll('.selected-day').forEach(function(day) {
                    day.classList.remove('selected-day');
                });

                info.dayEl.classList.add('selected-day');

                const eventsForDate = calendar.getEvents().filter(event => event.startStr === info.dateStr);
                let eventDetailsHtml = '';

                if (eventsForDate.length > 0) {
                    eventsForDate.forEach(event => {
                        let situationClass = '';
                        let buttonClass = '';

                        switch (event.extendedProps.situation) {
                            case 'Devolvido':
                                situationClass = 'dropdown-devolvido';
                                buttonClass = 'btn-success';
                                break;
                            case 'Emprestado':
                                situationClass = 'dropdown-emprestimo';
                                buttonClass = 'btn-secondary';
                                break;
                            case 'Atrasado':
                                situationClass = 'dropdown-atraso';
                                buttonClass = 'btn-warning';
                                break;
                            case 'Urgente':
                                situationClass = 'dropdown-urgente';
                                buttonClass = 'btn-danger';
                                break;
                        }

                        eventDetailsHtml += `
                            <div class="dropdown">
                                <button class="btn ${buttonClass} ${situationClass} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ${event.extendedProps.situation}: ${event.extendedProps.book}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><strong>Data de Retirada:</strong> ${event.extendedProps.dateRetirada}</li>
                                    <li><strong>Data de Devolução:</strong> ${event.extendedProps.dateDevolucao}</li>
                                    <li><strong>Tombo:</strong> ${event.extendedProps.tombo}</li>
                                    <li><strong>Situação:</strong> ${event.extendedProps.situation}</li>
                                </ul>
                            </div>
                            <hr>
                        `;
                    });
                } else {
                    eventDetailsHtml = `<p>Nenhum evento em ${info.dateStr}</p>`;
                }

                document.getElementById('eventDetails').style.display = 'block';
                document.getElementById('eventTitle').textContent = `Eventos em ${formatDate(info.dateStr)}`;
                document.getElementById('eventDescription').innerHTML = eventDetailsHtml;
            }    
        });

        calendar.render();
    });
    </script>
</body>
</html>