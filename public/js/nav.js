$(document).ready(function(){

    // Mostrar opções de usuário
    $(document).on('click', '.profile-photo, .profile-data, .bg-modal-opc-profile', function(){
        if(!$('.content-opc-profile').is(':visible')){
            $('.content-opc-profile').show('fast');
            $('body').append(`<div class="background-modal-manual bg-modal-opc-profile"></div>`);

        }else{
            $('.content-opc-profile').hide('fast');
            $('.bg-modal-opc-profile').remove();
        }
    });

    // Mostrar opções de Configurações
    $(document).on('click', '.opc_config_nav, .bg-modal-config-nav', function(){
        if(!$('.content-config').is(':visible')){
            $('.content-config').show('fast');
            $('body').append(`<div class="background-modal-manual bg-modal-config-nav"></div>`);
            $('.content-profile').css('z-index', '1');

        }else{
            $('.content-config').hide('fast');
            $('.bg-modal-config-nav').remove();
            $('.content-profile').css('z-index', '999');
        }
    });
});