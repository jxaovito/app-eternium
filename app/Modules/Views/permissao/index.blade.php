@extends('default.layout')
@section('content')
<div class="container-permissao">
    <div class="head">
        <h2>Permissões</h2>
        <a href="/permissao/novo">
            <button class="btn btn-success"><i class="ph ph-plus"></i> Novo Perfil</button>
        </a>
    </div>
    <div class="content-nv-permissao">
    <table class="table table-hover">
        <thead>
            <th>Perfil</th>
            <th>Ações</th>
        </thead>
        <tbody>
            @foreach($nivel_permissao as $nv)
            <tr>
                <td>{{$nv['nome']}}</td>
                <td>
                    <a href="permissao/editar/{{$nv['id']}}">
                        <i class="ph ph-pencil-simple"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Editar"
                        ></i>
                    </a>
                    <span>
                        <i class="ph ph-x"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Remover"
                        ></i>
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection