@extends('default.layout')
@section('content')
<div class="container-profissional">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Profissionais</h2>

		@if($adicionar_usuarios)
		<div>
			<a href="/profissional/novo"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i> Adicionar Profissional</button></a>
		</div>
		@endif
	</div>

	<div class="filters mgb-px-30">
		<form action="profissional/filtrar" class="d-flex w-100 justify-content-between" method="post">
			@csrf
			<div class="w-35">
				<label for="nome_profissional">Profissional</label>
				<input
					type="text"
					id="nome_profissional"
					class="form-control w-100"
					placeholder="Ana..."
					name="nome"
					value="{{session('filtro_profissional_nome') ? session('filtro_profissional_nome') : ''}}"
				>
			</div>
			<div class="w-50">
				<label for="especialidade">Especialdiade</label>
				<select
					class="select2 w-100"
					id="especialidade"
					name="especialidade"
				>
					<option value="">Selecione...</option>
					@if($especialidades)
						@foreach($especialidades as $especialidade)
							<option
								value="{{$especialidade['id']}}"
								{{session('filtro_profissional_especialidade') && session('filtro_profissional_especialidade') == $especialidade['id'] ? 'selected' : ''}}
							>{{$especialidade['nome']}}</option>
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
					href="/profissional/limpar_filtro"
					class="btn btn-light 
						{{session('filtro_profissional_nome') || session('filtro_profissional_especialidade')
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
					<th class="w-4"></th>
					<th>Nome</th>
					<th>Especialidade</th>
					<th class="w-15 text-center">Ações</th>
				</tr>
			</thead>
			<tbody>
				@if($registros)
					@foreach($registros as $registro)
					<tr class="{{$registro['deletado'] ? 'deletado' : ''}}">
						<td>
							<div class="row-table">
								@if($registro['imagem'])
									<span class="icone-nome"><img src="{{asset('clientes/'.session('conexao_id').'/usuario/'.$registro['imagem'])}}"></span>
								@else
									@php
										$nome = explode(' ', $registro['nome']);
										if(count($nome) > 1){
										    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
										}else{
										    $iniciais = strtolower(substr($registro['nome'], 0, 2));
										}
									@endphp
									<span class="icone-nome pequeno {{$iniciais}}">{{strtoupper($iniciais)}}</span>
								@endif
							</div>
						</td>
						<td>
							<div class="row-table">{{$registro['nome']}}</div>
						</td>
						<td>
							<div class="row-table">
								@php
									if(strpos($registro['especialidade'], ',') !== false){
										$especialidades = explode(',', $registro['especialidade']);
										foreach($especialidades as $especialidade){
											$nome = explode(' ', $especialidade);
											if(count($nome) > 1){
											    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
											}else{
											    $iniciais = strtolower(substr($especialidade, 0, 2));
											}

											echo '<span class="icone-nome pequeno mgl-px-10 '.$iniciais.'"
													data-bs-toggle="tooltip"
						                            data-bs-placement="bottom"
						                            data-bs-custom-class="custom-tooltip"
						                            data-bs-title="'.$especialidade.'"
													>'.strtoupper($iniciais).'</span>';
										}
									}else{
										$especialidade = $registro['especialidade'];

										$nome = explode(' ', $especialidade);
										if(count($nome) > 1){
										    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
										}else{
										    $iniciais = strtolower(substr($especialidade, 0, 2));
										}

										echo '<span class="icone-nome pequeno mgl-px-10 '.$iniciais.'"
													data-bs-toggle="tooltip"
						                            data-bs-placement="bottom"
						                            data-bs-custom-class="custom-tooltip"
						                            data-bs-title="'.$especialidade.'"
													>'.strtoupper($iniciais).'</span>';
									}
								@endphp
							</div>
						</td>
						<td>
							<div class="row-table justify-content-around">
								<a href="profissional/horario/{{$registro['usuario_id']}}">
									<i 
										data-bs-toggle="tooltip"
			                            data-bs-placement="bottom"
			                            data-bs-custom-class="custom-tooltip"
			                            data-bs-title="Configurar Horários do Profissional"
										class="ph ph-alarm icone-nome minimo pointer"
									></i>
								</a>

								<a href="profissional/comissao/{{$registro['usuario_id']}}">
									<i 
										data-bs-toggle="tooltip"
			                            data-bs-placement="bottom"
			                            data-bs-custom-class="custom-tooltip"
			                            data-bs-title="Configurar Comissão do Profissional"
										class="ph ph-currency-dollar icone-nome minimo pointer"
									></i>
								</a>
							
								<a href="profissional/editar/{{$registro['usuario_id']}}">
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
								@if($registro['deletado'])
									<a>
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Ativar"
											class="ph ph-check icone-nome minimo pointer deletar"
											link="/profissional/ativar/{{$registro['usuario_id']}}"
											titulo="Ativar Profissional"
											texto="Você tem certeza que deseja ativar o profissional <b>{{$registro['nome']}}</b>"
											btn-texto="Ativar"
											btn-cor="success"
										></i>
									</a>
								@else
									<a>
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Desativar"
											class="ph ph-prohibit icone-nome minimo pointer deletar"
											link="/profissional/desativar/{{$registro['usuario_id']}}"
											titulo="Desativar Profissional"
											texto="Você tem certeza que deseja desativar o profissional <b>{{$registro['nome']}}</b>"
											btn-texto="Desativar"
										></i>
									</a>
								@endif
							</div>
						</td>
					</tr>
					@endforeach
				@else
				<tr>
					<td colspan="4">Nenhum Convênio Registrado...</td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

{{ $registros->links() }}
@endsection