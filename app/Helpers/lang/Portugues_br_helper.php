<?php
function portugues_br($class, $key){
    if($class == 'agenda'){
        $array_lang = array(
            'msg1' => 'Hoje',
            'msg2' => 'Dia',
            'msg3' => 'Semana',
            'msg4' => 'Mês',
            'msg5' => 'Profissionais',
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