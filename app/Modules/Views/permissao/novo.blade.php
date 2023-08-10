@extends('default.layout')
@section('content')
<div class="container-permissao-novo">
    <form action="/permissao/novo_salvar" method="post">
        @csrf
        <div class="mb-3">
            <label for="nome_nivel_permisao" class="form-label">Informe o nome do Nível de Permissão</label>
            <input type="text" class="form-control" id="nome_nivel_permisao" placeholder="Administrador" name="nome" autofocus="autofocus">
        </div>
        <div class="mb-3 d-flex justify-content-between">
            <a href="/permissao" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
            <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
        </div>
    </form>
</div>
@endsection