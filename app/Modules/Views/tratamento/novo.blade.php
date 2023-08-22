@extends('default.layout')
@section('content')
<div class="container-tratamento-novo">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Novo Tratamento</h2>
	</div>

	<form action="/profissional/novo/" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
		@csrf
		<div class="mb-3 w-40">
            <label for="busca_paciente_tratamento" class="form-label" required>Paciente</label>
            <input type="text" class="form-control" id="busca_paciente_tratamento" placeholder="" name="nome" autofocus="autofocus" required autocomplete="off">
            <input type="hidden" class="autocomplete_paciente_id" name="paciente_id">
        </div>

        <div class="mb-3 w-25">
            <label for="" class="form-label" required>Convenio</label>
            <select class="select2 convenio" required>
        		<option value="">Selecione...</option>
        		@if($convenios)
        			@foreach($convenios as $convenio)
        				<option value="{{$convenio['id']}}">{{$convenio['nome']}}</option>
        			@endforeach
				@endif
            </select>
        </div>

        <div class="mb-3 w-25">
            <label for="" class="form-label" required>Profissional</label>
            <select class="select2 profissional" required name="profissional">
        		<option value="">Selecione...</option>
        		@if($profissionais)
        			@foreach($profissionais as $profissional)
        				<option value="{{$profissional['profissional_id']}}">{{$profissional['profissional']}}</option>
        			@endforeach
				@endif
            </select>
        </div>

        <div class="mb-3 w-32">
            <label for="" class="form-label" required>Especialidade</label>
            <select class="select2 especialidade" required>
        		<option value="">Selecione...</option>
        		@if($especialidades)
        			@foreach($especialidades as $especialidade)
        				<option value="{{$especialidade['id']}}">{{$especialidade['nome']}}</option>
        			@endforeach
				@endif
            </select>
        </div>

        <div class="w-100 mgb-px-30">
        	<h5 class="mgt-px-30 mgb-px-10">Procedimentos</h5>
        	<div class="w-100 d-flex flex-wrap justify-content-between mgb-px-10">
        		<div class="w-15">
        			<label>Código</label>
        		</div>

        		<div class="w-25">
        			<label>Procedimento</label>
        		</div>

        		<div class="w-15">
        			<label>Sessões</label>
        		</div>

        		<div class="w-10">
        			<label>Valor</label>
        		</div>

        		<div class="w-10">
        			<label>Desconto</label>
        		</div>

        		<div class="w-10 text-center">
        			<label>Total</label>
        		</div>

        		<div class="w-10 text-center">
        			<label>Remover</label>
        		</div>
    		</div>
    		<div class="content-procedimentos w-100 d-flex flex-wrap justify-content-between">

    		</div>
    		<div class="d-flex justify-content-center w-100 text-align-center add_procedimento mgt-px-30">
				<i 
					data-bs-toggle="tooltip"
	                data-bs-placement="bottom"
	                data-bs-custom-class="custom-tooltip"
	                data-bs-title="Adicionar Procedimento"
					class="ph ph-plus icone-nome minimo pointer"
				></i>
			</div>
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label" required>Total de Sessões</label>
            <input type="text" readonly readonly-disabled name="total_sessoes" class="form-control">
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label" required>Subtotal</label>
            <input type="text" readonly readonly-disabled name="total_sessoes" class="form-control">
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label">Descontos em R$</label>
            <input type="text" name="desconto_real" class="form-control">
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label">Descontos em %</label>
            <input type="text" name="desconto_porcentagem" class="form-control">
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label" required>Total</label>
            <input type="text" readonly readonly-disabled name="total_sessoes" class="form-control">
        </div>

        <div class="mb-3 w-10">
        </div>
        <div class="mb-3 w-10">
        </div>
        <div class="mb-3 w-10">
        </div>

        <div class="w-100">
        	<h5 class="mgt-px-30">Pagamento</h5>
        </div>
	</form>
</div>

<div class="clones d-none">
<div class="procedimentos-clone w-100 d-flex flex-wrap justify-content-between mgb-px-5">
	<div class="w-15">
		<input type="text" name="codigo_procedimento[]" class="form-control busca_procedimento_codigo_tratamento">
	</div>

	<div class="w-25">
		<input type="text" name="nome_procedimento[]" class="form-control busca_procedimento_tratamento">
		<input type="hidden" class="autocomplete_procedimento_id" name="procedimento_id[]">
	</div>

	<div class="w-15">
		<input type="text" name="sessoes_procedimento[]" class="form-control">
	</div>

	<div class="w-10">
		<div class="div-money">
	    	<label for="valor_procedimento" class="moeda"><span>R$</span></label>
	    	<input type="text" name="valor_procedimento[]" class="form-control money">
	    </div>
	</div>

	<div class="w-10">
		<div class="div-money-opc">
	    	<label for="valor_desconto" class="moeda"><i class="ph ph-caret-down"></i><span>R$</span></label>
	    	<input type="text" name="desconto_procedimento[]" class="form-control money" id="valor_desconto">
	    	<input type="hidden" name="tipo_desconto[]" class="form-control" receber-tipo-desconto="true">
	    </div>
	</div>

	<div class="w-10 text-center">
		<input type="text" name="total_procedimento[]" class="form-control money">
	</div>

	<div class="w-10 d-flex align-items-center justify-content-center">
		<i
			data-bs-toggle="tooltip"
            data-bs-placement="bottom"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="Remover"
			class="ph ph-x icone-nome minimo pointer remover_procedimento_tratamento"
		></i>
	</div>
</div>
@endsection