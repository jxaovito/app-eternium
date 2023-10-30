@extends('default.layout')
@section('content')
<div class="container-configuracao mgb-px-30">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>{{mensagem('msg3')}}</h2>
	</div>

	@if(session('usuario_id') == -1)
	<div class="aba mgb-px-30">
		<div class="opc active" destino="dados-empresa">
			<span>{{mensagem('msg4')}}</span>
		</div>
		<div class="opc" destino="sistema">
			<span>{{mensagem('msg5')}}</span>
		</div>
	</div>
	@endif

	<div class="w-100 dados-empresa" destino-aba="true">
		<form action="/configuracao/salvar_dados" method="post" class="d-flex flex-wrap w-100 justify-content-between" enctype="multipart/form-data">
			@csrf
			<div class="w-48">
				<div class="mgb-px-10">
					<label>{{mensagem('msg6')}}</label>
					<select class="select2" name="idioma">
						<option value="portugues_br" <?=($dados['idioma']['valor'] == 'portugues_br' ? 'selected="selected"' : '')?>>{{mensagem('msg7')}}</option>
						<option value="ingles_us" <?=($dados['idioma']['valor'] == 'ingles_us' ? 'selected="selected"' : '')?>>{{mensagem('msg8')}}</option>
					</select>
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg38')}}</label>
					<select class="select2" name="moeda">
						<option value="R$" <?=($dados['moeda']['valor'] == 'R$' ? 'selected="selected"' : '')?>>R$ (Real)</option>
						<option value="$" <?=($dados['moeda']['valor'] == '$' ? 'selected="selected"' : '')?>>$ (USD - Dollar)</option>
					</select>
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg9')}}</label>
					<input type="text" class="form-control" name="nome_empresa" value="{{$dados['nome_empresa']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg10')}}</label>
					<input type="text" class="form-control cpf" name="cpf" value="{{$dados['cpf']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg11')}}</label>
					<input type="text" class="form-control cnpj" name="cnpj" value="{{$dados['cnpj']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg12')}}</label>
					<input type="text" class="form-control telefone" name="numero_clinica1" value="{{$dados['numero_clinica1']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg13')}}</label>
					<input type="text" class="form-control telefone" name="numero_clinica2" value="{{$dados['numero_clinica2']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg14')}}</label>
					<input type="text" class="form-control telefone" name="numero_clinica3" value="{{$dados['numero_clinica3']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg15')}}</label>
					<input type="text" class="form-control" name="nome_proprietario" value="{{$dados['nome_proprietario']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg16')}}</label>
					<input type="text" class="form-control" name="site" value="{{$dados['site']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg17')}}</label>
					<input type="text" class="form-control" name="endereco" value="{{$dados['endereco']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg18')}}</label>
					<input type="text" class="form-control" name="bairro" value="{{$dados['bairro']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg19')}}</label>
					<input type="text" class="form-control" name="cidade" value="{{$dados['cidade']['valor']}}">
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg20')}}</label>
					<input type="text" class="form-control" name="estado" value="{{$dados['estado']['valor']}}">
				</div>
			</div>
			<div class="w-48">
				<div class="mgb-px-10 d-flex justify-content-between">
					<div class="w-25 d-flex justify-content-center align-items-center">
						<img id="logo_empresa_preview" class="max-w-150px max-h-60px" src="{{asset('clientes/'.session('conexao_id').'/img/'.$dados['logo']['valor'])}}">
					</div>
					<div class="w-75">
						<label>{{mensagem('msg21')}}</label>
						<input type="file" class="form-control" name="logo" id="logo_empresa" accept="image/png, image/gif, image/jpeg">
					</div>
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg22')}}</label>
					<div class="d-flex">
						<input type="text" class="form-control" value="{{$dados['cor_logo']['valor']}}">
						<input
		                    type="color"
		                    class="form-control form-control-color"
		                    value="{{$dados['cor_logo']['valor']}}"
		                    data-bs-toggle="tooltip"
		                    data-bs-placement="bottom"
		                    data-bs-custom-class="custom-tooltip"
		                    data-bs-title="{{mensagem('msg23')}}"
		                    name="cor_logo"
		                >
		            </div>
				</div>

				<div class="mgb-px-10">
					<label>{{mensagem('msg24')}}</label>
					<div class="d-flex">
						<input type="text" class="form-control" value="{{$dados['cor_font']['valor']}}">
						<input
		                    type="color"
		                    class="form-control form-control-color"
		                    value="{{$dados['cor_font']['valor']}}"
		                    data-bs-toggle="tooltip"
		                    data-bs-placement="bottom"
		                    data-bs-custom-class="custom-tooltip"
		                    data-bs-title="{{mensagem('msg25')}}"
		                    name="cor_font"
		                >
		            </div>
				</div>

				<div class="mgb-px-10">
					<hr>
					<h5>{{mensagem('msg26')}}</h5>
					<div class="form-group">
						<label for="cor_entorno">{{mensagem('msg27')}}:</label>
						<input type="color" class="form-control" id="cor_entorno" name="cor_entorno" value="{{$dados['cor_entorno']['valor']}}">
					</div>
					<div class="form-group">
						<label for="cor_centro">{{mensagem('msg28')}}:</label>
						<input type="color" class="form-control" id="cor_centro" name="cor_centro" value="{{$dados['cor_centro']['valor']}}">
						<input type="hidden" name="cor_menu_topo" id="cor_menu_topo" value="{{$dados['cor_menu_topo']['valor']}}">
					</div>
					<div class="gradient-preview mt-4" style="background:{{$dados['cor_menu_topo']['valor']}};"></div>
				</div>
			</div>

			<div class="w-100 d-flex justify-content-end">
				<button class="btn btn-success bg-cor-logo-cliente" type="submit">{{mensagem('msg29')}} <i class="ph ph-check"></i></button>
			</div>
		</form>
	</div>

	@if(session('usuario_id') == -1)
	<div class="w-100 d-flex justify-content-between sistema d-none" destino-aba="true">
		<form action="/configuracao/salvar_sistema" class="d-flex flex-wrap w-100 justify-content-between" method="post">
			@csrf
			<div class="w-48">
				<div class="mgb-px-10">
					<label>Quantidade de Usuários</label>
					<input type="number" class="form-control" name="qtd_usuarios" value="{{$sistema['qtd_usuarios']['valor']}}">
				</div>

				<div class="mgb-px-10 d-flex flex-wrap">
					<label class="w-100">Público Álvo</label>
					<select class="select2 w-100" name="publico_alvo">
						<option value="paciente" {{$sistema['publico_alvo']['valor'] == 'paciente' ? 'selected' : ''}}>Paciente</option>
						<option value="cliente" {{$sistema['publico_alvo']['valor'] == 'cliente' ? 'selected' : ''}}>Cliente</option>
					</select>
				</div>
			</div>

			<div class="w-48">
				<div class="mgb-px-10">
					<label>Envio de Lembrete Automático</label>
					<div class="form-check">
					  	<input
					  		type="radio"
					  		class="form-check-input"
					  		name="whatsapp_automatico"
					  		id="whatsapp_automatico1" value="1"
					  		{{$sistema['whatsapp_automatico']['valor'] ? 'checked="checked"' : ''}}
					  	>
					  	<label class="form-check-label" for="whatsapp_automatico1">
				    		Sim
					  	</label>
					</div>

					<div class="form-check">
					  	<input
					  		type="radio"
					  		class="form-check-input"
					  		name="whatsapp_automatico"
					  		id="whatsapp_automatico0"
					  		value="0"
					  		{{$sistema['whatsapp_automatico']['valor'] ? '' : 'checked="checked"'}}
					  	>
					  	<label class="form-check-label" for="whatsapp_automatico0">
					    	Não
					  	</label>
					</div>
				</div>
			</div>

			<div class="w-100 d-flex justify-content-end">
				<button class="btn btn-success bg-cor-logo-cliente" type="submit">Salvar <i class="ph ph-check"></i></button>
			</div>
		</form>
	</div>
	@endif
</div>
@endsection