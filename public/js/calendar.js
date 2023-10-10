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

$(document).ready(function(){
    // Ativar PopUp
    calendar.setOptions({
      useFormPopup: false,
      useDetailPopup: false,
    });

    // Iniciando Agendas
    calendar.setCalendars([
      {
        id: $('[type="hidden"][name="profissional_id"]').val(),
        name: $('[type="hidden"][name="profissional_nome"]').val(),
      },
    ]);

    // Inicializa o calendário
    calendar.render();

    // Nomeando os dias da semana
    calendar.setOptions({
        week: {
            dayNames: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        },
    });

    // Retorceder / Avançar Datas
    $(document).on('click', '.alternar-datas .voltar-datas, .alternar-datas .avancar-datas, .alternar-datas .hoje', function(){
        if($(this).hasClass('voltar-datas')){
            var tipo_agenda = $('.calendar-visualizacao.active').attr('tipo');

            if(tipo_agenda == 'month'){
                var data_inicio_anterior = $('[name="data_inicio_mes"]').val();
                var data_fim_anterior = $('[name="data_fim_mes"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_inicio = new Date(data_inicio_anterior);
                var data_fim = new Date(data_fim_anterior);

                // Subtrai 1 mês da data de início
                data_inicio.setMonth(data_inicio.getMonth() - 1);
                data_fim.setMonth(data_fim.getMonth() - 1);

                data_inicio.setDate(data_inicio.getDate() + 1);
                data_fim.setDate(data_fim.getDate() + 1);

                var data_inicio = data_inicio.getFullYear() + '-' + (data_inicio.getMonth() + 1).toString().padStart(2, '0') + '-' + data_inicio.getDate().toString().padStart(2, '0');
                var data_fim = data_fim.getFullYear() + '-' + (data_fim.getMonth() + 1).toString().padStart(2, '0') + '-' + data_fim.getDate().toString().padStart(2, '0');

                $('[name="data_inicio_mes"]').val(data_inicio);
                $('[name="data_fim_mes"]').val(data_fim);
            
            }else if(tipo_agenda == 'week'){
                var data_inicio_anterior = $('[name="data_inicio_semana"]').val();
                var data_fim_anterior = $('[name="data_fim_semana"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_inicio = new Date(data_inicio_anterior);
                var data_fim = new Date(data_fim_anterior);

                data_inicio.setDate(data_inicio.getDate() - 6);
                data_fim.setDate(data_fim.getDate() - 6);

                var data_inicio = data_inicio.getFullYear() + '-' + (data_inicio.getMonth() + 1).toString().padStart(2, '0') + '-' + data_inicio.getDate().toString().padStart(2, '0');
                var data_fim = data_fim.getFullYear() + '-' + (data_fim.getMonth() + 1).toString().padStart(2, '0') + '-' + data_fim.getDate().toString().padStart(2, '0');

                $('[name="data_inicio_semana"]').val(data_inicio);
                $('[name="data_fim_semana"]').val(data_fim);
            
            }else{
                var data_hoje = $('[name="data_hoje"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_hoje = new Date(data_hoje);

                var data_inicio = data_hoje.getFullYear() + '-' + (data_hoje.getMonth() + 1).toString().padStart(2, '0') + '-' + data_hoje.getDate().toString().padStart(2, '0');
                var data_fim = data_inicio;

                $('[name="data_hoje"]').val(data_inicio);
            }


            atualizar_agenda(data_inicio, data_fim);
            calendar.move(-1);

        }else if($(this).hasClass('avancar-datas')){
            var tipo_agenda = $('.calendar-visualizacao.active').attr('tipo');
            if(tipo_agenda == 'month'){
                var data_inicio_anterior = $('[name="data_inicio_mes"]').val();
                var data_fim_anterior = $('[name="data_fim_mes"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_inicio = new Date(data_inicio_anterior);
                var data_fim = new Date(data_fim_anterior);

                // Subtrai 1 mês da data de início
                data_inicio.setMonth(data_inicio.getMonth() + 1);
                data_fim.setMonth(data_fim.getMonth() + 1);

                data_inicio.setDate(data_inicio.getDate() + 1);
                data_fim.setDate(data_fim.getDate() + 1);

                var data_inicio = data_inicio.getFullYear() + '-' + (data_inicio.getMonth() + 1).toString().padStart(2, '0') + '-' + data_inicio.getDate().toString().padStart(2, '0');
                var data_fim = data_fim.getFullYear() + '-' + (data_fim.getMonth() + 1).toString().padStart(2, '0') + '-' + data_fim.getDate().toString().padStart(2, '0');

                $('[name="data_inicio_mes"]').val(data_inicio);
                $('[name="data_fim_mes"]').val(data_fim);
            
            }else if(tipo_agenda == 'week'){
                var data_inicio_anterior = $('[name="data_inicio_semana"]').val();
                var data_fim_anterior = $('[name="data_fim_semana"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_inicio = new Date(data_inicio_anterior);
                var data_fim = new Date(data_fim_anterior);

                data_inicio.setDate(data_inicio.getDate() + 8);
                data_fim.setDate(data_fim.getDate() + 8);

                var data_inicio = data_inicio.getFullYear() + '-' + (data_inicio.getMonth() + 1).toString().padStart(2, '0') + '-' + data_inicio.getDate().toString().padStart(2, '0');
                var data_fim = data_fim.getFullYear() + '-' + (data_fim.getMonth() + 1).toString().padStart(2, '0') + '-' + data_fim.getDate().toString().padStart(2, '0');

                $('[name="data_inicio_semana"]').val(data_inicio);
                $('[name="data_fim_semana"]').val(data_fim);
            
            }else{
                var data_hoje = $('[name="data_hoje"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_hoje = new Date(data_hoje);

                data_hoje.setDate(data_hoje.getDate() + 2);

                var data_inicio = data_hoje.getFullYear() + '-' + (data_hoje.getMonth() + 1).toString().padStart(2, '0') + '-' + data_hoje.getDate().toString().padStart(2, '0');
                var data_fim = data_inicio;

                $('[name="data_hoje"]').val(data_inicio);
            }

            atualizar_agenda(data_inicio, data_fim);
            calendar.move(1);
        
        }else{
            var tipo_agenda = $('.calendar-visualizacao.active').attr('tipo');
            if(tipo_agenda == 'month'){
                var data_inicio_anterior = $('[name="data_inicio_mes_padrao"]').val();
                var data_fim_anterior = $('[name="data_fim_mes_padrao"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_inicio = new Date(data_inicio_anterior);
                var data_fim = new Date(data_fim_anterior);

                var data_inicio = data_inicio.getFullYear() + '-' + (data_inicio.getMonth() + 1).toString().padStart(2, '0') + '-' + data_inicio.getDate().toString().padStart(2, '0');
                var data_fim = data_fim.getFullYear() + '-' + (data_fim.getMonth() + 1).toString().padStart(2, '0') + '-' + data_fim.getDate().toString().padStart(2, '0');

                $('[name="data_inicio_mes"]').val(data_inicio);
                $('[name="data_fim_mes"]').val(data_fim);
            
            }else if(tipo_agenda == 'week'){
                var data_inicio_anterior = $('[name="data_inicio_semana_padrao"]').val();
                var data_fim_anterior = $('[name="data_fim_semana_padrao"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_inicio = new Date(data_inicio_anterior);
                var data_fim = new Date(data_fim_anterior);

                var data_inicio = data_inicio.getFullYear() + '-' + (data_inicio.getMonth() + 1).toString().padStart(2, '0') + '-' + data_inicio.getDate().toString().padStart(2, '0');
                var data_fim = data_fim.getFullYear() + '-' + (data_fim.getMonth() + 1).toString().padStart(2, '0') + '-' + data_fim.getDate().toString().padStart(2, '0');

                $('[name="data_inicio_semana"]').val(data_inicio);
                $('[name="data_fim_semana"]').val(data_fim);
            
            }else{
                var data_hoje = $('[name="data_hoje"]').val();

                // Cria objetos Date a partir das datas anteriores
                var data_hoje = new Date(data_hoje);

                data_hoje.setDate(data_hoje.getDate() + 1);

                var data_inicio = data_hoje.getFullYear() + '-' + (data_hoje.getMonth() + 1).toString().padStart(2, '0') + '-' + data_hoje.getDate().toString().padStart(2, '0');
                var data_fim = data_inicio;

                $('[name="data_hoje"]').val(data_inicio);
            }

            atualizar_agenda(data_inicio, data_fim);
            calendar.today();
        }
    });

    // Ir para data expecífica
    $(document).on('change', '.container-agenda .selecionar-data .date', function(){
        var tipo_agenda = $('.calendar-visualizacao.active').attr('tipo');
        var date = $(this).val();
        date = date.split('/');

        if((date[0] && date[1] && date[2]) && (date[2].length == 4)){
            data_selecionada = date[2]+'-'+date[1]+'-'+date[0];

            if(tipo_agenda == 'month'){
                var data = new Date(data_selecionada);

                // Encontrar o primeiro dia do mês
                var primeiro_dia_mes = new Date(data.getFullYear(), data.getMonth(), 1);
                primeiro_dia_mes.setDate(primeiro_dia_mes.getDate() - 7);

                // Encontrar o último dia do mês
                var ultimo_dia_mes = new Date(data.getFullYear(), data.getMonth() + 1, 0);
                ultimo_dia_mes.setDate(ultimo_dia_mes.getDate() + 14);

                var data_inicio = `${primeiro_dia_mes.getFullYear()}-${String(primeiro_dia_mes.getMonth() + 1).padStart(2, '0')}-${String(primeiro_dia_mes.getDate()).padStart(2, '0')}`;
                var data_fim = `${ultimo_dia_mes.getFullYear()}-${String(ultimo_dia_mes.getMonth() + 1).padStart(2, '0')}-${String(ultimo_dia_mes.getDate()).padStart(2, '0')}`;

                $('[name="data_inicio_mes"]').val(data_inicio);
                $('[name="data_fim_mes"]').val(data_fim);

            }else if(tipo_agenda == 'week'){
                var data = new Date(data_selecionada);
                var dia_semana = data.getDay();
                var dia_inicio_semana = -dia_semana + 1;
                var dia_fim_semana = 7 - dia_semana;

                var primeiro_dia_semana = new Date(data);
                primeiro_dia_semana.setDate(data.getDate() + dia_inicio_semana);

                var ultimo_dia_semana = new Date(data);
                ultimo_dia_semana.setDate(data.getDate() + dia_fim_semana);

                var data_inicio = `${primeiro_dia_semana.getFullYear()}-${String(primeiro_dia_semana.getMonth() + 1).padStart(2, '0')}-${String(primeiro_dia_semana.getDate()).padStart(2, '0')}`;
                var data_fim = `${ultimo_dia_semana.getFullYear()}-${String(ultimo_dia_semana.getMonth() + 1).padStart(2, '0')}-${String(ultimo_dia_semana.getDate()).padStart(2, '0')}`;

                $('[name="data_inicio_semana"]').val(data_inicio);
                $('[name="data_fim_semana"]').val(data_fim);
            
            }else{
                // Cria objetos Date a partir das datas anteriores
                var data_hoje = new Date(data_selecionada);

                data_hoje.setDate(data_hoje.getDate() + 1);

                var data_inicio = data_hoje.getFullYear() + '-' + (data_hoje.getMonth() + 1).toString().padStart(2, '0') + '-' + data_hoje.getDate().toString().padStart(2, '0');
                var data_fim = data_inicio;

                $('[name="data_hoje"]').val(data_inicio);

                data_hoje.setDate(data_hoje.getDate() + 1);
                var data_selecionada = data_hoje.getFullYear() + '-' + (data_hoje.getMonth() + 1).toString().padStart(2, '0') + '-' + data_hoje.getDate().toString().padStart(2, '0');
            }

            atualizar_agenda(data_inicio, data_fim);
            calendar.setDate(data_selecionada);

        }else{
            alerta('Data inválida!', 'vermelho');
        }
    });

    // Mudar a visualização da Agenda
    calendar.changeView($('[name="visualizacao_agenda"]').val());
    $(document).on('click', '.calendar-visualizacao', function(){
        var tipo = $(this).attr('tipo');
        $(this).parent('div').find('button').removeClass('active');
        $(this).addClass('active');

        if(tipo == 'month'){
            var data_atual = new Date();
            var inicio_mes = new Date(data_atual.getFullYear(), data_atual.getMonth(), 1);
            var ultimo_dia_mes = new Date(data_atual.getFullYear(), data_atual.getMonth() + 1, 0);

            var inicio_mes_menos_7_dias = new Date(inicio_mes);
            inicio_mes_menos_7_dias.setDate(inicio_mes_menos_7_dias.getDate() - 7);

            var ultimo_dia_mes_menos_7_dia = new Date(ultimo_dia_mes);
            ultimo_dia_mes_menos_7_dia.setDate(ultimo_dia_mes_menos_7_dia.getDate() + 7);

            var formatoData = { day: '2-digit', month: '2-digit', year: 'numeric' };
            var data_inicio = inicio_mes_menos_7_dias.toLocaleDateString('pt-BR', formatoData);
            var data_fim = ultimo_dia_mes_menos_7_dia.toLocaleDateString('pt-BR', formatoData);

        }else if(tipo == 'week'){
            var data_atual = new Date();
            var primeiro_dia_semana = new Date(data_atual.getFullYear(), data_atual.getMonth(), data_atual.getDate() - data_atual.getDay());

            var data_inicio_semana = new Date(primeiro_dia_semana);
            data_inicio_semana.setDate(data_inicio_semana.getDate() + 1);

            var data_fim_semana = new Date(data_inicio_semana);
            data_fim_semana.setDate(data_fim_semana.getDate() + 6);

            var formatoData = { day: '2-digit', month: '2-digit', year: 'numeric' };
            var data_inicio = data_inicio_semana.toLocaleDateString('pt-BR', formatoData);
            var data_fim = data_fim_semana.toLocaleDateString('pt-BR', formatoData);

        }else{
            var data_atual = new Date();
            var formatoData = { day: '2-digit', month: '2-digit', year: 'numeric' };
            var data_inicio = data_atual.toLocaleDateString('pt-BR', formatoData);
            var data_fim = data_atual.toLocaleDateString('pt-BR', formatoData);
        }

        atualizar_agenda(data_inicio, data_fim);

        if(data_inicio.indexOf('/') != -1){
            var data_inicio = `${data_inicio.split('/')[2]}-${data_inicio.split('/')[1]}-${data_inicio.split('/')[0]}`;
        }else{
            var data_inicio = data_inicio;
        }

        if(data_fim.indexOf('/') != -1){
            var data_fim = `${data_fim.split('/')[2]}-${data_fim.split('/')[1]}-${data_fim.split('/')[0]}`;
        }else{
            var data_fim = data_fim;
        }
        $('[name="data_inicio_agenda"]').val(data_inicio);
        $('[name="data_fim_agenda"]').val(data_fim);

        calendar.changeView(tipo);
    });

    $(document).on('click', '.close-modal-agenda', function(){
        $('.contents-modal').hide('fast');
        $('.toastui-calendar-popup-overlay').click();
        calendar.clearGridSelections();
        setTimeout(function(){
            $('#calendar').css('width', '100%');
            $('.criar-agendamento').hide();
            $('.visualizar-agendamento').hide();
        },100);
    });

    $(document).on('click', '.criar-agendamento .tipo-agendamento span', function(){
        if(!$(this).hasClass('active')){
            $(this).parent('div').find('.active').removeClass('active');
            $(this).addClass('active');
            $(this).parent('div').find('[name="tipo-agendamento"]').val($(this).attr('tipo'));
        }
    });

    $('#busca_paciente_tratamento').on('input', function(){
        var self = $(this);
        if($(this).val().length > 0){
            var nome = $(this).val();
            var token = $('[name="_token"]').val();

            $.ajax({
              url: '/paciente/busca_paciente_by_nome',
              type: 'post',
              data: { nome: nome, _token: token },
              dataType: 'json',
                success: function(data){
                    autocomplete(data.data, self, 'autocomplete_paciente_id');
                }
            });
        }
    });

    $(document).on('change', '.autocomplete_paciente_id', function(){
        var id = $(this).val();
        var token = $('[name="_token"]').val();

        $.ajax({
            url: '/paciente/busca_paciente_by_id',
            type: 'post',
            data:{ 
                id: id,
                tratamento: true,
                _token: token,
            },
            dataType: 'json',
            success: function(data){
                $('select.convenio').val(data.convenio_id);
                $('select.convenio').trigger('change');

                if(data.tratamento){
                    $('[name="tratamento_id"]').val('');
                    $('[name="tratamento_id"]').find('option').remove();
                    $('[name="tratamento_id"]').append(`<option value="">Selecione...</option>`);

                    $.each(data.tratamento, function(index, value){
                        if(value.sessoes_consumida != value.sessoes_contratada){
                            if(data.tratamento.length > 1){
                                $('[name="tratamento_id"]').append(`<option value="${value.tratamento_id}">${data_para_br(value.data_hora.split(' ')[0])} ${value.profissional} (${value.especialidade}) - ${value.sessoes_consumida}/${value.sessoes_contratada}</option>`);
                            }else{
                                $('[name="tratamento_id"]').append(`<option selected="selected" value="${value.tratamento_id}">${data_para_br(value.data_hora.split(' ')[0])} ${value.profissional} (${value.especialidade}) - ${value.sessoes_consumida}/${value.sessoes_contratada}</option>`);
                            }
                        }
                    });
                }
            },
        });
    });

    // Criar novo Agendamento (Salvar novo agendamento)
    $(document).on('click', '.salvar-novo-agendamento', function(){
        var results = $(this).parents('form').serialize().split('&');
        var whatsapp = $(this).parents('.criar-agendamento').find('[name="whatsapp"]').val();
        var dados = {};

        if(whatsapp){
            results.push(`whatsapp=${whatsapp}`);
        }

        for(var i = 0; i < results.length; i++){
            var pair = results[i].split('=');
            dados[pair[0]] = decodeURIComponent(pair[1]);
        }

        var data_parts = dados.data_inicio.split("/");
        var dia = data_parts[0];
        var mes = data_parts[1];
        var ano = data_parts[2];
        var hora_parts = dados.hora_inicio.split(":");
        var horas = hora_parts[0];
        var minutos = hora_parts[1];

        var data_hora_inicio = ano+'-'+mes+'-'+dia+'T'+horas+':'+minutos+':00';

        var data_parts = dados.data_fim.split("/");
        var dia = data_parts[0];
        var mes = data_parts[1];
        var ano = data_parts[2];
        var hora_parts = dados.hora_fim.split(":");
        var horas = hora_parts[0];
        var minutos = hora_parts[1];

        var data_hora_fim = ano+'-'+mes+'-'+dia+'T'+horas+':'+minutos+':00';

        $.ajax({
            url: '/agenda/criar_agendamento',
            type: 'post',
            data: {
                dados: dados,
                profissional_id: $('[type="hidden"][name="profissional_id"]').val(),
                _token: dados._token,
            },
            dataType: 'json',
            success: function(data){
                atualizar_agenda()
            },
        });

        $('.close-modal-agenda').trigger('click');
    });

    // Atualiza agenda
    atualizar_agenda();

    // Ao clicar no Evento
    calendar.on('clickEvent', ({ event }) => {
        visualizar_agendamento(event.id)
    });

    // Remover Agendamento
    $(document).on('click', '.remover_agendamento', function(){
        const agenda_id = $(this).attr('agenda_id');
        const tratamento_id = $(this).attr('tratamento_id');
        setTimeout(function(){
            $('#modal_deletar').find('.modal-footer').find('a').attr('href', 'javascript:void(0);');
            $('#modal_deletar').find('.modal-footer').find('a').attr('agenda_id', agenda_id);
            $('#modal_deletar').find('.modal-footer').find('a').attr('tratamento_id', tratamento_id);
            $('#modal_deletar').find('.modal-footer').find('a').removeClass('confirmacao_remover_agendamento');
            $('#modal_deletar').find('.modal-footer').find('a').addClass('confirmacao_remover_agendamento');
        }, 10)
    });

    // Confirmação para remover agendamento
    $(document).on('click', '.confirmacao_remover_agendamento', function(){
        $.ajax({
            url: '/agenda/remover_agendamento',
            type: 'post',
            data: {
                agenda_id: $(this).attr('agenda_id'),
                tratamento_id: $(this).attr('tratamento_id'),
                _token: $('#form_menu').find('[name="_token"]').val(),
            },
            dataType: 'json',
            success: function(data){
                atualizar_agenda();
                $('#modal_deletar').find('.modal-footer').find('[data-bs-dismiss="modal"]').click();
                $('.visualizar-agendamento').find('.close-modal-agenda').click();

                alerta('Removido com sucesso!', 'azul')
            },
        });
    });


    calendar.on('selectDateTime', ( event ) => {
        var ano = event.start.getFullYear();
        var mes = String(event.start.getMonth() + 1).padStart(2, '0'); // Mês é base 0, então adicionamos 1 e formatamos com 2 dígitos.
        var dia = String(event.start.getDate()).padStart(2, '0');
        var hora = String(event.start.getHours()).padStart(2, '0');
        var minuto = String(event.start.getMinutes()).padStart(2, '0');
        var segundo = String(event.start.getSeconds()).padStart(2, '0');

        var data_inicio = `${ano}-${mes}-${dia}`;
        var hora_inicio = `${hora}:${minuto}`;

        var ano = event.end.getFullYear();
        var mes = String(event.end.getMonth() + 1).padStart(2, '0'); // Mês é base 0, então adicionamos 1 e formatamos com 2 dígitos.
        var dia = String(event.end.getDate()).padStart(2, '0');
        var hora = String(event.end.getHours()).padStart(2, '0');
        var minuto = String(event.end.getMinutes()).padStart(2, '0');
        var segundo = String(event.end.getSeconds()).padStart(2, '0');

        var data_fim = `${ano}-${mes}-${dia}`;
        var hora_fim = `${hora}:${minuto}`;

        criar_agendamento(data_inicio, data_fim, hora_inicio, hora_fim);
    });

    function criar_agendamento(data_inicio, data_fim, hora_inicio, hora_fim){
        $('#calendar').css('width', '70%');
        $('.contents-modal').show('fast');
        $('.visualizar-agendamento').hide('fast');

        var modal = $('.criar-agendamento');

        modal.find('[name="data_inicio"]').val(data_para_br(data_inicio));
        modal.find('[name="data_fim"]').val(data_para_br(data_fim));
        modal.find('[name="hora_inicio"]').val(hora_inicio);
        modal.find('[name="hora_fim"]').val(hora_fim);
        modal.show();

         setTimeout(function(){
            modal.find('[name="paciente"]').focus();
        }, 500);
    }

    calendar.on('beforeUpdateEvent', function ({ event, changes }) {
      const { id, calendarId } = event;

      var data_inicio = null;
      var hora_inicio = null;
      if(changes.start){
        var ano = changes.start.getFullYear();
        var mes = String(changes.start.getMonth() + 1).padStart(2, '0'); // Mês é base 0, então adicionamos 1 e formatamos com 2 dígitos.
        var dia = String(changes.start.getDate()).padStart(2, '0');
        var hora = String(changes.start.getHours()).padStart(2, '0');
        var minuto = String(changes.start.getMinutes()).padStart(2, '0');
        var segundo = String(changes.start.getSeconds()).padStart(2, '0');

        data_inicio = `${ano}-${mes}-${dia}`;
        hora_inicio = `${hora}:${minuto}`;
      }

      var ano = changes.end.getFullYear();
      var mes = String(changes.end.getMonth() + 1).padStart(2, '0'); // Mês é base 0, então adicionamos 1 e formatamos com 2 dígitos.
      var dia = String(changes.end.getDate()).padStart(2, '0');
      var hora = String(changes.end.getHours()).padStart(2, '0');
      var minuto = String(changes.end.getMinutes()).padStart(2, '0');
      var segundo = String(changes.end.getSeconds()).padStart(2, '0');

      var data_fim = `${ano}-${mes}-${dia}`;
      var hora_fim = `${hora}:${minuto}`;

      atualizar_agendamento(id, data_inicio, data_fim, hora_inicio, hora_fim);
    });

    // Editar dados do agendamento
    $(document).on('click', '.editar_dados_agendamento i', function(){
        const container = $('.visualizar-agendamento');
        const element = $('.editar_dados_agendamento .btn_editar_dados_agendamento');
        const self = $(this);

        if(element.hasClass('ph-pencil-simple')){
            $('.bg_modal_editar_agendamento').remove();
            $('.contents-modal').append('<div class="bg_modal_editar_agendamento"></div>');
            container.find('.dados_agendamento').addClass('z-index-10');
            container.find('.header-modal').addClass('z-index-10');

            container.find('.ph-x').removeClass('d-none');
            element.removeClass('ph-pencil-simple');
            element.addClass('ph-check');
            element.css('background-color', element.attr('background-cliente')+'!important');

            element.tooltip('dispose');
            element.attr('data-bs-title', 'Salvar Edição');
            element.tooltip();

            // Btn de Remover Agendamento
            container.find('.remover_agendamento').attr('readonly-disabled', 'readonly-disabled');
            container.find('.remover_agendamento').attr('readonly', 'readonly');
            container.find('.remover_agendamento').addClass('subclass_remover_agendamento');
            container.find('.remover_agendamento').removeClass('remover');
            container.find('.remover_agendamento').removeClass('remover_agendamento');

            // Btn de Salvar
            container.find('.salvar-editar-agendamento').attr('readonly-disabled', 'readonly-disabled');
            container.find('.salvar-editar-agendamento').attr('readonly', 'readonly');
            container.find('.salvar-editar-agendamento').addClass('subclass_salvar-editar-agendamento');
            container.find('.salvar-editar-agendamento').removeClass('salvar-editar-agendamento');

            // Btn de Cancelar
            container.find('.close-modal-agenda').attr('readonly-disabled', 'readonly-disabled');
            container.find('.close-modal-agenda').attr('readonly', 'readonly');
            container.find('.close-modal-agenda').addClass('subclass_close-modal-agenda');
            container.find('.close-modal-agenda').removeClass('close-modal-agenda');

            // Altaração dos elementos Inputs
            container.find('[name="data_inicio"]').removeAttr('readonly');
            container.find('[name="data_inicio"]').removeClass('border-none');
            container.find('[name="data_inicio"]').addClass('data');

            container.find('[name="data_fim"]').removeAttr('readonly');
            container.find('[name="data_fim"]').removeClass('border-none');
            container.find('[name="data_fim"]').addClass('data');
            data();

            container.find('[name="hora_inicio"]').removeAttr('readonly');
            container.find('[name="hora_inicio"]').removeClass('border-none');

            container.find('[name="hora_fim"]').removeAttr('readonly');
            container.find('[name="hora_fim"]').removeClass('border-none');

            container.find('[name="profissional_label"]').hide();
            container.find('.select_profissional').removeClass('d-none');

            container.find('.observacoes-agendamento').removeClass('d-none');
            container.find('[name="observacoes"]').removeAttr('readonly');
            container.find('[name="observacoes"]').removeClass('border-none');

        }else{

            // Salvar edição de dados do agendamento
            if(self.hasClass('btn_editar_dados_agendamento')){
                agenda_id = container.find('[name="agenda_id"]').val();
                data_inicio = data_para_us(container.find('[name="data_inicio"]').val());
                data_fim = data_para_us(container.find('[name="data_fim"]').val());
                hora_inicio = container.find('[name="hora_inicio"]').val();
                hora_fim = container.find('[name="hora_fim"]').val();
                profissional_id = container.find('[name="profissional"]').val();
                observacoes = container.find('[name="observacoes"]').val();

                atualizar_agendamento(agenda_id, data_inicio, data_fim, hora_inicio, hora_fim, profissional_id, observacoes);

                if(profissional_id != container.find('[name="profissional_id"]').val()){
                    $('.close-modal-agenda').click();
                }
            }

            $('.bg_modal_editar_agendamento').remove();
            container.find('.dados_agendamento').removeClass('z-index-10');
            container.find('.header-modal').removeClass('z-index-10');

            container.find('.editar_dados_agendamento').find('.ph-x').addClass('d-none');
            element.removeClass('ph-check');
            element.addClass('ph-pencil-simple');
            element.css('background-color', element.attr('background-cliente-transp')+'!important');

            element.tooltip('dispose');
            element.attr('data-bs-title', 'Editar Agendamento');
            element.tooltip();

            // Btn de Remover Agendamento
            container.find('.subclass_remover_agendamento').removeAttr('readonly-disabled');
            container.find('.subclass_remover_agendamento').removeAttr('readonly');
            container.find('.subclass_remover_agendamento').addClass('remover_agendamento');
            container.find('.subclass_remover_agendamento').addClass('remover');
            container.find('.subclass_remover_agendamento').removeClass('subclass_remover_agendamento');

            // Btn de Salvar
            container.find('.subclass_salvar-editar-agendamento').removeAttr('readonly-disabled', 'readonly-disabled');
            container.find('.subclass_salvar-editar-agendamento').removeAttr('readonly', 'readonly');
            container.find('.subclass_salvar-editar-agendamento').addClass('salvar-editar-agendamento');
            container.find('.subclass_salvar-editar-agendamento').removeClass('subclass_salvar-editar-agendamento');

            // Btn de Cancelar
            container.find('.subclass_close-modal-agenda').removeAttr('readonly-disabled', 'readonly-disabled');
            container.find('.subclass_close-modal-agenda').removeAttr('readonly', 'readonly');
            container.find('.subclass_close-modal-agenda').addClass('close-modal-agenda');
            container.find('.subclass_close-modal-agenda').removeClass('subclass_close-modal-agenda');

            // Alteração dos elementos inputs
            container.find('[name="data_inicio"]').attr('readonly', 'readonly');
            container.find('[name="data_inicio"]').addClass('border-none');
            container.find('[name="data_inicio"]').removeClass('data');

            container.find('[name="data_fim"]').addClass('border-none');
            container.find('[name="data_fim"]').attr('readonly', 'readonly');
            container.find('[name="data_fim"]').removeClass('data');

            container.find('[name="hora_inicio"]').addClass('border-none');
            container.find('[name="hora_inicio"]').attr('readonly', 'readonly');

            container.find('[name="hora_fim"]').addClass('border-none');
            container.find('[name="hora_fim"]').attr('readonly', 'readonly');

            container.find('[name="profissional_label"]').show();
            container.find('.select_profissional').addClass('d-none');

            if(!container.find('[name="observacoes"]').val()){
                container.find('.observacoes-agendamento').addClass('d-none');
            }
            container.find('[name="observacoes"]').addClass('border-none');
            container.find('[name="observacoes"]').attr('readonly', 'readonly');
        }
    });

    // Resolver bug que ao renderizar edição de datas para visualziar agendaento, ao cancelar bloquear a possibilidade de editar a data
    $(document).on('click', '.visualizar-agendamento [name="data_inicio"], .visualizar-agendamento [name="data_fim"]', function(){
        if($(this).attr('readonly')){
            setTimeout(function(){
                $('#ui-datepicker-div').remove();
            }, 100);
        }
    });
    $(document).on('click', function(){
        if(!$('#ui-datepicker-div').length){
            data();
        }
    });

    $(document).on('click', '.bg_modal_editar_agendamento', function(){
        alerta('Salve ou cancele a edição do agendamento!', 'azul')
    });

    // Ativa/desativa envio de lembrete automático para agendamento
    $(document).on('click', '.ativar-lembrete-whats', function(){
        if($(this).find('.ph-check').is(':visible')){
            $(this).addClass('opacity-05');
            $(this).find('.ph-check').addClass('d-none');
            $(this).parents('.criar-agendamento').find('[name="whatsapp"]').val('');
            alerta('Desativado envio de lembrete automático para este agendamento.', 'azul');

        }else{
            $(this).removeClass('opacity-05');
            $(this).find('.ph-check').removeClass('d-none');
            $(this).parents('.criar-agendamento').find('[name="whatsapp"]').val('enviar');
            alerta('Ativado envio de lembrete automático para este agendamento.', 'azul');
        }
    });

    // Criar Tratamento através da agenda
    $(document).on('click', '.btn_criar_tratamento_ag', function(){
        const element = $(this);
        const container = $(this).parents('form');

        if(!container.find('[name="paciente"]').val() || !container.find('[name="paciente_id"]').val()){
            alerta('Você deve selecionar um <b>paciente</b> antes de criar um <b>tratamento</b>', 'amarelo');
            destacar(container.find('[name="paciente"]'));

            return false;
        }

        container.find('[name="tratamento_id"]').val('');
        container.find('[name="tratamento_id"]').find('option').removeAttr('selected');
        container.find('[name="tratamento_id"]').parent('div').find('.select2').hide();
        container.find('[name="tratamento_id"]').parent('div').find('span').removeClass('d-none');
        element.addClass('d-none');

        $('.modal-criar-tratamento').removeClass('d-none');
        $('#calendar').addClass('d-none');
        $('.btn-acoes-agenda').addClass('pointer-events-none');
        $('.btn-acoes-agenda').addClass('opacity-05');
        $('.contents-modal').css('width', '100%');
        $('.criar-agendamento').addClass('d-none');
        $('.criar-tratamento-agenda-header').html(`Criando Tratamento para <b>${container.find('[id="busca_paciente_tratamento"]').val()}</b>`);
    });

    // Cancelar criação de tratamento
    $(document).on('click', '.close-modal-criar-tratamento', function(){
        const container = $('.criar-agendamento').find('form');

        if(container.find('[name="tratamento_id"]').find('option').length == 2){
            var id_select_tratamento = '';
            $.each(container.find('[name="tratamento_id"]').find('option'), function(i,v){
                if($(this).attr('value')){
                    $(this).attr('selected', 'selected');
                    id_select_tratamento = $(this).val();
                }
            });

            container.find('[name="tratamento_id"]').val(id_select_tratamento);
        }

        container.find('[name="tratamento_id"]').parent('div').find('span').addClass('d-none');
        container.find('[name="tratamento_id"]').parent('div').find('.select2').show();
        container.find('[name="tratamento_id"]').parent('div').find('.select2').removeClass('d-none');
        container.find('[name="tratamento_id"]').parent('div').find('.select2').find('span').removeClass('d-none');
        $('.btn_criar_tratamento_ag').removeClass('d-none');

        $('.modal-criar-tratamento').addClass('d-none');
        $('#calendar').removeClass('d-none');
        $('.btn-acoes-agenda').removeClass('pointer-events-none');
        $('.btn-acoes-agenda').removeClass('opacity-05');
        $('.contents-modal').css('width', '30%');
        $('.criar-agendamento').removeClass('d-none');
    });

    // Adicionar procedimentos no cadastro de tratamento através da agenda
    $(document).on('click', '.adicionar_procedimento', function(){
        const container = $(this).parents('form');
        var element = container.find('.clone_procedimento_agenda.first_procedimento').clone();

        element.removeClass('first_procedimento');
        var id_element = $('[name="desconto_procedimento[]"]').length - 1;
        element.find('[name="desconto_procedimento[]"]').attr('id', `valor_desconto_${id_element}`);
        element.find('[for="valor_desconto"]').attr('for', `valor_desconto_${id_element}`);

        container.find('.lista_procedimentos').append(element);
        element.find('[data-bs-title="adicionar_procedimento"]').tooltip();
        container.find('.lista_procedimentos').css('padding-bottom', '60px');
    });

    // Remove procedimentos adicionados no cadastro de tratamento através da agenda
    $(document).on('click', '.lista_procedimentos [data-bs-title="Remover Procedimento"]', function(){
        const container = $(this).parents('.clone_procedimento_agenda');

        if(container.hasClass('first_procedimento')){
            container.find('input').val('');

        }else{
            container.remove();
        }

        if($('.clone_procedimento_agenda').length == 1){
            $('.lista_procedimentos').css('padding-bottom', '10px');
        }
    });
});

function visualizar_agendamento(agenda_id){
    $('#calendar').css('width', '70%');
    $('.contents-modal').show('fast');
    $('.criar-agendamento').hide('fast');
    var _token = $('[name="_token"]').val();

    var modal = $('.visualizar-agendamento');
    modal.show();
    
    $.ajax({
        url: '/agenda/busca_agendamento',
        type: 'post',
        data: {
            _token: _token,
            agenda_id: agenda_id
        },
        dataType: 'json',
        success: function(data){
            $.each(data, function(index, dado){
                var hora_inicio = `${dado.hora_inicio.split(':')[0]}:${dado.hora_inicio.split(':')[1]}`;
                var hora_fim = `${dado.hora_fim.split(':')[0]}:${dado.hora_fim.split(':')[1]}`;

                modal.find('.header-modal').find('h4').text(dado.tipo_agendamento);
                modal.find('[name="agenda_id"]').val(dado.id);
                modal.find('[name="data_inicio"]').val(data_para_br(dado.data_inicio));
                modal.find('[name="data_inicio"]').attr('value', data_para_br(dado.data_inicio));
                modal.find('[name="data_fim"]').val(data_para_br(dado.data_fim));
                modal.find('[name="data_fim"]').attr('value', data_para_br(dado.data_fim));
                modal.find('[name="hora_inicio"]').val(hora_inicio);
                modal.find('[name="hora_fim"]').val(hora_fim);
                modal.find('[name="paciente"]').val(dado.paciente);
                modal.find('[name="paciente_id"]').val(dado.paciente_id);
                modal.find('[name="paciente_id"]').val(dado.paciente_id);
                modal.find('[name="profissional_label"]').val(dado.profissional);
                modal.find('[name="profissional_id"]').val(dado.profissional_id);
                modal.find('[name="profissional"]').val(dado.profissional_id);
                modal.find('[name="profissional"]').trigger('change');
                modal.find('[name="tratamento"]').val(dado.sessao != null ? `${dado.sessao}/${dado.sessoes_contratada}` : 'Reserva ');
                modal.find('[name="tratamento_id"]').val(dado.tratamento_id);
                modal.find('.remover_agendamento').attr('agenda_id', dado.id);
                modal.find('.remover_agendamento').attr('tratamento_id', dado.tratamento_id);

                if(dado.observacoes){
                    modal.find('.observacoes-agendamento').removeClass('d-none');
                    modal.find('[name="observacoes"]').val(dado.observacoes);
                }else{
                    modal.find('.observacoes-agendamento').addClass('d-none');
                    modal.find('[name="observacoes"]').val('');
                }

                modal.find('.procedimentos').html('');
                var procedimentos = dado.procedimentos.split('[|]');
                var id_procedimentos = dado.id_procedimentos.split(',');
                var tratamento_has_procedimento = dado.tratamento_has_procedimento.split(',');
                var sessoes_contratada = dado.sessoes_contratada_proc.split(',');
                var sessoes_consumida = dado.sessoes_consumida_proc.split(',');
                $.each(procedimentos, function(i, val){
                    clone = modal.find('.procedimento_clone').clone();
                    clone.removeClass('procedimento_clone');
                    clone.removeClass('d-none');
                    clone.find('[name="procedimento[]"]').val(val);
                    clone.find('[name="procedimento_id[]"').val(id_procedimentos[i]);
                    clone.find('[name="tratamento_has_procedimento_id[]"').val(tratamento_has_procedimento[i]);
                    var label_sessao_consumida = 'Sessão consumida';
                    if(sessoes_consumida[i] > 1){
                        label_sessao_consumida = 'Sessões consumidas';
                    }

                    var label_sessao_contratada = 'sessão contratada';
                    if(sessoes_contratada[i] > 1){
                        label_sessao_contratada = 'sessões contratadas';
                    }
                    clone.find('label').text(`${sessoes_consumida[i]} ${label_sessao_consumida} de ${sessoes_contratada[i]} ${label_sessao_contratada}`);

                    modal.find('.procedimentos').append(clone);
                });
            });
        },
    });
}

function atualizar_agendamento(agenda_id, data_inicio = null, data_fim = null, hora_inicio, hora_fim, profissional_id = null, observacoes = null){
    $.ajax({
        url: '/agenda/atualizar_agendamento',
        type: 'post',
        data: {
            agenda_id: agenda_id,
            data_inicio: data_inicio,
            data_fim: data_fim,
            hora_inicio: hora_inicio,
            hora_fim: hora_fim,
            profissional_id: profissional_id,
            observacoes: observacoes,
            _token: $('#form_menu').find('[name="_token"]').val(),
        },
        dataType: 'json',
        success: function(data){
            
        },
    });

    atualizar_agenda();
}

function atualizar_agenda(data_inicio = false, data_fim = false){
    var profissional_id = $('[name="profissional_id"]').val();
    var _token = $('[name="_token"]').val();
    calendar.clear();

    if(!data_inicio){
        var data_inicio_agenda = $('[name="data_inicio_agenda"]').val();
    }else{
        if(data_inicio.indexOf('/') != -1){
            var data_inicio_agenda = `${data_inicio.split('/')[2]}-${data_inicio.split('/')[1]}-${data_inicio.split('/')[0]}`;
        }else{
            var data_inicio_agenda = data_inicio;
        }
    }

    if(!data_fim){
        var data_fim_agenda = $('[name="data_fim_agenda"]').val();

    }else{
        if(data_fim.indexOf('/') != -1){
            var data_fim_agenda = `${data_fim.split('/')[2]}-${data_fim.split('/')[1]}-${data_fim.split('/')[0]}`;
        }else{
            var data_fim_agenda = data_fim;
        }
    }

    $.ajax({
        url: '/agenda/atualizar_agenda',
        type: 'post',
        data: {
            _token: _token,
            data_inicio_agenda: data_inicio_agenda,
            data_fim_agenda: data_fim_agenda,
            profissional_id: profissional_id,
        },
        dataType: 'json',
        success: function(data){
            if(data){
                $.each(data, function(index, dado){
                    var sessao = '';
                    var cor_fundo = dado.cor_fundo;

                    if(dado.sessao){
                        sessao = `${dado.sessao}/${dado.sessoes_contratada}`;
                    }else{
                        sessao = 'Reserva';
                        cor_fundo = cor_fundo+63;
                    }

                    if(dado.whatsapp){
                        if(dado.whatsapp == 'enviar'){
                            lembrete = '⚪';

                        }else if(dado.whatsapp == 'enviado'){
                            lembrete = '🟢';

                        }else if(dado.whatsapp == 'erro_enviar'){
                            lembrete = '🔴';

                        }else if(dado.whatsapp == 'respondido'){
                            lembrete = '🔵';
                        }
                    }else{
                        lembrete = '';
                    }

                    calendar.createEvents([
                        {
                            id: dado.agenda_id,
                            calendarId: dado.profissional_id,
                            title: `${lembrete} ${dado.paciente} (${sessao})`,
                            start: `${dado.data_inicio}T${dado.hora_inicio}`,
                            end: `${dado.data_fim}T${dado.hora_fim}`,
                            body: dado.observacoes,
                            color: dado.cor_fonte,
                            backgroundColor: cor_fundo,
                            borderColor: dado.cor_fundo,
                            dragBackgroundColor: dado.cor_fundo+9,
                            isReadOnly: false,
                        },
                    ]);
                });
            }

            if($('.criar-agendamento form [type="hidden"][name="_token"]').val()){
                $('.criar-agendamento form [type="hidden"][name="_token"]').attr('_token', $('.criar-agendamento form [type="hidden"][name="_token"]').val());
            }
            $('.criar-agendamento form').find('input').val('');
            $('.criar-agendamento form').find('select').val('');
            $('.criar-agendamento form').find('select').find('option').remove();
            $('.criar-agendamento form').find('select').trigger('change');
            $('.criar-agendamento form').find('textarea').val('');
            $('.criar-agendamento form').find('[name="tipo-agendamento"]').val('1');
            $('.criar-agendamento .tipo-agendamento').find('span').removeClass('active');
            $('.criar-agendamento .tipo-agendamento').find('[tipo="1"]').addClass('active');
            $('.criar-agendamento form [type="hidden"][name="_token"]').val($('.criar-agendamento form [type="hidden"][name="_token"]').attr('_token'));
        },
        complete: function(){
            setTimeout(function(){
                $('.toastui-calendar-template-time span').each(function(){
                    if($(this).text().indexOf('⚪') != -1){
                        $(this).html(`<svg class="w-13px h-13px relative top-px--1 wp-branco" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Envio de Lembrete Pendente"><use xlink:href="#whatsapp"></use></svg> ${$(this).text().replaceAll('⚪', '')}`);
                        $(this).find('svg').tooltip();
                    }

                    if($(this).text().indexOf('🟢') != -1){
                        $(this).html(`<svg class="w-13px h-13px relative top-px--1 wp-verde" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Envio de Lembrete Realizado"><use xlink:href="#whatsapp"></use></svg> ${$(this).text().replaceAll('🟢', '')}`);
                        $(this).find('svg').tooltip();
                    }

                    if($(this).text().indexOf('🔴') != -1){
                        $(this).html(`<svg class="w-13px h-13px relative top-px--1 wp-vermelho" data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Falha ao Enviar Lembrete"><use xlink:href="#whatsapp"></use></svg> ${$(this).text().replaceAll('🔴', '')}`);
                        $(this).find('svg').tooltip();
                    }
                });
            }, 100);
        }
    });
}