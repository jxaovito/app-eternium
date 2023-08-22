@extends('default.layout')
@section('content')
<div class="container-novo-paciente">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Novo Paciente</h2>
	</div>

	<form action="/paciente/novo_salvar" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
	    @csrf
	    <div class="mb-3 w-32">
	        <label for="nome_paciente" class="form-label" required>Nome do Paciente</label>
	        <input type="text" class="form-control" id="nome_paciente" placeholder="" name="nome" autofocus="autofocus" required>
	    </div>

	    <div class="mb-3 w-32">
	        <label for="data_nascimento_paciente" class="form-label">Data de Nascimento</label>
	        <input type="text" class="form-control data" id="data_nascimento_paciente" placeholder="" name="data_nascimento">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="data_nascimento_paciente" class="form-label">Gênero</label>
	        <select class="select2" name="genero_id">
	        	<option value="">Selecione...</option>
	        	@if($generos)
	        		@foreach($generos as $genero)
	        			<option value="{{$genero['id']}}">{{$genero['nome']}}</option>
	        		@endforeach
	        	@endif
	        </select>
	    </div>

	    <div class="mb-3 w-32">
	        <label for="email_paciente" class="form-label">E-mail</label>
	        <input type="email" class="form-control" id="email_paciente" placeholder="" name="email">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="telefone_principal_paciente" class="form-label">Telefone Principal</label>
	        <input type="text" class="form-control telefone" id="telefone_principal_paciente" placeholder="" name="telefone_principal">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="telefone_secundario_paciente" class="form-label">Telefone Secundário</label>
	        <input type="text" class="form-control telefone" id="telefone_secundario_paciente" placeholder="" name="telefone_secundario">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="imagem_paciente" class="form-label">Imagem</label>
	        <input type="file" class="form-control" id="imagem" name="image">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="cpf_paciente" class="form-label">CPF</label>
	        <input type="text" class="form-control cpf" id="cpf_paciente" placeholder="" name="cpf">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="cnpj_paciente" class="form-label">CNPJ</label>
	        <input type="text" class="form-control cnpj" id="cnpj_paciente" placeholder="" name="cnpj">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="nome_mae_paciente" class="form-label">Nome da Mãe</label>
	        <input type="text" class="form-control" id="nome_mae_paciente" placeholder="" name="nome_mae">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="nome_pai_paciente" class="form-label">Nome do Pai</label>
	        <input type="text" class="form-control" id="nome_pai_paciente" placeholder="" name="nome_pai">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="nome_responsavel_paciente" class="form-label">Nome do responsável</label>
	        <input type="text" class="form-control" id="nome_responsavel_paciente" placeholder="" name="nome_responsavel">
	    </div>

	    <div class="mb-3 w-100">
	        <label for="data_vencimento_carteirinha_paciente" class="form-label">Observações</label>
	        <textarea class="form-control" name="observacoes"></textarea>
	    </div>

	    <h5 class="mgt-px-30 w-100">Dados de Convênio</h5>

	    <div class="mb-3 w-32">
	        <label for="data_nascimento_paciente" class="form-label">Convênio</label>
	        <select class="select2" name="convenio_id">
	        	<option value="">Selecione...</option>
	        	@if($convenios)
	        		@foreach($convenios as $convenio)
	        			<option value="{{$convenio['id']}}">{{$convenio['nome']}}</option>
	        		@endforeach
	        	@endif
	        </select>
	    </div>
	    
	    <div class="mb-3 w-32">
	        <label for="matricula_paciente" class="form-label">Matrícula (Carteirinha)</label>
	        <input type="text" class="form-control" id="matricula_paciente" placeholder="" name="matricula">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="data_vencimento_carteirinha_paciente" class="form-label">Data de vencimento</label>
	        <input type="text" class="form-control data" id="data_vencimento_carteirinha_paciente" placeholder="" name="data_vencimento_carteirinha">
	    </div>

	    <div class="mb-3 w-32">
	    </div>

	    <h5 class="mgt-px-30 w-100">Endereço</h5>

	    <div class="mb-3 w-15">
	        <label for="cep_paciente" class="form-label">CEP</label>
	        <input type="text" class="form-control cep" id="cep_paciente" placeholder="" name="cep">
	    </div>

	    <div class="mb-3 w-16">
	        <label for="estado_paciente" class="form-label">Estado</label>
	        <input
				data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Preencha o CEP para que este campo seja valiado"
	        	type="text"
	        	class="form-control estado"
	        	id="estado_paciente"
	        	placeholder=""
	        	name="estado"
	        	readonly
	        	readonly-disabled
	        >
	    </div>

	    <div class="mb-3 w-32">
	        <label for="cidade_paciente" class="form-label">Cidade</label>
	        <input
				data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Preencha o CEP para que este campo seja valiado"
	        	type="text"
	        	class="form-control cidade"
	        	id="cidade_paciente"
	        	placeholder=""
	        	name="cidade"
	        	readonly
	        	readonly-disabled
	        >
	    </div>

	    <div class="mb-3 w-32">
	        <label for="bairro_paciente" class="form-label">Bairro</label>
	        <input
				data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Preencha o CEP para que este campo seja valiado"
	        	type="text"
	        	class="form-control bairro"
	        	id="bairro_paciente"
	        	placeholder=""
	        	name="bairro"
	        	readonly
	        	readonly-disabled
	        >
	    </div>

	    <div class="mb-3 w-100">
	        <label for="rua_paciente" class="form-label">Rua</label>
	        <input type="text" class="form-control" id="rua_paciente" placeholder="" name="rua">
	    </div>

	    <div class="w-100 mgt-px-50">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/paciente" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
            </div>
        </div>
	</form>
</div>
@endsection