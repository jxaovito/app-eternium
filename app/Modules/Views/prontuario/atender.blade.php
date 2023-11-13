@extends('default.layout')
@section('content')
@php
	if($agendamento['sessoes_consumida']){
		$porcentagem = ($agendamento['sessoes_consumida'] / $agendamento['sessoes_contratada']) * 100;
	}else{
		$porcentagem = 0;
	}
	$sessoes_completadas = '';
	if($porcentagem <= 25){
		$sessoes_completadas .= 'border-top-color: var(--cor-logo-cliente);';
	}
	if($porcentagem > 25 && $porcentagem <= 50){
		$sessoes_completadas .= 'border-top-color: var(--cor-logo-cliente);border-right-color: var(--cor-logo-cliente);';
	}
	if($porcentagem > 50 && $porcentagem < 100){
		$sessoes_completadas .= 'border-top-color: var(--cor-logo-cliente);border-right-color: var(--cor-logo-cliente);border-bottom-color: var(--cor-logo-cliente);';
	}
	if($porcentagem == 100){
		$sessoes_completadas .= 'border-top-color: var(--cor-logo-cliente);border-right-color: var(--cor-logo-cliente);border-bottom-color: var(--cor-logo-cliente);border-left-color: var(--cor-logo-cliente);';
	}
@endphp

<input type="hidden" name="paciente_id" value="{{$paciente_id}}">
<input type="hidden" name="agenda_id" value="{{$agenda_id}}">
<input type="hidden" name="submenu" value="{{$submenu}}">

