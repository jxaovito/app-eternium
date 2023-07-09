<?php

namespace App\Modules\Login\Controllers;

use App\Modules\Login\Models\Login_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Login_controller extends Controller{
	protected $login_model;

    public function __construct(){
        $this->login_model = new Login_model();
    }

    public function index(){
        if(session('usuario_id')){
            return redirect()->route('acesso');
        }
        return view('login.index');
    }

    public function auth(Request $request){
    	$dados = $request->all();
    	$email = $request->email;
    	$password = $request->password;
    	$password_crypto = password_hash($password, PASSWORD_BCRYPT);

    	$usuario = $this->login_model->get_all_table('usuario', $email);

    	if($usuario && password_verify($password, $usuario['password'])){
            $permissoes = $this->login_model->get_permissoes_usuario($usuario['id']);
            $permissoes_all = $this->login_model->get_permissoes();

            session(['permissoes' => $permissoes]);
            session(['permissoes_all' => $permissoes_all]);
    		session(['usuario_id' => $usuario['id']]);
    		session(['usuario_nome' => $usuario['nome']]);
            session(['usuario_email' => $usuario['email']]);

    		return redirect()->route('acesso');
	    }else{
	        return redirect()->back()->with('error', 'Usuário e/ou senha não incorretos');
	    }
    }

    public function logout(Request $request){
    	session()->flush();
    	return redirect('/');
    }

    public function permissao_negada(){
        return view('default.permissao_negada');
    }
}
