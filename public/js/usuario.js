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
});