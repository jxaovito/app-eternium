<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Modules\Auth\Models\Auth_model;

if (!function_exists('checkAuthentication')) {
    function checkAuthentication($class, $function, $nome){
        if (!session('usuario_id')) {
            return false;
        } else {
            if (session('permissoes')) {
                $permissionsAll = session('permissoes_all');
                $permissionExists = false;

                foreach ($permissionsAll as $acesso) {
                    if ($acesso['modulo'] == $class && $acesso['funcao'] == $function) {
                        $permissionExists = true;
                        break;
                    }
                }

                if (!$permissionExists) {
                    $auth_model = new Auth_model();
                    $modulo_id = $auth_model->insert_new_funcao(['modulo' => $class, 'funcao' => $function, 'nome' => $nome]);

                    $permissionsAll[] = [
                        'id' => $modulo_id,
                        'modulo' => $class,
                        'funcao' => $function
                    ];

                    session(['permissoes_all' => $permissionsAll]);
                }

                $permissaoUsuario = false;
                foreach (session('permissoes') as $acesso_u) {
                    if ($acesso_u['modulo'] == $class && $acesso_u['funcao'] == $function) {
                        $permissaoUsuario = true;
                        break;
                    }
                }

                if ($permissaoUsuario) {
                    return true;
                } else {
                    return 'sp';
                }
            } else {
                $auth_model = new Auth_model();
                $permissionsAll = session('permissoes_all');
                $permissionExists = false;

                foreach ($permissionsAll as $acesso) {
                    if ($acesso['modulo'] == $class && $acesso['funcao'] == $function) {
                        $permissionExists = true;
                        break;
                    }
                }

                if (!$permissionExists) {
                    $modulo_id = $auth_model->insert_new_funcao(['modulo' => $class, 'funcao' => $function, 'nome' => $nome]);

                    $permissionsAll[] = [
                        'id' => $modulo_id,
                        'modulo' => $class,
                        'funcao' => $function
                    ];

                    session(['permissoes_all' => $permissionsAll]);
                }

                return 'sp';
            }

            return true;
        }
    }
}
