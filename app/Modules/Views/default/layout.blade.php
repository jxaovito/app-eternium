<!DOCTYPE html>
<html lang="pt-br">
    <head>
        {{-- Idioma --}}
        <script>
            let idioma = "{{session('idioma')}}";
            let moeda = "{{session('moeda')}}";
            let pagina = "{{isset($pagina) ? $pagina : ''}}";
            const base_url = "/";
        </script>

        <title>{{array_column(session('config_dados'), 'valor', 'variavel')['nome_empresa']}} - Eternium</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/x-icon" href="{{ asset('img/eternium_logo_icon.svg') }}">
        <link rel="stylesheet" href="{{ asset('css/default.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bg_nomes.css') }}">
        <link rel="stylesheet" href="{{ asset('css/nav.css') }}">

        <script src="https://unpkg.com/@phosphor-icons/web"></script>

        {{-- JS de IDIOMAS --}}
        <script type="text/javascript" src="{{ asset('js/lang/Lang_helper.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lang/Portugues_br_helper.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lang/Ingles_us_helper.js') }}"></script>

        <!-- baixar posteriormente -->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <!-- /baixar posteriormente -->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="{{ asset('js/min') }}/select2.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/min') }}/select2.min.css"/>
        <script type="text/javascript" src="{{ asset('js/functions.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/autocomplete.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/min/jquery.mask.js') }}"></script>
        <script src="{{ asset('js/min') }}/popper.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/mascaras.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/nav.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('css/min/tui-date-picker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/min/tui-time-picker.min.css') }}">

        <script type="text/javascript" src="{{ asset('js/min/tui-time-picker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/min/tui-date-picker.min.js') }}"></script>

        @php 
            // Importações que dependem da página
        @endphp

        @if(isset($pagina) && $pagina == 'permissoes')
        <link rel="stylesheet" href="{{ asset('css/permissoes.css') }}">
        <script type="text/javascript" src="{{ asset('js/nivel_permissao.js') }}"></script>
        @endif

        @if(isset($pagina) && $pagina == 'paciente')
        <link rel="stylesheet" href="{{ asset('css/paciente.css') }}">
        <script type="text/javascript" src="{{ asset('js/paciente.js') }}"></script>
        @endif

        @if(isset($pagina) && $pagina == 'profissional')
        <script type="text/javascript" src="{{ asset('js/profissional.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/profissional.css') }}">
        @endif

        @if(isset($pagina) && $pagina == 'convenio')
        <script type="text/javascript" src="{{ asset('js/convenio.js') }}"></script>
        @endif

        @if(isset($pagina) && $pagina == 'especialidade')
        <link rel="stylesheet" href="{{ asset('css/especialidade.css') }}">
        @endif

        @if(isset($pagina) && $pagina == 'usuario')
        <script type="text/javascript" src="{{ asset('js/usuario.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/usuario.css') }}">
        @endif

        @if(isset($pagina) && $pagina == 'configuracao')
        <script type="text/javascript" src="{{ asset('js/configuracao.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/configuracao.css') }}">
        @endif

        @if(isset($pagina) && $pagina == 'procedimento')
        <script type="text/javascript" src="{{ asset('js/procedimento.js') }}"></script>
        @endif

        @if(isset($pagina) && ($pagina == 'tratamento' || $pagina == 'agenda'))
        <script type="text/javascript" src="{{ asset('js/tratamento.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/tratamento.css') }}">
        @endif

        @if(isset($pagina) && $pagina == 'prontuario')
        <script type="text/javascript" src="{{ asset('js/prontuario.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/prontuario.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tratamento.css') }}">
        @endif

        <style>
            :root{
                --cor-logo-cliente: <?= array_column(session('config_dados'), 'valor', 'variavel')['cor_logo'] ?>;
                --cor-logo-cliente-transp: <?= array_column(session('config_dados'), 'valor', 'variavel')['cor_logo'] ?>36;
                --cor-font-cliente: <?= array_column(session('config_dados'), 'valor', 'variavel')['cor_font'] ?>;
                --cor-menu-superior-cliente: <?= array_column(session('config_dados'), 'valor', 'variavel')['cor_menu_topo'] ?>;
                --font-regular: 'Montserrat-Regular', sans-serif;
                --font-color: #000;
                --background-success: #4CAF50;
                --background-success-hover: '#3a8b3d';
            }
        </style>
    </head>
    <body>
        <container>
            @include('default.nav')
            <div class="content-page">
                <?php //Configuração de Alertas ?>
                @if(session('mensagem'))
                    <div class="alert alert-{{session('tipo_mensagem')}} text-center alert-dismissible fade show" role="alert">
                        {{session('mensagem')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <?php session()->forget('mensagem'); ?>
                    <?php session()->forget('tipo_mensagem'); ?>
                @endif

                <?php //Chamada do conteúdo do Sistema ?>
                @yield('content')
            </div>
        </container>

        <!-- Modal de Deletar -->
        <div class="modal fade" id="modal_deletar" tabindex="-1" aria-labelledby="modal_deletar" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal_deletar_titulo">Remover</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal_deletar_content">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="">
                            <button type="button" class="btn btn-danger">Deletar</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alerta --}}
        <div class="toast alerta" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed;top: 10%;right: 2%;">
              <div class="toast-header">
                <span class="bg_tipo_alerta"></span>
                <strong class="me-auto">Atenção</strong>
                <small>agora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                
            </div>
        </div>

        {{-- Calenddar --}}
        @if(isset($pagina) && $pagina == 'agenda')
            <script type="text/javascript" src="{{ asset('js/min/toastui-calendar.min.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('css/min/toastui-calendar.min.css') }}">
            <script type="text/javascript" src="{{ asset('js/calendar.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
        @endif

        {{-- Incluir Icons --}}
        @include('/default/icons')

        {{-- Páginas que precisam de CKEditor --}}
        @if(isset($pagina) && $pagina == 'prontuario')
            <script type="text/javascript" src="{{ asset('vendor/ckeditor5/build/ckeditor.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        @endif
    </body>
</html>
