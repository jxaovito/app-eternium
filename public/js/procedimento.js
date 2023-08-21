$(document).ready(function(){
	$(document).on('click', '.add_procedimento', function(){
		var container = $('.div-clone').clone();
		var row = 0;
		$.each($('.remover_procedimento'), function(){
			row = parseInt($(this).attr('row')) + 1;
		});
		container.find('.deletar').addClass('remover_procedimento');
		container.find('.remover_procedimento').attr('row', row);
		container.removeClass('div-clone');
		container.removeClass('d-none');
		container.addClass('d-flex');
		$('.procedimentos').append(container);

	});

	$(document).on('click', '.remover_procedimento', function(){
		$('#modal_deletar').find('.modal-footer').find('a').remove();
		$('#modal_deletar').find('.modal-footer').find('.btn-danger').remove();
		$('#modal_deletar').find('.modal-footer').append(`<button type="button" class="btn btn-danger confirar_exclusao" row="${$(this).attr('row')}">Remover</button>`);
	});

	$(document).on('click', '.confirar_exclusao', function(){
		var row = $(this).attr('row');
		$.each($('.procedimentos .content-procedimentos'), function(index, val){
			if(index == row){
				if($(this).find('[name="id[]"]').val()){
					$('[name="deletado"]').val(($('[name="deletado"]').val() ? $('[name="deletado"]').val()+',' : '')+$(this).find('[name="id[]"]').val());
				}
				$(this).remove();
			}
		});

		$('#modal_deletar').find('[data-bs-dismiss="modal"]').click();
	});
});