@extends('default.layout')
@section('content')
<div class="container-procedimento">
	<div class="mgb-px-30">
		<h2>Procedimentos</h2>
		<h5>
			@if($convenio['imagem'])
				<div class="d-flex align-items-center">
					@if($convenio['imagem'])
						<span class="mgr-px-15 icone-nome w-60px h-60px"><img src="{{asset('clientes/'.session('conexao_id').'/convenio/'.$convenio['imagem'])}}"></span>
					@endif
					{{$convenio['nome']}}
				</div>
			@else
				{{$convenio['nome']}}
			@endif
		</h5>
	</div>

	<form action="/profissional/editar_salvar/{{$convenio['id']}}" method="post" class="d-flex flex-wrap justify-content-between">
		@if($procedimentos)

		@else
			<div class="mb-3 w-15">
			    <label for="codigo_procedimento" class="form-label">Código do Procedimento</label>
			    <input type="text" class="form-control" id="codigo_procedimento" placeholder="" name="codigo" autofocus="autofocus" value="">
			</div>

			<div class="mb-3 w-50">
			    <label for="nome_procedimento" class="form-label" required>Nome do Procedimento</label>
			    <input type="text" class="form-control" id="nome_procedimento" placeholder="" name="nome" required value="">
			</div>

			<div class="mb-3 w-20">
			    <label for="tmpo_procedimento" class="form-label">Tempo do Procedimento</label>
			    <input type="text" class="form-control time" id="tmpo_procedimento" placeholder="hh:mm" name="tempo" value="">
			</div>

			<div class="mb-3 w-13">
			    <label for="valor_procedimento" class="form-label">Valor</label>
			    <div class="div-money">
			    	<label for="valor_procedimento" class="moeda">R$</label>
			    	<input type="text" class="form-control money" id="valor_procedimento" placeholder="" name="valor" value="">
			    </div>
			</div>
		@endif
		<div class="w-100">
	        <div class="mb-3 d-flex justify-content-between">
	            <a href="/procedimento" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
	            <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
	        </div>
	    </div>
	</form>
</div>
@endsection