<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Modules\Auth\Models\Auth_model;

if (!function_exists('checkAuthentication')) {
    function checkAuthentication($class, $function){
        if(!session('usuario_id')){
            return false;

        }else{
        	if(session('permissoes')){
        		$criar_permissao = true;
        		$permissoes_all = session('permissoes_all');
        		foreach($permissoes_all as $acesso){
        			if($acesso['modulo'] == $class && $acesso['funcao'] == $function){
        				$criar_permissao = false;
        			}
        		}

        		if($criar_permissao){
        			$auth_model = new Redirect();
        			$modulo_id = $auth_model->insert_new_funcao(array('modulo' => $class, 'funcao' => $function));
        			$i = count($permissoes_all) +1;
        			$permissoes_all[$i]['id'] = $modulo_id;
        			$permissoes_all[$i]['modulo'] = $class;
        			$permissoes_all[$i]['funcao'] = $function;
        		}

        		session(['permissoes_all' => $permissoes_all]);

        		$permissao_usuario = false;
        		foreach(session('permissoes') as $acesso_u){
        			if($acesso_u['modulo'] == $class && $acesso_u['funcao'] == $function){
        				$permissao_usuario = true;
        			}
        		}

        		if($permissao_usuario){
        			return true;
        		}else{
        			return 'sp';
        		}

        	}else{
        		$criar_permissao = true;
        		$permissoes_all = session('permissoes_all');
        		foreach($permissoes_all as $acesso){
        			if($acesso['modulo'] == $class && $acesso['funcao'] == $function){
        				$criar_permissao = false;
        			}
        		}

        		if($criar_permissao){
        			$auth_model = new Auth_model();
        			$modulo_id = $auth_model->insert_new_funcao(array('modulo' => $class, 'funcao' => $function));
        			$i = count($permissoes_all) +1;
        			$permissoes_all[$i]['id'] = $modulo_id;
        			$permissoes_all[$i]['modulo'] = $class;
        			$permissoes_all[$i]['funcao'] = $function;
        		}

        		session(['permissoes_all' => $permissoes_all]);

				return 'sp';        		
        	}

        	return true;
        }
    }
}