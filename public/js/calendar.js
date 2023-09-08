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
      useFormPopup: true,
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

    const observer = new MutationObserver(popup_nativo_abertura);
    const parent = document.body;
    observer.observe(parent, {
        childList: true, // Observar adições/remoções de nós filhos
        subtree: true // Observar todos os nós descendentes
    });

    $(document).on('click', '.close-modal-agenda', function(){
        $('.contents-modal').hide('fast');
        $('.toastui-calendar-popup-overlay').click();
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
        var dados = {};

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
});

var focus_paciente = 0;
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
        focus_paciente = 0;
    }
}

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

    if(!focus_paciente){
        setTimeout(function(){
            modal.find('[name="paciente"]').focus();
            focus_paciente++;
        }, 500);
    }
}

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
                modal.find('[name="data_inicio"]').val(data_para_br(dado.data_inicio));
                modal.find('[name="data_fim"]').val(data_para_br(dado.data_fim));
                modal.find('[name="hora_inicio"]').val(hora_inicio);
                modal.find('[name="hora_fim"]').val(hora_fim);
                modal.find('[name="paciente"]').val(dado.paciente);
                modal.find('[name="paciente_id"]').val(dado.paciente_id);
                modal.find('[name="paciente_id"]').val(dado.paciente_id);
                modal.find('[name="profissional"]').val(dado.profissional);
                modal.find('[name="profissional_id"]').val(dado.profissional_id);
                modal.find('[name="tratamento"]').val(dado.sessao != null ? `${dado.sessao}/${dado.sessoes_contratada}` : 'Reserva ');
                modal.find('[name="tratamento_id"]').val(dado.tratamento_id);

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

                    var label_sessao_contratada = 'sessao contratada';
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
    });
}