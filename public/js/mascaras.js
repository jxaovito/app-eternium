function mascaras(){
	$('.date, .data').mask('00/00/0000');
	$(document).on('focus', '.date, .data', function(){
		$('.date, .data').mask('00/00/0000');
	});

	$('.cep').mask('00000-000');
	$(document).on('focus', '.cep', function(){
		$('.cep').mask('00000-000');
	});
	
	$('.telefone, .phone').mask('(00) 00000-0000');
	$(document).on('focus', '.telefone, .phone', function(){
		$('.telefone, .phone').mask('(00) 00000-0000');
	});

	$('.cpf').mask('000.000.000-00', {reverse: true});
	$(document).on('focus', '.cpf', function(){
		$('.cpf').mask('000.000.000-00', {reverse: true});
	});

	$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
	$(document).on('focus', '.cnpj', function(){
		$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
	});

	$('.money').mask('000.000.000.000.000,00', {reverse: true});
	$(document).on('focus', '.money', function(){
		$('.money').mask('000.000.000.000.000,00', {reverse: true});
	});

	$('.porcentagem').mask('##0,00%', {reverse: true});
	$(document).on('focus', '.porcentagem', function(){
		$('.porcentagem').mask('##0,00%', {reverse: true});
	});

	$('.time').mask('00:00', {reverse: true});
	$(document).on('focus', '.time', function(){
		$('.time').mask('00:00', {reverse: true});
	});
	$(document).on('focusout', '.time', function(){
		if($(this).val().length == 1){
			$(this).val(`0${$(this).val()}:00`);

		}else if($(this).val().length == 2){
			$(this).val(`${$(this).val()}:00`);
		}

		if($(this).val().split(':')[0] > 23){
			$(this).val('');
			alerta('Hora inválida', 'vermelho');
		}

		if($(this).val().split(':')[1] > 59){
			$(this).val('');
			alerta('Minutos inválidos', 'vermelho');
		}


		$('.time').mask('00:00', {reverse: true});
	});
}