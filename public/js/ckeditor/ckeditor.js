$(document).ready(function(){
    let prontuario_agendamento = $('.container-atendimento #ckeditor_atendimento');

    if(prontuario_agendamento.length){
        ClassicEditor
            .create(document.querySelector('#ckeditor_atendimento'),{
                height: '300px',
            })
            .catch( error => {
                console.error( error );
        });
    }
});