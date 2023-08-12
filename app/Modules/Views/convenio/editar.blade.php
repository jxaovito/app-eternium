@extends('default.layout')
@section('content')
<div class="container-permissao-novo">
    <div class="mgb-px-30">
        <h2>Editar Convênio</h2>
    </div>
    @foreach($convenio as $con)
        <form action="/convenio/editar_salvar/{{$con['id']}}" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 {{$con['imagem'] ? 'w-60' : 'w-32'}}">
                <label for="nome_convenio" class="form-label">Nome do Convênio</label>
                <input type="text" class="form-control" id="nome_convenio" placeholder="" name="nome" autofocus="autofocus" value="{{$con['nome']}}">
            </div>

            <div class="mb-3 {{$con['imagem'] ? 'w-35' : 'w-32'}}">
                <label for="cnpj_convenio" class="form-label">CNPJ</label>
                <input type="text" class="form-control cnpj" id="cnpj_convenio" placeholder="" name="cnpj"  value="{{$con['cnpj']}}">
            </div>

            @if($con['imagem'])
                <div class="mb-3 w-8 d-flex flex-wrap justify-content-center">
                    <img class="w-80" src="{{asset('clientes/'.session('conexao_id').'/convenio/'.$con['imagem'])}}">
                    <div class="w-100 d-flex flex-wrap text-align-center justify-content-center">
                        <input 
                            id="remover-imagem"
                            type="checkbox"
                            class="switch"
                            name="remover-imagem"
                            value="1"
                        >
                        <label class="w-100" for="remover-imagem"><sub>Remover Imagem</sub></label>
                    </div>
                </div>
            @endif

            <div class="mb-3 {{$con['imagem'] ? 'w-90' : 'w-32'}}">
                <label for="imagem" class="form-label">Logo</label>
                <input type="file" class="form-control" id="imagem" name="image">
            </div>

            <div class="w-100">
                <div class="mb-3 d-flex justify-content-between">
                    <a href="/convenio" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                    <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
                </div>
            </div>
        </form>
    @endforeach
</div>
@endsection