<div class="container-atender-prontuario d-flex flex-wrap justify-content-between align-items-start">
	<div class="w-100 mgb-px-30 d-flex justify-content-between">
		<h2>Prontuário</h2>
		<div>
			<a href="{{$agenda_id ? '/agenda' : '/prontuario'}}"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</button></a>
		</div>
	</div>

	<div class="content-principal d-flex flex-wrap justify-content-between align-items-start">
		<div class="box-graficos">
			<div class="area-box">
				<div class="left">
					<h2>{{$agendamentos_realizados}}</h2>
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

		@if($agendamento['id'])
			<div class="w-32 d-flex flex-wrap">
				<label class="w-100 bold">Data e Hora do Agendamento:</label>
				<span class="w-100">{{data_hora($agendamento['data_inicio'] . ' ' . $agendamento['hora_inicio'])}}</span>
			</div>

			<div class="w-32 d-flex flex-wrap">
				<label class="w-100 bold">Especialidade:</label>
				<span class="especialidade_list" style="background-color: {{$agendamento['cor_fundo_esp']}};color: {{$agendamento['cor_fonte_esp']}};">{{$agendamento['especialidade']}}</span>
			</div>
		@endif

		<div class="w-32 d-flex flex-wrap">
			<label class="w-100 bold">Nº da Carteirinha:</label>
			@if($paciente['observacoes'])
				<span class="w-100">{{$paciente['matricula']}}</span>
			@else
				<span class="w-100 opacity-05 user-select-none">Matrícula não registrada</span>
			@endif
		</div>

		<div class="w-100 d-flex flex-wrap">
			<label class="w-100 bold">Observações do Paciente:</label>
			@if($paciente['observacoes'])
				<span class="w-100">{{$paciente['observacoes']}}</span>
			@else
				<span class="w-100 opacity-05 user-select-none">Nenhuma observação registrada</span>
			@endif
		</div>

		@if($agendamento['id'])
			<div class="w-32 d-flex flex-wrap">
				<label class="w-100 bold">Sessões:<br><sub class="realtive top-px--5 opacity-05 font-10">Consumida/Contratada</sub></label>
				<span class="w-100">{{$agendamento['sessoes_consumida']}}/{{$agendamento['sessoes_contratada']}}</span>
			</div>

			<div class="divisor w-100 mgt-px-20 mgb-px-20"></div>

			<div class="w-100 d-flex flex-wrap mgb-px-10 opacity-05 user-select-none">
				<h5><label class="w-100 bold">Procedimentos:</label></h5>
			</div>

			<div class="w-70 d-flex flex-wrap mgb-px-10">
				<label class="w-100 bold">Nome:</label>
			</div>

			<div class="w-14 d-flex flex-wrap mgb-px-10">
				<label class="w-100 bold">Sessões:<br><sub class="realtive top-px--5 opacity-05 font-10">Contratada</sub></label>
			</div>

			<div class="w-14 d-flex flex-wrap mgb-px-10">
				<label class="w-100 bold">Sessões:<br><sub class="realtive top-px--5 opacity-05 font-10">Consumida</sub></label>
			</div>

			@foreach($tratamento['procedimentos'] as $procedimento)
				<div class="w-70 d-flex flex-wrap">
					<span class="w-100">{{$procedimento['procedimento']}}</span>
				</div>

				<div class="w-14 d-flex flex-wrap">
					<span class="w-100">{{$procedimento['sessoes_contratada']}}</span>
				</div>

				<div class="w-14 d-flex flex-wrap">
					<span class="w-100">{{$procedimento['sessoes_consumida']}}</span>
				</div>
			@endforeach
		@endif
	</div>

	<div class="content-profile relative top-px-0">
		<div class="data-user">
			<div class="imagem_paciente">
				<div class="circle circle-half-black" style="<?= $sessoes_completadas ?>">
				  	<div class="circle-inner">
				  		@if($paciente['imagem'])
				  			<img src="{{asset('clientes/'.session('conexao_id').'/paciente/'.$paciente['imagem'])}}">
				  		@else
				  			<img src="{{asset('img/user-circle.svg')}}">
				  		@endif
				  	</div>
				</div>
			</div>
			<h5>{{$paciente['nome']}}</h5>
		</div>
		<div class="divisor w-100 mgb-px-10 mgt-px-10"></div>

		<div class="w-100 mgb-px-10">
			<div class="w-100 d-flex justify-content-between align-items-center">
				<div class="w-20 font-28 text-align-center">
					<i class="ph ph-info"></i>
				</div>
				<div class="w-80 d-flex justify-content-center">
					<div class="mgl--10">
						<label
							data-bs-toggle="tooltip"
	                        data-bs-placement="bottom"
	                        data-bs-custom-class="custom-tooltip"
	                        data-bs-title="{{($paciente['data_nascimento'] ? 'Data de nascimento: ' . $paciente['data_nascimento'] : 'Realize o cadastro da Idade nas configurações do Paciente.')}}"
	                        class="{{!$paciente['data_nascimento'] ? 'opacity-05' : ''}}"
						>
							{{$paciente['idade']}} {{$paciente['idade'] != 'Idade não cadastrada' ? $paciente['idade'] > 1 ? 'anos' : 'ano' : ''}} 
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="w-100 mgb-px-10">
			<div class="w-100 d-flex justify-content-between align-items-center">
				<div class="w-20 font-28 text-align-center">
					<i class="ph ph-heart-straight"></i>
				</div>
				<div class="w-80 d-flex justify-content-center">
					<div class="mgl--10">
						<label
							data-bs-toggle="tooltip"
	                        data-bs-placement="bottom"
	                        data-bs-custom-class="custom-tooltip"
	                        data-bs-title="Convênio"
						>
							{{$convenio['nome']}}
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="w-100 mgb-px-10">
			<div class="w-100 d-flex justify-content-between align-items-center">
				<div class="w-20 font-28 text-align-center">
					<i class="ph ph-phone"></i>
				</div>
				<div class="w-80 d-flex justify-content-center">
					<div class="mgl--10">
						@if($paciente['telefone_principal'])
							<label
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="Telefone"
							>
								{{$paciente['telefone_principal']}}
							</label>
							<a
								href="https://wa.me/55{{preg_replace('/[^0-9]/', '', $paciente['telefone_principal'])}}"
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="Abrir conversa no Whatsapp"
		                        target="_blank"
							>
								<i class="ph ph-whatsapp-logo font-24 mgl-px-5 relative top-px-5"></i>
							</a>
						@else
							<label
								class="opacity-05"
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="{{$paciente['telefone_principal'] ? 'Telefone' : 'Realize o cadastro do telefone nas configurações do Paciente.'}}"
							>
								Telefone não cadastrado
							</label>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div class="w-100 mgb-px-10">
			<div class="w-100 d-flex justify-content-between align-items-center">
				<div class="w-20 font-28 text-align-center">
					<i class="ph ph-envelope-simple"></i>
				</div>
				<div class="w-80 d-flex justify-content-center">
					<div class="mgl--10">
						@if($paciente['email'])
							<label
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="E-mail"
							>
								{{$paciente['email']}}
							</label>
							<a
								href="mailto:{{$paciente['email']}}"
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="Abrir conversa no Whatsapp"
							>
							</a>
						@else
							<label
								class="opacity-05"
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="{{$paciente['telefone_principal'] ? 'E-mail' : 'Realize o cadastro do telefone nas configurações do Paciente.'}}"
							>
								E-mail não cadastrado
							</label>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="navegacao w-100 d-flex flex-wrap justify-content-center sticky top-px-0">
		<span submenu="1" class="{{ $submenu == 1 ? 'active ' : '' }}btn btn-success bg-transp-cor-logo-cliente border-radius-20px margin-8px">Históricos</span>
		<span submenu="2" class="{{ $submenu == 2 ? 'active ' : '' }}btn btn-success bg-transp-cor-logo-cliente border-radius-20px margin-8px">Atendimento</span>
	</div>
	
	<div class="w-100 container-content">
		@include('prontuario.views.historico')
		@include('prontuario.views.atendimento')
	</div>
</div>
@endsection