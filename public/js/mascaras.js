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
	$(document).on('focus', '.v', function(){
		$('.porcentagem').mask('##0,00%', {reverse: true});
	});
}