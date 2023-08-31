$(document).ready(function(){
    // Cria uma instância do calendário
    const calendar = new tui.Calendar('#calendar', {
        usageStatistics: false,
        defaultView: 'week', // Modo de exibição padrão (semana, mês, etc.)
        useCreationPopup: true, // Desativar pop-up para criar eventos
        useDetailPopup: true, // Desativar pop-up para detalhes de eventos
        isReadOnly: false, //Ativa somente leitura no calendário
        scheduleFilter(schedule) {
            return schedule.category !== 'milestone' && schedule.category !== 'task';
        },
        language: 'pt-BR',
        week: {
            dayNames: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        },
        week: {
            startDayOfWeek: 1,
        },
        timezone: {
            zones: [
                {
                    timezoneOffset: -180, // Offset para o horário de Brasília (em minutos)
                    displayLabel: 'Brasília',
                    tooltip: 'Horário de Brasília',
                },
            ]
          },
        hourStart: 0, // Começa às 00:00 (formato de 24 horas)
        hourEnd: 24,  // Termina às 24:00 (formato de 24 horas)
    });

    // Ativar PopUp
    calendar.setOptions({
      useFormPopup: true,
      useDetailPopup: true,
    });

    // Iniciando Agendas
    calendar.setCalendars([
      {
        id: '1',
        name: 'Gustavo Rieper',
        color: '#ffffff',
        backgroundColor: '#9e5fff',
        dragBackgroundColor: '#9e5fff',
        borderColor: '#9e5fff',
      },
      {
        id: '2',
        name: 'Bruna Vinter',
        color: '#ffffff',
        backgroundColor: '#00a9ff',
        dragBackgroundColor: '#00a9ff',
        borderColor: '#00a9ff',
      },
    ]);

    // Inicializa o calendário
    calendar.render();

    calendar.on('beforeCreateEvent', (eventObj) => {
      console.log(eventObj);
    });

    // Nomeando os dias da semana
    calendar.setOptions({
        week: {
            dayNames: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        },
    });

    // Retorceder / Avançar Datas
    $(document).on('click', '.alternar-datas .voltar-datas, .alternar-datas .avancar-datas, .alternar-datas .hoje', function(){
        if($(this).hasClass('voltar-datas')){
            calendar.move(-1);

        }else if($(this).hasClass('avancar-datas')){
            calendar.move(1);
        
        }else{
            calendar.today();
        }
    });

    // Ir para data expecífica
    $(document).on('change', '.container-agenda .selecionar-data .date', function(){
        var date = $(this).val();
        date = date.split('/');

        if((date[0] && date[1] && date[2]) && (date[2].length == 4)){
            calendar.setDate(date[2]+'-'+date[1]+'-'+date[0]);
        }else{
            alerta('Data inválida!', 'vermelho');
        }
    });

    // Mudar a visualização da Agenda
    // calendar.changeView('month');
    calendar.changeView('week');
    // calendar.changeView('day');

    calendar.createEvents([
      {
        id: '1',
        calendarId: '1',
        title: 'Weekly Meeting',
        start: '2023-08-28T20:00:00',
        end: '2023-08-28T21:00:00',
      },
      {
        id: '2',
        calendarId: '2',
        title: 'Weekly Meeting',
        start: '2023-08-28T09:00:00',
        end: '2023-08-28T10:00:00',
      },
    ]);

    const firstEvent = calendar.getEvent('event1', 'cal1');
    const secondEvent = calendar.getEvent('event2', 'cal2');

    const observer = new MutationObserver(popup_nativo_abertura);
    const parent = document.body;
    observer.observe(parent, {
        childList: true, // Observar adições/remoções de nós filhos
        subtree: true // Observar todos os nós descendentes
    });

    $(document).on('click', '.close-modal-agenda', function(){
        console.log('teste');
        $('.contents-modal').hide('fast');
        $('.toastui-calendar-popup-overlay').click();
        setTimeout(function(){
            $('#calendar').css('width', '100%');
        },100);
    });
});

function popup_nativo_abertura() {
    // const target = document.querySelector('.toastui-calendar-popup-overlay');
    const target = document.querySelector('.toastui-calendar-popup-overlay');
    
    // Se o elemento existir e for visível
    if(target && getComputedStyle(target).display !== 'none'){
        if($('.toastui-calendar-popup-container').find('[name="start"]').val() && $('.toastui-calendar-popup-container').find('[name="end"]').val()){
            $('.toastui-calendar-event-detail-popup-slot').hide();
            $('.toastui-calendar-event-form-popup-slot').hide();

            const data_inicio = $('.toastui-calendar-popup-container').find('[name="start"]').val().split(' ')[0];
            const data_fim = $('.toastui-calendar-popup-container').find('[name="end"]').val().split(' ')[0];

            const hora_inicio = $('.toastui-calendar-popup-container').find('[name="start"]').val().split(' ')[1];
            const hora_fim = $('.toastui-calendar-popup-container').find('[name="end"]').val().split(' ')[1];

            criar_agendamento(data_inicio, data_fim, hora_inicio, hora_fim);
            
        }
    }else{
        $('.close-modal-agenda').trigger('click');
    }
}

function criar_agendamento(data_inicio, data_fim, hora_inicio, hora_fim){
    $('#calendar').css('width', '70%');
    $('.contents-modal').show('fast');

    var modal = $('.criar-agendamento');

    modal.find('[name="data_inicio"]').val(data_para_br(data_inicio))
    modal.find('[name="data_fim"]').val(data_para_br(data_fim))
    modal.find('[name="hora_inicio"]').val(hora_inicio)
    modal.find('[name="hora_fim"]').val(hora_fim)
}