@extends('default.layout')
@section('content')
<div class="container-paciente-visualizar">
	<div class="header mgb-px-30 d-flex justify-content-between">
		<h2>Visualizar Paciente</h2>
		<div>
			<a href="/paciente/editar/{{$registro['paciente_id']}}"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-pencil-simple"></i> Editar</button></a>
			<a href="/paciente"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</button></a>
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
					<span>Email</span>
					<label>{{$registro['email']}}</label>
				</div>

				<div class="info telefone-info">
					<span>Telefone</span>
					@if($registro['telefone_principal'])
						<label>{{$registro['telefone_principal']}}</label>
						<a
							href="https://wa.me/55{{preg_replace('/[^0-9]/', '', $registro['telefone_principal'])}}"
							data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Abrir conversa no Whatsapp"
                            target="_blank"
						>
							<i class="ph ph-whatsapp-logo"></i>
						</a>
					@else
						<label class="opacity-05">(00) 00000-0000</label>
					@endif
				</div>

				<div class="info">
					<span>Gênero</span>
					<label>{{$registro['genero']}}</label>
				</div>

				<div class="info">
					<span>Convênio</span>
					<label>{{$registro['convenio']}}</label>
				</div>

				<div class="info">
					<span>Data de Nascimento</span>
					<label>{{$registro['data_nascimento'] ? date_format(date_create_from_format('Y-m-d', $registro['data_nascimento']), 'd/m/Y') : '00/00/0000'}}</label>
				</div>
			</div>
		</div>

		<div class="conteudo-complementar">
			<div class="box-graficos">
				<div class="area-box">
					<div class="left">
						<h2>10</h2>
						<span>Agendamentos</span>
					</div>
					<div class="right">
						<i class="ph ph-calendar-blank"></i>
					</div>
				</div>

				<div class="area-box">
					<div class="left">
						<h2>8</h2>
						<span>Agendamentos Finalizados</span>
					</div>
					<div class="right">
						<i class="ph ph-calendar-blank"></i>
					</div>
				</div>

				<div class="area-box">
					<div class="left">
						<h2>2</h2>
						<span>Agendamentos com Faltas Justificadas</span>
					</div>
					<div class="right">
						<i class="ph ph-calendar-blank"></i>
					</div>
				</div>

				<div class="area-box">
					<div class="left">
						<h2>0</h2>
						<span>Agendamentos com Faltas</span>
					</div>
					<div class="right">
						<i class="ph ph-calendar-blank"></i>
					</div>
				</div>
			</div>
			<div class="box-detalhes">
				<div class="headers">
					<span>Dados Cadastrais</span>
				</div>

				<div class="conteudo-detalhes">
					<div class="conteudo-dados-cadastrais">
						<div class="box w-32">
							<label>Telefone Secundário</label>
							<span>{{$registro['telefone_secundario']}}</span>
						</div>

						<div class="box w-32">
							<label>CPF</label>
							<span>{{$registro['cpg']}}</span>
						</div>

						<div class="box w-32">
							<label>CNPJ</label>
							<span>{{$registro['CNPJ']}}</span>
						</div>

						<div class="box w-32">
							<label>Nome da Mãe</label>
							<span>{{$registro['nome_mae']}}</span>
						</div>

						<div class="box w-32">
							<label>Nome do Pai</label>
							<span>{{$registro['nome_pai']}}</span>
						</div>

						<div class="box w-32">
							<label>Nome do responsável</label>
							<span>{{$registro['nome_responsavel']}}</span>
						</div>

						<div class="box w-100">
							<label>Nome do Observações</label>
							<span>{{$registro['observacoes']}}</span>
						</div>

						<h5>Dados do Convênio</h5>

						<div class="box w-32">
							<label>Convênio</label>
							<span>{{$registro['convenio']}}</span>
						</div>

						<div class="box w-32">
							<label>Matrícula (Carteirinha)</label>
							<span>{{$registro['matricula']}}</span>
						</div>

						<div class="box w-32">
							<label>Data de Vencimento</label>
							<span>{{$registro['data_vencimento_carteirinha']}}</span>
						</div>

						<h5>Endereço</h5>

						<div class="box w-32">
							<label>CEP</label>
							<span>{{$registro['cep']}}</span>
						</div>

						<div class="box w-32">
							<label>Estado</label>
							<span>{{$registro['estado']}}</span>
						</div>

						<div class="box w-32">
							<label>Cidade</label>
							<span>{{$registro['cidade']}}</span>
						</div>

						<div class="box w-32">
							<label>Bairro</label>
							<span>{{$registro['bairro']}}</span>
						</div>

						<div class="box w-64">
							<label>Rua</label>
							<span>{{$registro['rua']}}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection