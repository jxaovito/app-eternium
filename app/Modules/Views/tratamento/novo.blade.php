@extends('default.layout')
@section('content')
<div class="container-tratamento-novo">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Novo Tratamento</h2>
	</div>

	<form action="/tratamento/novo_salvar/" method="post" class="d-flex flex-wrap justify-content-between" enctype="multipart/form-data">
		@csrf

        {{-- Chama View do Form --}}
        @include('tratamento.form_novo')
        
        <div class="w-100 mgt-px-50">
            <div class="mb-3 d-flex justify-content-between">
                <a href="/tratamento" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
            </div>
        </div>
	</form>
</div>

{{-- Chama View do Form --}}
@include('tratamento.form_novo_clone')

@endsection