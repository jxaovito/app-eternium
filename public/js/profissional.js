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

	$(document).on('keyup, focusout', '[name="senha"], [name="repetir_senha"]', function(){
		if($('[name="repetir_senha"]').val() && $('[name="senha"]').val()){
			if($('[name="repetir_senha"]').val() != $('[name="senha"]').val()){
				$('#status_senha').html('<sup>Senhas diferentes!</sup>');
				$('[type="submit"]').attr('disabled', 'disabled');

			}else{
				$('#status_senha').html('');
				$('[type="submit"]').removeAttr('disabled');
			}
		}else{
			$('#status_senha').html('');
			$('[type="submit"]').removeAttr('disabled');
		}
	});

	$(document).on('click', '[data-bs-title="Adicionar horários"]', function(){
		var container = $(this);
		var clone = container.parent('div').parent('div').find('.horarios').find('.first-div').clone();
		clone.find('input').val('');
		clone.removeClass('first-div');
		clone.find('.remover_linha').removeClass('d-none');
		$.each(container.parent('div').parent('div').find('.horarios'), function(index, val){
			if(!container.parent('div').parent('div').find('.horarios')[index+1]){
				$(this).append(clone);
			}
		})
	});

	$(document).on('click', '.remover_linha', function(){
		$(this).parent('div').remove();
	});
});