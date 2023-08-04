<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>{{array_column(session('config_dados'), 'valor', 'variavel')['nome_clinica']}} - Eternium</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/x-icon" href="{{ asset('img/eternium_logo_icon.svg') }}">
        <link rel="stylesheet" href="{{ asset('css/default.css') }}">
        <link rel="stylesheet" href="{{ asset('css/nav.css') }}">

        <script src="https://unpkg.com/@phosphor-icons/web"></script>

        <!-- baixar posteriormente -->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <!-- /baixar posteriormente -->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="{{ asset('js/slim') }}/select2.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/min') }}/select2.min.css"/>
        <script type="text/javascript" src="{{ asset('js/functions.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/slim/jquery.mask.js') }}"></script>
        <script src="{{ asset('js/slim') }}/popper.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/mascaras.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/nav.js') }}"></script>

        <style>
            :root{
                --cor-logo-cliente: {{array_column(session('config_dados'), 'valor', 'variavel')['cor_logo']}};
                --cor-font-cliente: {{array_column(session('config_dados'), 'valor', 'variavel')['cor_font']}};
            }
        </style>
    </head>
    <body>
        <container>
            @include('default.nav')
            <div class="content-page">
                <?php //Configuração de Alertas ?>
                @if(session('mensagem'))
                    @if(session('tipo_mensagem'))
                        <div class="alert alert-success" role="alert">
                            {{session('mensagem')}}
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            {{session('mensagem')}}
                        </div>
                    @endif

                    <?php session()->forget('mensagem'); ?>
                    <?php session()->forget('tipo_mensagem'); ?>
                @endif

                <?php //Chamada do conteúdo do Sistema ?>
                @yield('content')
            </div>
        </container>
    </body>
</html>
