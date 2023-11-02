function mensagem($key){
	var mensagem = '';
	if(idioma == 'portugues_br'){
		mensagem = portugues_br($key);

	}else if(idioma == 'ingles_us'){
		mensagem = ingles_us($key);
	}

	return mensagem;
}

function data(){
	if(idioma == 'portugues_br'){
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

	}else if(idioma == 'ingles_us'){
		$(function(){
		    $(".date, .data").datepicker({
		        dateFormat: 'mm/dd/yy',
		        closeText:"To close",
		        prevText:"Previous",
		        nextText:"Next",
		        currentText:"Today",
		        monthNames: ["January","February","March","April","May","June","July","August","September","October","November","December"],
		        monthNamesShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
					dayNames:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
					dayNamesShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
		        dayNamesMin:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
		        weekHeader:"Sm",
		        firstDay:1
		    });
		});
	}
}

function data_para_view(data, lang = null){
	if(!lang){
		lang = '';
	}

	if(data){
		if(idioma == 'portugues_br' || lang == 'portugues_br'){
			var data = data.split('-');
			var data_formatada = `${data[2]}/${data[1]}/${data[0]}`;
			return data_formatada;
		
		}else if(idioma == 'ingles_us' || lang == 'ingles_us'){
			var data = data.split('-');
			var data_formatada = `${data[1]}/${data[2]}/${data[0]}`;
			return data_formatada;
		}
	}else{
		return '';
	}
}

function data_para_db(data){
	if(data){
		if(idioma == 'portugues_br'){
			var data = data.split('/');
			var data_formatada = `${data[2]}-${data[1]}-${data[0]}`;
			return data_formatada;
		
		}else if(idioma == 'ingles_us'){
			var data = data.split('/');
			var data_formatada = `${data[2]}-${data[0]}-${data[1]}`;
			return data_formatada;
		}
	}else{
		return '';
	}
}

function data_hora_para_view(data){
	if(data){
		if(idioma == 'portugues_br'){
			var data_hora = data.split(' ');
			var data = data_hora[0].split('-')
			var data_formatada = `${data[2]}/${data[1]}/${data[0]} ${data_hora[1]}`;
			return data_formatada;
		
		}else if(idioma == 'ingles_us'){
			var data_hora = data.split(' ');
			var data = data_hora[0].split('-')
			var data_formatada = `${data[1]}/${data[0]}/${data[2]} ${data_hora[1]}`;
			return data_formatada;
		}

	}else{
		return '';
	}
}

function money(valor){
	var mascara = '000.000.000.000.000,00';
	if(moeda == '$'){
		mascara = '000,000,000,000,000.00';
	}

	$('.money').mask(mascara, {reverse: true});
	$(document).on('focus', '.money', function(){
		$('.money').mask(mascara, {reverse: true});
	});
}

function moeda_view(){
	if(moeda == 'R$'){
		return 'R$';

	}else if(moeda == '$'){
		return '$';

	}
}