@extends('default.layout')
@section('content')
<div class="container-paciente">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>{{mensagem('msg1')}}</h2>

		<div>
			<a href="paciente/novo"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i> Adicionar Paciente</button></a>
		</div>
	</div>

	<div class="filters mgb-px-30">
		<form action="paciente/filtrar" class="d-flex w-100 justify-content-between" method="post">
			@csrf
			<div class="w-45">
				<label for="nome_paciente">Paciente</label>
				<input type="text" id="nome_paciente" name="nome" class="form-control w-100" placeholder="">
			</div>
			<div class="w-10">
				<label for="telefone">Telefone</label>
				<input type="text" id="telefone" class="form-control w-100 telefone" name="telefone" placeholder="(21) 99999-9999">
			</div>
			<div class="w-30">
				<label for="convenio">Convênio</label>
				<select class="select2 w-100" name="convenio">
					<option value="">Selecione...</option>
					@if($convenios)
						@foreach($convenios as $convenio)
							<option value="{{$convenio['id']}}">{{$convenio['nome']}}</option>
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
					href="/paciente/limpar_filtro"
					class="btn btn-light 
						{{session('filtro_paciente_nome') || session('filtro_paciente_telefone') || session('filtro_paciente_convenio')
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
					<th>Nome</th>
					<th>Data de Nascimento</th>
					<th>Telefone</th>
					<th>Email</th>
					<th>Carteirinha</th>
					<th>Convênio</th>
					<th class="w-10 text-center">Ações</th>
				</tr>
			</thead>
			<tbody>
				@if($registros)
					@foreach($registros as $registro)
						<tr  class="{{$registro['deletado'] ? 'deletado' : ''}}">
							<td>
								<div class="row-table">
									@if($registro['imagem'])
										<span class="icone-nome"><img src="{{asset('clientes/'.session('conexao_id').'/paciente/'.$registro['imagem'])}}"></span>
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
							<td><div class="row-table">{{data($registro['data_nascimento'])}}</div></td>
							<td><div class="row-table">{{$registro['telefone_principal']}}</div></td>
							<td>
								<div class="row-table">
									<span
										data-bs-toggle="tooltip"
			                            data-bs-placement="bottom"
			                            data-bs-custom-class="custom-tooltip"
			                            data-bs-title="{{$registro['email']}}"
										class="limita_character limita_em_30"
									>
									{{$registro['email']}}
								</div>
							</td>
							<td><div class="row-table">{{$registro['matricula']}}</div></td>
							<td><div class="row-table">{{$registro['convenio']}}</div></td>
							<td>
								<div class="row-table justify-content-around">
									<a href="paciente/visualizar/{{$registro['paciente_id']}}">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="Visualizar"
											class="ph ph-caret-right icone-nome minimo pointer"
										></i>
									</a>
									<a href="paciente/editar/{{$registro['paciente_id']}}">
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
												link="/paciente/ativar/{{$registro['paciente_id']}}"
												titulo="Ativar Paciente"
												texto="Você tem certeza que deseja ativar o paciente <b>{{$registro['nome']}}</b>"
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
												link="/paciente/desativar/{{$registro['paciente_id']}}"
												titulo="Desativar Paciente"
												texto="Você tem certeza que deseja desativar o paciente <b>{{$registro['nome']}}</b>"
												btn-texto="Desativar"
											></i>
										</a>
									@endif
								</div>
							</td>
						</tr>
					@endforeach
				@else
					<td colspan="7"><div class="row-table">Nenhum paciente registrado.</div></td>
				@endif
			</tbody>
		</table>
	</div>
</div>
{{ $registros->links() }}
@endsection