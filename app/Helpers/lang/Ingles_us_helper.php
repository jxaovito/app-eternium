<?php
function ingles_us($class, $key){
    if($class == 'agenda'){
        $array_lang = array(
            'msg1' => 'Today',
            'msg2' => 'Day',
            'msg3' => 'Week',
            'msg4' => 'Month',
            'msg5' => 'Professionals',
            'msg6' => 'Specialties',
            'msg7' => 'Appointment Reminders sending status',
            'msg8' => 'To send',
            'msg9' => 'Sent',
            'msg10' => 'Error when sending',
            'msg11' => 'Answered',
            'msg12' => 'New Schedule',
            'msg13' => 'To close',
            'msg14' => 'Click to activate/deactivate sending automatic reminders for this appointment.',
            'msg15' => 'Send Reminder',
            'msg16' => 'Initial date',
            'msg17' => 'End Date',
            'msg18' => 'Start Time',
            'msg19' => 'End Time',
            'msg20' => 'Scheduling',
            'msg21' => 'Patient',
            'msg22' => 'Treatment',
            'msg23' => 'Select...',
            'msg24' => 'Create treatment',
            'msg25' => 'Comments',
            'msg26' => 'Cancel',
            'msg27' => 'View Schedule',
            'msg28' => 'Edit Schedule',
            'msg29' => 'Cancel Edit',
            'msg30' => 'To close',
            'msg31' => 'Initial date',
            'msg32' => 'End Date',
            'msg33' => 'Start Time',
            'msg34' => 'End Time',
            'msg35' => 'Patient',
            'msg36' => 'Professional',
            'msg37' => 'Treatment',
            'msg38' => 'Procedure',
            'msg39' => 'Session',
            'msg40' => 'Cancel',
            'msg41' => 'Remove Agreement',
            'msg42' => 'Are you sure you want to <b>Remove</b> this schedule?',
            'msg43' => 'To remove',
            'msg44' => 'To remove',
            'msg45' => 'To save',
            'msg46' => 'Creating Treatment for',
            'msg47' => 'Cancel',
            'msg48' => 'Create Treatment',
            'msg49' => 'Patient',
            'msg50' => 'Comments',
            'msg51' => 'Patient',
            'msg52' => 'Professional',
            'msg53' => 'Treatment',
            'msg54' => 'Comments',
            'msg55' => 'Comments',
            'msg56' => 'Procedure',
            'msg57' => 'Procedure',
            'msg58' => 'Block Time',
            'msg59' => 'To save',
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