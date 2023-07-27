<?php
namespace App\Modules\Agenda\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agenda_db_model extends Model {
    protected $table = 'usuario';
    protected $connection = 'mysql';

    function get_all_usuarios($where = null){
        $this->setTable('usuario');
        return $this->get()->toArray();
    }
}
