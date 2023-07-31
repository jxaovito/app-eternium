$(document).ready(function(){

	// Ativação de popover
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

	// Alterar texto da Paginação
	$('.flex.items-center.justify-between .flex.justify-between.flex-1').remove();
	var divTexto = $('p.text-sm.text-gray-700.leading-5');
  	var textoAtual = divTexto.text();
  	var novoTexto = textoAtual.replace('Showing', 'Mostrando')
	                            .replace('to', 'de')
	                            .replace('of', 'de um total de')
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
	$('a[href!="#"]').on('click', function(event) {
		event.preventDefault(); // Evita o comportamento padrão do link
		mostrar_loading();
		// Obtém o href do link
		var href = $(this).attr('href');
		// Redireciona manualmente para o href após algum tempo (exemplo: 1 segundo)
		setTimeout(function() {
			window.location.href = href;
		}, 1); // Tempo em milissegundos
	});

});

function mostrar_loading(){
	$('body').append('<div class="loading-spinner"><div class="custom-loader"></div></div>');
}
function ocultar_loading(){
	$('body').append('<div class="loading-spinner"><div class="custom-loader"></div></div>');
}