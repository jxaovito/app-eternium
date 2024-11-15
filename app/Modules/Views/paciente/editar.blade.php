@extends('default.layout')
@section('content')
<div class="container-novo-paciente">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>{{mensagem('msg59')}}</h2>
	</div>

	<form action="/paciente/editar_salvar/{{$registro['id']}}" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
	    @csrf
	    <div class="mb-3 w-32">
	        <label for="nome_paciente" class="form-label" required>{{mensagem('msg60')}}</label>
	        <input type="text" class="form-control" id="nome_paciente" placeholder="" name="nome" autofocus="autofocus" required value="{{$registro['nome']}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="data_nascimento_paciente" class="form-label">{{mensagem('msg61')}}</label>
	        <input type="text" class="form-control data" id="data_nascimento_paciente" placeholder="" name="data_nascimento" value="{{$registro['data_nascimento'] ? data($registro['data_nascimento']) : ''}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="" class="form-label">{{mensagem('msg62')}}</label>
	        <select class="select2" name="genero_id">
	        	<option value="">{{mensagem('msg63')}}</option>
	        	@if($generos)
	        		@foreach($generos as $genero)
	        			<option value="{{$genero['id']}}" {{$registro['genero_id'] == $genero['id'] ? 'selected' : ''}}>{{$genero['nome']}}</option>
	        		@endforeach
	        	@endif
	        </select>
	    </div>

	    <div class="mb-3 w-32">
	        <label for="email_paciente" class="form-label">{{mensagem('msg64')}}</label>
	        <input type="email" class="form-control" id="email_paciente" placeholder="" name="email" value="{{$registro['email']}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="telefone_principal_paciente" class="form-label">{{mensagem('msg65')}}</label>
	        <input type="text" class="form-control telefone" id="telefone_principal_paciente" placeholder="" name="telefone_principal" value="{{$registro['telefone_principal']}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="telefone_secundario_paciente" class="form-label">{{mensagem('msg66')}}</label>
	        <input type="text" class="form-control telefone" id="telefone_secundario_paciente" placeholder="" name="telefone_secundario" value="{{$registro['telefone_secundario']}}">
	    </div>

	    @if($registro['imagem'])
            <div class="mb-3 w-10 d-flex flex-wrap justify-content-center">
                <img class="w-40" src="{{asset('clientes/'.session('conexao_id').'/paciente/'.$registro['imagem'])}}">
                <div class="w-100 d-flex flex-wrap text-align-center justify-content-center">
                    <input 
                        id="remover-imagem"
                        type="checkbox"
                        class="switch"
                        name="remover-imagem"
                        value="1"
                    >
                    <label class="w-100" for="remover-imagem"><sub>{{mensagem('msg67')}}</sub></label>
                </div>
            </div>

            <div class="mb-3 w-20">
                <label for="imagem" class="form-label">{{mensagem('msg68')}}</label>
                <input type="file" class="form-control" id="imagem" name="image">
            </div>

        @else
            <div class="mb-3 w-32">
                <label for="imagem_paciente" class="form-label">{{mensagem('msg69')}}</label>
	        	<input type="file" class="form-control" id="imagem" name="image">
            </div>
        @endif

	    <div class="mb-3 w-32">
	        <label for="cpf_paciente" class="form-label">{{mensagem('msg70')}}</label>
	        <input type="text" class="form-control cpf" id="cpf_paciente" placeholder="" name="cpf" value="{{$registro['cpf']}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="cnpj_paciente" class="form-label">{{mensagem('msg71')}}</label>
	        <input type="text" class="form-control cnpj" id="cnpj_paciente" placeholder="" name="cnpj" value="{{$registro['cnpj']}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="nome_mae_paciente" class="form-label">{{mensagem('msg72')}}</label>
	        <input type="text" class="form-control" id="nome_mae_paciente" placeholder="" name="nome_mae" value="{{$registro['nome_mae']}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="nome_pai_paciente" class="form-label">{{mensagem('msg73')}}</label>
	        <input type="text" class="form-control" id="nome_pai_paciente" placeholder="" name="nome_pai" value="{{$registro['nome_pai']}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="nome_responsavel_paciente" class="form-label">{{mensagem('msg74')}}</label>
	        <input type="text" class="form-control" id="nome_responsavel_paciente" placeholder="" name="nome_responsavel" value="{{$registro['nome_responsavel']}}">
	    </div>

	    <div class="mb-3 w-100">
	        <label for="observacoes_paciente" class="form-label">{{mensagem('msg75')}}</label>
	        <textarea class="form-control" name="observacoes" id="observacoes_paciente">{{$registro['observacoes']}}</textarea>
	    </div>

	    <h5 class="mgt-px-30 w-100">{{mensagem('msg76')}}</h5>

	    <div class="mb-3 w-32">
	        <label for="data_nascimento_paciente" class="form-label">{{mensagem('msg77')}}</label>
	        <select class="select2" name="convenio_id">
	        	<option value="">{{mensagem('msg78')}}</option>
	        	@if($convenios)
	        		@foreach($convenios as $convenio)
	        			<option value="{{$convenio['id']}}" {{$registro['convenio_id'] == $convenio['id'] ? 'selected' : ''}}>{{$convenio['nome']}}</option>
	        		@endforeach
	        	@endif
	        </select>
	    </div>
	    
	    <div class="mb-3 w-32">
	        <label for="matricula_paciente" class="form-label">{{mensagem('msg79')}}</label>
	        <input type="text" class="form-control" id="matricula_paciente" placeholder="" name="matricula" value="{{$registro['matricula']}}">
	    </div>

	    <div class="mb-3 w-32">
	        <label for="data_vencimento_carteirinha_paciente" class="form-label">{{mensagem('msg80')}}</label>
	        <input type="text" class="form-control data" id="data_vencimento_carteirinha_paciente" placeholder="" name="data_vencimento_carteirinha" value="{{$registro['data_vencimento_carteirinha'] ? data($registro['data_vencimento_carteirinha']) : ''}}">
	    </div>

	    <div class="mb-3 w-32">
	    </div>

	    <h5 class="mgt-px-30 w-100">{{mensagem('msg81')}}</h5>

	    <div class="mb-3 w-15">
	        <label for="cep_paciente" class="form-label">{{mensagem('msg82')}}</label>
	        <input type="text" class="form-control cep" id="cep_paciente" placeholder="" name="cep" value="{{$registro['cep']}}">
	    </div>

	    <div class="mb-3 w-16">
	        <label for="estado_paciente" class="form-label">{{mensagem('msg84')}}</label>
	        <input
				data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{mensagem('msg83')}}"
	        	type="text"
	        	class="form-control estado"
	        	id="estado_paciente"
	        	placeholder=""
	        	name="estado"
	        	readonly
	        	readonly-disabled
	        	value="{{$registro['estado']}}"
	        >
	    </div>

	    <div class="mb-3 w-32">
	        <label for="cidade_paciente" class="form-label">{{mensagem('msg85')}}</label>
	        <input
				data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{mensagem('msg86')}}"
	        	type="text"
	        	class="form-control cidade"
	        	id="cidade_paciente"
	        	placeholder=""
	        	name="cidade"
	        	readonly
	        	readonly-disabled
	        	value="{{$registro['cidade']}}"
	        >
	    </div>

	    <div class="mb-3 w-32">
	        <label for="bairro_paciente" class="form-label">{{mensagem('msg87')}}</label>
	        <input
				data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{mensagem('msg88')}}"
	        	type="text"
	        	class="form-control bairro"
	        	id="bairro_paciente"
	        	placeholder=""
	        	name="bairro"
	        	readonly
	        	readonly-disabled
	        	value="{{$registro['bairro']}}"
	        >
	    </div>

	    <div class="mb-3 w-100">
	        <label for="rua_paciente" class="form-label">{{mensagem('msg89')}}</label>
	        <input type="text" class="form-control" id="rua_paciente" placeholder="" name="rua" value="{{$registro['rua']}}">
	    </div>

	    <div class="w-100 mgt-px-50">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/paciente" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> {{mensagem('msg90')}}</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">{{mensagem('msg91')}} <i class="ph ph-check"></i></button>
            </div>
        </div>
	</form>
</div>
@endsection