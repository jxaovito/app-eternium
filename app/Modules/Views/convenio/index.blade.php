@extends('default.layout')
@section('content')
<div class="container-paciente">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Convênios</h2>

		<div>
			<a href="/convenio/novo"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i> Adicionar Convenio</button></a>
		</div>
	</div>

	<div class="filters mgb-px-30">
		<form class="d-flex w-100 justify-content-between">
			<div class="w-85">
				<input type="text" id="nome_paciente" class="form-control w-100" placeholder="Pesquise pelo Convênio...">
			</div>
			<div class="w-6 mgr-4 mgl-2 d-flex align-items-end justify-content-around">
				<a href="/paciente/limpar_filtro" class="btn btn-light"><i class="ph ph-eraser"></i></a>
				<a href="/paciente/filtrar" class="btn btn-light"><i class="ph ph-magnifying-glass"></i></a>
			</div>
		</form>
	</div>

	<div class="content-list mgb-px-30">
		<table class="table table-hover">
			<thead>
				<tr>
					<th class="w-4"></th>
					<th>Nome</th>
					<th>CNPJ</th>
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
							<td><div class="row-table">{{$registro['nome']}}</div></td>
							<td>
								<div class="row-table">
									@if($registro['cnpj'])
										{{$registro['cnpj']}}
									@else
										<span class="user-select-none opacity-03">00.000.000/0000-00</span>
									@endif
								</div>
							</td>
							<td>
								<div class="row-table justify-content-around">
									<a href="/convenio/editar/{{$registro['id']}}">
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
									<a href="">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Desativar"
											class="ph ph-arrow-line-down icone-nome minimo pointer"
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
@endsection