@extends('default.layout')
@section('content')
<div class="container-profissional-horario">
    <div class="mgb-px-30">
        <h2>Horários do Profissional</h2>
        <h5>{{$registros[0]['nome']}}</h5>
    </div>
    <form action="/profissional/novo_salvar" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
        @csrf
        @for($i=0; $i <= 6; $i++)
            <div class="mb-3 w-12 text-center">
                <label for="nome_profissional" class="form-label">
                    @if($i == 0)
                        Segunda-Feira
                        @php $dia_semana = 'segunda'; @endphp
                    @elseif($i == 1)
                        Terça-Feira
                        @php $dia_semana = 'terca'; @endphp
                    @elseif($i == 2)
                        Quarta-Feira
                        @php $dia_semana = 'quarta'; @endphp
                    @elseif($i == 3)
                        Quinta-Feira
                        @php $dia_semana = 'quinta'; @endphp
                    @elseif($i == 4)
                        Sexta-Feira
                        @php $dia_semana = 'sexta'; @endphp
                    @elseif($i == 5)
                        Sábado
                        @php $dia_semana = 'sabado'; @endphp
                    @elseif($i == 6)
                        Domingo
                        @php $dia_semana = 'domingo'; @endphp
                    @endif
                </label>
                <div class="w-100 d-flex justify-content-around mb-3">
                    <sub>Hora Início</sub>
                    <sub>Hora Fim</sub>
                </div>
                <div class="horarios">
                    <div class="w-100 d-flex justify-content-between first-div mgb-px-10 align-items-center">
                        <input type="text" class="form-control time" name="hora_inicio_{{$dia_semana}}[]" tipo="hora_inicio">
                        <input type="text" class="form-control time" name="hora_fim_{{$dia_semana}}[]" tipo="hora_fim">
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
        @endfor
        <div class="w-100 mgt-px-50">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/profissional" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
            </div>
        </div>
    </form>
</div>
@endsection