@extends('default.layout')
@section('content')
<div class="container-permissao">
    <div class="head">
        <h2>Permissões</h2>
        @if($permissao_adicionar_perfil)
        <a href="/permissao/novo">
            <button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-plus"></i> Novo Perfil</button>
        </a>
        @endif
    </div>
    <div class="content-nv-permissao">
    <table class="table table-hover">
        <thead>
            <th>Perfil</th>
            @if($permissao_editar_perfil || $permissao_remover_perfil)
            <th width="100" class="text-align-center">Ações</th>
            @endif
        </thead>
        <tbody>
            @foreach($nivel_permissao as $nv)
            <tr>
                <td>
                    <div class="row-table">
                        <text
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="{{$nv['nome']}}"
                            class="limita_character limita_em_30"
                        >
                            {{$nv['nome']}}
                        </text>
                    </div>
                </td>
                @if($permissao_editar_perfil || $permissao_remover_perfil)
                <td>
                    <div class="row-table justify-content-around">
                        @if($permissao_editar_perfil)
                            <a href="permissao/editar/{{$nv['id']}}">
                                <i class="ph ph-pencil-simple"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-title="Editar"
                                ></i>
                            </a>
                        @endif
                        @if($permissao_remover_perfil)
                        @php
                            $deletar = true;
                            if((array_key_exists($nv['id'], $niveis_permissao_utilizados))){
                                $deletar = false;
                            }
                        @endphp
                        <span>
                            <i class="ph ph-x <?= ($nv['padrao'] == 's' ? '' : ($deletar ? 'deletar' : ''))?>"
                                data-bs-toggle="tooltip"
                                data-bs-placement="bottom"
                                data-bs-custom-class="custom-tooltip"
                                link="{{url('/')}}/permissao/remover/{{$nv['id']}}"
                                titulo="Remover Permissão"
                                texto="Você tem certeza que deseja <b>remover</b> a permissão <b>{{$nv['nome']}}</b>?"
                                <?= ($nv['padrao'] == 's' ? 'disabled' : ($deletar ? '' : 'disabled'))?>
                                <?= ($nv['padrao'] == 's' ? 'data-bs-title="Não é possível remover nível de permissão padrão do sistema"' : 
                                    ($deletar ? 'data-bs-title="Remover"' : 'data-bs-title="Não é possível remover nível de permissão pois existe usuários relacionados"'))?>
                            ></i>
                        </span>
                        @endif
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection