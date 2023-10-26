<?php
if (!function_exists('mensagem')) {
    function mensagem($key){
        $route = app('router')->getCurrentRoute();

        if($route){
            // Obtém o controlador associado à rota
            $controller_ativo = $route->getAction('controller');

            // Divide a string do controlador para obter a classe
            list($class, $method) = explode('@', $controller_ativo);
            $class = strtolower(str_replace('_controller', '', substr(explode('Controllers', $class)[1], 1)));

            $msg = '';
            if(session('idioma') == 'portugues_br'){
                $msg = portugues_br($class, $key);

            }else if(session('idioma') == 'ingles_us'){
                $msg = ingles_us($class, $key);

            }

            return trans($msg);
        }
    }
}

