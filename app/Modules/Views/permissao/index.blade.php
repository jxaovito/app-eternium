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
            <th>Ações</th>
            @endif
        </thead>
        <tbody>
            @foreach($nivel_permissao as $nv)
            <tr>
                <td>{{$nv['nome']}}</td>
                @if($permissao_editar_perfil || $permissao_remover_perfil)
                <td>
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
                    <span>
                        <i class="ph ph-x <?= ($nv['id'] == 1 ? '' : 'deletar')?>"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-custom-class="custom-tooltip"
                            link="{{url('/')}}/permissao/remover/{{$nv['id']}}"
                            titulo="Remover Permissão"
                            texto="Você tem certeza que deseja <b>remover</b> a permissão <b>{{$nv['nome']}}</b>?"
                            <?= ($nv['id'] == 1 ? 'disabled' : '')?>
                            <?= ($nv['id'] == 1 ? 'data-bs-title="Não é possível remover perfil de Administrador"' : 'data-bs-title="Remover"')?>
                        ></i>
                    </span>
                    @endif
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection