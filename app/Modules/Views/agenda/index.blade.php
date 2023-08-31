@extends('default.layout')
@section('content')
<div class="container-agenda">
	<div class="header">
		<div class="w-20 d-flex justify-content-center flex-wrap">
			<div class="w-100 d-flex justify-content-center">
				<div class="w-40 d-flex align-items-center justify-content-center alternar-datas mgb-px-5">
					<div class="w-20 text-center voltar-datas">
						<i class="ph ph-caret-left"></i>
					</div>
					<div class="w-60 text-center hoje">
						Hoje
					</div>
					<div class="w-20 text-center avancar-datas">
						<i class="ph ph-caret-right"></i>
					</div>
				</div>
			</div>

			<div class="w-100 d-flex justify-content-center">
				<div class="selecionar-data mgb-px-5 w-40">
					<input type="text" class="date form-control" value="{{date('d-m-Y')}}">
				</div>
			</div>
		</div>

		<div class="w-45">
			<h6 class="opacity-05 user-select-none">Profissionais</h6>
			<div class="d-flex flex-wrap justify-content-start align-items-center">
				@if($profissionais)
					@foreach($profissionais as $prof)
						@if($prof['imagem'])
							<span
								class="icone-nome w-40px h-40px mgl-px-5 mgr-px-5 {{($profissional_id != $prof['id'] ? 'opacity-05' : '')}} pointer"
								data-bs-toggle="tooltip"
				                data-bs-placement="bottom"
				                data-bs-custom-class="custom-tooltip"
				                data-bs-title="{{$prof['nome']}}"
							>
								<img class="w-40px h-40px" src="{{asset('clientes/'.session('conexao_id').'/usuario/'.$prof['imagem'])}}">
							</span>
						@else
							@php
								$nome = explode(' ', $prof['nome']);
								if(count($nome) > 1){
								    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
								}else{
								    $iniciais = strtolower(substr($prof['nome'], 0, 2));
								}
							@endphp
							<span
								class="icone-nome w-40px h-40px mgl-px-5 mgr-px-5 {{($profissional_id != $prof['id'] ? 'opacity-05' : '')}} pointer pequeno {{$iniciais}}"
								data-bs-toggle="tooltip"
				                data-bs-placement="bottom"
				                data-bs-custom-class="custom-tooltip"
				                data-bs-title="{{$prof['nome']}}"
							>
								{{strtoupper($iniciais)}}
							</span>
						@endif
					@endforeach
				@endif
			</div>
		</div>

		<div class="w-35">
			<h6 class="opacity-05 user-select-none">Especialidades</h6>
			<div class="d-flex flex-wrap justify-content-start align-items-center">
				@if($especialidades)
					@foreach($especialidades as $key => $esp)
						<span
							class="cor_especialidade" 
							{{$esp['cor_fundo'] ? 'style=background-color:'.$esp['cor_fundo'].';color:'.$esp['cor_fonte'].';' : ''}}
						>
							{{$esp['nome']}}
						</span>
					@endforeach
				@endif
			</div>
		</div>
	</div>
	<div id="calendar" style="height: 100vh"></div>

	<div class="bg-modal-agenda"></div>
	<div class="contents-modal">
		<div class="modal-agendamento criar-agendamento">
			<div class="header-modal d-flex justify-content-between align-items-center">
				<h4>Novo Agendamento</h4>
				<span>
					<i
						class="ph ph-x pointer close-modal-agenda"
						data-bs-toggle="tooltip"
		                data-bs-placement="bottom"
		                data-bs-custom-class="custom-tooltip"
		                data-bs-title="Fechar"
					></i>
				</span>
			</div>
			<div class="content-modal">
				<form class="d-flex flex-wrap w-100 justify-content-between">
					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 date" id="data_inicial" placeholder="{{date('d/m/Y')}}" value="" name="data_inicio">
					  	<label for="data_inicial">Data Inicial</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 date" id="data_fim" placeholder="{{date('d/m/Y')}}" value="" name="data_fim">
					  	<label for="data_fim">Data Fim</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 time" id="hora_inicial" placeholder="00:00" value="" name="hora_inicio">
					  	<label for="hora_inicial">Hora Inicial</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 time" id="hora_fim" placeholder="00:00" value="" name="hora_fim">
					  	<label for="hora_fim">Hora Final</label>
					</div>
				</form>
			</div>
			<div class="footer-modal">

			</div>
		</div>
	</div>
</div>
@endsection