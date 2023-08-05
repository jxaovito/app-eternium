$(document).ready(function(){

    // Apresenta as permissões conforme o clique do usuário
    $(document).on('click', '.box-permission button', function(){
        $('.box-permission button').removeClass('btn-secondary');
        $('.box-permission button').addClass('btn-light');
        $(this).removeClass('btn-light');
        $(this).addClass('btn-secondary');

        $('.box-permiss').hide('fast');
        $(`.${$(this).attr('referencia')}`).show('fast');
    });
});