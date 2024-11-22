// /*
// *   @author Camila Inocencio
// *   @version 1.0    
// *   @file calendario.js
// *   @description Javascript da tela calendário.php.
// *   Aqui, é criado um calendário interativo com a biblioteca FullCalendar, exibindo eventos relacionados a livros e detalhando informações ao clicar em uma data.
// */
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        events: [
            {
                book: 'Entendendo Algorítmos',
                tombo: '104294',
                start: '2024-11-20',
                dateRetirada: '08-08-2024',
                dateDevolucao: '08-08-2024',
                aluno: 'Carla Mariguella',
                situation: 'Devolvido',
                color: '#88A27C'
            },
            {
                book: 'Programming Python',
                tombo: '104294',
                start: '2024-11-20',
                dateRetirada: '08-08-2024',
                dateDevolucao: '08-08-2024',
                aluno: 'Carla Mariguella',
                situation: 'Empréstimo',
                color: '#9e9e9e33'
            },
            {
                book: 'Entendendo Algorítmos',
                tombo: '104294',
                start: '2024-11-20',
                dateRetirada: '08-08-2024',
                dateDevolucao: '08-08-2024',
                aluno: 'Carla Mariguella',
                situation: 'Atraso na devolução',
                color: '#ffeb3bae'
            },
            {
                book: 'Entendendo Algorítmos',
                tombo: '104294',
                start: '2024-11-20',
                dateRetirada: '08-08-2024',
                dateDevolucao: '08-08-2024',
                aluno: 'Carla Mariguella',
                situation: 'Urgente',
                color: '#f44336cb'
            }
        ],
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

                    switch (event.extendedProps.situation) {
                        case 'Devolvido':
                            situationClass = 'dropdown-devolvido';
                            break;
                        case 'Empréstimo':
                            situationClass = 'dropdown-emprestimo';
                            break;
                        case 'Atraso na devolução':
                            situationClass = 'dropdown-atraso';
                            break;
                        case 'Urgente':
                            situationClass = 'dropdown-urgente';
                            break;
                    }

                    eventDetailsHtml += `
                        <div class="dropdown">
                            <button class="btn ${situationClass} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ${event.extendedProps.situation}: ${event.extendedProps.book}
                            </button>
                            <ul class="dropdown-menu">
                                <li><strong>Data de Retirada:</strong> ${event.extendedProps.dateRetirada}</li>
                                <li><strong>Data de Devolução:</strong> ${event.extendedProps.dateDevolucao}</li>
                                <li><strong>Aluno:</strong> ${event.extendedProps.aluno}</li>
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
            document.getElementById('eventTitle').textContent = `Eventos em ${info.dateStr}`;
            document.getElementById('eventDescription').innerHTML = eventDetailsHtml;
        }    
    });

    calendar.render();
});