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
        $_dados['conexao_id'] = (session('temp_conexao_id') ? base64_encode(session('temp_conexao_id')) : '');
        if(!$_dados['conexao_id'] && session('usuario_id')){
            return redirect()->route('agenda');

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

    public function adm(Request $request){
        $dados = $request->all();
        $_dados['conexao_id'] = (isset($dados['con']) ? base64_encode($dados['con']) : '');

        session()->flush();
        if(isset($dados['con'])){
            session(['temp_conexao_id' => base64_encode($dados['con'])]);
        }

        return redirect('/');
    }
}
