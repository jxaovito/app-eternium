$(document).ready(function(){
	$('#busca_paciente_tratamento').on('input', function(){
		var self = $(this);
		if($(this).val().length > 0){
			var nome = $(this).val();
			var token = $('[name="_token"]').val();

			$.ajax({
		      url: '/paciente/busca_paciente_by_nome',
		      type: 'post',
		      data: { nome: nome, _token: token },
		      dataType: 'json',
				success: function(data){
					autocomplete(data.data, self, 'autocomplete_paciente_id');
				}
		  	});
		}
	});

	$(document).on('input', '.busca_procedimento_tratamento', function(){
		if(!$('.convenio').val()){
			alerta('Você deve selecionar um convênio para buscar os procedimentos.', 'vermelho');
		}

		var self = $(this);
		if($(this).val().length > 0){
			var nome = $(this).val();
			var token = $('[name="_token"]').val();
			var convenio_id = $('.convenio').val();

			$.ajax({
		      url: '/procedimento/busca_procedimento_by_nome_and_convenio',
		      type: 'post',
		      data: { nome: nome, _token: token, convenio_id: convenio_id, },
		      dataType: 'json',
				success: function(data){
					autocomplete_procedimento_tratamento(data, self, 'autocomplete_procedimento_id');
				}
		  	});
		}
	});

	$(document).on('change', '.autocomplete_paciente_id', function(){
		var id = $(this).val();
		var token = $('[name="_token"]').val();
		$.ajax({
			url: '/paciente/busca_paciente_by_id',
			type: 'post',
			data: { id: id, _token: token },
			dataType: 'json',
			success: function(data){
				$('select.convenio').val(data.convenio_id);
				$('select.convenio').trigger('change');
			},
		});
	});

	$(document).on('change', '[name="profissional"]', function(){
		var id = $(this).val();
		var token = $('[name="_token"]').val();

		$.ajax({
			url: '/profissional/get_especialidade_by_profissional_id',
			type: 'post',
			data: {
				id: id,
				_token: token,
			},
			dataType: 'json',
			success: function(data){
				$('.especialidade').find('option').remove();

				if(data){
					var select = true;
					$.each(data, function(index, val){
						if(data[index+1]){
							select = false;
						}
						$('.especialidade').append(`<option value="">Selecione...</option>`);
						$('.especialidade').append(`<option ${select ? 'selected' : ''} value="${val.especialidade_id}">${val.especialidade}</option>`);
					});

				}else{
					alerta('Nenhuma especialidade configurada para o Profissional', 'amarelo');

					$.ajax({
						url: '/especialidade/get_all_especialidade',
						type: 'post',
						data: {
							_token: token,
						},
						dataType: 'json',
						success: function(data){
							$.each(data, function(index, val){
								$('.especialidade').append(`<option value="">Selecione...</option>`);
								$('.especialidade').append(`<option value="${val.id}">${val.nome}</option>`);
							});
						},
					});
				}

				$('.especialidade').trigger('change');
			},
		});
	});

	$(document).on('click', '.add_procedimento', function(){
		var clone = $('.clones .procedimentos-clone').clone();
		clone.removeClass('d-none');
		var radom = Math.floor(Math.random() * 100001);
		clone.find('[for="valor_desconto"]').attr('for', `valor_desconto_${radom}`);
		clone.find('[id="valor_desconto"]').attr('id', `valor_desconto_${radom}`);

		$('.content-procedimentos').append(clone);
	});

	$(document).on('click', '.remover_procedimento_tratamento', function(){
		$(this).parents('.procedimentos-clone').remove();
	});
});