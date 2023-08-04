$(document).ready(function(){

    // Mostrar opções de usuário
    $(document).on('click', '.profile-photo, .profile-data, .background-modal-manual', function(){
        if(!$('.content-opc-profile').is(':visible')){
            $('.content-opc-profile').show('fast');
            $('body').append(`<div class="background-modal-manual"></div>`)

        }else{
            $('.content-opc-profile').hide('fast');
            $('.background-modal-manual').remove();
        }
    });
});