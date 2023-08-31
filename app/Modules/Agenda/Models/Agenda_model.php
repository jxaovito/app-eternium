<?php
namespace App\Modules\Agenda\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agenda_model extends Model {
    protected $table = 'agenda';
    protected $connection = 'mysql_db';

    function get_all_table($table, $where = null){
        $this->setTable($table);
    
        if($where){
            return $this->where($where)->get()->toArray();
        }
    
        return $this->get()->toArray();
    }

    function delete_dados($table, $where){
        $this->setTable($table);
        
        return $this->where($where)->delete();
    }

    function insert_dados($table, $dados){
        $this->setTable($table);
    
        return $this->insertGetId($dados);
    }

    function update_table($table, $where, $dados){
        $this->setTable($table);
    
        return DB::table($this->table)
        ->where($where)
        ->update($dados);;
    }

    function get_profissionais(){
        return $this->setTable('profissional as p')
             ->select('p.id', 'p.nome', 'u.imagem')
             ->join('usuario as u', function($join){
                $join->on('u.id', '=', 'p.usuario_id');
             })
             ->where('u.deletado', '=', '0')
             ->get()
             ->toArray();
    }

    function get_especialidade_by_profissional_id($id){
        return $this->setTable('especialidade as e')
                    ->select('e.id as especialidade_id', 'e.nome as especialidade', 'pr.id as profissional_id', 'e.cor_fundo', 'e.cor_fonte')
                    ->join('especialidade_has_profissional as ehp', function($join){
                        $join->on('ehp.especialidade_id', '=', 'e.id');
                    })
                    ->join('profissional as pr', function($join){
                        $join->on('pr.id', '=', 'ehp.profissional_id');
                    })
                    ->where('pr.id', '=', $id)
                    ->where('e.deletado', '=', '0')
                    ->orderBy('e.nome', 'ASC')
                    ->groupBy('e.id')
                    ->get()
                    ->toArray();
    }
}
