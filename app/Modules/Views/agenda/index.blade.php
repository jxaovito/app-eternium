@extends('default.layout')
@section('content')
<div class="container-agenda">
	<div class="header">
		<div class="w-20 d-flex justify-content-center flex-wrap">
			<div class="w-100 d-flex justify-content-center">
				<div class="w-40 d-flex align-items-center justify-content-center alternar-datas mgb-px-5">
					<div class="w-20 text-center voltar-datas">
						<i class="ph ph-caret-left"></i>
					</div>
					<div class="w-60 text-center hoje">
						Hoje
					</div>
					<div class="w-20 text-center avancar-datas">
						<i class="ph ph-caret-right"></i>
					</div>
				</div>
			</div>

			<div class="w-100 d-flex justify-content-center">
				<div class="selecionar-data mgb-px-5 w-40">
					<input type="text" class="date form-control" value="{{date('d-m-Y')}}">
				</div>
			</div>
			<div class="btn-group mgb-px-5" role="group">
				<button
				  	type="button"
				  	class="btn btn-primary calendar-visualizacao bg-cor-logo-cliente {{$visualizacao_agenda == 'day' ? 'active' : ''}}"
				  	tipo="day"
				  	style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
				>
					Dia
				</button>
				<button
					type="button"
					class="btn btn-primary calendar-visualizacao bg-cor-logo-cliente {{$visualizacao_agenda == 'week' ? 'active' : ''}}"
					tipo="week"
					style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
				>
					Semana
				</button>
				<button
					type="button"
					class="btn btn-primary calendar-visualizacao bg-cor-logo-cliente {{$visualizacao_agenda == 'month' ? 'active' : ''}}"
					tipo="month"
					style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
				>
					Mês
				</button>
			</div>
		</div>

		<div class="w-45">
			<h6 class="opacity-05 user-select-none">Profissionais</h6>
			<div class="d-flex flex-wrap justify-content-start align-items-center">
				@if($profissionais)
					@foreach($profissionais as $prof)
						<a href="{{$profissional_id != $prof['id'] ? '/agenda/'.$prof['id'] : '#'}}   ">

							@if($prof['imagem'])
								<span
									class="icone-nome w-40px h-40px mgl-px-5 mgr-px-5 {{($profissional_id != $prof['id'] ? 'opacity-05' : '')}} pointer"
									data-bs-toggle="tooltip"
					                data-bs-placement="bottom"
					                data-bs-custom-class="custom-tooltip"
					                data-bs-title="{{$prof['nome']}}"
								>
									<img class="w-40px h-40px" src="{{asset('clientes/'.session('conexao_id').'/usuario/'.$prof['imagem'])}}">
								</span>
							@else
								@php
									$nome = explode(' ', $prof['nome']);
									if(count($nome) > 1){
									    $iniciais = strtolower(substr($nome[0], 0, 1) . substr($nome[1], 0, 1));
									}else{
									    $iniciais = strtolower(substr($prof['nome'], 0, 2));
									}
								@endphp
								<span
									class="icone-nome w-40px h-40px mgl-px-5 mgr-px-5 {{($profissional_id != $prof['id'] ? 'opacity-05' : '')}} pointer pequeno {{$iniciais}}"
									data-bs-toggle="tooltip"
					                data-bs-placement="bottom"
					                data-bs-custom-class="custom-tooltip"
					                data-bs-title="{{$prof['nome']}}"
								>
									{{strtoupper($iniciais)}}
								</span>
							@endif
						</a>
					@endforeach
				@endif
			</div>
		</div>

		<div class="w-35">
			<h6 class="opacity-05 user-select-none">Especialidades</h6>
			<div class="d-flex flex-wrap justify-content-start align-items-center">
				@if($especialidades)
					@foreach($especialidades as $key => $esp)
						<span
							class="cor_especialidade" 
							{{$esp['cor_fundo'] ? 'style=background-color:'.$esp['cor_fundo'].';color:'.$esp['cor_fonte'].';' : ''}}
						>
							{{$esp['nome']}}
						</span>
					@endforeach
				@endif
			</div>
			@if($whatsapp_automatico)
				<div class="w-70 d-flex flex-wrap mgt-px-20 justify-content-between user-select-none">
					<sup class="w-100 mgb-px-5">Status de envio dos Lembretes dos agendamentos</sup>
					<span class="opacity-05 font-13">⚪ Enviar</span>
					<span class="opacity-05 font-13">🟢 Enviado</span>
					<span class="opacity-05 font-13">🔴 Erro ao Enviar</span>
					<span class="opacity-05 font-13">🔵 Respondido</span>
				</div>
			@endif
		</div>
	</div>
	<div id="calendar" style="height: 100vh"></div>
	{{-- Início Hiddens --}}
		<input type="hidden" name="visualizacao_agenda" value="{{$visualizacao_agenda}}">
		<input type="hidden" name="data_inicio_agenda" value="{{$data_inicio_agenda}}">
		<input type="hidden" name="data_fim_agenda" value="{{$data_fim_agenda}}">
		<input type="hidden" name="data_hoje_fim_agenda" value="{{$data_fim_agenda}}">
		<input type="hidden" name="profissional_id" value="{{$profissional_id}}">
		<input type="hidden" name="profissional_nome" value="{{$profissional_nome}}">
	{{-- Final Hiddens --}}

	{{-- Valores de datas para configuração do Calendar --}}
		<input type="hidden" name="data_hoje" value="{{date('Y-m-d')}}">

		<input type="hidden" name="data_inicio_semana" value="{{$data_inicio_semana}}">	
		<input type="hidden" name="data_fim_semana" value="{{$data_fim_semana}}">

		<input type="hidden" name="data_inicio_mes" value="{{$data_inicio_mes}}">	
		<input type="hidden" name="data_fim_mes" value="{{$data_fim_mes}}">

		{{-- Data Padrão Sem alterações de Navegação --}}
		<input type="hidden" name="data_inicio_semana_padrao" value="{{$data_inicio_semana}}">	
		<input type="hidden" name="data_fim_semana_padrao" value="{{$data_fim_semana}}">

		<input type="hidden" name="data_inicio_mes_padrao" value="{{$data_inicio_mes}}">	
		<input type="hidden" name="data_fim_mes_padrao" value="{{$data_fim_mes}}">
	{{-- Valores de datas para configuração do Calendar --}}

	<div class="bg-modal-agenda"></div>
	<div class="contents-modal">
		<div class="modal-agendamento criar-agendamento">
			<div class="header-modal d-flex justify-content-between align-items-center">
				<h4>Novo Agendamento</h4>
				<span>
					<i
						class="ph ph-x pointer close-modal-agenda"
						data-bs-toggle="tooltip"
		                data-bs-placement="bottom"
		                data-bs-custom-class="custom-tooltip"
		                data-bs-title="Fechar"
					></i>
				</span>
			</div>
			<div class="content-modal">
				<form class="d-flex flex-wrap w-100 justify-content-between">
					@csrf
					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 date" id="data_inicial" placeholder="{{date('d/m/Y')}}" value="" name="data_inicio">
					  	<label for="data_inicial">Data Inicial</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 date" id="data_fim" placeholder="{{date('d/m/Y')}}" value="" name="data_fim">
					  	<label for="data_fim">Data Fim</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 time" id="hora_inicial" placeholder="00:00" value="" name="hora_inicio">
					  	<label for="hora_inicial">Hora Inicial</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 time" id="hora_fim" placeholder="00:00" value="" name="hora_fim">
					  	<label for="hora_fim">Hora Final</label>
					</div>

					<div class="w-100 mgb-px-5 d-flex justify-content-between align-items-center mgt-px-5 tipo-agendamento">
						<span class="w-48 text-center active" tipo="1">Agendamento</span>
						<span class="w-48 text-center" tipo="2">Bloquear Horário</span>
						<input type="hidden" name="tipo-agendamento" value="1">
					</div>

					<div class="form-floating w-100">
						<input type="text" class="form-control mgb-px-5" id="busca_paciente_tratamento" placeholder="Paciente" name="paciente" autocomplete="off">
						<label for="busca_paciente_tratamento">Paciente</label>
						<input type="hidden" class="autocomplete_paciente_id" name="paciente_id">
					</div>

					<div class="w-100 d-flex flex-wrap mgt-px-5 mgb-px-5">
						<label class="w-100" for="tratamento">Tratamento</label>
						<select class="select2 tratamento" id="tratamento" name="tratamento_id">
							<option value="">Selecione...</option>
						</select>
					</div>

					<div class="w-100 d-none flex-wrap mgt-px-5 mgb-px-5">
						<label class="w-100" for="convenio">Convenio</label>
						<select class="select2 convenio" id="convenio" name="convenio">
							<option value="">Selecione...</option>
							@if($convenios)
								@foreach($convenios as $registro)
									<option value="{{$registro['id']}}">{{$registro['nome']}}</option>
								@endforeach
							@endif
						</select>
					</div>

					<div class="form-floating w-100 d-flex flex-wrap mgt-px-5 mgb-px-5 h-120px">
						<textarea class="form-control w-100 h-120px" placeholder="Observações" id="observacoes" name="observacoes"></textarea>
						<label class="w-100" for="observacoes">Observações</label>
					</div>

					<div class="w-100 d-flex flex-wrap mgt-px-30 mgb-px-5 justify-content-between">
						<span type="submit" class="btn btn-success bg-cor-logo-cliente close-modal-agenda"><i class="ph ph-x"></i> Cancelar</span>
						<span type="submit" class="btn btn-success bg-cor-logo-cliente salvar-novo-agendamento">Salvar <i class="ph ph-check"></i></span>
					</div>
				</form>
			</div>
		</div>
		<div class="modal-agendamento visualizar-agendamento">
			<div class="header-modal d-flex justify-content-between align-items-center">
				<h4>Novo Agendamento</h4>
				<span>
					<i
						class="ph ph-x pointer close-modal-agenda"
						data-bs-toggle="tooltip"
		                data-bs-placement="bottom"
		                data-bs-custom-class="custom-tooltip"
		                data-bs-title="Fechar"
					></i>
				</span>
			</div>
			<div class="content-modal">
				<form class="d-flex flex-wrap w-100 justify-content-between">
					<div class="form-floating w-49">
					  	<input type="text" class="form-control border-none mgb-px-5" readonly id="data_inicial" placeholder="{{date('d/m/Y')}}" value="" name="data_inicio">
					  	<label for="data_inicial">Data Inicial</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control border-none mgb-px-5" readonly id="data_fim" placeholder="{{date('d/m/Y')}}" value="" name="data_fim">
					  	<label for="data_fim">Data Fim</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control border-none mgb-px-5" readonly id="hora_inicial" placeholder="00:00" value="" name="hora_inicio">
					  	<label for="hora_inicial">Hora Inicial</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control border-none mgb-px-5" readonly id="hora_fim" placeholder="00:00" value="" name="hora_fim">
					  	<label for="hora_fim">Hora Final</label>
					</div>

					<div class="form-floating w-100">
						<input type="text" class="form-control border-none mgb-px-5" readonly placeholder="Paciente" name="paciente" autocomplete="off">
						<label>Paciente</label>
					</div>

					<div class="form-floating w-100">
						<input type="text" class="form-control border-none mgb-px-5" readonly placeholder="Profissional" name="profissional" autocomplete="off">
						<label>Profissional</label>
						<input type="hidden" name="profissional_id">
					</div>

					<div class="form-floating w-100">
						<input type="text" class="form-control border-none mgb-px-5" readonly placeholder="Tratamento" name="tratamento" autocomplete="off">
						<label>Tratamento</label>
						<input type="hidden" name="tratamento_id">
					</div>

					<div class="w-100">
						<hr>
					</div>

					<div class="w-80">
					  	<label>Procedimento</label>
					</div>

					<div class="w-19">
					  	<label>Sessão</label>
					</div>

					<div class="w-100 d-flex flex-wrap procedimentos">

					</div>

					<div class="w-100 d-flex flex-wrap mgt-px-30 mgb-px-5 justify-content-between">
						<div>
							<span type="submit" class="btn btn-success bg-cor-logo-cliente close-modal-agenda"><i class="ph ph-x"></i> Cancelar</span>
							<span
								type="submit"
								class="btn btn-success bg-cor-logo-cliente remover remover_agendamento"
								link="/agenda/remover_agendamento/"
								titulo="Remover Convênio"
								texto="Você tem certeza que deseja <b>Remover</b> este agendamento?"
								btn-texto="Remover"
							>
								<i class="ph ph-trash"></i> Remover
						</span>
						</div>
						<span type="submit" class="btn btn-success bg-cor-logo-cliente salvar-editar-agendamento">Salvar <i class="ph ph-check"></i></span>
					</div>
				</form>

				{{-- Clone --}}
				<div class="w-100 procedimento_clone d-none">
					<div class="w-100 d-flex justify-content-between mgb-px-5">
						<div class="form-floating w-80">
						  	<input type="text" class="form-control w-100" readonly placeholder="Procedimento" name="procedimento[]" autocomplete="off">
						  	<label></label>
						</div>
						<input type="hidden" name="tratamento_has_procedimento_id[]">
						<input type="hidden" name="procedimento_id[]">
						<input type="text" name="sessao[]" class="form-control w-19 number">
					</div>
				</div>
				{{-- <div class="w-100 procedimento_clone d-none">
					<div class="w-100 d-flex justify-content-between mgb-px-5">
						<input type="text" class="form-control w-80" readonly placeholder="Procedimento" name="procedimento[]" autocomplete="off">
						<input type="hidden" name="tratamento_has_procedimento_id[]">
						<input type="hidden" name="procedimento_id[]">
						<input type="text" name="sessao[]" class="form-control w-19">
					</div>
				</div> --}}
			</div>
		</div>
	</div>
</div>
@endsection