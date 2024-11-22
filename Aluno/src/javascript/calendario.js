document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('../../dracotheca_files/Aluno/PHP/get_eventos.php')
                .then(response => response.json())
                .then(data => {
                    const events = data.map(event => ({
                        title: event.book,
                        start: event.start_date,
                        end: event.end_date,
                        extendedProps: {
                            situation: event.situation,
                        }
                    }));
                    successCallback(events);
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
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