<!DOCTYPE html>
<html>
<head>
	<title>Login - Eternium</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
	<link rel="icon" type="image/x-icon" href="{{ asset('img/eternium_logo_icon.svg') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
	<div class="section-login">
		<div class="assets-bg"></div>

		<div class="box-login">
			<div class="banner">
				<img src="{{ asset('img/banner-login.jpg') }}">
			</div>
			<div class="area-login">
				<div class="content-logo">
					<img src="{{ asset('img/eternium_logo.svg') }}">
				</div>
				<div class="content-form">
					<form action="/auth" method="post">
						@csrf
						<span>Acesse com seu email e sua senha.</span>

						<input type="email" name="email" placeholder="E-mail" autofocus="autofocus" required>
						<input type="password" name="password" placeholder="Senha" required>
						<input type="hidden" name="con" value="{{$conexao_id}}">

						<div class="form-buttons">
							<button type="submit">Acessar</button>
						</div>

						@if(session('error'))
							<span class="error-login"><i class="bi bi-x-lg"></i> <text>{{ session('error') }}</text></span>
						@endif
					</form>
				</div>
				<div class="content-footer">
					<span style="color: #818181;">Ou</span>
					<span><a href="">Recuperar senha</a></span>
					<div class="direitos-reservados">
						&copy Eternium <?= date('Y') ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>