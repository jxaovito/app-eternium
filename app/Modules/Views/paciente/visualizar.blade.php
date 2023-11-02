{{mensagem('msg33')}}@extends('default.layout')
@section('content')
<div class="container-paciente-visualizar">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>{{mensagem('msg92')}}</h2>
		<div>
			<a href="/paciente/editar/{{$registro['paciente_id']}}"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-pencil-simple"></i> {{mensagem('msg94')}}</button></a>
			<a href="/paciente"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> {{mensagem('msg93')}}</button></a>
		</div>
	</div>

	<div class="container-paciente">
		<div class="dados-principais">
			@if($registro['imagem'])
				<span class="icone-nome"><img src="{{asset('clientes/'.session('conexao_id').'/paciente/'.$registro['imagem'])}}"></span>
			@else
				@php
					$nome = explode(' ', $registro['nome']);
					if(count($nome) > 1){
					    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
					}else{
					    $iniciais = strtolower(substr($registro['nome'], 0, 2));
					}
				@endphp
				<span class="icone-nome grande {{$iniciais}}">{{strtoupper($iniciais)}}</span>
			@endif

			<h2>{{$registro['nome']}}</h2>

			<div class="informacoes">
				<div class="info">
					<span>{{mensagem('msg95')}}</span>
					<label>{{$registro['email']}}</label>
				</div>

				<div class="info telefone-info">
					<span>{{mensagem('msg96')}}</span>
					@if($registro['telefone_principal'])
						<label>{{$registro['telefone_principal']}}</label>
						<a
							href="https://wa.me/55{{preg_replace('/[^0-9]/', '', $registro['telefone_principal'])}}"
							data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="{{mensagem('msg97')}}"
                            target="_blank"
						>
							<i class="ph ph-whatsapp-logo"></i>
						</a>
					@else
						<label class="opacity-05">(00) 00000-0000</label>
					@endif
				</div>

				<div class="info">
					<span>{{mensagem('msg98')}}</span>
					<label>{{$registro['genero']}}</label>
				</div>

				<div class="info">
					<span>{{mensagem('msg99')}}</span>
					<label>{{$registro['convenio']}}</label>
				</div>

				<div class="info">
					<span>{{mensagem('msg100')}}</span>
					<label>{{$registro['data_nascimento'] ? data($registro['data_nascimento']) : '00/00/0000'}}</label>
				</div>
			</div>
		</div>

		<div class="conteudo-complementar">
			<div class="box-graficos">
				<div class="area-box">
					<div class="left">
						<h2>10</h2>
						<span>{{mensagem('msg101')}}</span>
					</div>
					<div class="right">
						<i class="ph ph-calendar-blank"></i>
					</div>
				</div>

				<div class="area-box">
					<div class="left">
						<h2>8</h2>
						<span>{{mensagem('msg102')}}</span>
					</div>
					<div class="right">
						<i class="ph ph-calendar-blank"></i>
					</div>
				</div>

				<div class="area-box">
					<div class="left">
						<h2>2</h2>
						<span>{{mensagem('msg103')}}</span>
					</div>
					<div class="right">
						<i class="ph ph-calendar-blank"></i>
					</div>
				</div>

				<div class="area-box">
					<div class="left">
						<h2>0</h2>
						<span>{{mensagem('msg104')}}</span>
					</div>
					<div class="right">
						<i class="ph ph-calendar-blank"></i>
					</div>
				</div>
			</div>
			<div class="box-detalhes">
				<div class="headers">
					<span>{{mensagem('msg105')}}</span>
				</div>

				<div class="conteudo-detalhes">
					<div class="conteudo-dados-cadastrais">
						<div class="box w-32">
							<label>{{mensagem('msg106')}}</label>
							<span>{{$registro['telefone_secundario']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg107')}}</label>
							<span>{{$registro['cpg']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg108')}}</label>
							<span>{{$registro['CNPJ']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg109')}}</label>
							<span>{{$registro['nome_mae']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg110')}}</label>
							<span>{{$registro['nome_pai']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg111')}}</label>
							<span>{{$registro['nome_responsavel']}}</span>
						</div>

						<div class="box w-100">
							<label>{{mensagem('msg112')}}</label>
							<span>{{$registro['observacoes']}}</span>
						</div>

						<h5>{{mensagem('msg113')}}</h5>

						<div class="box w-32">
							<label>{{mensagem('msg114')}}</label>
							<span>{{$registro['convenio']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg115')}}</label>
							<span>{{$registro['matricula']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg116')}}</label>
							<span>{{$registro['data_vencimento_carteirinha'] ? data($registro['data_vencimento_carteirinha']) : '00/00/0000'}}</span>
						</div>

						<h5>{{mensagem('msg117')}}</h5>

						<div class="box w-32">
							<label>{{mensagem('msg118')}}</label>
							<span>{{$registro['cep']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg119')}}</label>
							<span>{{$registro['estado']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg120')}}</label>
							<span>{{$registro['cidade']}}</span>
						</div>

						<div class="box w-32">
							<label>{{mensagem('msg121')}}</label>
							<span>{{$registro['bairro']}}</span>
						</div>

						<div class="box w-64">
							<label>{{mensagem('msg122')}}</label>
							<span>{{$registro['rua']}}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection