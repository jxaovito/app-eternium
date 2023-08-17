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

	$(function(){
	    $(".date, .data").datepicker({
	        dateFormat: 'dd/mm/yy',
	        closeText:"Fechar",
	        prevText:"Anterior",
	        nextText:"Próximo",
	        currentText:"Hoje",
	        monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
	        monthNamesShort:["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
				dayNames:["Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sábado"],
				dayNamesShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
	        dayNamesMin:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
	        weekHeader:"Sm",
	        firstDay:1
	    });
	});

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
});

// Função de Alerta
// @params tipo = azul/amarelo/vermelho
function alerta(mensagem, tipo, time){
	if(!time){
		time = 5000;
	}

	$('.alerta').show('fast');
	$('.alerta').find('.bg_tipo_alerta').addClass(tipo);
	$('.alerta').find('.toast-body').html(mensagem);

	setTimeout(function(){
		$('.alerta').hide('fast');
	}, time);

	$(document).on('click', '.alerta .btn-close', function(){
		$(this).parents('.alerta').hide('fast');
	});
}

// function mostrar_loading(){
// 	$('body').append('<div class="loading-spinner"><div class="custom-loader"></div></div>');
// }
// function ocultar_loading(){
// 	$('body').append('<div class="loading-spinner"><div class="custom-loader"></div></div>');
// }