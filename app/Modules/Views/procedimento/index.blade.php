@extends('default.layout')
@section('content')
<div class="container-procedimento">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Procedimentos</h2>
	</div>

	<div class="filters mgb-px-30">
		<form action="/procedimento/filtrar" method="post" class="d-flex w-100 justify-content-between">
			@csrf
			<div class="w-85">
				<input 
					type="text"
					id="procedimento_nome"
					name="procedimento_nome"
					class="form-control w-100"
					placeholder="Pesquise pelo Convênio..."
					value="{{session('filtro_procedimento_nome') ? session('filtro_procedimento_nome') : ''}}"
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
					href="/procedimento/limpar_filtro"
					class="btn btn-light {{session('filtro_procedimento_nome') ? 'active' : ''}}"
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
					<th class="w-10 text-center">Ações</th>
				</tr>
			</thead>
			<tbody>
				@if($registros)
					@foreach($registros as $registro)
						<tr>
							<td>
								<div class="row-table">
									@if($registro['imagem'])
										<span class="icone-nome"><img src="{{asset('clientes/'.session('conexao_id').'/convenio/'.$registro['imagem'])}}"></span>
									@else
										@php
											$nome = explode(' ', $registro['nome']);
											if (count($nome) > 1) {
											    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
											} else {
											    $iniciais = strtolower(substr($registro['nome'], 0, 2));
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
			                            data-bs-title="{{$registro['nome']}}"
										class="limita_character limita_em_30"
									>{{$registro['nome']}}</span>
								</div>
							</td>
							<td>
								<div class="row-table justify-content-around">
									<a href="/procedimento/editar/{{$registro['id']}}">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Editar Procedimentos"
											class="ph ph-pencil-simple icone-nome minimo pointer"
										></i>
									</a>
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