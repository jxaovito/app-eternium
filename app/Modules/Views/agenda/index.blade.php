@extends('default.layout')
@section('content')
<div class="container-agenda">
	<div class="header">
		<div class="w-20 d-flex justify-content-center flex-wrap btn-acoes-agenda">
			<div class="w-100 d-flex justify-content-center">
				<div class="w-40 d-flex align-items-center justify-content-center alternar-datas mgb-px-5">
					<div class="w-20 text-center voltar-datas">
						<i class="ph ph-caret-left"></i>
					</div>
					<div class="w-60 text-center hoje">
						{{mensagem('msg1')}}
					</div>
					<div class="w-20 text-center avancar-datas">
						<i class="ph ph-caret-right"></i>
					</div>
				</div>
			</div>

			<div class="w-100 d-flex justify-content-center">
				<div class="selecionar-data mgb-px-5 w-40">
					<input type="text" class="date form-control" value="{{data()}}">
				</div>
			</div>
			<div class="btn-group mgb-px-5" role="group">
				<button
				  	type="button"
				  	class="btn btn-primary calendar-visualizacao bg-cor-logo-cliente {{$visualizacao_agenda == 'day' ? 'active' : ''}}"
				  	tipo="day"
				  	style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
				>
					{{mensagem('msg2')}}
				</button>
				<button
					type="button"
					class="btn btn-primary calendar-visualizacao bg-cor-logo-cliente {{$visualizacao_agenda == 'week' ? 'active' : ''}}"
					tipo="week"
					style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
				>
					{{mensagem('msg3')}}
				</button>
				<button
					type="button"
					class="btn btn-primary calendar-visualizacao bg-cor-logo-cliente {{$visualizacao_agenda == 'month' ? 'active' : ''}}"
					tipo="month"
					style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
				>
					{{mensagem('msg4')}}
				</button>
			</div>
		</div>

		<div class="w-45">
			<h6 class="opacity-05 user-select-none">{{mensagem('msg5')}}</h6>
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
			<h6 class="opacity-05 user-select-none">{{mensagem('msg6')}}</h6>
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
				<div class="w-70 d-flex flex-wrap mgt-px-20 mgb-px-10 justify-content-between user-select-none">
					<sup class="w-100 mgb-px-5">{{mensagem('msg7')}}</sup>
					<div class="legendas-whatsapp-agenda">
						<span class="font-13">
							<svg class="w-13px h-13px relative top-px--1 wp-branco"><use xlink:href="#whatsapp"></use></svg> {{mensagem('msg8')}}
						</span>
						<span class="font-13">
							<svg class="w-13px h-13px relative top-px--1 wp-verde"><use xlink:href="#whatsapp"></use></svg> {{mensagem('msg9')}}
						</span>
						<span class="font-13">
							<svg class="w-13px h-13px relative top-px--1 wp-vermelho"><use xlink:href="#whatsapp"></use></svg> {{mensagem('msg10')}}
						</span>
						{{-- <span class="font-13">🔵 {{mensagem('msg11')}}</span> --}}
					</div>
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
				<h4>{{mensagem('msg12')}}</h4>
				<span>
					<i
						class="ph ph-x pointer close-modal-agenda"
						data-bs-toggle="tooltip"
		                data-bs-placement="bottom"
		                data-bs-custom-class="custom-tooltip"
		                data-bs-title="{{mensagem('msg13')}}"
					></i>
				</span>
			</div>
			@if($whatsapp_automatico)
				<div class="d-flex w-100 mgb-px-10">
					<sub class="d-flex w-100 align-items-center">
						<div 
							class="{{$envio_lembrete_para_todos != 'sim' ? 'opacity-05' : ''}} hover-opacity-1 ativar-lembrete-whats"
							data-bs-toggle="tooltip"
			                data-bs-placement="bottom"
			                data-bs-custom-class="custom-tooltip"
			                data-bs-title="{{mensagem('msg14')}}"
						>
							<label for="redefinicao_senha" class="form-label user-select-none mgb-px-0 d-flex align-items-center pointer">
								@if($envio_lembrete_para_todos == 'sim')
									<i class="ph ph-check mgr-px-5"></i>
								@else
									<i class="ph ph-check mgr-px-5 d-none"></i>
								@endif
								{{mensagem('msg15')}} <svg class="w-13px h-13px relative top-px--1 wp-verde mgl-px-5"><use xlink:href="#whatsapp"></use></svg>
								<input type="hidden" name="whatsapp" value="{{$envio_lembrete_para_todos == 'sim' ? 'enviar' : ''}}">
							</label>
						</div>
					</sub>
				</div>
			@endif
			<div class="content-modal">
				<form class="d-flex flex-wrap w-100 justify-content-between">
					@csrf
					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 date" id="data_inicial" placeholder="{{date('d/m/Y')}}" value="" name="data_inicio">
					  	<label for="data_inicial">{{mensagem('msg16')}}</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 date" id="data_fim" placeholder="{{date('d/m/Y')}}" value="" name="data_fim">
					  	<label for="data_fim">{{mensagem('msg17')}}</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 time" id="hora_inicial" placeholder="00:00" value="" name="hora_inicio">
					  	<label for="hora_inicial">{{mensagem('msg18')}}</label>
					</div>

					<div class="form-floating w-49">
					  	<input type="text" class="form-control mgb-px-5 time" id="hora_fim" placeholder="00:00" value="" name="hora_fim">
					  	<label for="hora_fim">{{mensagem('msg19')}}</label>
					</div>

					<div class="w-100 mgb-px-5 d-flex justify-content-between align-items-center mgt-px-5 tipo-agendamento">
						<span class="w-48 text-center active" tipo="1">{{mensagem('msg20')}}</span>
						<span class="w-48 text-center" tipo="2">{{mensagem('msg58')}}</span>
						<input type="hidden" name="tipo-agendamento" value="1">
					</div>

					<div class="form-floating w-100">
						<input type="text" class="form-control mgb-px-5" id="busca_paciente_tratamento" placeholder="{{mensagem('msg49')}}" name="paciente" autocomplete="off">
						<label for="busca_paciente_tratamento">{{mensagem('msg21')}}</label>
						<input type="hidden" class="autocomplete_paciente_id" name="paciente_id">
					</div>

					<div class="w-100 d-flex flex-wrap mgt-px-5 mgb-px-5">
						<label class="w-100" for="tratamento">{{mensagem('msg22')}}</label>
						<span class="user-select-none opacity-05 font-weight-bold d-none font-12">Criando tratamento...</span>
						<select class="select2 tratamento" id="tratamento" name="tratamento_id">
							<option value="">{{mensagem('msg23')}}</option>
						</select>
					</div>

					@php
					    $modulo='tratamento';$funcao='novo';if(count(array_filter(session('permissoes'),function($item)use($modulo, $funcao){
					        return$item['modulo']===$modulo&&$item['funcao']===$funcao;
					    }))>0):
					@endphp
						<div class="w-100 d-flex flex-wrap mgt-px-5 mgb-px-5 align-items-center">
							<sup class="w-100 d-flex align-items-center font-weight-bold pointer mgt-px-5 btn_criar_tratamento_ag user-select-none" data-bs-toggle="modal">
								<i class="ph ph-plus mgr-px-5"></i> {{mensagem('msg24')}}
							</sup>
						</div>
					@php endif @endphp

					<div class="form-floating w-100 d-flex flex-wrap mgt-px-5 mgb-px-5 h-120px">
						<textarea class="form-control w-100 h-120px" placeholder="{{mensagem('msg50')}}" id="observacoes" name="observacoes"></textarea>
						<label class="w-100" for="observacoes">{{mensagem('msg25')}}</label>
					</div>

					<div class="w-100 d-flex flex-wrap mgt-px-30 mgb-px-5 justify-content-between">
						<span type="submit" class="btn btn-success bg-cor-logo-cliente close-modal-agenda"><i class="ph ph-x"></i> {{mensagem('msg26')}}</span>
						<span type="submit" class="btn btn-success bg-cor-logo-cliente salvar-novo-agendamento">{{mensagem('msg59')}} <i class="ph ph-check"></i></span>
					</div>
				</form>
			</div>
		</div>
		<div class="modal-agendamento visualizar-agendamento relative">
			<div class="header-modal d-flex justify-content-between align-items-center relative">
				<div class="d-flex align-items-start editar_dados_agendamento">
					<h4>{{mensagem('msg27')}}</h4>
					<i
						class="ph ph-pencil-simple mgl-px-5 pointer btn_editar_dados_agendamento"
						data-bs-toggle="tooltip"
		                data-bs-placement="bottom"
		                data-bs-custom-class="custom-tooltip"
		                data-bs-title="{{mensagem('msg28')}}"
		                style="background-color: var(--cor-logo-cliente-transp)!important;color: var(--cor-font-cliente)!important;"
		                background-cliente="<?= array_column(session('config_dados'), 'valor', 'variavel')['cor_logo'] ?>"
		                background-cliente-transp="<?= array_column(session('config_dados'), 'valor', 'variavel')['cor_logo'] ?>36"
					></i>
					<i
						class="ph ph-x mgl-px-5 pointer d-none"
						data-bs-toggle="tooltip"
		                data-bs-placement="bottom"
		                data-bs-custom-class="custom-tooltip"
		                data-bs-title="{{mensagem('msg29')}}"
		                style="background-color: var(--cor-logo-cliente)!important;color: var(--cor-font-cliente)!important;"
					></i>
				</div>
				<span>
					<i
						class="ph ph-x pointer close-modal-agenda"
						data-bs-toggle="tooltip"
		                data-bs-placement="bottom"
		                data-bs-custom-class="custom-tooltip"
		                data-bs-title="{{mensagem('msg30')}}"
					></i>
				</span>
			</div>
			<div class="content-modal">
				<form class="d-flex flex-wrap w-100 justify-content-between">
					<div class="dados_agendamento d-flex flex-wrap w-100 justify-content-between">
						<div class="form-floating w-49">
						  	<input type="text" class="form-control border-none mgb-px-5" readonly id="data_inicial_visualizar" placeholder="{{date('d/m/Y')}}" value="" name="data_inicio">
						  	<input type="hidden" name="agenda_id" value="">
						  	<label for="data_inicial">{{mensagem('msg31')}}</label>
						</div>

						<div class="form-floating w-49">
						  	<input type="text" class="form-control border-none mgb-px-5" readonly id="data_fim_visualizar" placeholder="{{date('d/m/Y')}}" value="" name="data_fim">
						  	<label for="data_fim">{{mensagem('msg32')}}</label>
						</div>

						<div class="form-floating w-49">
						  	<input type="text" class="form-control border-none mgb-px-5 hora" readonly id="hora_inicial" placeholder="00:00" value="" name="hora_inicio">
						  	<label for="hora_inicial">{{mensagem('msg33')}}</label>
						</div>

						<div class="form-floating w-49">
						  	<input type="text" class="form-control border-none mgb-px-5 hora" readonly id="hora_fim" placeholder="00:00" value="" name="hora_fim">
						  	<label for="hora_fim">{{mensagem('msg34')}}</label>
						</div>

						<div class="form-floating w-100">
							<input type="text" class="form-control border-none mgb-px-5" readonly placeholder="{{mensagem('msg51')}}" name="paciente" autocomplete="off">
							<label>{{mensagem('msg35')}}</label>
						</div>

						<div class="form-floating w-100">
							<input type="text" class="form-control border-none mgb-px-5" readonly placeholder="{{mensagem('msg52')}}" name="profissional_label" autocomplete="off">
							<div class="select_profissional d-none mgt-px-30">
								<select class="select2" name="profissional">
									@foreach($profissionais as $profissional)
										<option value="{{$profissional['id']}}">{{$profissional['nome']}}</option>
									@endforeach;
								</select>
							</div>
							<label>{{mensagem('msg36')}}</label>
							<input type="hidden" name="profissional_id">
						</div>

						<div class="form-floating w-100">
							<input type="text" class="form-control border-none mgb-px-5" readonly placeholder="{{mensagem('msg53')}}" name="tratamento" autocomplete="off">
							<label>{{mensagem('msg37')}}</label>
							<input type="hidden" name="tratamento_id">
						</div>

						<div class="form-floating w-100 observacoes-agendamento d-none">
							<textarea class="form-control w-100 border-none" readonly placeholder="{{mensagem('msg54')}}" id="observacoes" name="observacoes" rows="2"></textarea>
							<label>{{mensagem('msg55')}}</label>
						</div>
					</div>

					<div class="w-100">
						<hr>
					</div>

					<div class="w-80">
					  	<label>{{mensagem('msg38')}}</label>
					</div>

					<div class="w-19">
					  	<label>{{mensagem('msg39')}}</label>
					</div>

					<div class="w-100 d-flex flex-wrap procedimentos">

					</div>

					<div class="w-100 d-flex flex-wrap mgt-px-30 mgb-px-5 justify-content-between">
						<div>
							<span type="submit" class="btn btn-success bg-cor-logo-cliente close-modal-agenda"><i class="ph ph-x"></i> {{mensagem('msg40')}}</span>
							<span
								type="submit"
								class="btn btn-success bg-cor-logo-cliente remover remover_agendamento"
								link="/agenda/remover_agendamento/"
								titulo="{{mensagem('msg41')}}"
								texto="{{mensagem('msg42')}}"
								btn-texto="{{mensagem('msg43')}}"
							>
								<i class="ph ph-trash"></i> {{mensagem('msg44')}}
						</span>
						</div>
						<span type="submit" class="btn btn-success bg-cor-logo-cliente salvar-editar-agendamento">{{mensagem('msg45')}} <i class="ph ph-check"></i></span>
					</div>
				</form>

				{{-- Clone --}}
				<div class="w-100 procedimento_clone d-none">
					<div class="w-100 d-flex justify-content-between mgb-px-5">
						<div class="form-floating w-80">
						  	<input type="text" class="form-control w-100" readonly placeholder="{{mensagem('msg56')}}" name="procedimento[]" autocomplete="off">
						  	<label></label>
						</div>
						<input type="hidden" name="tratamento_has_procedimento_id[]">
						<input type="hidden" name="procedimento_id[]">
						<input type="text" name="sessao[]" class="form-control w-19 number">
					</div>
				</div>
				{{-- <div class="w-100 procedimento_clone d-none">
					<div class="w-100 d-flex justify-content-between mgb-px-5">
						<input type="text" class="form-control w-80" readonly placeholder="{{mensagem('msg57')}}" name="procedimento[]" autocomplete="off">
						<input type="hidden" name="tratamento_has_procedimento_id[]">
						<input type="hidden" name="procedimento_id[]">
						<input type="text" name="sessao[]" class="form-control w-19">
					</div>
				</div> --}}
			</div>
		</div>
	</div>
</div>

{{-- Modal para criar tratamento através da agenda --}}
<div class="modal fade modal-criar-tratamento" id="modal-criar-tratamento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5 criar-tratamento-agenda-header">{{mensagem('msg46')}} </h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="d-flex flex-wrap justify-content-between">
					<input type="hidden" name="origem" value="agenda">
					<input type="hidden" name="paciente_id" value="">
					<input type="hidden" name="profissional" value="{{$profissional_id}}">
					@include('tratamento.form_novo')
				</form>

				<div class="d-none">
					@include('tratamento.form_novo_clone')
				</div>
			</div>
			<div class="modal-footer">
				<span type="submit" class="btn btn-success bg-cor-logo-cliente close-modal-criar-tratamento"><i class="ph ph-x"></i> {{mensagem('msg47')}}</span>
				<span type="submit" class="btn btn-success bg-cor-logo-cliente salvar-novo-tratamento">{{mensagem('msg48')}} <i class="ph ph-check"></i></span>
			</div>
		</div>
	</div>
</div>
@endsection