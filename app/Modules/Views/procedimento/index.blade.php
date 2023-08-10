@extends('default.layout')
@section('content')
<div class="container-paciente">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Procedimentos</h2>

		<div>
			<a href=""><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i> Adicionar Paciente</button></a>
		</div>
	</div>

	<div class="filters mgb-px-30">
		<form class="d-flex w-100 justify-content-between">
			<div class="w-35">
				<label for="nome_paciente">Paciente</label>
				<input type="text" id="nome_paciente" class="form-control w-100" placeholder="Ana...">
			</div>
			<div class="w-10">
				<label for="cpf">CPF</label>
				<input type="text" id="cpf" class="form-control w-100 cpf" placeholder="123-456-789.10">
			</div>
			<div class="w-10">
				<label for="telefone">Telefone</label>
				<input type="text" id="telefone" class="form-control w-100 telefone" placeholder="(21) 99999-9999">
			</div>
			<div class="w-30">
				<label for="convenio">Convênio</label>
				<select class="select2 w-100">
					<option>Selecione...</option>
					<option>Unimed</option>
				</select>
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
					<th></th>
					<th>Nome</th>
					<th>Data de Nascimento</th>
					<th>Telefone</th>
					<th>Carteirinha</th>
					<th>CPF</th>
					<th>Convênio</th>
					<th class="w-10 text-center">Ações</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><div class="row-table"><span class="icone-nome pequeno gr">GR</span></div></td>
					<td><div class="row-table">Gustavo Rieper</div></td>
					<td><div class="row-table">17/07/1996</div></td>
					<td><div class="row-table">(47) 99682-7273</div></td>
					<td><div class="row-table">1554999565454555</div></td>
					<td><div class="row-table">093.888.159-04</div></td>
					<td><div class="row-table">Unimed</div></td>
					<td>
						<div class="row-table justify-content-around">
							<a href="">
								<i 
									data-bs-toggle="tooltip"
		                            data-bs-placement="bottom"
		                            data-bs-custom-class="custom-tooltip"
		                            data-bs-title="Visualizar"
									class="ph ph-caret-right icone-nome minimo pointer"
								></i>
							</a>
							<a href="">
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
			</tbody>
		</table>
	</div>
</div>
@endsection