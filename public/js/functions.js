$(document).ready(function(){

	// Ativação de popover
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

	// Alterar texto da Paginação
	$('.flex.items-center.justify-between .flex.justify-between.flex-1').remove();
	var divTexto = $('p.text-sm.text-gray-700.leading-5');
  	var textoAtual = divTexto.text();
  	var novoTexto = textoAtual.replace('Showing', 'Mostrando de')
	                            .replace('to', 'a')
	                            .replace('of', 'em um total de')
	                            .replace('results', 'resultados');

  	divTexto.text(novoTexto);

  	data();

	// Mascaras
	mascaras();

	$("select").select2();

	$("select").select2({
		placeholder: "Selecione...",
		allowClear: true,
		language: "pt-BR"
	});
	$(document).on('keypress', '.select2-search', function(){
		$(this).parent('span').find('ul').hide();
	});
	$(document).on('keyup keydown', '.select2-search', function(){
		$(this).parent('span').find('ul').show();
		if($(this).parent('span').find('ul').find('li').text() == 'No results found'){
			$(this).parent('span').find('ul').find('li').text('Nenhum resultado Encontrado.');
			$(this).parent('span').find('ul').find('li').css('color', '#212529!important');
		}else{
			$(this).parent('span').find('ul').find('li').css('color', '#212529!important');
		}
	});
	$(document).on('click', '.select2', function(){
		if($('.select2-results').find('ul').find('li').text() == 'No results found'){
			$('.select2-results').find('ul').find('li').text('Nenhum resultado Encontrado.');
			$('.select2-results').find('ul').find('li').css('color', '#212529!important');
		}else{
			$('.select2-results').find('ul').find('li').css('color', '#212529!important');
		}
	});

	// Efeito para menu nos drop-down
	$(document).on('mouseenter', '.opc-drop-down-nav', function(){
		$(this).find('.drop-down-nav').show();
	}).on('mouseleave', '.opc-drop-down-nav', function() {
	    $(this).find('.drop-down-nav').hide();
	});

	// Chamar Loading a cada clique de carregamento
	// $('a[href!="#"]').on('click', function(event) {
	// 	event.preventDefault(); // Evita o comportamento padrão do link
	// 	mostrar_loading();
	// 	// Obtém o href do link
	// 	var href = $(this).attr('href');
	// 	// Redireciona manualmente para o href após algum tempo (exemplo: 1 segundo)
	// 	setTimeout(function() {
	// 		window.location.href = href;
	// 	}, 1); // Tempo em milissegundos
	// });

	// Modal de deletar (remover)
	$(document).on('click', '.deletar, .remover', function(){
		var link = $(this).attr('link');
		var titulo = $(this).attr('titulo');
		var texto = $(this).attr('texto');
		var texto_confirm = $(this).attr('btn-texto');
		var btn_cor = $(this).attr('btn-cor');

		$('#modal_deletar #modal_deletar_titulo').html(titulo);
		$('#modal_deletar #modal_deletar_content').html(texto);
		$('#modal_deletar .modal-footer a').attr('href', link);
		$('#modal_deletar .modal-footer a button').text(texto_confirm ? texto_confirm : 'Deletar');
		$('#modal_deletar .modal-footer a button').removeClass('btn-danger');

		if(btn_cor){
			$('#modal_deletar .modal-footer a button').addClass('btn-'+btn_cor);
		}else{
			$('#modal_deletar .modal-footer a button').addClass('btn-danger');
		}

		$('#modal_deletar').modal('show');
	});

	// Configuração padrão de Abas
	$(document).on('click', '.aba .opc', function(){
		var self = $(this);
		self.parent('div').find('.opc').removeClass('active');

		if(!$(`.${self.attr('destino')}`).is(':visible')){
			$('[destino-aba="true"]').hide('fast');
			setTimeout(function(){
				$('[destino-aba="true"]').addClass('d-none');
				$('[destino-aba="true"]').removeClass('active');
			}, 200);

			setTimeout(function(){
				$(`.${self.attr('destino')}`).removeClass('d-none');
				self.addClass('active');
				$(`.${self.attr('destino')}`).show('fast');
			}, 300);
		}
	});

	// validação e Preenchimento de CEP
	$(document).on('keyup', '.cep', function(){
		var self = $(this);
		if($(this).val().length == 0){
			if(self.parents('div').find('.estado').length){
				self.parents('div').find('.estado').val('');
				self.parents('div').find('.estado').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').find('.estado').attr('readonly', 'readonly');

			}else if(self.parents('div').parents('div').find('.estado').length){
				self.parents('div').parents('div').find('.estado').vaL('');
				self.parents('div').parents('div').find('.estado').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').find('.estado').attr('readonly', 'readonly');

			}else if(self.parents('div').parents('div').parents('div').find('.estado').length){
				self.parents('div').parents('div').parents('div').find('.estado').val('');
				self.parents('div').parents('div').parents('div').find('.estado').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').parents('div').find('.estado').attr('readonly', 'readonly');
				
			}else if(self.parents('div').parents('div').parents('div').parents('div').find('.estado').length){
				self.parents('div').parents('div').parents('div').parents('div').find('.estado').val('');
				self.parents('div').parents('div').parents('div').parents('div').find('.estado').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').parents('div').parents('div').find('.estado').attr('readonly', 'readonly');
			}

			if(self.parents('div').find('.cidade').length){
				self.parents('div').find('.cidade').val('');
				self.parents('div').find('.cidade').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').find('.cidade').attr('readonly', 'readonly');

			}else if(self.parents('div').parents('div').find('.cidade').length){
				self.parents('div').parents('div').find('.cidade').val('');
				self.parents('div').parents('div').find('.cidade').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').find('.cidade').attr('readonly', 'readonly');

			}else if(self.parents('div').parents('div').parents('div').find('.cidade').length){
				self.parents('div').parents('div').parents('div').find('.cidade').val('');
				self.parents('div').parents('div').parents('div').find('.cidade').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').parents('div').find('.cidade').attr('readonly', 'readonly');
				
			}else if(self.parents('div').parents('div').parents('div').parents('div').find('.cidade').length){
				self.parents('div').parents('div').parents('div').parents('div').find('.cidade').val('');
				self.parents('div').parents('div').parents('div').parents('div').find('.cidade').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').parents('div').parents('div').find('.cidade').attr('readonly', 'readonly');
			}

			if(self.parents('div').find('.bairro').length){
				self.parents('div').find('.bairro').val('');
				self.parents('div').find('.bairro').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').find('.bairro').attr('readonly', 'readonly');

			}else if(self.parents('div').parents('div').find('.bairro').length){
				self.parents('div').parents('div').find('.bairro').val('');
				self.parents('div').parents('div').find('.bairro').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').find('.bairro').attr('readonly', 'readonly');

			}else if(self.parents('div').parents('div').parents('div').find('.bairro').length){
				self.parents('div').parents('div').parents('div').find('.bairro').val('');
				self.parents('div').parents('div').parents('div').find('.bairro').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').parents('div').find('.bairro').attr('readonly', 'readonly');
				
			}else if(self.parents('div').parents('div').parents('div').parents('div').find('.bairro').length){
				self.parents('div').parents('div').parents('div').parents('div').find('.bairro').val('');
				self.parents('div').parents('div').parents('div').parents('div').find('.bairro').attr('readonly-disabled', 'readonly-disabled');
				self.parents('div').parents('div').parents('div').parents('div').find('.bairro').attr('readonly', 'readonly');
				
			}
		}

		if($(this).val().length == 9){
			$.ajax({
				url: `https://viacep.com.br/ws/${$(this).val().replaceAll('-', '')}/json/`,
				type: 'get',
				dataType: 'json',
				success: function(data){
					if(!data.erro){
						if(data.uf){
							if(self.parents('div').find('.estado').length){
								self.parents('div').find('.estado').val(data.uf);
								self.parents('div').find('.estado').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').find('.estado').attr('readonly', 'readonly');

							}else if(self.parents('div').parents('div').find('.estado').length){
								self.parents('div').parents('div').find('.estado').val(data.uf);
								self.parents('div').parents('div').find('.estado').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').find('.estado').attr('readonly', 'readonly');

							}else if(self.parents('div').parents('div').parents('div').find('.estado').length){
								self.parents('div').parents('div').parents('div').find('.estado').val(data.uf);
								self.parents('div').parents('div').parents('div').find('.estado').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').parents('div').find('.estado').attr('readonly', 'readonly');
								
							}else if(self.parents('div').parents('div').parents('div').parents('div').find('.estado').length){
								self.parents('div').parents('div').parents('div').parents('div').find('.estado').val(data.uf);
								self.parents('div').parents('div').parents('div').parents('div').find('.estado').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').parents('div').parents('div').find('.estado').attr('readonly', 'readonly');
								
							}
						}else{
							if(self.parents('div').find('.estado').length){
								self.parents('div').find('.estado').val('');
								self.parents('div').find('.estado').removeAttr('readonly-disabled');
								self.parents('div').find('.estado').removeAttr('readonly');

							}else if(self.parents('div').parents('div').find('.estado').length){
								self.parents('div').parents('div').find('.estado').val('');
								self.parents('div').parents('div').find('.estado').removeAttr('readonly-disabled');
								self.parents('div').parents('div').find('.estado').removeAttr('readonly');

							}else if(self.parents('div').parents('div').parents('div').find('.estado').length){
								self.parents('div').parents('div').parents('div').find('.estado').val('');
								self.parents('div').parents('div').parents('div').find('.estado').removeAttr('readonly-disabled');
								self.parents('div').parents('div').parents('div').find('.estado').removeAttr('readonly');
								
							}else if(self.parents('div').parents('div').parents('div').parents('div').find('.estado').length){
								self.parents('div').parents('div').parents('div').parents('div').find('.estado').val('');
								self.parents('div').parents('div').parents('div').parents('div').find('.estado').removeAttr('readonly-disabled');
								self.parents('div').parents('div').parents('div').parents('div').find('.estado').removeAttr('readonly');
								
							}
						}

						if(data.localidade){
							if(self.parents('div').find('.cidade').length){
								self.parents('div').find('.cidade').val(data.localidade);
								self.parents('div').find('.cidade').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').find('.cidade').attr('readonly', 'readonly');

							}else if(self.parents('div').parents('div').find('.cidade').length){
								self.parents('div').parents('div').find('.cidade').val(data.localidade);
								self.parents('div').parents('div').find('.cidade').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').find('.cidade').attr('readonly', 'readonly');

							}else if(self.parents('div').parents('div').parents('div').find('.cidade').length){
								self.parents('div').parents('div').parents('div').find('.cidade').val(data.localidade);
								self.parents('div').parents('div').parents('div').find('.cidade').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').parents('div').find('.cidade').attr('readonly', 'readonly');
								
							}else if(self.parents('div').parents('div').parents('div').parents('div').find('.cidade').length){
								self.parents('div').parents('div').parents('div').parents('div').find('.cidade').val(data.localidade);
								self.parents('div').parents('div').parents('div').parents('div').find('.cidade').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').parents('div').parents('div').find('.cidade').attr('readonly', 'readonly');
								
							}
						}else{
							if(self.parents('div').find('.cidade').length){
								self.parents('div').find('.cidade').val('');
								self.parents('div').find('.cidade').removeAttr('readonly-disabled');
								self.parents('div').find('.cidade').removeAttr('readonly');

							}else if(self.parents('div').parents('div').find('.cidade').length){
								self.parents('div').parents('div').find('.cidade').val('');
								self.parents('div').parents('div').find('.cidade').removeAttr('readonly-disabled');
								self.parents('div').parents('div').find('.cidade').removeAttr('readonly');

							}else if(self.parents('div').parents('div').parents('div').find('.cidade').length){
								self.parents('div').parents('div').parents('div').find('.cidade').val('');
								self.parents('div').parents('div').parents('div').find('.cidade').removeAttr('readonly-disabled');
								self.parents('div').parents('div').parents('div').find('.cidade').removeAttr('readonly');
								
							}else if(self.parents('div').parents('div').parents('div').parents('div').find('.cidade').length){
								self.parents('div').parents('div').parents('div').parents('div').find('.cidade').val('');
								self.parents('div').parents('div').parents('div').parents('div').find('.cidade').removeAttr('readonly-disabled');
								self.parents('div').parents('div').parents('div').parents('div').find('.cidade').removeAttr('readonly');
								
							}
						}

						if(data.bairro){
							if(self.parents('div').find('.bairro').length){
								self.parents('div').find('.bairro').val(data.bairro);
								self.parents('div').find('.bairro').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').find('.bairro').attr('readonly', 'readonly');

							}else if(self.parents('div').parents('div').find('.bairro').length){
								self.parents('div').parents('div').find('.bairro').val(data.bairro);
								self.parents('div').parents('div').find('.bairro').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').find('.bairro').attr('readonly', 'readonly');

							}else if(self.parents('div').parents('div').parents('div').find('.bairro').length){
								self.parents('div').parents('div').parents('div').find('.bairro').val(data.bairro);
								self.parents('div').parents('div').parents('div').find('.bairro').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').parents('div').find('.bairro').attr('readonly', 'readonly');
								
							}else if(self.parents('div').parents('div').parents('div').parents('div').find('.bairro').length){
								self.parents('div').parents('div').parents('div').parents('div').find('.bairro').val(data.bairro);
								self.parents('div').parents('div').parents('div').parents('div').find('.bairro').attr('readonly-disabled', 'readonly-disabled');
								self.parents('div').parents('div').parents('div').parents('div').find('.bairro').attr('readonly', 'readonly');
								
							}
						}else{
							if(self.parents('div').find('.bairro').length){
								self.parents('div').find('.bairro').val('');
								self.parents('div').find('.bairro').removeAttr('readonly-disabled');
								self.parents('div').find('.bairro').removeAttr('readonly');

							}else if(self.parents('div').parents('div').find('.bairro').length){
								self.parents('div').parents('div').find('.bairro').val('');
								self.parents('div').parents('div').find('.bairro').removeAttr('readonly-disabled');
								self.parents('div').parents('div').find('.bairro').removeAttr('readonly');

							}else if(self.parents('div').parents('div').parents('div').find('.bairro').length){
								self.parents('div').parents('div').parents('div').find('.bairro').val('');
								self.parents('div').parents('div').parents('div').find('.bairro').removeAttr('readonly-disabled');
								self.parents('div').parents('div').parents('div').find('.bairro').removeAttr('readonly');
								
							}else if(self.parents('div').parents('div').parents('div').parents('div').find('.bairro').length){
								self.parents('div').parents('div').parents('div').parents('div').find('.bairro').val('');
								self.parents('div').parents('div').parents('div').parents('div').find('.bairro').removeAttr('readonly-disabled');
								self.parents('div').parents('div').parents('div').parents('div').find('.bairro').removeAttr('readonly');
								
							}
						}

					}else{
						alerta('CEP não encontrado', 'amarelo');

						if(self.parents('div').find('.estado').length){
							self.parents('div').find('.estado').removeAttr('readonly-disabled');
							self.parents('div').find('.estado').removeAttr('readonly');
							self.parents('div').find('.estado').val('');

						}else if(self.parents('div').parents('div').find('.estado').length){
							self.parents('div').parents('div').find('.estado').removeAttr('readonly-disabled');
							self.parents('div').parents('div').find('.estado').removeAttr('readonly');
							self.parents('div').parents('div').find('.estado').val('');

						}else if(self.parents('div').parents('div').parents('div').find('.estado').length){
							self.parents('div').parents('div').parents('div').find('.estado').removeAttr('readonly-disabled');
							self.parents('div').parents('div').parents('div').find('.estado').removeAttr('readonly');
							self.parents('div').parents('div').parents('div').find('.estado').val('');
							
						}else if(self.parents('div').parents('div').parents('div').parents('div').find('.estado').length){
							self.parents('div').parents('div').parents('div').parents('div').find('.estado').removeAttr('readonly-disabled');
							self.parents('div').parents('div').parents('div').parents('div').find('.estado').removeAttr('readonly');
							self.parents('div').parents('div').parents('div').parents('div').find('.estado').val('');
							
						}

						if(self.parents('div').find('.cidade').length){
							self.parents('div').find('.cidade').removeAttr('readonly-disabled');
							self.parents('div').find('.cidade').removeAttr('readonly');
							self.parents('div').find('.cidade').val('');

						}else if(self.parents('div').parents('div').find('.cidade').length){
							self.parents('div').parents('div').find('.cidade').removeAttr('readonly-disabled');
							self.parents('div').parents('div').find('.cidade').removeAttr('readonly');
							self.parents('div').parents('div').find('.cidade').val('');

						}else if(self.parents('div').parents('div').parents('div').find('.cidade').length){
							self.parents('div').parents('div').parents('div').find('.cidade').removeAttr('readonly-disabled');
							self.parents('div').parents('div').parents('div').find('.cidade').removeAttr('readonly');
							self.parents('div').parents('div').parents('div').find('.cidade').val('');
							
						}else if(self.parents('div').parents('div').parents('div').parents('div').find('.cidade').length){
							self.parents('div').parents('div').parents('div').parents('div').find('.cidade').removeAttr('readonly-disabled');
							self.parents('div').parents('div').parents('div').parents('div').find('.cidade').removeAttr('readonly');
							self.parents('div').parents('div').parents('div').parents('div').find('.cidade').val('');
							
						}

						if(self.parents('div').find('.bairro').length){
							self.parents('div').find('.bairro').removeAttr('readonly-disabled');
							self.parents('div').find('.bairro').removeAttr('readonly');
							self.parents('div').find('.bairro').val('');

						}else if(self.parents('div').parents('div').find('.bairro').length){
							self.parents('div').parents('div').find('.bairro').removeAttr('readonly-disabled');
							self.parents('div').parents('div').find('.bairro').removeAttr('readonly');
							self.parents('div').parents('div').find('.bairro').val('');

						}else if(self.parents('div').parents('div').parents('div').find('.bairro').length){
							self.parents('div').parents('div').parents('div').find('.bairro').removeAttr('readonly-disabled');
							self.parents('div').parents('div').parents('div').find('.bairro').removeAttr('readonly');
							self.parents('div').parents('div').parents('div').find('.bairro').val('');
							
						}else if(self.parents('div').parents('div').parents('div').parents('div').find('.bairro').length){
							self.parents('div').parents('div').parents('div').parents('div').find('.bairro').removeAttr('readonly-disabled');
							self.parents('div').parents('div').parents('div').parents('div').find('.bairro').removeAttr('readonly');
							self.parents('div').parents('div').parents('div').parents('div').find('.bairro').val('');
							
						}
					}
				},
			});
		}
	});

	$(document).on('input', '.estado', function(){
	    let inputValue = $(this).val().toUpperCase();
	    inputValue = inputValue.replace(/[^A-Z]/g, '');
	    if(inputValue.length > 2) {
	        inputValue = inputValue.slice(0, 2);
	    }
	    $(this).val(inputValue);
	});

	/**/
		$(document).on('click', '.div-money-opc .moeda', function(){
			$(this).find('.ph-caret-down').addClass('ph-caret-up');
			$(this).find('.ph-caret-down').addClass('div-money-opc-active');
			$(this).find('.ph-caret-down').removeClass('ph-caret-down');

			var html = `
			<ul class="money-opc">
				<li value="real">${moeda_view()}</li>
				<li value="porcentagem">%</li>
			</ul>
			<div class="bg-money-opc"></div>
			`;
			$(this).parent().before(html);
		});

		$(document).on('click', '.bg-money-opc', function(){
			$('.money-opc').remove();
			$('.bg-money-opc').remove();
			$('.div-money-opc-active').addClass('ph-caret-down');
			$('.div-money-opc-active').removeClass('ph-caret-up');
			$('.div-money-opc-active').removeClass('div-money-opc-active');
		});

		$(document).on('click', '.money-opc li', function(){
			$(this).parent().parent().find('.div-money-opc').find('.moeda').find('span').text($(this).text());
			$(this).parent().parent().find('[receber-tipo-desconto="true"]').val($(this).attr('value'));
			$(this).parent().parent().find('[receber-tipo-desconto="true"]').trigger('input');
			$(this).parent().parent().find('.money').focus();
			$('.bg-money-opc').trigger('click');
		});
	/**/
});

