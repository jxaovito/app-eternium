$(document).ready(function(){
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

	$(document).on('keyup', '[name="senha"], [name="repetir_senha"]', function(){
		if($('[name="repetir_senha"]').val() && $('[name="senha"]').val()){
			if($('[name="repetir_senha"]').val() != $('[name="senha"]').val()){
				$('#status_senha').html('<sup>Senhas diferentes!</sup>');
				$('[type="submit"]').attr('disabled', 'disabled');

			}else{
				$('#status_senha').html('');
				$('[type="submit"]').removeAttr('disabled');
			}
		}
	});
});