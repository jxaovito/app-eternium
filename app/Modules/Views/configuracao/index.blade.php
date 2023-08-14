@extends('default.layout')
@section('content')
<div class="container-configuracao">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Configurações da Empresa</h2>
	</div>

	<div class="w-100 d-flex justify-content-between">
		<div class="w-48">
			<div class="mgb-px-10">
				<label>Nome da Empresa</label>
				<input type="text" class="form-control">
			</div>

			<div class="mgb-px-10">
				<label>Telefone Principal</label>
				<input type="text" class="form-control telefone">
			</div>

			<div class="mgb-px-10">
				<label>Telefone Secundário</label>
				<input type="text" class="form-control telefone">
			</div>

			<div class="mgb-px-10">
				<label>Nome do Proprietário</label>
				<input type="text" class="form-control">
			</div>

			<div class="mgb-px-10">
				<label>Site</label>
				<input type="text" class="form-control">
			</div>

			<div class="mgb-px-10">
				<label>Endereço</label>
				<input type="text" class="form-control">
			</div>

			<div class="mgb-px-10">
				<label>Bairro</label>
				<input type="text" class="form-control">
			</div>

			<div class="mgb-px-10">
				<label>Cidade</label>
				<input type="text" class="form-control">
			</div>

			<div class="mgb-px-10">
				<label>Estado</label>
				<input type="text" class="form-control">
			</div>
		</div>
		<div class="w-48">
			<div class="mgb-px-10 d-flex justify-content-between">
				<div class="w-80">
					<label>Logo</label>
					<input type="file" class="form-control">
				</div>
				<div class="w-20">
				</div>
			</div>

			<div class="mgb-px-10">
				<label>Cor da Logo (Predominante)</label>
				<div class="d-flex">
					<input type="text" class="form-control">
					<input
	                    type="color"
	                    class="form-control form-control-color"
	                    id="cor_fonte_especialidade"
	                    value=""
	                    data-bs-toggle="tooltip"
	                    data-bs-placement="bottom"
	                    data-bs-custom-class="custom-tooltip"
	                    data-bs-title="Selecionar Cor da Fonte"
	                >
	            </div>
			</div>

			<div class="mgb-px-10">
				<label>Cor da Fonte</label>
				<div class="d-flex">
					<input type="text" class="form-control">
					<input
	                    type="color"
	                    class="form-control form-control-color"
	                    id="cor_fonte_especialidade"
	                    value=""
	                    data-bs-toggle="tooltip"
	                    data-bs-placement="bottom"
	                    data-bs-custom-class="custom-tooltip"
	                    data-bs-title="Selecionar Cor da Fonte"
	                >
	            </div>
			</div>
		</div>
	</div>
</div>
@endsection