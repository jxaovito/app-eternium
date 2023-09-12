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

    // Expandir/Recolher menu
    $(document).on('click', '.lateral-nav .content-nav .content-expand i', function(){
        const container = $('.lateral-nav .content-nav .content-menus a span');
        var tipo = '';
        var element = $(this);

        if(container.is(':visible')){
            $(this).addClass('ph-caret-right');
            $(this).removeClass('ph-caret-left');
            container.parents('.lateral-nav').animate({ width: '4%' }, 500);
            container.parent('a').find('i').animate({ width: '90%' }, 500);
            container.hide('fast');
            $('.content-page').css('width', '92.5%');
            tipo = 'ocultar';
            element.tooltip('dispose');
            element.attr('data-bs-title', 'Mostrar Menu');
            element.tooltip();

            $.each(container.parent('a').find('i'), function(){
                $(this).parent('a').tooltip('dispose');
                $(this).parent('a').attr('data-bs-toggle', 'tooltip');
                $(this).parent('a').attr('data-bs-placement', 'right');
                $(this).parent('a').attr('data-bs-custom-class', 'custom-tooltip');
                $(this).parent('a').attr('data-bs-title', $(this).parent('a').attr('data-tooltip'));
                $(this).parent('a').tooltip();
            });

        }else{
            $(this).addClass('ph-caret-left');
            $(this).removeClass('ph-caret-right');
            container.parent('a').find('i').css('width', '20%');
            container.parents('.lateral-nav').css('width', '15%');
            $('.content-page').css('width', '82.5%');
            container.show('fast');
            tipo = 'mostrar';
            element.tooltip('dispose');
            element.attr('data-bs-title', 'Ocultar Menu');
            element.tooltip();

            $.each(container.parent('a').find('i'), function(){
                $(this).parent('a').tooltip('dispose');
                $(this).parent('a').removeAttr('data-bs-toggle');
                $(this).parent('a').removeAttr('data-bs-placement');
                $(this).parent('a').removeAttr('data-bs-custom-class');
                $(this).parent('a').removeAttr('data-bs-title');
            });
        }

        $.ajax({
            url: '/configuracao/menu',
            type: 'post',
            data: {
                tipo: tipo,
                _token: $('#form_menu [name="_token"]').val(),
            },
            dataType: 'json',
            success: function(data){
                
            },
        });
    });
});