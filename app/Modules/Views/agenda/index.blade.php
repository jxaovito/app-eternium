@extends('default.layout')
@section('content')
<div class="container-agenda">
	<div class="header">
		<div class="w-10 d-flex align-items-center justify-content-center alternar-datas">
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

		<div class="selecionar-data">
			<input type="text" class="date form-control" value="{{date('d-m-Y')}}">
		</div>
	</div>
	<div id="calendar" style="height: 100vh"></div>
</div>
@endsection