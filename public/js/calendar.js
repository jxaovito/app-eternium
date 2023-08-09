$(document).ready(function() {
    // Obtém uma referência ao elemento do calendário
    const calendarElement = $('#calendar')[0]; // Convertendo para um elemento DOM

    // Cria uma instância do calendário
    const calendar = new tui.Calendar('#calendar', {
        defaultView: 'week', // Modo de exibição padrão (semana, mês, etc.)
        useCreationPopup: false, // Desativar pop-up para criar eventos
        useDetailPopup: false, // Desativar pop-up para detalhes de eventos
        scheduleFilter(schedule) {
          return schedule.category !== 'milestone' && schedule.category !== 'task';
        },

        // Configuração para o padrão português brasileiro e horário de Brasília
        language: 'pt-BR',
        timezones: [
          {
            timezoneOffset: -180, // Offset para o horário de Brasília (em minutos)
            displayLabel: 'Brasília',
          },
        ],
        hourStart: 0, // Começa às 00:00 (formato de 24 horas)
        hourEnd: 24,  // Termina às 24:00 (formato de 24 horas)
      });
});