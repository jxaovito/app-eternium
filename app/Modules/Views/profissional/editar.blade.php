@extends('default.layout')
@section('content')
<div class="container-profissional-editar">
    <div class="mgb-px-30">
        <h2>Editar Profissional</h2>
    </div>

    @foreach($registros as $registro)
    <form action="/profissional/editar_salvar/{{$registro['usuario_id']}}" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 w-32">
            <label for="nome_profissional" class="form-label" required>Nome do Profissional</label>
            <input type="text" class="form-control" id="nome_profissional" placeholder="" name="nome" autofocus="autofocus" required value="{{$registro['nome']}}">
        </div>

        <div class="mb-3 w-32">
            <label for="especialidade_profissional" class="form-label" required>Especialidade</label>
            <select id="especialidade_profissional" name="especialidade[]" class="select2" multiple required>
                @if($especialidades)
                    @foreach($especialidades as $esp)
                        @php
                            $selected = false;
                            if(strpos($registro['especialidade_id'], ',') !== false){
                                $especialidade_array = explode(',', $registro['especialidade_id']);

                                foreach($especialidade_array as $esp_prof){
                                    if($esp_prof == $esp['id']){
                                        $selected = true;
                                    }
                                }
                            }else{
                                if($registro['especialidade_id'] == $esp['id']){
                                    $selected = true;
                                }
                            }
                        @endphp
                        <option value="{{$esp['id']}}" {{ $selected ? 'selected' : ''}}>{{$esp['nome']}}</option>
                    @endforeach
                @endif
            </select>
        </div>

        @if($registro['imagem'])
            <div class="mb-3 w-12 d-flex flex-wrap justify-content-center">
                <img class="w-30" src="{{asset('clientes/'.session('conexao_id').'/usuario/'.$registro['imagem'])}}">
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

            <div class="mb-3 w-20">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="imagem" name="image">
            </div>

        @else
            <div class="mb-3 w-32">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="imagem" name="image">
            </div>
        @endif

        <div class="mb-3 w-32">
            <label for="telefone_principal_profissional" class="form-label">Telefone Principal</label>
            <input type="text" class="form-control telefone" id="telefone_principal_profissional" placeholder="" name="telefone_principal" value="{{$registro['telefone_principal']}}">
        </div>

        <div class="mb-3 w-32">
            <label for="telefone_secundario_profissional" class="form-label">Telefone Secundário</label>
            <input type="text" class="form-control telefone" id="telefone_secundario_profissional" placeholder="" name="telefone_secundario" value="{{$registro['telefone_secundario']}}">
        </div>

        <div class="mb-3 w-32">
            <label for="cpf_profissional" class="form-label">CPF</label>
            <input type="text" class="form-control cpf" id="cpf_profissional" placeholder="" name="cpf" value="{{$registro['cpf']}}">
        </div>

        <div class="mb-3 w-32">
            <label for="cnpj_profissional" class="form-label">CNPJ</label>
            <input type="text" class="form-control cnpj" id="cnpj_profissional" placeholder="" name="cnpj" value="{{$registro['cnpj']}}">
        </div>

        <div class="mb-3 w-100">
            <label for="email" class="form-label">Login</label>
            <input type="email" class="form-control" id="email" name="email" disabled="disabled" required="required" placeholder="usuario@dominio.com.br" value="{{$usuario[0]['email']}}" title="Não é possível alterar o E-mail">
        </div>

        <div class="mb-3 w-48 d-flex flex-wrap">
            <label for="senha" class="form-label w-100">Senha</label>
            <sub class="w-100">Deixe em branco, para não atualizar a senha</sub>
            <input type="password" class="form-control mgt-px-10" id="senha" name="senha" placeholder="************">
        </div>

        <div class="mb-3 w-48 d-flex flex-wrap">
            <label for="repetir_senha" class="form-label w-100">Repetir Senha</label>
            <sub class="w-100">Deixe em branco, para não atualizar a senha</sub>
            <input type="password" class="form-control mgt-px-10" id="repetir_senha" placeholder="************" name="repetir_senha">
        </div>

        <div class="w-100">
            <div id="status_senha" class="w-100 user-select-none text-danger-emphasis"></div>
        </div>

        <div class="mb-3 w-100">
            <input type="checkbox" name="solicitar_redefinicao" value="1" class="switch" id="redefinicao_senha" {{$registro['atualizar_senha'] ? 'checked' : ''}}>
            <label for="redefinicao_senha" class="form-label user-select-none">Solicitar redefinição de senha após o primeiro Login.</label>
        </div>

        <div class="w-100">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/profissional" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
            </div>
        </div>
    </form>
    @endforeach
</div>
@endsection