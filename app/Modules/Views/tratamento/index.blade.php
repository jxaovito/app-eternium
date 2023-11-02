@extends('default.layout')
@section('content')
<div class="container-tratamento">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Tratamentos</h2>

		<div>
			<a href="/tratamento/novo/"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i> Adicionar Tratamento</button></a>
		</div>
	</div>

	<div class="filters mgb-px-30">
		<form action="/tratamento/filtrar" method="post" class="d-flex w-100 justify-content-between">
			@csrf
			<div class="w-25">
				<label for="nome_paciente">Paciente</label>
				<input
					type="text"
					id="nome_paciente"
					class="form-control w-100"
					placeholder=""
					name="paciente"
					value="{{session('filtro_tratamento_paciente') ? session('filtro_tratamento_paciente') : ''}}"
				>
			</div>
			<div class="w-25">
				<label for="convenio">Profissional</label>
				<select class="select2 w-100" name="profissional">
					<option value="">Selecione...</option>
					@if($profissional)
						@foreach($profissional as $prof)
							<option
								value="{{$prof['id']}}"
								{{session('filtro_tratamento_profissional') && session('filtro_tratamento_profissional') == $prof['id'] ? 'selected': '' }}
							>
								{{$prof['nome']}}
							</option>
						@endforeach
					@endif
				</select>
			</div>
			
			<div class="w-15">
				<label for="convenio">Convênio</label>
				<select class="select2 w-100" name="convenio">
					<option value="">Selecione...</option>
					@if($convenio)
						@foreach($convenio as $con)
							<option
								value="{{$con['id']}}"
								{{session('filtro_tratamento_convenio') && session('filtro_tratamento_convenio') == $con['id'] ? 'selected': '' }}
							>
								{{$con['nome']}}
							</option>
						@endforeach
					@endif
				</select>
			</div>

			<div class="w-20">
				<label for="convenio">Especialidade</label>
				<select class="select2 w-100" name="especialidade">
					<option value="">Selecione...</option>
					@if($especialidade)
						@foreach($especialidade as $esp)
							<option
								value="{{$esp['id']}}"
								{{session('filtro_tratamento_especialidade') && session('filtro_tratamento_especialidade') == $esp['id'] ? 'selected': '' }}
							>
								{{$esp['nome']}}
							</option>
						@endforeach
					@endif
				</select>
			</div>

			<div class="w-6 mgr-4 mgl-2 d-flex align-items-end justify-content-around">
				<button
					type="submit"
					class="btn btn-light"
					data-bs-toggle="tooltip"
	                data-bs-placement="bottom"
	                data-bs-custom-class="custom-tooltip"
	                data-bs-title="Filtrar"
				>
					<i class="ph ph-magnifying-glass"></i>
				</button>
				
				<a
					href="/tratamento/limpar_filtro"
					class="btn btn-light 
						{{session('filtro_tratamento_paciente') || session('filtro_tratamento_profissional') || session('filtro_tratamento_convenio') || session('filtro_tratamento_especialidade')
							? 'active' 
							: ''
						}}
					"
					data-bs-toggle="tooltip"
	                data-bs-placement="bottom"
	                data-bs-custom-class="custom-tooltip"
	                data-bs-title="Limpar Filtro"
				>
					<i class="ph ph-eraser"></i>
				</a>
			</div>
		</form>
	</div>

	<div class="content-list mgb-px-30">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th>Paciente</th>
					<th>Data e Hora de Criação do Trat.</th>
					<th>Convênio</th>
					<th>Carteirinha</th>
					<th>Profissional</th>
					<th>Especialidade</th>
					<th>Sessões</th>
					<th class="w-10 text-center">Ações</th>
				</tr>
			</thead>
			<tbody>
				@if(isset($registros['data']) && $registros['data'])
					@foreach($registros['data'] as $registro)
						<tr>
							<td>
								<div class="row-table">
									@if(isset($registro['imagem_paciente']))
										<span class="icone-nome"><img src="{{asset('clientes/'.session('conexao_id').'/paciente/'.$registro['imagem_paciente'])}}"></span>
									@else
										@php
											$nome = explode(' ', $registro['paciente']);
											if(count($nome) > 1){
											    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
											}else{
											    $iniciais = strtolower(substr($registro['paciente'], 0, 2));
											}
										@endphp
										<span class="icone-nome pequeno {{$iniciais}}">{{strtoupper($iniciais)}}</span>
									@endif
								</div>
							</td>
							<td>
								<div class="row-table">
									<span
										data-bs-toggle="tooltip"
			                            data-bs-placement="bottom"
			                            data-bs-custom-class="custom-tooltip"
			                            data-bs-title="{{$registro['paciente']}}"
										class="limita_character limita_em_20"
									>
										{{$registro['paciente']}}
									</span>
								</div>
							</td>
							<td>
								<div class="row-table">
								{{($registro['data_hora'] ? data_hora($registro['data_hora']) : '')}}
								</div>
							</td>
							<td>
								<div class="row-table">
									{{$registro['convenio']}}
								</div>
							</td>
							<td>
								<div class="row-table">
									{{$registro['matricula']}}
								</div>
							</td>
							<td>
								<div class="row-table">
									<span
										data-bs-toggle="tooltip"
			                            data-bs-placement="bottom"
			                            data-bs-custom-class="custom-tooltip"
			                            data-bs-title="{{$registro['profissional']}}"
										class="limita_character limita_em_20"
									>
										{{$registro['profissional']}}
									</span>
								</div>
							</td>
							<td>
								<div class="row-table">
									<span class="especialidade_list" style="background-color: {{$registro['cor_fundo_especialidade']}};color: {{$registro['cor_fonte_especialidade']}};">
										{{$registro['especialidade']}}
									</span>
								</div>
							</td>
							<td>
								<div class="row-table">
									@php
										if($registro['sessoes_consumida']){
											$porcentagem = ($registro['sessoes_consumida'] / $registro['sessoes_contratada']) * 100;
										}else{
											$porcentagem = 0;
										}
									@endphp
									<div class="progress w-100 d-flex flex-wrap" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
									  <div class="progress-bar h-20px" style="width: {{$porcentagem}}%"></div>
									  <div class="div-text-sessoes-progress w-100 d-flex justify-content-center relative {{$porcentagem ? 'top--20px' : ''}}">
										  	<span class="absolute">{{$registro['sessoes_consumida']}}/{{$registro['sessoes_contratada']}}</span>
									  	</div>
									</div>
								</div>
							</td>
							<td>
								<div class="row-table justify-content-around">
									<a href="/tratamento/visualizar/{{$registro['tratamento_id']}}">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Visualizar"
											class="ph ph-caret-right icone-nome minimo pointer"
										></i>
									</a>
									<a href="/tratamento/editar/{{$registro['tratamento_id']}}">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Editar"
											class="ph ph-pencil-simple icone-nome minimo pointer"
										></i>
									</a>
									<a href="">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Remover"
											class="ph ph-x icone-nome minimo pointer"
										></i>
									</a>
								</div>
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@endsection