@csrf

@if($pagina == 'tratamento')
    <div class="mb-3 w-40">
        <label for="busca_paciente_tratamento" class="form-label" required>Paciente</label>
        <input type="text" class="form-control" id="busca_paciente_tratamento" placeholder="" name="nome" autofocus="autofocus" required autocomplete="off"  autocomplete="off">
        <input type="hidden" class="autocomplete_paciente_id" name="paciente_id">
    </div>
@endif

<div class="mb-3 w-25">
    <label for="" class="form-label" required>Convenio</label>
    <select class="select2 convenio" required name="convenio">
        <option value="">Selecione...</option>
        @if($convenios)
            @foreach($convenios as $convenio)
                <option value="{{$convenio['id']}}">{{$convenio['nome']}}</option>
            @endforeach
        @endif
    </select>
</div>

@if($pagina == 'tratamento')
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
@endif

<div class="mb-3 w-32">
    <label for="" class="form-label" required>Especialidade</label>
    <select class="select2 especialidade" required name="especialidade">
        <option value="">Selecione...</option>
        @if($especialidades)
            @foreach($especialidades as $especialidade)
                <option value="{{$especialidade['id']}}">{{$especialidade['nome']}}</option>
            @endforeach
        @endif
    </select>
</div>

<div class="w-100 mgb-px-30">
    <h5 class="mgt-px-30 mgb-px-10" required>Procedimentos</h5>
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
    <input type="text" readonly readonly-disabled name="total_sessoes" class="form-control" autocomplete="off">
</div>

<div class="mb-3 w-10">
    <label for="" class="form-label" required>Subtotal</label>
    <div class="div-money">
        <label for="valor_procedimento" class="moeda"><span>{{moeda()}}</span></label>
        <input type="text" readonly readonly-disabled name="subtotal" class="form-control money" autocomplete="off">
    </div>
</div>

<div class="mb-3 w-10">
    <label for="" class="form-label">Descontos em {{moeda()}}</label>
    <div class="div-money">
        <label for="valor_procedimento" class="moeda"><span>{{moeda()}}</span></label>
        <input type="text" name="desconto_real" class="form-control money" autocomplete="off">
    </div>
</div>

<div class="mb-3 w-10">
    <label for="" class="form-label">Descontos em %</label>
    <div class="div-money">
        <label for="valor_procedimento" class="moeda"><span>%</span></label>
        <input type="text" name="desconto_porcentagem" class="form-control money" autocomplete="off">
    </div>
</div>

<div class="mb-3 w-10">
    <label for="" class="form-label" required>Total</label>
    <div class="div-money">
        <label for="valor_procedimento" class="moeda"><span>{{moeda()}}</span></label>
        <input type="text" readonly readonly-disabled name="total" class="form-control money" autocomplete="off">
    </div>
</div>

<div class="mb-3 w-10">
</div>
<div class="mb-3 w-10">
</div>
<div class="mb-3 w-10">
</div>

<div class="mb-3 w-100 mgt-px-10">
    <label for="observacoes_tratamento" class="form-label">Observações do Tratamento</label>
    <textarea id="observacoes_tratamento" name="observacoes_tratamento" class="form-control"></textarea>
</div>

<div class="w-100 d-flex">
    <h5 class="mgt-px-10"><input name="pagamentos" id="pagamentos" type="checkbox" class="check-checkbox" value="1"> <label for="pagamentos">Pagamento</label></h5>
</div>

<div class="w-100 pagamentos-tratamento">
    <div class="w-100 d-flex flex-wrap justify-content-between">
        <div class="mb-3 w-15">
            <label for="" class="form-label">Forma de Pagamento</label>
            <select class="select2 forma_pagamento" name="forma_pagamento">
                <option value="">Selecione...</option>
                @if($forma_pagamento)
                    @foreach($forma_pagamento as $pagamento)
                        <option value="{{$pagamento['id']}}">{{$pagamento['nome']}}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mb-3 w-15">
            <label for="" class="form-label">Parcelas</label>
            <select class="select2 parcela_pagamento" name="parcela_pagamento">
                <option value="">Selecione...</option>
                @if($parcelas_pagamento)
                    @foreach($parcelas_pagamento as $key => $parcela)
                        <option value="{{$parcela['parcela']}}" {{$key == 0 ? 'checked="checked"' : ''}}>{{$parcela['parcela']}}x</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mb-3 w-15">
            <label for="data_vencimento" class="form-label">Data de Vencimento</label>
            <input type="text" name="data_vencimento" id="data_vencimento" class="form-control data" value="{{data()}}" name="data_vencimento">
        </div>

        <div class="mb-3 w-15">
            <label for="" class="form-label">Categoria</label>
            <select class="select2 categoria" name="categoria">
                <option value="">Selecione...</option>
                @if($categorias)
                    @foreach($categorias as $categoria)
                        <option value="{{$categoria['id']}}">{{$categoria['nome']}}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mb-3 w-15">
            <label for="" class="form-label">Subcategoria</label>
            <select class="select2 subcategoria" name="subcategoria">
            </select>
        </div>

        <div class="mb-3 w-15">
            <label for="" class="form-label">Conta</label>
            <select class="select2 conta" name="conta">
                <option value="">Selecione...</option>
                @if($contas)
                    @foreach($contas as $conta)
                        <option value="{{$conta['id']}}">{{$conta['nome']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>