@extends('default.layout')
@section('content')
<div class="container-permissao-novo">
    <div class="mgb-px-30">
        <h2>Editar Usuário</h2>
    </div>
    <form action="/usuario/editar_salvar/{{$usuario[0]['id']}}" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 w-32">
            <label for="nome_usuario" class="form-label" required>Nome do usuário</label>
            <input type="text" class="form-control" id="nome_usuario" placeholder="" name="nome" autofocus="autofocus" required value="{{$usuario[0]['nome']}}">
        </div>

        <div class="mb-3 w-32">
            <label for="cnpj_convenio" class="form-label" required>
                Nível de Permissão
                <?=$nivel_permissao_user[0]['auth_nivel_permissao_id'] == 2 
                    ? '<i class="ph ph-question"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="Não é possível alterar o nível de permissão de um Profissional"></i>' 
                    : ''?>
            </label>
            <select class="select2" name="nivel_permissao" required="required"
            {{$nivel_permissao_user[0]['auth_nivel_permissao_id'] == 2 ? 'disabled' : ''}}
            >
                @foreach($nivel_permissao as $permissao)
                    @if($nivel_permissao_user[0]['auth_nivel_permissao_id'] == $permissao['id'])
                        <option value="{{$permissao['id']}}" selected>{{$permissao['nome']}}</option>

                    @else
                        <option value="{{$permissao['id']}}">{{$permissao['nome']}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-3 w-32 d-flex align-items-center">
            @if($usuario[0]['imagem'])
                <div class="mgr-px-10 d-flex justify-content-center flex-wrap w-30">
                    <img class="w-60px h-60px border-radius-50" src="{{asset('clientes/'.session('conexao_id').'/usuario/'.$usuario[0]['imagem'])}}">
                    <div class="w-100 d-flex flex-wrap justify-content-center mgt-px-10">
                        <input type="checkbox" name="remover-imagem" value="1" class="switch" id="remover-imagem">
                        <label class="w-100 text-align-center user-select-none" for="remover-imagem">Remover Imagem</label>
                    </div>
                </div>
            @endif
            <div>
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="imagem" name="image" accept="image/png, image/gif, image/jpeg">
            </div>
        </div>

        <div class="mb-3 w-100">
            <label for="email" class="form-label" required>Login</label>
            <input
                disabled
                type="email"
                class="form-control"
                id="email"
                name="email"
                required="required"
                placeholder="usuario@dominio.com.br"
                value="{{$usuario_db[0]['email']}}"
                title="Não é possível alterar o email de cadastro."
            >
        </div>

        <div class="mb-3 w-48 d-flex flex-wrap">
            <label for="senha" class="form-label w-100">Senha</label>
            <sub class="w-100">Deixe em branco, para não atualizar a senha</sub>
            <input type="password" class="form-control w-100 mgt-px-10" id="senha" name="senha" placeholder="************">
        </div>

        <div class="mb-3 w-48 d-flex flex-wrap">
            <label for="repetir_senha" class="form-label w-100">Repetir Senha</label>
            <sub class="w-100">Deixe em branco, para não atualizar a senha</sub>
            <input type="password" class="form-control w-100 mgt-px-10" id="repetir_senha" placeholder="************" name="repetir_senha">
        </div>

        <div class="w-100">
            <div id="status_senha" class="w-100 user-select-none text-danger-emphasis"></div>
        </div>

        <div class="mb-3 w-100">
            <input type="checkbox" name="solicitar_redefinicao" value="1" class="switch" id="redefinicao_senha" {{$usuario[0]['atualizar_senha'] ? 'checked' : ''}}>
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