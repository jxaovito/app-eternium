@extends('default.layout')
@section('content')
@foreach($registros as $registro)
<div class="container-tratamento-novo">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Editar Tratamento</h2>
	</div>

	<form action="/tratamento/editar_salvar/{{$registro['id']}}" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
		@csrf
		<div class="mb-3 w-40">
            <label for="busca_paciente_tratamento" class="form-label" required>Paciente</label>
            <input type="text" class="form-control" id="busca_paciente_tratamento" placeholder="" name="nome" autofocus="autofocus" required autocomplete="off" value="{{$registro['paciente']}}">
            <input type="hidden" class="autocomplete_paciente_id" name="paciente_id" value="{{$registro['paciente_id']}}">
        </div>

        <div class="mb-3 w-25">
            <label for="" class="form-label" required>Convenio</label>
            <select class="select2 convenio" required name="convenio">
        		<option value="">Selecione...</option>
        		@if($convenios)
        			@foreach($convenios as $convenio)
        				<option value="{{$convenio['id']}}" {{$registro['convenio_id'] == $convenio['id'] ? 'selected' : ''}}>{{$convenio['nome']}}</option>
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
        				<option value="{{$profissional['profissional_id']}}" {{$registro['profissional_id'] == $profissional['profissional_id'] ? 'selected' : ''}}>{{$profissional['profissional']}}</option>
        			@endforeach
				@endif
            </select>
        </div>

        <div class="mb-3 w-32">
            <label for="" class="form-label" required>Especialidade</label>
            <select class="select2 especialidade" required name="especialidade">
        		<option value="">Selecione...</option>
        		@if($especialidades)
        			@foreach($especialidades as $especialidade)
        				<option value="{{$especialidade['id']}}" {{$registro['especialidade_id'] == $especialidade['id'] ? 'selected' : ''}}>{{$especialidade['nome']}}</option>
        			@endforeach
				@endif
            </select>
        </div>

        <div class="w-100 mgb-px-30">
        	<h5 class="mgt-px-30 mgb-px-10">Procedimentos</h5>
        	<div class="w-100 d-flex flex-wrap justify-content-between mgb-px-10">
        		<div class="w-5">
        			<label>Código</label>
        		</div>

        		<div class="w-25">
        			<label>Procedimento</label>
        		</div>

        		<div class="w-7">
        			<label>Sessões<br><sub class="realtive top-px--5 opacity-08 font-12">Contratada</sub></label>
        		</div>

                <div class="w-7">
                    <label><br><sub class="realtive top-px--5 opacity-08 font-12">Realizadas</sub></label>
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
                    <label>Unitário por sessão</label>
                </div>

        		<div class="w-10 text-center">
        			<label>Remover</label>
        		</div>
    		</div>
    		<div class="content-procedimentos w-100 d-flex flex-wrap justify-content-between">
                @foreach($registro['procedimentos'] as $procedimento)
                    <div class="procedimentos-clone w-100 d-flex flex-wrap justify-content-between mgb-px-5">
                        <div class="w-5">
                            <input type="text" name="codigo_procedimento[]" class="form-control busca_procedimento_codigo_tratamento" value="{{$procedimento['codigo']}}">
                        </div>

                        <div class="w-25">
                            <input type="text" name="nome_procedimento[]" class="form-control busca_procedimento_tratamento" value="{{$procedimento['procedimento']}}">
                            <input type="hidden" class="autocomplete_procedimento_id" name="procedimento_id[]" value="{{$procedimento['procedimento_id']}}">
                        </div>

                        <div class="w-7">
                            <input type="text" name="sessoes_procedimento[]" class="form-control number" value="{{$procedimento['sessoes_contratada']}}" sessoes_consumidas="{{$procedimento['sessoes_consumida']}}">
                        </div>

                        <div class="w-7">
                            <input type="text" name="sessoes_consumida[]" class="form-control number" value="{{$procedimento['sessoes_consumida']}}" readonly readonly-disabled sessoes-contratada-anteriormente="{{$procedimento['sessoes_contratada']}}">
                        </div>

                        <div class="w-10">
                            <div class="div-money">
                                <label for="valor_procedimento" class="moeda"><span>R$</span></label>
                                <input
                                    type="text"
                                    name="valor_procedimento[]"
                                    class="form-control money"
                                    value="{{$procedimento['procedimento_valor']}}"
                                    {{$procedimento['sessoes_consumida'] != 0 || $registro['fin_lancamento'] ? 'readonly readonly-disabled' : ''}}
                                >
                            </div>
                        </div>

                        <div class="w-10">
                            <div class="div-money-opc">
                                @php
                                $desconto = '';
                                $tipo_desconto = 'real';
                                if($procedimento['tipo_desconto'] == null || $procedimento['tipo_desconto'] == 0 && $procedimento['desconto_real'] != '0.00'){
                                    $desconto = $procedimento['desconto_real'];
                                }

                                if($procedimento['tipo_desconto'] == 1 && $procedimento['desconto_porcento'] != '0.00'){
                                    $tipo_desconto = 'porcentagem';
                                    $desconto = $procedimento['desconto_porcento'];
                                }
                                @endphp
                                <label for="valor_desconto" class="moeda"><i class="ph ph-caret-down"></i><span>R$</span></label>
                                <input
                                    type="text"
                                    name="desconto_procedimento[]"
                                    class="form-control money"
                                    id="valor_desconto"
                                    value="{{$desconto}}"
                                    {{$procedimento['sessoes_consumida'] != 0 || $registro['fin_lancamento'] ? 'readonly readonly-disabled' : ''}}
                                >
                                <input type="hidden" name="tipo_desconto[]" class="form-control" receber-tipo-desconto="true" value="{{$tipo_desconto}}">
                            </div>
                        </div>

                        <div class="w-10 text-center">
                            <div class="div-money">
                                <label for="valor_procedimento" class="moeda"><span>R$</span></label>
                                <input type="text" name="total_procedimento[]" class="form-control money" readonly readonly-disabled value="{{$procedimento['total']}}">
                            </div>
                        </div>

                        <div class="w-10 text-center">
                            <div class="div-money">
                                <label for="valor_procedimento" class="moeda"><span>R$</span></label>
                                <input type="text" class="form-control money" readonly readonly-disabled value="{{number_format($procedimento['total'] / $procedimento['sessoes_contratada'], 2)}}">
                            </div>
                        </div>

                        <div class="w-10 d-flex align-items-center justify-content-center">
                            <i
                                data-bs-toggle="tooltip"
                                data-bs-placement="bottom"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="{{$procedimento['sessoes_consumida'] == 0 && !$registro['fin_lancamento'] ? 'Remover' : 'Não é possível remover um procedimento com sessões já realizadas ou quando o tratamento já foi pago.'}}"
                                {{$procedimento['sessoes_consumida'] != 0 || $registro['fin_lancamento'] ? 'disabled' : ''}}
                                class="ph ph-x icone-nome minimo pointer {{$procedimento['sessoes_consumida'] == 0 && !$registro['fin_lancamento'] ? 'remover_procedimento_tratamento' : ''}}"
                            ></i>
                        </div>
                    </div>
                @endforeach
    		</div>
    		<div class="d-flex justify-content-center w-100 text-align-center mgt-px-30">
				<i 
					data-bs-toggle="tooltip"
	                data-bs-placement="bottom"
	                data-bs-custom-class="custom-tooltip"
	                data-bs-title="Adicionar Procedimento"
					class="ph ph-plus icone-nome minimo pointer add_procedimento"
				></i>
			</div>
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label" required>Total de Sessões</label>
            <input type="text" readonly readonly-disabled name="total_sessoes" class="form-control" value="{{$registro['sessoes_contratada']}}">
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label" required>Subtotal</label>
            <div class="div-money">
                <label for="valor_procedimento" class="moeda"><span>R$</span></label>
                <input type="text" readonly readonly-disabled name="subtotal" class="form-control money" value="{{$registro['subtotal']}}">
            </div>
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label">Descontos em R$</label>
            <div class="div-money">
                <label for="valor_procedimento" class="moeda"><span>R$</span></label>
                @php
                $desconto_real = '';
                $desconto_porcento = '';
                $block_porcento = '';
                $block_real = '';
                if($registro['tipo_desconto'] == null || $registro['tipo_desconto'] == 0 && $registro['desconto_real'] != '0.00'){
                    $block_porcento = 'readonly readonly-disabled';
                    $desconto_real = 'value="'.$registro['desconto_real'].'"';
                }

                if($registro['tipo_desconto'] == 1 && $registro['desconto_porcento'] != '0.00'){
                    $block_real = 'readonly readonly-disabled';
                    $desconto_porcento = 'value="'.$registro['desconto_porcento'].'"';
                }
                @endphp
                <input type="text" name="desconto_real" class="form-control money" {{$desconto_real}} {{$block_real}}>
            </div>
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label">Descontos em %</label>
            <div class="div-money">
                <label for="valor_procedimento" class="moeda"><span>%</span></label>
                <input type="text" name="desconto_porcentagem" class="form-control money" {{$desconto_porcento}} {{$block_porcento}}>
            </div>
        </div>

        <div class="mb-3 w-10">
            <label for="" class="form-label" required>Total</label>
            <div class="div-money">
                <label for="valor_procedimento" class="moeda"><span>R$</span></label>
                <input type="text" readonly readonly-disabled name="total" class="form-control money" value="{{$registro['total']}}">
            </div>
        </div>

        <div class="mb-3 w-10">
        </div>
        <div class="mb-3 w-10">
        </div>
        <div class="mb-3 w-10">
        </div>

        <div class="w-100" style="display:none;">
            <div class="w-100 d-flex credito-paciente" style="background-image: url('{{asset('img/credito-money.png')}}')">
                <h5 class="mgt-px-10">
                     <label class="form-label">Crédito para o paciente</label>
                     <div class="div-money">
                         <label for="valor_procedimento" class="moeda color-000"><span class="font-16">R$</span></label>
                         <input type="text" readonly name="credito_paciente" class="form-control money">
                     </div>
                 </h5>
            </div>
        </div>

        <div class="mb-3 w-100 mgt-px-10">
            <label for="observacoes_tratamento" class="form-label">Observações do Tratamento</label>
            <textarea id="observacoes_tratamento" name="observacoes_tratamento" class="form-control">{{$registro['observacoes']}}</textarea>
        </div>

        <div class="w-100 d-flex">
            <h5 class="mgt-px-10">
                <input name="pagamentos" id="pagamentos" type="checkbox" class="check-checkbox" value="1" {{$registro['fin_lancamento'] ? 'checked' : ''}} {{$registro['fin_lancamento'] ? 'disabled' : ''}}>
                 <label for="pagamentos">Pagamento</label>
                 @if($registro['fin_lancamento'])
                    <input name="pagamentos" type="checkbox" class="d-none" value="1" checked>
                 @endif
             </h5>
        </div>

        <div class="w-100 pagamentos-tratamento" style="{{$registro['fin_lancamento'] ? 'display:inline-block' : ''}}">
            <div class="w-100 d-flex flex-wrap justify-content-between">
                <div class="mb-3 w-15">
                    <label for="" class="form-label">Forma de Pagamento</label>
                    <select class="select2 forma_pagamento" name="forma_pagamento" {{$registro['fin_lancamento'] ? 'disabled' : ''}}>
                		<option value="">Selecione...</option>
                		@if($forma_pagamento)
                			@foreach($forma_pagamento as $pagamento)
                				<option value="{{$pagamento['id']}}" {{$registro['fin_forma_pagamento_id'] == $pagamento['id'] ? 'selected' : ''}}>{{$pagamento['nome']}}</option>
                			@endforeach
        				@endif
                    </select>
                </div>

                <div class="mb-3 w-15">
                    <label for="" class="form-label">Parcelas</label>
                    <select class="select2 parcela_pagamento" name="parcela_pagamento" {{$registro['fin_lancamento'] ? 'disabled' : ''}}>
                		<option value="">Selecione...</option>
                		@if($parcelas_pagamento)
                			@foreach($parcelas_pagamento as $key => $parcela)
                				<option value="{{$parcela['id']}}" {{$registro['fin_parcelas_pagamento_id'] == $parcela['id'] ? 'selected' : ''}}>
                                    {{$parcela['parcela']}}x
                                </option>
                			@endforeach
        				@endif
                    </select>
                </div>

                <div class="mb-3 w-15">
                    <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                    <input type="text" name="data_vencimento" id="data_vencimento" class="form-control data" value="{{$registro['data_vencimento'] ? date_format(date_create_from_format('Y-m-d', $registro['data_vencimento']), 'd/m/Y') : date('d-m-Y')}}" name="data_vencimento"  {{$registro['fin_lancamento'] ? 'disabled' : ''}}>
                </div>

                <div class="mb-3 w-15">
                    <label for="" class="form-label">Categoria</label>
                    <select class="select2 categoria" name="categoria" {{$registro['fin_lancamento'] ? 'disabled' : ''}}>
                		<option value="">Selecione...</option>
                		@if($categorias)
                			@foreach($categorias as $categoria)
                				<option value="{{$categoria['id']}}" {{$registro['fin_categoria_id'] == $categoria['id'] ? 'selected' : ''}}>
                                    {{$categoria['nome']}}
                                </option>
                			@endforeach
        				@endif
                    </select>
                </div>

                <div class="mb-3 w-15">
                    <label for="" class="form-label">Subcategoria</label>
                    <select class="select2 subcategoria" name="subcategoria" {{$registro['fin_lancamento'] ? 'disabled' : ''}}>
                    </select>
                    @if($registro['fin_categoria_id'])
                        <script>
                            $(document).ready(function(){
                                setTimeout(function(){
                                    $('[name="categoria"]').trigger('change');

                                    setTimeout(function(){
                                        $.each($('[name="subcategoria"] option'), function(i,v){
                                            if($(this).attr('value') == {{$registro['fin_subcategoria_id']}}){
                                                $(this).attr('selected', 'selected');
                                            }
                                        });
                                        $('[name="subcategoria"]').trigger('change');
                                    }, 500);
                                }, 100)
                            })
                        </script>
                    @endif
                </div>

                <div class="mb-3 w-15">
                    <label for="" class="form-label">Conta</label>
                    <select class="select2 conta" name="conta" {{$registro['fin_lancamento'] ? 'disabled' : ''}}>
                		<option value="">Selecione...</option>
                		@if($contas)
                			@foreach($contas as $conta)
                				<option value="{{$conta['id']}}" {{$registro['fin_conta_id'] == $conta['id'] ? 'selected' : ''}}>{{$conta['nome']}}</option>
                			@endforeach
        				@endif
                    </select>
                </div>

                @if($registro['fin_lancamento'] && isset($registro['parcelas']))
                    <div class="w-100 d-flex flex-wrap mgb-px-10 mgt-px-10 opacity-05 user-select-none">
                        <h5><label class="w-100 bold font-15">Parcelas:</label></h5>
                    </div>

                    <div class="w-3 d-flex flex-wrap mgb-px-10 text-align-center">
                        <label class="w-100 bold">Nº</label>
                    </div>

                    <div class="w-24 d-flex flex-wrap mgb-px-10 text-align-center">
                        <label class="w-100 bold">Valor da Parcela</label>
                    </div>

                    <div class="w-24 d-flex flex-wrap mgb-px-10 text-align-center">
                        <label class="w-100 bold">Valor Restante</label>
                    </div>

                    <div class="w-24 d-flex flex-wrap mgb-px-10 text-align-center">
                        <label class="w-100 bold">Data de Vencimento</label>
                    </div>

                    <div class="w-24 d-flex flex-wrap mgb-px-10 text-align-center">
                        <label class="w-100 bold">Status</label>
                    </div>

                    @foreach($registro['parcelas'] as $key => $pacela)
                        <div 
                            class="w-100 d-flex 
                                    {{$pacela['data_vencimento'] < date('Y-m-d') && $pacela['quitado'] == 'n' ? 'pagamento_atrasado' : ''}}
                                    {{$pacela['quitado'] == 's' ? 'pagamento_pago' : ''}}
                                "
                        >
                            <div class="w-3 d-flex flex-wrap text-align-center">
                                <span class="w-100">{{$key+1}}</span>
                            </div>

                            <div class="w-24 d-flex flex-wrap text-align-center">
                                <span class="w-100">R$ {{number_format($pacela['valor'] ? $pacela['valor'] : '0', 2, ',', '.')}}</span>
                            </div>

                            <div class="w-24 d-flex flex-wrap text-align-center">
                                <span class="w-100">R$ {{number_format($pacela['valor_restante'] ? $pacela['valor_restante'] : '0', 2, ',', '.')}}</span>
                            </div>

                            <div class="w-24 d-flex flex-wrap text-align-center">
                                <span class="w-100">{{date_format(date_create_from_format('Y-m-d', $pacela['data_vencimento']), 'd/m/Y')}}</span>
                            </div>

                            <div class="w-24 d-flex flex-wrap text-align-center">
                                <span class="w-100">
                                    @if($pacela['data_vencimento'] < date('Y-m-d') && $pacela['quitado'] == 'n')
                                    <b>Em Atraso</b>
                                    @elseif($pacela['quitado'] == 'n')
                                    Em aberto
                                    @else
                                    Pago
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

		<div class="w-100 mgt-px-50">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/tratamento" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
            </div>
        </div>
	</form>
</div>
@endforeach

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
    		<input type="text" name="sessoes_procedimento[]" class="form-control number">
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
    	    	<input type="hidden" name="tipo_desconto[]" class="form-control" receber-tipo-desconto="true" value="real">
    	    </div>
    	</div>

    	<div class="w-10 text-center">
            <div class="div-money">
                <label for="valor_procedimento" class="moeda"><span>R$</span></label>
                <input type="text" name="total_procedimento[]" class="form-control money" readonly readonly-disabled >
            </div>
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
</div>
@endsection