@extends('default.layout')
@section('content')
<div class="container-paciente">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>{{mensagem('msg1')}}</h2>

		<div>
			<a href="paciente/novo"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i>{{mensagem('msg2')}} </button></a>
		</div>
	</div>

	<div class="filters mgb-px-30">
		<form action="paciente/filtrar" class="d-flex w-100 justify-content-between" method="post">
			@csrf
			<div class="w-45">
				<label for="nome_paciente">{{mensagem('msg27')}}</label>
				<input type="text" id="nome_paciente" name="nome" class="form-control w-100" placeholder="">
			</div>
			<div class="w-10">
				<label for="telefone">{{mensagem('msg3')}}</label>
				<input type="text" id="telefone" class="form-control w-100 telefone" name="telefone" placeholder="(21) 99999-9999">
			</div>
			<div class="w-30">
				<label for="convenio">{{mensagem('msg4')}}</label>
				<select class="select2 w-100" name="convenio">
					<option value="">{{mensagem('msg5')}}</option>
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
	                data-bs-title="{{mensagem('msg6')}}"
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
	                data-bs-title="{{mensagem('msg7')}}"
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
					<th>{{mensagem('msg8')}}</th>
					<th>{{mensagem('msg9')}}</th>
					<th>{{mensagem('msg10')}}</th>
					<th>{{mensagem('msg11')}}</th>
					<th>{{mensagem('msg12')}}</th>
					<th>{{mensagem('msg13')}}</th>
					<th class="w-10 text-center">{{mensagem('msg14')}}</th>
				</tr>
			</thead>
			<tbody>
				@if($registros)
					@foreach($registros as $registro)
						<tr class="{{$registro['deletado'] ? 'deletado' : ''}}">
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
				                            data-bs-title="{{mensagem('msg15')}}"
				                            tipo-icone="visualizar"
											class="ph ph-caret-right icone-nome minimo pointer"
										></i>
									</a>
									<a href="paciente/editar/{{$registro['paciente_id']}}">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="{{mensagem('msg16')}}"
				                            tipo-icone="editar"
											class="ph ph-pencil-simple icone-nome minimo pointer"
										></i>
									</a>
									<a href="">
										<i 
											data-bs-toggle="tooltip"
				                            data-bs-placement="bottom"
				                            data-bs-custom-class="custom-tooltip"
				                            data-bs-title="{{mensagem('msg17')}}"
				                            tipo-icone="remover"
											class="ph ph-x icone-nome minimo pointer"
										></i>
									</a>
									@if($registro['deletado'])
										<a>
											<i 
												data-bs-toggle="tooltip"
					                            data-bs-placement="bottom"
					                            data-bs-custom-class="custom-tooltip"
					                            data-bs-title="{{mensagem('msg18')}}"
					                            tipo-icone="ativar"
												class="ph ph-check icone-nome minimo pointer deletar"
												link="/paciente/ativar/{{$registro['paciente_id']}}"
												titulo="{{mensagem('msg19')}}"
												texto="{{mensagem('msg20')}} <b>{{$registro['nome']}}</b>?"
												btn-texto="{{mensagem('msg21')}}"
												btn-cor="success"
											></i>
										</a>
									@else
										<a>
											<i 
												data-bs-toggle="tooltip"
					                            data-bs-placement="bottom"
					                            data-bs-custom-class="custom-tooltip"
					                            data-bs-title="{{mensagem('msg22')}}"
					                            tipo-icone="desativar"
												class="ph ph-prohibit icone-nome minimo pointer deletar"
												link="/paciente/desativar/{{$registro['paciente_id']}}"
												titulo="{{mensagem('msg23')}}"
												texto="{{mensagem('msg24')}} <b>{{$registro['nome']}}</b>?"
												btn-texto="{{mensagem('msg25')}}"
											></i>
										</a>
									@endif
								</div>
							</td>
						</tr>
					@endforeach
				@else
					<td colspan="7"><div class="row-table">{{mensagem('msg26')}}</div></td>
				@endif
			</tbody>
		</table>
	</div>
</div>
{{ $registros->links() }}
@endsection