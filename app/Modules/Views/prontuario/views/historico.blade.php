<div class="w-100 content-submenu {{$submenu != 1 ? 'd-none' : ''}}" submenu="1">
	<div class="container-historico">
		<div class="time-lide-div">
			<h5>Histórico de Atendimentos</h5>

			@foreach($historico_prontuarios as $key => $pront)
				<div class="time-line">
					<div class="data-time-line">
						<div class="data-line">
							<span>{{data($pront['data_hora'])}}</span>
						</div>
					</div>
					<div class="graph">
						<div class="circle">
							<div class="line1"></div>
							<div class="area-circle">
								<div class="col1"></div>
								<div class="circle-obj"></div>
								<div class="col2"></div>
							</div>
						</div>

						<div class="line">
							<div class="line1"></div>
							<div class="line2"></div>
						</div>

						<div class="line">
							<div class="line1"></div>
							<div class="line2"></div>
						</div>
					</div>
					<div class="content">
						<p class="d-inline-block text-truncate pointer" style="max-width: 100%;">
							Atendimento realizado pelo Profissional: <b>{{$pront['profissional']}}</b>
							<br>
							<sub>Clique para expandir conteúdo...</sub>
						</p>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>