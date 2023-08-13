@extends('default.layout')
@section('content')
<div class="container-permissao-novo">
    <div class="mgb-px-30">
        <h2>Novo Usuário</h2>
    </div>
    <form action="/usuario/novo_salvar" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 w-32">
            <label for="nome_usuario" class="form-label" required>Nome do usuário</label>
            <input type="text" class="form-control" id="nome_usuario" placeholder="" name="nome" autofocus="autofocus" required>
        </div>

        <div class="mb-3 w-32">
            <label for="cnpj_convenio" class="form-label" required>Nível de Permissão</label>
            <select class="select2" name="nivel_permissao" required="required">
                <option selected value="">Selecione...</option>
                @foreach($nivel_permissao as $permissao)
                    <option value="{{$permissao['id']}}">{{$permissao['nome']}}</option>
                @endforeach
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

        <div class="mb-3 w-100">
            <input type="checkbox" name="solicitar_redefinicao" value="1" class="switch" id="redefinicao_senha">
            <label for="redefinicao_senha" class="form-label user-select-none">Solicitar redefinição de senha após o primeiro Login.</label>
        </div>

        <div class="w-100">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/usuario" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
            </div>
        </div>
    </form>
</div>
@endsection