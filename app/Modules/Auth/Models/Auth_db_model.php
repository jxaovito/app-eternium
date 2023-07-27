<?php
namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auth_db_model extends Model {
    protected $table = 'usuario';
    protected $connection = 'mysql';

    public function get_all_table($table, $email){
		$this->setTable($table);
		return $this->where('email', $email)
					->first();
	}
}
