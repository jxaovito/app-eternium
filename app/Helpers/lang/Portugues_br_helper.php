<?php
function portugues_br($class, $key){
    if($class == 'agenda'){
        $array_lang = array(
            'msg1' => 'Hoje',
            'msg2' => 'Dia',
            'msg3' => 'Semana',
            'msg4' => 'Mês',
            'msg5' => 'Profissionais',
            'msg6' => 'Especialidades',
            'msg7' => 'Status de envio dos Lembretes dos agendamentos',
            'msg8' => 'Enviar',
            'msg9' => 'Enviado',
            'msg10' => 'Erro ao Enviar',
            'msg11' => 'Respondido',
            'msg12' => 'Novo Agendamento',
            'msg13' => 'Fechar',
            'msg14' => 'Clique para ativar/desativar envio de lembrete automático deste agendamento.',
            'msg15' => 'Enviar Lembrete',
            'msg16' => 'Data Inicial',
            'msg17' => 'Data Fim',
            'msg18' => 'Hora Inicial',
            'msg19' => 'Hora Final',
            'msg20' => 'Agendamento',
            'msg21' => 'Paciente',
            'msg22' => 'Tratamento',
            'msg23' => 'Selecione...',
            'msg24' => 'Criar tratamento',
            'msg25' => 'Observações',
            'msg26' => 'Cancelar',
            'msg27' => 'Visualizar Agendamento',
            'msg28' => 'Editar Agendamento',
            'msg29' => 'Cancelar Edição',
            'msg30' => 'Fechar',
            'msg31' => 'Data Inicial',
            'msg32' => 'Data Fim',
            'msg33' => 'Hora Inicial',
            'msg34' => 'Hora Final',
            'msg35' => 'Paciente',
            'msg36' => 'Profissional',
            'msg37' => 'Tratamento',
            'msg38' => 'Procedimento',
            'msg39' => 'Sessão',
            'msg40' => 'Cancelar',
            'msg41' => 'Remover Convênio',
            'msg42' => 'Você tem certeza que deseja <b>Remover</b> este agendamento?',
            'msg43' => 'Remover',
            'msg44' => 'Remover',
            'msg45' => 'Salvar',
            'msg46' => 'Criando Tratamento para',
            'msg47' => 'Cancelar',
            'msg48' => 'Criar Tratamento',
            'msg49' => 'Paciente',
            'msg50' => 'Observações',
            'msg51' => 'Paciente',
            'msg52' => 'Profissional',
            'msg53' => 'Tratamento',
            'msg54' => 'Observações',
            'msg55' => 'Observações',
            'msg56' => 'Procedimento',
            'msg57' => 'Procedimento',
            'msg58' => 'Bloquear Horário',
            'msg59' => 'Salvar',
        );

    }else if($class == 'paciente'){
        $array_lang = array(
            'msg1' => 'Pacientes',
        );

    }

    // Padrões que aparecem em todas as telas ou não pertencem a um único módulo
    if(!isset($array_lang[$key])){
    	$array_lang = array(
            'menu_msg1' => 'Agenda',
        );
    }

    return $array_lang[$key];
}