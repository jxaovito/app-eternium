$(document).ready(function(){
	$(document).on('change', '#cor_entorno', function(){
		var cor = `radial-gradient(circle, ${$(this).val()}, ${$('#cor_centro').val()})`;
		$('.gradient-preview').css('background', cor);
		$('#cor_menu_topo').val(cor);
	});

	$(document).on('change', '#cor_centro', function(){
		var cor = `radial-gradient(circle, ${$('#cor_entorno').val()}, ${$(this).val()})`;
		$('.gradient-preview').css('background', cor);
		$('#cor_menu_topo').val(cor);
	});

	$('#logo_empresa').on('change', function(e) {
		var file = e.target.files[0];
		if (file) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#logo_empresa_preview').attr('src', e.target.result);
			};
			reader.readAsDataURL(file);
		}
	});
});