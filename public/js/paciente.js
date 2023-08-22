$(document).ready(function(){
	$(document).on('keyup', '#bairro_paciente', function(){
		if($(this).val()){
			$('#bairro_paciente').attr('required', 'required');
			$('[for="bairro_paciente"]').attr('required', 'required');

			$('#cidade_paciente').attr('required', 'required');
			$('[for="cidade_paciente"]').attr('required', 'required');
			$('#cidade_paciente').trigger('keyup');

		}else{
			$('#bairro_paciente').removeAttr('required');
			$('[for="bairro_paciente"]').removeAttr('required');

			$('#cidade_paciente').removeAttr('required');
			$('[for="cidade_paciente"]').removeAttr('required');
			$('#cidade_paciente').trigger('keyup');
		}
	});

	$(document).on('keyup', '#cidade_paciente', function(){
		if($(this).val()){
			$('#estado_paciente').attr('required', 'required');
			$('[for="estado_paciente"]').attr('required', 'required');
		}else{
			$('#estado_paciente').removeAttr('required');
			$('[for="estado_paciente"]').removeAttr('required');
		}
	});

	$(document).on('change', '#remover-imagem', function(){
		if($(this).is(':checked')){
			$(this).parent('div').parent('div').find('img').hide('slow');
		}else{
			$(this).parent('div').parent('div').find('img').show('slow');
			$('#imagem').val('');
		}
	});

	$(document).on('change', '#imagem', function(){
		if($(this).val()){
			$('#remover-imagem').click();
		}
	});
});