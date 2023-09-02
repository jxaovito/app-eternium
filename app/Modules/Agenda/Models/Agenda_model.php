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

    function get_agendamentos($data_inicio_agenda, $data_fim_agenda, $profissional_id){
        return $this->setTable('agenda as a')
                    ->select('a.id as agenda_id', 'a.data_inicio', 'a.hora_inicio', 'a.data_fim', 'a.hora_fim', 'a.sessao', 'a.observacoes', 'e.id AS especialidade_id', 't.id AS tratamento_id', 'e.cor_fundo', 'e.cor_fonte', 'p.nome AS paciente', 't.profissional_id', 't.sessoes_contratada', 'a.reserva', 'a.whatsapp', 'a.confirmacao')
                    ->leftJoin('tratamento as t', function($join){
                        $join->on('t.id', '=', 'a.tratamento_id');
                    })
                    ->leftJoin('paciente as p', function($join){
                        $join->on('p.id', '=', 't.paciente_id');
                    })
                    ->leftJoin('especialidade as e', function($join){
                        $join->on('e.id', '=', 't.especialidade_id');
                    })
                    ->whereBetween('data_inicio', [$data_inicio_agenda, $data_fim_agenda])
                    ->where('a.profissional_id', '=', $profissional_id)
                    ->get()
                    ->toArray();
    }

    function get_agendamentos_futuros($agenda_id, $data_inicio, $hora_inicio, $tratamento_id){
        return $this->setTable('agenda as a')
                    ->select('*')
                    ->where('a.id', '!=', $agenda_id)
                    ->where('a.data_inicio', '>=', $data_inicio)
                    ->where('a.hora_inicio', '>=', $hora_inicio)
                    ->where('a.tratamento_id', '=', $tratamento_id)
                    ->get()
                    ->toArray();
    }
}
