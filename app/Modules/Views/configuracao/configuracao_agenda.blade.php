@extends('default.layout')
@section('content')
<div class="container-configuracao mgb-px-30">
	<div class="w-100">
		<form action="/configuracao/agenda_salvar" method="post" class="w-100 d-flex flex-wrap justify-content-center">
			@csrf
			@foreach($configuracoes_agenda as $configuracao)
				@if($configuracao['identificador'] == 'visualizacao_agenda')
					<div class="w-32">
						<h5 class="bold">Mode de visualização da Agenda</h5>
						<div class="form-check">
						  	<input
						  		class="form-check-input"
						  		type="radio"
						  		name="visualizacao_agenda"
						  		id="dia"
						  		value="day"
						  		{{$configuracao['valor'] == 'day' ? 'checked="checked' : ''}}
						  	>
						  	<label class="form-check-label" for="dia">
						    	Dia
						  	</label>
						</div>
						<div class="form-check">
						  	<input
						  		class="form-check-input"
						  		type="radio"
						  		name="visualizacao_agenda"
						  		id="semana"
						  		value="week"
						  		{{$configuracao['valor'] == 'week' ? 'checked="checked' : ''}}
						  	>
						  	<label class="form-check-label" for="semana">
						    	Semana
						  	</label>
						</div>
						<div class="form-check">
						  	<input
						  		class="form-check-input"
						  		type="radio"
						  		name="visualizacao_agenda"
						  		id="mes"
						  		value="month"
						  		{{$configuracao['valor'] == 'month' ? 'checked="checked' : ''}}
						  	>
						  	<label class="form-check-label" for="mes">
						    	Mes
						  	</label>
						</div>
					</div>
				@endif

				@if($configuracao['identificador'] == 'envio_lembrete_para_todos')
					@if($whatsapp_automatico)
						<div class="w-32">
							<h5 class="bold"><i class="ph ph-whatsapp-logo"></i> Ativar envio de lembrete automático para todos os agendamentos</h5>
							<div class="form-check">
							  	<input
							  		class="form-check-input"
							  		type="radio"
							  		name="envio_lembrete_para_todos"
							  		id="sim"
							  		value="sim"
							  		{{$configuracao['valor'] == 'sim' ? 'checked="checked' : ''}}
							  	>
							  	<label class="form-check-label" for="sim">
							    	Sim
							  	</label>
							</div>
							<div class="form-check">
							  	<input
							  		class="form-check-input"
							  		type="radio"
							  		name="envio_lembrete_para_todos"
							  		id="nao"
							  		value="nao"
							  		{{$configuracao['valor'] == 'nao' ? 'checked="checked' : ''}}
							  	>
							  	<label class="form-check-label" for="nao">
							    	Não
							  	</label>
							</div>
						</div>
					@endif
				@endif
			@endforeach

			<div class="w-100 d-flex justify-content-end">
				<button class="btn btn-success bg-cor-logo-cliente" type="submit">Salvar <i class="ph ph-check"></i></button>
			</div>
		</form>
	</div>
</div>
@endsection