@extends('default.layout')
@section('content')
<div class="container-especialidade-novo">
    <div class="mgb-px-30">
        <h2>Editar Especialidade</h2>
    </div>
    @foreach($especialidade as $esp)
        <form action="/especialidade/editar_salvar/{{$esp['id']}}" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 w-32">
                <label for="nome_especialidade" class="form-label">Nome da Especialidade</label>
                <input type="text" class="form-control" id="nome_especialidade" placeholder="" name="nome" autofocus="autofocus" value="{{$esp['nome']}}">
            </div>

            <div class="mb-3 w-32">
                <label for="cor_fundo_especialidade" class="form-label">Cor de Fundo</label>
                <input
                    type="color"
                    class="form-control form-control-color"
                    id="cor_fundo_especialidade"
                    name="cor_fundo"
                    value="{{$esp['cor_fundo']}}"
                    title="Choose your color"
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Selecionar Cor de Fundo"
                >
            </div>

            <div class="mb-3 w-32">
                <label for="cor_fonte_especialidade" class="form-label">Cor da Fonte</label>
                <input
                    type="color"
                    class="form-control form-control-color"
                    id="cor_fonte_especialidade"
                    name="cor_fonte"
                    value="{{$esp['cor_fonte']}}"
                    title="Choose your color"
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Selecionar Cor da Fonte"
                >
            </div>

            <div class="w-100">
                <div class="mb-3 d-flex justify-content-between">
                    <a href="/especialidade" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                    <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
                </div>
            </div>
        </form>
    @endforeach
</div>
@endsection