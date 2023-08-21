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

	<form action="/procedimento/editar_salvar/{{$convenio['id']}}" method="post" class="d-flex flex-wrap justify-content-between">
		@csrf
		<div class="procedimentos d-flex flex-wrap justify-content-between w-100">
			<div class="d-flex flex-wrap justify-content-between w-100">
				<div class="mb-3 w-15">
					<label class="form-label">Código do Procedimento</label>
				</div>

				<div class="mb-3 w-45">
					<label class="form-label" required>Nome do Procedimento</label>
				</div>

				<div class="mb-3 w-20">
					<label class="form-label">Tempo do Procedimento</label>
				</div>

				<div class="mb-3 w-13">
					<label class="form-label">Valor</label>
				</div>

				<div class="mb-3 w-5 d-flex justify-content-center flex-wrap">
					<label class="form-label">Remover</label>
				</div>
			</div>
			@php
				$key = 0;
			@endphp
			@if($procedimentos)
				@foreach($procedimentos as $key => $registro)
					<div class="content-procedimentos d-flex flex-wrap justify-content-between w-100">
						<div class="mb-3 w-15">
						    <input type="text" class="form-control" id="codigo_procedimento" placeholder="" name="codigo[]" autofocus="autofocus" value="{{$registro['codigo']}}">
						    <input type="hidden" name="id[]" value="{{$registro['id']}}">
						</div>

						<div class="mb-3 w-45">
						    <input type="text" class="form-control" id="nome_procedimento" placeholder="" name="nome[]" required value="{{$registro['nome']}}">
						</div>

						<div class="mb-3 w-20">
						    @php
							    $hora = explode(':', $registro['tempo']);
							    $hora = count($hora) > 1 ? $hora[0] . $hora[1] : '';
						    @endphp
						    <input type="text" class="form-control time" id="tmpo_procedimento" placeholder="hh:mm" name="tempo[]" value="{{$hora}}">
						</div>

						<div class="mb-3 w-13">
						    <div class="div-money">
						    	<label for="valor_procedimento_{{$key}}" class="moeda">R$</label>
						    	<input type="text" class="form-control money" id="valor_procedimento_{{$key}}" placeholder="" name="valor[]" value="{{$registro['valor']}}">
						    </div>
						</div>

						<div class="mb-3 w-5 d-flex justify-content-center flex-wrap">
							<span>
								<i 
									data-bs-toggle="tooltip"
			                        data-bs-placement="bottom"
			                        data-bs-custom-class="custom-tooltip"
			                        data-bs-title="Remover"
									class="ph ph-x icone-nome minimo pointer remover_procedimento deletar"
									titulo="Remover procedimento"
									texto="Você tem certeza que deseja remover?"
									btn-texto="Remover"
									btn-cor="danger"
									row="{{$key}}"
								></i>
							</span>
						</div>
					</div>
				@endforeach
			@else
				<div class="content-procedimentos flex-wrap justify-content-between w-100 d-flex">
					<div class="mb-3 w-15">
					    <input type="text" class="form-control" id="codigo_procedimento" placeholder="" name="codigo[]" autofocus="autofocus" value="">
					</div>

					<div class="mb-3 w-45">
					    <input type="text" class="form-control" id="nome_procedimento" placeholder="" name="nome[]" required value="">
					</div>

					<div class="mb-3 w-20">
					    <input type="text" class="form-control time" id="tmpo_procedimento" placeholder="hh:mm" name="tempo[]" value="">
					</div>

					<div class="mb-3 w-13">
					    <div class="div-money">
					    	<label for="valor_procedimento" class="moeda">R$</label>
					    	<input type="text" class="form-control money" id="valor_procedimento" placeholder="" name="valor[]" value="">
					    </div>
					</div>

					<div class="mb-3 w-5 d-flex justify-content-center flex-wrap">
						<span>
							<i 
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="Remover"
								class="ph ph-x icone-nome minimo pointer remover_procedimento deletar"
								titulo="Remover procedimento"
								texto="Você tem certeza que deseja remover?"
								btn-texto="Remover"
								btn-cor="danger"
								row="0"
							></i>
						</span>
					</div>
				</div>
			@endif
		</div>
		<div class="d-flex justify-content-center w-100 text-align-center add_procedimento">
			<i 
				data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Adicionar Procedimento"
				class="ph ph-plus icone-nome minimo pointer"
			></i>
		</div>
		<div class="w-100">
	        <div class="mb-3 d-flex justify-content-between">
	            <a href="/procedimento" class="btn btn-default bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</a>
	            <button type="submit" class="btn btn-success bg-cor-logo-cliente">Salvar <i class="ph ph-check"></i></button>
	        </div>
	    </div>
	    <input type="hidden" name="deletado" value="">
	</form>

	<div class="content-procedimentos flex-wrap justify-content-between w-100 div-clone d-none">
		<div class="mb-3 w-15">
		    <input type="text" class="form-control" id="codigo_procedimento" placeholder="" name="codigo[]" autofocus="autofocus" value="">
		</div>

		<div class="mb-3 w-45">
		    <input type="text" class="form-control" id="nome_procedimento" placeholder="" name="nome[]" required value="">
		</div>

		<div class="mb-3 w-20">
		    <input type="text" class="form-control time" id="tmpo_procedimento" placeholder="hh:mm" name="tempo[]" value="">
		</div>

		<div class="mb-3 w-13">
		    <div class="div-money">
		    	<label for="valor_procedimento" class="moeda">R$</label>
		    	<input type="text" class="form-control money" id="valor_procedimento" placeholder="" name="valor[]" value="">
		    </div>
		</div>

		<div class="mb-3 w-5 d-flex justify-content-center flex-wrap">
			<span>
				<i 
					data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="Remover"
					class="ph ph-x icone-nome minimo pointer deletar"
					titulo="Remover procedimento"
					texto="Você tem certeza que deseja remover?"
					btn-texto="Remover"
					btn-cor="danger"
					row=""
				></i>
			</span>
		</div>
	</div>
</div>
@endsection