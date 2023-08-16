@extends('default.layout')
@section('content')
<div class="container-permissao-novo">
    <div class="mgb-px-30">
        <h2>Novo Convênio</h2>
    </div>
    <form action="/convenio/novo_salvar" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 w-32">
            <label for="nome_convenio" class="form-label">Nome do Convênio</label>
            <input type="text" class="form-control" id="nome_convenio" placeholder="" name="nome" autofocus="autofocus">
        </div>

        <div class="mb-3 w-32">
            <label for="cnpj_convenio" class="form-label">CNPJ</label>
            <input type="text" class="form-control cnpj" id="cnpj_convenio" placeholder="" name="cnpj">
        </div>

        <div class="mb-3 w-32">
            <label for="imagem" class="form-label">Logo</label>
            <input type="file" class="form-control" id="imagem" name="image" accept="image/png, image/gif, image/jpeg">
        </div>

        <div class="w-100">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/convenio" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
            </div>
        </div>
    </form>
</div>
@endsection