@extends('default.layout')
@section('content')
<div class="container-permissao-novo">
    <div class="mb-3">
        <a href="/permissao">
            <i class="ph ph-caret-left"></i> Voltar
        </a>
    </div>
    <form action="/permissao/novo_salvar" method="post">
        @csrf
        <div class="mb-3">
            <label for="nome_nivel_permisao" class="form-label">Informe o nome do Nível de Permissão</label>
            <input type="text" class="form-control" id="nome_nivel_permisao" placeholder="Administrador" name="nome" autofocus="autofocus">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
    </form>
</div>
@endsection