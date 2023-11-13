$(document).ready(function(){
	$(document).on('click', '.navegacao span', function(){
		$(this).parent('div').find('span').removeClass('active');
		
		let submenu = $(this).attr('submenu');
		let paciente_id = $('[name="paciente_id"]').val();
		let agenda_id = $('[name="agenda_id"]').val();

		$(this).addClass('active');
		$('[name="submenu"]').val(submenu);

		$('.container-content').find('.content-submenu').addClass('d-none');
		$('.container-content').find(`[submenu="${submenu}"]`).removeClass('d-none');

		history.pushState({}, '', `${window.location.origin}/prontuario/atender/${paciente_id}/${agenda_id}/${submenu}`);
	});
});