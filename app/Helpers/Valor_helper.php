<?php
function valor($valor = null){
	$idioma = session('moeda');

	if($idioma == 'R$'){
		$valor = number_format($valor, 2, ',', '');
		return $valor;

	}else if($idioma == '$'){
		$valor = number_format($valor, 2, '.', ',');
		return $valor;
	}
}

function moeda(){
	$idioma = session('moeda');

	if($idioma == 'R$'){
		$string = 'R$';
		return $string;

	}else if($idioma == '$'){
		$string = '$';
		return $string;
	}
}