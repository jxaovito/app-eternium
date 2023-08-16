@extends('default.layout')
@section('content')
<div class="container-permissao-novo">
    <div class="mgb-px-30">
        <h2>Novo Profissional</h2>
    </div>
    <form action="/profissional/novo_salvar" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 w-32">
            <label for="nome_profissional" class="form-label" required>Nome do Profissional</label>
            <input type="text" class="form-control" id="nome_profissional" placeholder="" name="nome" autofocus="autofocus" required>
            <input type="hidden" name="nivel_permissao" value="2">
        </div>

        <div class="mb-3 w-32">
            <label for="especialidade_profissional" class="form-label" required>Especialidade</label>
            <select id="especialidade_profissional" name="especialidade[]" class="select2" multiple required>
                @if($especialidades)
                    @foreach($especialidades as $esp)
                        <option value="{{$esp['id']}}">{{$esp['nome']}}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="mb-3 w-32">
            <label for="imagem" class="form-label">Imagem</label>
            <input type="file" class="form-control" id="imagem" name="image">
        </div>

        <div class="mb-3 w-100">
            <label for="email" class="form-label" required>Login</label>
            <input type="email" class="form-control" id="email" name="email" required="required" placeholder="usuario@dominio.com.br">
        </div>

        <div class="mb-3 w-48">
            <label for="senha" class="form-label" required>Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required="required" placeholder="************">
        </div>

        <div class="mb-1 w-48">
            <label for="repetir_senha" class="form-label" required>Repetir Senha</label>
            <input type="password" class="form-control" id="repetir_senha" required="required" placeholder="************" name="repetir_senha">
        </div>

        <div class="w-100">
            <div id="status_senha" class="w-100 user-select-none text-danger-emphasis"></div>
        </div>

        <div class="mb-3 w-100">
            <input type="checkbox" name="solicitar_redefinicao" value="1" class="switch" id="redefinicao_senha">
            <label for="redefinicao_senha" class="form-label user-select-none">Solicitar redefinição de senha após o primeiro Login.</label>
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