@extends('default.layout')
@section('content')
<div class="container-permissao-editar">
    <div class="head">
        <a href="/permissao">
            <i class="ph ph-caret-left"></i> Voltar
        </a>
    </div>

    <div class="content">
        <h4>Editar nível de permissão: <b>{{$nivel_permissao[0]['nome']}}</b></h4>

        <div class="permissoes">
            <form method="post" action="/permissao/editar_salvar">
                @csrf
                <input type="hidden" value="{{$nivel_permissao_id}}" name="nivel_permissao_id">
                <?php $permissao_atual = ''; ?>
                    <div class="box-permission">
                    @foreach($permissoes as $permissao)
                        @if(!$permissao_atual || $permissao_atual != $permissao['modulo'])
                            <?php $permissao_atual = $permissao['modulo']; ?>
                            <button 
                                class="btn btn-light"
                                type="button"
                                referencia="{{$permissao['modulo']}}"
                            >
                                {{$permissao['modulo']}}
                            </button>
                        @endif
                    @endforeach
                    </div>

                    <div class="box-permission-list">
                    @foreach($permissoes as $permissao)
                        <div class="box-permiss {{$permissao['modulo']}}">
                            <div class="permissao">
                                <input 
                                    id="{{strtolower(str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $permissao['nome']))))}}"
                                    type="checkbox"
                                    class="switch"
                                    name="{{$permissao['modulo']}}[{{$permissao['funcao']}}]"
                                    value="1"
                                    <?= $permissao['status'] ? 'checked' : '' ?>
                                >
                                <label for="{{strtolower(str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $permissao['nome']))))}}">
                                    {{$permissao['nome']}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                    </div>

                <div class="footer d-flex justify-content-between">
                    <a href="/permissao" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                    <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection