<!DOCTYPE html>
<html>
<head>
	<title>Login - Eternium</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
	<link rel="icon" type="image/x-icon" href="{{ asset('img/eternium_logo_icon.svg') }}">
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
					<form action="#" method="post">
						<span>Acesse com seu email e sua senha.</span>

						<input type="email" name="email" placeholder="E-email" autofocus="autofocus">
						<input type="password" name="email" placeholder="Senha">
						<input type="hidden" name="con" value="{{$conexao_id}}">

						<div class="form-buttons">
							<button type="submit">Acessar</button>
						</div>
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