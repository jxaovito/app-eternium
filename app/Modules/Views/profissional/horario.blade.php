@extends('default.layout')
@section('content')
<div class="container-profissional-horario">
    <div class="mgb-px-30">
        <h2>Horários do Profissional</h2>
        <h5>{{$registros[0]['nome']}}</h5>
    </div>
    <form action="/profissional/novo_salvar" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 w-12 text-center">
            <label for="nome_profissional" class="form-label">Segunda-Feira</label>
            <div class="w-100 d-flex justify-content-around mb-3">
                <sub>Hora Início</sub>
                <sub>Hora Fim</sub>
            </div>
            <div class="horarios">
                <div class="w-100 d-flex justify-content-between first-div mgb-px-10 align-items-center">
                    <input type="text" class="form-control time" name="hora_inicio_segunda[]" tipo="hora_inicio" placeholder="hh:mm">
                    <input type="text" class="form-control time" name="hora_fim_segunda[]" tipo="hora_fim" placeholder="hh:mm">
                    <span class="mgl-px-5 pointer remover_linha d-none"><i class="ph ph-x"></i></span>
                </div>
            </div>
            <div class="w-100 mt-3 d-flex justify-content-center">
                <i 
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Adicionar horários"
                    class="ph ph-plus icone-nome minimo pointer"
                ></i>
            </div>
        </div>

        <div class="mb-3 w-12 text-center">
            <label for="nome_profissional" class="form-label">Terça-Feira</label>
            <div class="w-100 d-flex justify-content-around mb-3">
                <sub>Hora Início</sub>
                <sub>Hora Fim</sub>
            </div>
            <div class="horarios">
                <div class="w-100 d-flex justify-content-between first-div mgb-px-10 align-items-center">
                    <input type="text" class="form-control time" name="hora_inicio_terca[]" tipo="hora_inicio" placeholder="hh:mm">
                    <input type="text" class="form-control time" name="hora_fim_terca[]" tipo="hora_fim" placeholder="hh:mm">
                    <span class="mgl-px-5 pointer remover_linha d-none"><i class="ph ph-x"></i></span>
                </div>
            </div>
            <div class="w-100 mt-3 d-flex justify-content-center">
                <i 
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Adicionar horários"
                    class="ph ph-plus icone-nome minimo pointer"
                ></i>
            </div>
        </div>

        <div class="mb-3 w-12 text-center">
            <label for="nome_profissional" class="form-label">Quarta-Feira</label>
            <div class="w-100 d-flex justify-content-around mb-3">
                <sub>Hora Início</sub>
                <sub>Hora Fim</sub>
            </div>
            <div class="horarios">
                <div class="w-100 d-flex justify-content-between first-div mgb-px-10 align-items-center">
                    <input type="text" class="form-control time" name="hora_inicio_quarta[]" tipo="hora_inicio" placeholder="hh:mm">
                    <input type="text" class="form-control time" name="hora_fim_quarta[]" tipo="hora_fim" placeholder="hh:mm">
                    <span class="mgl-px-5 pointer remover_linha d-none"><i class="ph ph-x"></i></span>
                </div>
            </div>
            <div class="w-100 mt-3 d-flex justify-content-center">
                <i 
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Adicionar horários"
                    class="ph ph-plus icone-nome minimo pointer"
                ></i>
            </div>
        </div>

        <div class="mb-3 w-12 text-center">
            <label for="nome_profissional" class="form-label">Quinta-Feira</label>
            <div class="w-100 d-flex justify-content-around mb-3">
                <sub>Hora Início</sub>
                <sub>Hora Fim</sub>
            </div>
            <div class="horarios">
                <div class="w-100 d-flex justify-content-between first-div mgb-px-10 align-items-center">
                    <input type="text" class="form-control time" name="hora_inicio_quinta[]" tipo="hora_inicio" placeholder="hh:mm">
                    <input type="text" class="form-control time" name="hora_fim_quinta[]" tipo="hora_fim" placeholder="hh:mm">
                    <span class="mgl-px-5 pointer remover_linha d-none"><i class="ph ph-x"></i></span>
                </div>
            </div>
            <div class="w-100 mt-3 d-flex justify-content-center">
                <i 
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Adicionar horários"
                    class="ph ph-plus icone-nome minimo pointer"
                ></i>
            </div>
        </div>

        <div class="mb-3 w-12 text-center">
            <label for="nome_profissional" class="form-label">Sexta-Feira</label>
            <div class="w-100 d-flex justify-content-around mb-3">
                <sub>Hora Início</sub>
                <sub>Hora Fim</sub>
            </div>
            <div class="horarios">
                <div class="w-100 d-flex justify-content-between first-div mgb-px-10 align-items-center">
                    <input type="text" class="form-control time" name="hora_inicio_sexta[]" tipo="hora_inicio" placeholder="hh:mm">
                    <input type="text" class="form-control time" name="hora_fim_sexta[]" tipo="hora_fim" placeholder="hh:mm">
                    <span class="mgl-px-5 pointer remover_linha d-none"><i class="ph ph-x"></i></span>
                </div>
            </div>
            <div class="w-100 mt-3 d-flex justify-content-center">
                <i 
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Adicionar horários"
                    class="ph ph-plus icone-nome minimo pointer"
                ></i>
            </div>
        </div>

        <div class="mb-3 w-12 text-center">
            <label for="nome_profissional" class="form-label">Sábado</label>
            <div class="w-100 d-flex justify-content-around mb-3">
                <sub>Hora Início</sub>
                <sub>Hora Fim</sub>
            </div>
            <div class="horarios">
                <div class="w-100 d-flex justify-content-between first-div mgb-px-10 align-items-center">
                    <input type="text" class="form-control time" name="hora_inicio_sabado[]" tipo="hora_inicio" placeholder="hh:mm">
                    <input type="text" class="form-control time" name="hora_fim_sabado[]" tipo="hora_fim" placeholder="hh:mm">
                    <span class="mgl-px-5 pointer remover_linha d-none"><i class="ph ph-x"></i></span>
                </div>
            </div>
            <div class="w-100 mt-3 d-flex justify-content-center">
                <i 
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Adicionar horários"
                    class="ph ph-plus icone-nome minimo pointer"
                ></i>
            </div>
        </div>

        <div class="mb-3 w-12 text-center">
            <label for="nome_profissional" class="form-label">Domingo</label>
            <div class="w-100 d-flex justify-content-around mb-3">
                <sub>Hora Início</sub>
                <sub>Hora Fim</sub>
            </div>
            <div class="horarios">
                <div class="w-100 d-flex justify-content-between first-div mgb-px-10 align-items-center">
                    <input type="text" class="form-control time" name="hora_inicio_domingo[]" tipo="hora_inicio" placeholder="hh:mm">
                    <input type="text" class="form-control time" name="hora_fim_domingo[]" tipo="hora_fim" placeholder="hh:mm">
                    <span class="mgl-px-5 pointer remover_linha d-none"><i class="ph ph-x"></i></span>
                </div>
            </div>
            <div class="w-100 mt-3 d-flex justify-content-center">
                <i 
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Adicionar horários"
                    class="ph ph-plus icone-nome minimo pointer"
                ></i>
            </div>
        </div>

        <div class="w-100 mgt-px-50">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/profissional" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
            </div>
        </div>
    </form>
</div>
@endsection