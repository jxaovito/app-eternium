<?php

namespace App\Modules\Procedimento\Controllers;

use function App\Helpers\checkAuthentication;
use App\Modules\Procedimento\Models\Procedimento_model;
use App\Modules\Procedimento\Models\Procedimento_db_model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Procedimento_controller extends Controller{
	protected $Procedimento_model;
    protected $class;

    public function __construct(){
        $this->Procedimento_model = new Procedimento_model();
        $this->class = get_class($this);
        $this->class = basename(str_replace('\\', '/', $this->class));
        $this->class = strtolower(basename(str_replace('_controller', '/', $this->class)));
    }

    public function index(){
        $check_auth = checkAuthentication($this->class, __FUNCTION__, 'Procedimentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $_dados['registros'] = $this->Procedimento_model->get_all();
        $_dados['pagina'] = 'procedimento';

        return view('procedimento.index', $_dados);
    }

    //Filtrar Convenio
    public function filtrar(Request $request){
        $request->all();
        session(['filtro_procedimento_nome' => $request->procedimento_nome]);

        return redirect()->route('procedimento');
    }

    //Limpar Filtro
    public function limpar_filtro(){
        session()->forget('filtro_procedimento_nome');
        return redirect()->route('procedimento');
    }

    public function editar(){
        $check_auth = checkAuthentication($this->class, 'index', 'Procedimentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');
        $_dados['convenio'] = $this->Procedimento_model->get_all_table('convenio', array('id' => $id))[0];
        $_dados['procedimentos'] = $this->Procedimento_model->get_all_table('convenio_procedimento', array('convenio_id' => $id, 'deletado' => '0'));

        $_dados['pagina'] = 'procedimento';

        return view('procedimento.editar', $_dados);
    }

    public function editar_salvar(Request $request){
        $check_auth = checkAuthentication($this->class, 'index', 'Procedimentos');
        if(!$check_auth){return redirect('/');}else if($check_auth === 'sp'){return redirect('/permissao_negada');}

        $id = request()->route('id');
        $procedimentos = $this->Procedimento_model->get_all_table('convenio_procedimento', array('convenio_id' => $id, 'deletado' => '0'));
        $procedimento_last_grupo_id = $this->Procedimento_model->get_grupos_procedimentos('convenio_procedimento', array('convenio_id' => $id))[0]['grupo_procedimento'];
        $insert = false;
        $update = false;
        $remove = false;
        $dados = $request->all();

        if($dados['deletado']){
            $deletados = explode(',', $dados['deletado']);
            foreach($deletados as $deletado){
                $remove = $this->Procedimento_model->update_table('convenio_procedimento', array('id' => $deletado), array('deletado' => '1'));
            }
        }

        foreach($dados['nome'] as $key => $dado){
            if(!isset($dados['id'][$key])){
                $i = $procedimento_last_grupo_id + 1;
                $procedimentos_insert = array(
                    'codigo' => $dados['codigo'][$key],
                    'nome' => $dados['nome'][$key],
                    'tempo' => $dados['tempo'][$key],
                    'valor' => str_replace(',', '.', $dados['valor'][$key]),
                    'grupo_procedimento' => $i,
                    'convenio_id' => $id
                );
                unset($dados['codigo'][$key]);
                unset($dados['nome'][$key]);
                unset($dados['tempo'][$key]);
                unset($dados['valor'][$key]);
                unset($dados['id'][$key]);

                $insert = $this->Procedimento_model->insert_dados('convenio_procedimento', $procedimentos_insert);
                $i++;
            }
        }

        if($procedimentos){
            foreach($procedimentos as $key => $procedimento){
                $update = false;
                foreach($dados['id'] as $key_d => $dado){
                    if($dados['id'][$key_d] == $procedimento['id']){
                        if($dados['codigo'][$key_d] != $procedimento['codigo']){
                            $update = true;
                        }

                        if($dados['nome'][$key_d] != $procedimento['nome']){
                            $update = true;
                        }

                        if($dados['tempo'][$key_d].':00' != $procedimento['tempo']){
                            $update = true;
                        }

                        if(str_replace(',', '.', $dados['valor'][$key_d]) != $procedimento['valor']){
                            $update = true;
                        }

                        if($update){
                            $this->Procedimento_model->update_table('convenio_procedimento', array('id' => $procedimento['id']), array('deletado' => '1'));

                            $dados_insert = array(
                                'codigo' => $dados['codigo'][$key_d],
                                'nome' => $dados['nome'][$key_d],
                                'tempo' => $dados['tempo'][$key_d],
                                'valor' => str_replace(',', '.', $dados['valor'][$key_d]),
                                'grupo_procedimento' => $procedimento['grupo_procedimento'],
                                'convenio_id' => $procedimento['convenio_id'],
                            );
                            $insert = $this->Procedimento_model->insert_dados('convenio_procedimento', $dados_insert);
                        }
                    }
                }
            }
        }else{
            $i = 1;
            if($dados){
                foreach($dados['nome'] as $key => $dado){
                    $procedimentos = array(
                        'codigo' => $dados['codigo'][$key],
                        'nome' => $dados['nome'][$key],
                        'tempo' => $dados['tempo'][$key],
                        'valor' => str_replace(',', '.', $dados['valor'][$key]),
                        'grupo_procedimento' => $i,
                        'convenio_id' => $id
                    );

                    $insert = $this->Procedimento_model->insert_dados('convenio_procedimento', $procedimentos);
                    $i++;
                }
            }
        }

        if($insert || $update || $remove){
            session(['tipo_mensagem' => 'success']);
            session(['mensagem' => 'Procedimentos cadastrado com sucesso!']);
        }else{
            session(['tipo_mensagem' => 'danger']);
            session(['mensagem' => 'Houve um erro ao salvar o procedimentos. Entre em contato com o suporte.']);
        }
        return redirect()->route('editar_procedimento', ['id' => $id]);
    }

    public function busca_procedimento_by_nome_and_convenio(Request $request){
        $nome = $request->input('nome');
        $convenio_id = $request->input('convenio_id');

        $registros = $this->Procedimento_model->busca_procedimento_by_nome_and_convenio($nome, $convenio_id);

        echo json_encode($registros);
    }
}
