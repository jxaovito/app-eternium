<?php
function data($data = null){
    if(!$data){
        $data = new DateTime();
    }else{
        $data = new DateTime($data);
    }

    $idioma = session('idioma');

    if($idioma == 'portugues_br'){
        $data = $data->format('d/m/Y');

    }else if($idioma == 'ingles_us'){
        $data = $data->format('m/d/Y');

    }

    return $data;
}

function data_hora($data = null){
	if(!$data){
	    $data = new DateTime();
	}else{
	    $data = new DateTime($data);
	}

	$idioma = session('idioma');

	if($idioma == 'portugues_br'){
	    $data = $data->format('d/m/Y H:i:s');

	}else if($idioma == 'ingles_us'){
	    $data = $data->format('m/d/Y H:i:s');

	}

	return $data;
}

function data_para_db($data){
	$idioma = session('idioma');
	$data_formatada = '';

	if($data){
		if($idioma == 'portugues_br'){
			$data = explode('/', $data);
			$data_formatada = "$data[2]-$data[1]-$data[0]";
		
		}else if($idioma == 'ingles_us'){
			$data = explode('/', $data);
			$data_formatada = "$data[2]-$data[0]-$data[1]";
		}
	}

	return $data_formatada;
}