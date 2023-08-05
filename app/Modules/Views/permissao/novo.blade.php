@extends('default.layout')
@section('content')
<div class="container-permissao-novo">
    <div class="mb-3">
        <label for="nome_nivel_permisao" class="form-label">Informe o nome do Nível de Permissão</label>
        <input type="text" class="form-control" id="nome_nivel_permisao" placeholder="Administrador" name="nome">
    </div>
</div>
@endsection