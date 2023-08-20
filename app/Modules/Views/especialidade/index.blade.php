@extends('default.layout')
@section('content')
<div class="container-especialidade">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Especialidades</h2>

		<div>
			<a href="/especialidade/novo"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i> Adicionar Especialidade</button></a>
		</div>
	</div>

	<div class="filters mgb-px-30">
		<form action="/especialidade/filtrar" method="post" class="d-flex w-100 justify-content-between">
			@csrf
			<div class="w-85">
				<input 
					type="text"
					id="especialidade_nome"
					name="especialidade_nome"
					class="form-control w-100"
					placeholder="Pesquise pela Especialidade..."
					value="{{session('filtro_especialidade_nome') ? session('filtro_especialidade_nome') : ''}}"
				>
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
					href="/especialidade/limpar_filtro"
					class="btn btn-light {{session('filtro_especialidade_nome') ? 'active' : ''}}"
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
					<th width="50"></th>
					<th>Nome</th>
					<th>Cor</th>
					<th class="w-10 text-center">Ações</th>
				</tr>
			</thead>
			<tbody>
				@if($registros)
					@foreach($registros as $registro)
						<tr class="{{$registro['deletado'] ? 'deletado' : ''}}">
							<td>
								<div class="row-table">
									@php
										$nome = explode(' ', $registro['nome']);
										if (count($nome) > 1) {
										    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
										} else {
										    $iniciais = strtolower(substr($registro['nome'], 0, 2));
										}
									@endphp
									<span
										class="icone-nome pequeno {{$iniciais}}"
										{{$registro['cor_fundo'] ? 'style=background-color:'.$registro['cor_fundo'].';' : ''}}
									>
										{{strtoupper($iniciais)}}
									</span>
								</div>
							</td>
							<td>
								<div class="row-table">
									<span 
										data-bs-toggle="tooltip"
			                            data-bs-placement="bottom"
			                            data-bs-custom-class="custom-tooltip"
			                            data-bs-title="{{$registro['nome']}}"
										class="limita_character limita_em_30"
									>
										{{$registro['nome']}}
									</span>
								</div>
							</td>
							<td>
								<div class="row-table">
									<span
										class="cor_especialidade" 
										{{$registro['cor_fundo'] ? 'style=background-color:'.$registro['cor_fundo'].';color:'.$registro['cor_fonte'].';' : ''}}
									>
										{{$registro['cor_fundo']}}
									</span>
								</div>
							</td>
							<td>
								<div class="row-table justify-content-around">
									<a href="/especialidade/editar/{{$registro['id']}}">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Editar"
											class="ph ph-pencil-simple icone-nome minimo pointer"
										></i>
									</a>
									<a>
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Remover"
											class="ph ph-x icone-nome minimo pointer deletar"
											link="/especialidade/remover/{{$registro['id']}}"
											titulo="Remover Convênio"
											texto="Você tem certeza que deseja remover o convênio <b>{{$registro['nome']}}</b>"
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
												link="/especialidade/ativar/{{$registro['id']}}"
												titulo="Ativar Convênio"
												texto="Você tem certeza que deseja ativar o convênio <b>{{$registro['nome']}}</b>"
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
												link="/especialidade/desativar/{{$registro['id']}}"
												titulo="Desativar Convênio"
												texto="Você tem certeza que deseja desativar o convênio <b>{{$registro['nome']}}</b>"
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
						<td colspan="4">Nenhuma Especialidade Registrado...</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

{{ $registros->links() }}
@endsection