var element = null;
var classe = '';
function autocomplete(dados, elemento, classe_div){
	element = elemento;
	classe = classe_div;
	$('.autocomplete').remove();
	var html = `
		<ul class="autocomplete">
	`;
	$.each(dados, function(i,v){
		html += `<li id="${v.id ? v.id : ''}">${v.nome}</li>`;
	});

	html += `</ul>`;
	$('.autocomplete li').remove();
	element.after(html);

    var divPorcentagem = element.width() / element.parent().width() * 100;
    var larguraPixels = (divPorcentagem / 100) * $('.autocomplete').parent().width();
    $('.autocomplete').css('width', (larguraPixels+24) + 'px');
}

// Autocompelte para procedimentos no cadastro do Tratamento
/**/
	function autocomplete_procedimento_tratamento(dados, elemento, classe_div){
		element = elemento;
		classe = classe_div;
		$('.autocomplete').remove();
		var html = `
			<ul class="autocomplete">
		`;
		$.each(dados, function(i,v){
			html += `<li class="autocomplete_procedimento_tratamento" codigo="${v.codigo}" valor="${v.valor}" id="${v.id ? v.id : ''}">${v.nome}</li>`;
		});

		html += `</ul>`;
		$('.autocomplete li').remove();
		element.after(html);

	    var divPorcentagem = element.width() / element.parent().width() * 100;
	    var larguraPixels = (divPorcentagem / 100) * $('.autocomplete').parent().width();
	    $('.autocomplete').css('width', (larguraPixels+24) + 'px');
	}

	$(document).on('click', '.autocomplete_procedimento_tratamento', function(){
		var self = $(this);
		var validado = true;
		$.each(element.parents('.content-procedimentos').find('[name="procedimento_id[]"]'), function(){
			if($(this).attr('value') == self.attr('id')){
				validado = false;
			}
		});

		if(validado){
			element.parents('.procedimentos-clone').find('[name="codigo_procedimento[]"]').val(self.attr('codigo'));
			element.parents('.procedimentos-clone').find('[name="valor_procedimento[]"]').val(float_para_real(self.attr('valor')));
			element.parents('.procedimentos-clone').find('[name="nome_procedimento[]"]').val(self.text());
			element.parents('.procedimentos-clone').find('[name="procedimento_id[]"]').val(self.attr('id'));

		}else{
			alerta(`Você já selecionou o procedimento <b>${self.text()}</b>.`);
			element.parents('.procedimentos-clone').find('[name="codigo_procedimento[]"]').val('');
			element.parents('.procedimentos-clone').find('[name="valor_procedimento[]"]').val('');
			element.parents('.procedimentos-clone').find('[name="nome_procedimento[]"]').val('');
			element.parents('.procedimentos-clone').find('[name="procedimento_id[]"]').val('');
		}
		
		element.parents('.procedimentos-clone').find('[name="codigo_procedimento[]"]').trigger('input');
		element.parents('.procedimentos-clone').find('[name="valor_procedimento[]"]').trigger('input');
		element.parents('.procedimentos-clone').find('[name="procedimento_id[]"]').trigger('input');
	});
/**/


$(document).on('click', '.autocomplete li', function(){
	if(!$(this).attr('class')){
		element.parent().find(`.${classe}`).val($(this).attr('id'));
		element.val($(this).text());
		$(`.${classe}`).trigger('change');		
	}
});

$(document).on('focusout', element, function(){
	setTimeout(function(){
		$('.autocomplete').remove();
	}, 100)
});