// Função de Alerta
// @params tipo = azul/amarelo/vermelho
function alerta(mensagem, tipo, time, titulo){
	if(!time){
		time = 5000;
	}

	if(!titulo){
		titulo = 'Atenção';
	}

	$('.alerta').show('fast');
	$('.alerta').find('.bg_tipo_alerta').addClass(tipo);
	$('.alerta').find('.toast-body').html(mensagem);
	$('.alerta').find('.me-auto').html(titulo);

	setTimeout(function(){
		$('.alerta').hide('fast');
	}, time);

	$(document).on('click', '.alerta .btn-close', function(){
		$(this).parents('.alerta').hide('fast');
	});
}

// Função para destar elemento html
function destacar(element){
	if(element){
		element.addClass('destacar_elemento');

		setTimeout(function(){
			element.removeClass('destacar_elemento');
			element.focus();
		}, 2000);
	}
}

// function mostrar_loading(){
// 	$('body').append('<div class="loading-spinner"><div class="custom-loader"></div></div>');
// }
// function ocultar_loading(){
// 	$('body').append('<div class="loading-spinner"><div class="custom-loader"></div></div>');
// }

function float_para_real(valor) {
    if(typeof valor === 'string'){
        valor = parseFloat(valor.replace(',', '.'));
    }

    if(!isNaN(valor)){
        return valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }else{
        return '0,00';
    }
}

function real_para_float(valor){
	if(valor){
		valor = valor.replace(/\./g, '').replace(',', '.');
		return parseFloat(valor);
	}else{
		return 0.0;
	}
}