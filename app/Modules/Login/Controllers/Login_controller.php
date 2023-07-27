<?php

namespace App\Modules\Login\Controllers;

use App\Modules\Login\Models\Login_model;
use App\Modules\Auth\Models\Auth_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Login_controller extends Controller{
	protected $login_model;
    protected $auth_model;

    public function __construct(){
        $this->login_model = new Login_model();
        $this->auth_model = new Auth_model();
    }

    public function index(Request $request){
    	$dados = $request->all();
        $_dados['conexao_id'] = (isset($dados['con']) ? base64_encode($dados['con']) : '');
        if(!$_dados['conexao_id'] && session('usuario_id')){
            return redirect()->route('agenda');

        }else if($_dados['conexao_id']){
            session(['conexao_id' => $dados['con']]);
        }

        return view('login.index', $_dados);
    }

    public function logout(Request $request){
    	session()->flush();
    	return redirect('/');
    }

    public function permissao_negada(){
        return view('default.permissao_negada');
    }
}
