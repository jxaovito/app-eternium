@extends('default.layout')
@section('content')
<div class="container-usuario">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>
			Usuários
			<span id="contador_usuarios">{{count($registros)-1}}</span>
		</h2>

		@if($adicionar_usuarios)
		<div>
			<a href="/usuario/novo"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i> Adicionar Usuário</button></a>
		</div>
		@endif
	</div>

	<div class="filters mgb-px-30">
		<form action="/usuario/filtrar" method="post" class="d-flex w-100 justify-content-between">
			@csrf
			<div class="w-85">
				<input 
					type="text"
					id="usuario_nome"
					name="usuario_nome"
					class="form-control w-100"
					placeholder="Pesquise pelo Usuário..."
					value="{{session('filtro_usuario_nome') ? session('filtro_usuario_nome') : ''}}"
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
					href="/usuario/limpar_filtro"
					class="btn btn-light {{session('filtro_usuario_nome') ? 'active' : ''}}"
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
					<th>Email</th>
					<th>Nível de Permissão</th>
					<th class="w-10 text-center">Ações</th>
				</tr>
			</thead>
			<tbody>
				@if($registros)
					@foreach($registros as $registro)
						@if($registro['id'] != '-1')
							<tr class="{{$registro['deletado'] ? 'deletado' : ''}}">
								<td>
									<div class="row-table">
										@if($registro['imagem'])
											<span class="icone-nome"><img src="{{asset('clientes/'.session('conexao_id').'/usuario/'.$registro['imagem'])}}"></span>
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
										>
										{{$registro['nome']}}
									</div>
								</td>
								<td>
									<div class="row-table">
										<span 
											data-bs-toggle="tooltip"
											data-bs-placement="bottom"
											data-bs-custom-class="custom-tooltip"
											data-bs-title="{{$registro['email']}}"
											class="limita_character limita_em_20">
											{{$registro['email']}}
										</span>
									</div>
								</td>
								<td>
									<div class="row-table">
										{{$registro['nivel_permissao']}}
									</div>
								</td>
								<td>
									<div class="row-table justify-content-around">
										<a href="/usuario/editar/{{$registro['id']}}">
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
												link="/usuario/remover/{{$registro['id']}}"
												titulo="Remover Usuário"
												texto="Você tem certeza que deseja remover o usuário <b>{{$registro['nome']}}</b>"
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
													link="/usuario/ativar/{{$registro['id']}}"
													titulo="Ativar Usuário"
													texto="Você tem certeza que deseja ativar o usuário <b>{{$registro['nome']}}</b>"
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
													link="/usuario/desativar/{{$registro['id']}}"
													titulo="Desativar Usuário"
													texto="Você tem certeza que deseja desativar o usuário <b>{{$registro['nome']}}</b>"
													btn-texto="Desativar"
												></i>
											</a>
										@endif
									</div>
								</td>
							</tr>
						@endif
					@endforeach
				@else
					<tr>
						<td colspan="4">Nenhum Usuário Registrado...</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

{{ $registros->links() }}
@endsection