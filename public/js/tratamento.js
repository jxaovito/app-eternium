$(document).ready(function(){
	$(document).on('change', '[name="pagamentos"]', function(){
		if($(this).is(':checked')){
			$('.pagamentos-tratamento').show('fast');
			$('[name="forma_pagamento"]').parent('div').find('label').attr('required', 'required');
			$('[name="parcela_pagamento"]').parent('div').find('label').attr('required', 'required');
			$('[name="data_vencimento"]').parent('div').find('label').attr('required', 'required');
			$('[name="categoria"]').parent('div').find('label').attr('required', 'required');
			$('[name="subcategoria"]').parent('div').find('label').attr('required', 'required');
			$('[name="conta"]').parent('div').find('label').attr('required', 'required');

			$('[name="forma_pagamento"]').attr('required', 'required');
			$('[name="parcela_pagamento"]').attr('required', 'required');
			$('[name="data_vencimento"]').attr('required', 'required');
			$('[name="categoria"]').attr('required', 'required');
			$('[name="subcategoria"]').attr('required', 'required');
			$('[name="conta"]').attr('required', 'required');

		}else{
			$('.pagamentos-tratamento').hide('fast');
			$('[name="forma_pagamento"]').parent('div').find('label').removeAttr('required');
			$('[name="parcela_pagamento"]').parent('div').find('label').removeAttr('required');
			$('[name="data_vencimento"]').parent('div').find('label').removeAttr('required');
			$('[name="categoria"]').parent('div').find('label').removeAttr('required');
			$('[name="subcategoria"]').parent('div').find('label').removeAttr('required');
			$('name="conta"').parent('div').find('label').removeAttr('required');

			$('[name="forma_pagamento"]').removeAttr('required', 'required');
			$('[name="parcela_pagamento"]').removeAttr('required', 'required');
			$('[name="data_vencimento"]').removeAttr('required', 'required');
			$('[name="categoria"]').removeAttr('required', 'required');
			$('[name="subcategoria"]').removeAttr('required', 'required');
			$('[name="conta"]').removeAttr('required', 'required');
		}
	});

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
		$('[name="sessoes_procedimento[]"]').trigger('input');
	});

	$(document).on('input', '[name="valor_procedimento[]"], [name="desconto_procedimento[]"], [name="tipo_desconto[]"], [name="sessoes_procedimento[]"]', function(){
		var valor = $(this).parents('.procedimentos-clone').find('[name="valor_procedimento[]"]').val();
		var desconto = $(this).parents('.procedimentos-clone').find('[name="desconto_procedimento[]"]').val();
		var tipo_desconto = $(this).parents('.procedimentos-clone').find('[name="tipo_desconto[]"]').val();
		var sessoes = $(this).parents('.procedimentos-clone').find('[name="sessoes_procedimento[]"]').val();

		if($(this).attr('sessoes_consumidas') && $(this).val() < $(this).attr('sessoes_consumidas')){
			alerta(`Já foram realizadas ${$(this).attr('sessoes_consumidas')} sessões. Você não pode definir uma quantidade de sessões menor do que já foi realizada.`, 'vermelho');
			// $(this).val($(this).attr('sessoes_consumidas'));
			// sessoes = $(this).attr('sessoes_consumidas');
		}


		valor = (valor ? real_para_float(valor) : 0) * sessoes;
		desconto = desconto ? real_para_float(desconto) : 0;
		tipo_desconto = tipo_desconto ? tipo_desconto : 'real';

		var total = valor;
		if(tipo_desconto == 'porcentagem' && desconto){
			total = valor - (valor * desconto / 100);

		}else if(tipo_desconto == 'real'){
			total = valor - desconto;
		}

		$(this).parents('.procedimentos-clone').find('[name="total_procedimento[]"]').val(float_para_real(total));
		$(this).parents('.procedimentos-clone').find('[name="total_procedimento[]"]').trigger('input');

		if(total < 0){
			if($(this).attr('sessoes_consumidas') && $('[name="pagamentos"]').is(':checked')){
				var valor = $(this).parents('.procedimentos-clone').find('[name="valor_procedimento[]"]').val();
				valor = valor ? real_para_float(valor) : 0;

				valor = valor * sessoes;
				var total = valor;
				if(tipo_desconto == 'porcentagem' && desconto){
					total = valor - (valor * desconto / 100);

				}else if(tipo_desconto == 'real'){
					total = valor - desconto;
				}


				var credito_paciente = $('[name="credito_paciente"]').val() ? real_para_float($('[name="credito_paciente"]').val()) : 0;
				var valor = total * -1;
				credito_paciente = credito_paciente + valor;
				$('[name="credito_paciente"]').val(float_para_real(credito_paciente));
				$(this).parents('.procedimentos-clone').find('[name="total_procedimento[]"]').val(`-${float_para_real(credito_paciente)}`);

				var descontado = $('[name="credito_paciente"]').attr('descontado') ? $('[name="credito_paciente"]').attr('descontado') : '';
				var descontar =  $(this).parents('.procedimentos-clone').find('[name="procedimento_id[]"]').val();

				descontar = descontado != descontar && descontado ? descontado + ',' + descontar : descontar;
				$('[name="credito_paciente"]').attr('descontado', descontar);

				alerta('Você adicionou uma sessão menor do que já foi pago pelo <b>paciente</b>. O valor será <b>creditado</b> no registro do paciente.', 'amarelo', 12000);
				$('.credito-paciente').parent('div').show('fast');

			}else{
				alerta('O valor do Procedimento não pode ser Negativo', 'vermelho');

				$('.salvar-novo-tratamento').attr('readonly-disabled');
			}
		}
	});

	$(document).on('input', '[name="total_procedimento[]"]', function(){
		const container = $(this).parents('form');
		var subtotal = 0;

		$.each(container.find('[name="total_procedimento[]"]'), function(){
			var val = $(this).val() ? real_para_float($(this).val()) : 0;
			subtotal = subtotal + val;
		});

		$('[name="subtotal"]').val(float_para_real(subtotal));

		if(subtotal < 0){
			alerta('O valor do tratamento não pode ser Negativo', 'vermelho');

			$('.salvar-novo-tratamento').attr('readonly-disabled');
		}
	});

	$(document).on('input', '[name="sessoes_procedimento[]"]', function(){
		const container = $(this).parents('form');
		var total_sessoes = 0;

		$.each(container.find('[name="sessoes_procedimento[]"]'), function(){
			var val = $(this).val() ? parseInt($(this).val()) : 0;
			total_sessoes = total_sessoes + val;
		});

		$('[name="total_sessoes"]').val(total_sessoes);
	});

	$(document).on('input', '[name="desconto_real"], [name="sessoes_procedimento[]"], [name="valor_procedimento[]"], [name="desconto_procedimento[]"], [name="tipo_desconto[]"], [name="sessoes_procedimento[]"]', function(){
		if($('[name="subtotal"]').val()){
			if($('[name="desconto_real"]').val()){
				var total = real_para_float($('[name="subtotal"]').val());
				var desconto = $('[name="desconto_real"]').val() ? real_para_float($('[name="desconto_real"]').val()) : 0;

				total = total - desconto;

				if(total < 0){
					alerta('O total do tratamento não pode ser negativo.');
					$('[name="total"]').val('');
					return false;

				}else{
					$('[name="total"]').val(float_para_real(total));

				}

				$('[name="desconto_porcentagem"]').attr('readonly-disabled', 'readonly-disabled');
				$('[name="desconto_porcentagem"]').attr('readonly', 'readonly');
				$('[name="desconto_porcentagem"]').val('');

			}else{
				$('[name="total"]').val($('[name="subtotal"]').val());

				$('[name="desconto_porcentagem"]').removeAttr('readonly-disabled');
				$('[name="desconto_porcentagem"]').removeAttr('readonly');
				$('[name="desconto_porcentagem"]').val('');
			}
		}else{
			alerta('Você não pode aplicar o desconto sem haver um subtotal.', 'vermelho');
			$('[name="desconto_real"]').val('');
		}
	});

	$(document).on('input, keyup', '[name="desconto_porcentagem"], [name="sessoes_procedimento[]"], [name="valor_procedimento[]"], [name="desconto_procedimento[]"], [name="tipo_desconto[]"], [name="sessoes_procedimento[]"]', function(){
		if($('[name="subtotal"]').val()){
			if($('[name="desconto_porcentagem"]').val()){
				var total = real_para_float($('[name="subtotal"]').val());
				var desconto = $('[name="desconto_porcentagem"]').val() ? real_para_float($('[name="desconto_porcentagem"]').val()) : 0;

				total = total - (total * desconto / 100);

				if(total < 0){
					alerta('O total do tratamento não pode ser negativo.');
					$('[name="total"]').val('');
					return false;

				}else{
					$('[name="total"]').val(float_para_real(total));

				}

				$('[name="desconto_real"]').attr('readonly-disabled', 'readonly-disabled');
				$('[name="desconto_real"]').attr('readonly', 'readonly');
				$('[name="desconto_real"]').val('');

			}else{
				$('[name="total"]').val($('[name="subtotal"]').val());
				
				$('[name="desconto_real"]').removeAttr('readonly-disabled');
				$('[name="desconto_real"]').removeAttr('readonly');
				$('[name="desconto_real"]').val('');
			}
		}else{
			alerta('Você não pode aplicar o desconto sem haver um subtotal.', 'vermelho');
			$('[name="desconto_porcentagem"]').val('');
		}
	});

	$(document).on('change', '[name="categoria"]', function(){
		var categoria_id = $(this).val();
		var token = $('[name="_token"]').val();

		if(categoria_id){
			$.ajax({
				url: '/tratamento/get_subcategoria',
				type: 'post',
				data: {
					_token: token,
					categoria_id: categoria_id
				},
				dataType: 'json',
				success: function(data){
					if(data.length){
						$.each(data, function(index, val){
							$('[name="subcategoria"]').append(`<option value="">Selecione...</option>`);
							$('[name="subcategoria"]').append(`<option value="${val.id}">${val.nome}</option>`);
						});

					}else{
						$('[name="subcategoria"] option').val('');
						$('[name="subcategoria"] option').remove();
					}

					$('[name="subcategoria"]').trigger('change');
				},
			});
		}
	});
});