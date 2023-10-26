<?php
function ingles_us($class, $key){
    if($class == 'agenda'){
        $array_lang = array(
            'msg1' => 'Today',
            'msg2' => 'Day',
            'msg3' => 'Week',
            'msg4' => 'Month',
            'msg5' => 'Professionals',
        );

    }else if($class == 'paciente'){
        $array_lang = array(
            'msg1' => 'Patients',
        );

    }

    // Padrões que aparecem em todas as telas ou não pertencem a um único módulo
    if(!isset($array_lang[$key])){
        $array_lang = array(
            'menu_msg1' => 'Schedule',
        );
    }

    return $array_lang[$key];
}