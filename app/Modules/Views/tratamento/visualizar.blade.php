@extends('default.layout')
@section('content')
@foreach($registros as $registro)
@php
	if($registro['sessoes_consumida']){
		$porcentagem = ($registro['sessoes_consumida'] / $registro['sessoes_contratada']) * 100;
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
<div class="container-tratamento-visualizar d-flex flex-wrap justify-content-between align-itens-start">
	<div class="w-100 mgb-px-30 d-flex justify-content-between">
		<h2>Visualizar Tratamento</h2>
		<div>
			<a href="/tratamento/editar/{{$registro['tratamento_id']}}"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-pencil-simple"></i> Editar</button></a>
			<a href="/tratamento"><button class="btn btn-success bg-cor-logo-cliente"><i class="ph ph-caret-left"></i> Voltar</button></a>
		</div>
	</div>
	<div class="content-principal d-flex flex-wrap justify-content-between align-items-start">
		<div class="w-32 d-flex flex-wrap">
			<label class="w-100 bold">Data de Cadastro:</label>
			<span class="w-100">{{data_hora($registro['data_hora'])}}</span>
		</div>

		<div class="w-32 d-flex flex-wrap">
			<label class="w-100 bold">Profissional:</label>
			<span class="w-100">{{$registro['profissional']}}</span>
		</div>

		<div class="w-32 d-flex flex-wrap">
			<label class="w-100 bold">Especialidade:</label>
			<span class="especialidade_list" style="background-color: {{$registro['cor_fundo_esp']}};color: {{$registro['cor_fonte_esp']}};">{{$registro['especialidade']}}</span>
		</div>

		<div class="w-32 d-flex flex-wrap">
			<label class="w-100 bold">Sessões:<br><sub class="realtive top-px--5 opacity-05 font-10">Consumida/Contratada</sub></label>
			<span class="w-100">{{$registro['sessoes_consumida']}}/{{$registro['sessoes_contratada']}}</span>
		</div>

		<div class="w-32 d-flex flex-wrap">
			<label class="w-100 bold">Nº da Carteirinha:</label>
			@if($registro['observacoes'])
				<span class="w-100">{{$registro['matricula']}}</span>
			@else
				<span class="w-100 opacity-05 user-select-none">Matrícula não registrada</span>
			@endif
		</div>

		<div class="w-100 d-flex flex-wrap">
			<label class="w-100 bold">Observações do Tratamento:</label>
			@if($registro['observacoes'])
				<span class="w-100">{{$registro['observacoes']}}</span>
			@else
				<span class="w-100 opacity-05 user-select-none">Nenhuma observação registrada</span>
			@endif
		</div>

		<div class="divisor w-100 mgt-px-20 mgb-px-20"></div>

		<div class="w-100 d-flex flex-wrap mgb-px-10 opacity-05 user-select-none">
			<h5><label class="w-100 bold">Procedimentos:</label></h5>
		</div>

		<div class="w-25 d-flex flex-wrap mgb-px-10">
			<label class="w-100 bold">Nome:</label>
		</div>

		<div class="w-14 d-flex flex-wrap mgb-px-10">
			<label class="w-100 bold">Sessões:<br><sub class="realtive top-px--5 opacity-05 font-10">Contratada</sub></label>
		</div>

		<div class="w-14 d-flex flex-wrap mgb-px-10">
			<label class="w-100 bold">Sessões:<br><sub class="realtive top-px--5 opacity-05 font-10">Consumida</sub></label>
		</div>

		<div class="w-10 d-flex flex-wrap mgb-px-10">
			<label class="w-100 bold">Subtotal:</label>
		</div>

		<div class="w-14 d-flex flex-wrap mgb-px-10">
			<label class="w-100 bold">Desconto:<br><sub class="realtive top-px--5 opacity-05 font-10">Por procedimento</sub></label>
		</div>

		<div class="w-10 d-flex flex-wrap mgb-px-10">
			<label class="w-100 bold">Total:</label>
		</div>

		@foreach($registro['procedimentos'] as $procedimento)
			<div class="w-25 d-flex flex-wrap">
				<span class="w-100">{{$procedimento['procedimento']}}</span>
			</div>

			<div class="w-14 d-flex flex-wrap">
				<span class="w-100">{{$procedimento['sessoes_contratada']}}</span>
			</div>

			<div class="w-14 d-flex flex-wrap">
				<span class="w-100">{{$procedimento['sessoes_consumida']}}</span>
			</div>

			<div class="w-10 d-flex flex-wrap">
				<span class="w-100">{{moeda()}} {{valor($procedimento['subtotal'] ? $procedimento['subtotal'] : '0')}}</span>
			</div>

			@if($procedimento['tipo_desconto'] == '0')
				<div class="w-14 d-flex flex-wrap">
					<span class="w-100">{{moeda()}} {{valor($procedimento['desconto_real'] ? $procedimento['desconto_real'] : '0')}}</span>
				</div>
			@else
				<div class="w-14 d-flex flex-wrap">
					<span class="w-100">{{valor($procedimento['desconto_porcento'] ? $procedimento['desconto_porcento'] : '0')}} %</span>
				</div>
			@endif

			<div class="w-10 d-flex flex-wrap">
				<span class="w-100">{{moeda()}} {{valor($procedimento['total'] ? $procedimento['total'] : '0')}}</span>
			</div>
		@endforeach

		<div class="w-100 d-flex div-resumo-tratamento">
			<div class="w-24 d-flex flex-wrap">
				<label class="w-100 bold">Total de Procedimentos:</label>
				<span class="w-100">{{count($registro['procedimentos'])}} Procedimento{{count($registro['procedimentos']) > 1 ? 's' : ''}}</span>
			</div>

			<div class="w-24 d-flex flex-wrap">
				<label class="w-100 bold">Subtotal do Tratamento:</label>
				<span class="w-100">{{moeda()}} {{valor($registro['subtotal'] ? $registro['subtotal'] : '0')}}</span>
			</div>

			<div class="w-24 d-flex flex-wrap">
				<label class="w-100 bold">Desconto:</label>
				@if(!$registro['desconto_porcento'])
					<span class="w-100">{{moeda()}} {{valor($registro['desconto_real'] ? $registro['desconto_real'] : '0')}}</span>
				@else
					<span class="w-100">{{moeda()}} {{valor($registro['desconto_porcento'] ? $registro['desconto_porcento'] : '0')}}</span>
				@endif
			</div>

			<div class="w-24 d-flex flex-wrap">
				<label class="w-100 bold">Total do Tratamento:</label>
				<span class="w-100">{{moeda()}} {{valor($registro['total'] ? $registro['total'] : '0')}}</span>
			</div>
		</div>

		@if($registro['fin_lancamento'])
			<div class="divisor w-100 mgt-px-30 mgb-px-30"></div>

			<div class="w-100 d-flex flex-wrap mgb-px-10 opacity-05 user-select-none">
				<h5><label class="w-100 bold">Lançamento Financeiro:</label></h5>
			</div>

			<div class="w-19 d-flex flex-wrap">
				<label class="w-100 bold">Categoria:</label>
				<span class="w-100">{{$registro['categoria']}}</span>
			</div>

			<div class="w-19 d-flex flex-wrap">
				<label class="w-100 bold">Subcategoria:</label>
				<span class="w-100">{{$registro['subcategoria']}}</span>
			</div>

			<div class="w-19 d-flex flex-wrap">
				<label class="w-100 bold">Forma de Pagamento:</label>
				<span class="w-100">{{$registro['forma_pagamento']}}</span>
			</div>

			<div class="w-19 d-flex flex-wrap">
				<label class="w-100 bold">Total de Parcelas:</label>
				<span class="w-100">{{$registro['parcela']}}x</span>
			</div>

			<div class="w-19 d-flex flex-wrap">
				<label class="w-100 bold">Conta:</label>
				<span class="w-100">{{$registro['conta']}}</span>
			</div>

			<div class="w-100 d-flex flex-wrap mgb-px-10 mgt-px-10 opacity-05 user-select-none">
				<h5><label class="w-100 bold font-15">Parcelas:</label></h5>
			</div>

			<div class="w-3 d-flex flex-wrap mgb-px-10 text-align-center">
				<label class="w-100 bold">Nº</label>
			</div>

			<div class="w-24 d-flex flex-wrap mgb-px-10 text-align-center">
				<label class="w-100 bold">Valor da Parcela</label>
			</div>

			<div class="w-24 d-flex flex-wrap mgb-px-10 text-align-center">
				<label class="w-100 bold">Valor Restante</label>
			</div>

			<div class="w-24 d-flex flex-wrap mgb-px-10 text-align-center">
				<label class="w-100 bold">Data de Vencimento</label>
			</div>

			<div class="w-24 d-flex flex-wrap mgb-px-10 text-align-center">
				<label class="w-100 bold">Status</label>
			</div>

			@foreach($registro['parcelas'] as $key => $pacela)
				<div 
					class="w-100 d-flex 
							{{$pacela['data_vencimento'] < date('Y-m-d') && $pacela['quitado'] == 'n' ? 'pagamento_atrasado' : ''}}
							{{$pacela['quitado'] == 's' ? 'pagamento_pago' : ''}}
						"
				>
					<div class="w-3 d-flex flex-wrap text-align-center">
						<span class="w-100">{{$key+1}}</span>
					</div>

					<div class="w-24 d-flex flex-wrap text-align-center">
						<span class="w-100">{{moeda()}} {{valor($pacela['valor'] ? $pacela['valor'] : '0')}}</span>
					</div>

					<div class="w-24 d-flex flex-wrap text-align-center">
						<span class="w-100">{{moeda()}} {{valor($pacela['valor_restante'] ? $pacela['valor_restante'] : '0')}}</span>
					</div>

					<div class="w-24 d-flex flex-wrap text-align-center">
						<span class="w-100">{{data($pacela['data_vencimento'])}}</span>
					</div>

					<div class="w-24 d-flex flex-wrap text-align-center">
						<span class="w-100">
							@if($pacela['data_vencimento'] < date('Y-m-d') && $pacela['quitado'] == 'n')
							<b>Em Atraso</b>
							@elseif($pacela['quitado'] == 'n')
							Em aberto
							@else
							Pago
							@endif
						</span>
					</div>
				</div>
			@endforeach
		@endif
	</div>

	<div class="content-profile">
		<div class="data-user">
			<div class="imagem_paciente">
				<div class="circle circle-half-black" style="<?= $sessoes_completadas ?>">
				  	<div class="circle-inner">
				  		@if($registro['imagem_paciente'])
				  			<img src="{{asset('clientes/'.session('conexao_id').'/paciente/'.$registro['imagem_paciente'])}}">
				  		@else
				  			<img src="{{asset('img/user-circle.svg')}}">
				  		@endif
				  	</div>
				</div>
			</div>
			<h5>{{$registro['paciente']}}</h5>
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
	                        data-bs-title="{{($registro['data_nascimento'] ? 'Data de nascimento: ' . $registro['data_nascimento'] : 'Realize o cadastro da Idade nas configurações do Paciente.')}}"
	                        class="{{!$registro['data_nascimento'] ? 'opacity-05' : ''}}"
						>
							{{$registro['idade']}} {{$registro['idade'] != 'Idade não cadastrada' ? $registro['idade'] > 1 ? 'anos' : 'ano' : ''}} 
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
							{{$registro['convenio']}}
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
						@if($registro['telefone_principal'])
							<label
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="Telefone"
							>
								{{$registro['telefone_principal']}}
							</label>
							<a
								href="https://wa.me/55{{preg_replace('/[^0-9]/', '', $registro['telefone_principal'])}}"
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
		                        data-bs-title="{{$registro['telefone_principal'] ? 'Telefone' : 'Realize o cadastro do telefone nas configurações do Paciente.'}}"
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
						@if($registro['email'])
							<label
								data-bs-toggle="tooltip"
		                        data-bs-placement="bottom"
		                        data-bs-custom-class="custom-tooltip"
		                        data-bs-title="E-mail"
							>
								{{$registro['email']}}
							</label>
							<a
								href="mailto:{{$registro['email']}}"
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
		                        data-bs-title="{{$registro['telefone_principal'] ? 'E-mail' : 'Realize o cadastro do telefone nas configurações do Paciente.'}}"
							>
								E-mail não cadastrado
							</label>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
@endsection