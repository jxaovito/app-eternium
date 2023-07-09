<?php
namespace App\Modules\Login\Models;

use Illuminate\Database\Eloquent\Model;

class Login_model extends Model{
	protected $table = 'usuario';

	public function get_all_table($table, $email){
		$this->setTable($table);
		return $this->where('email', $email)
					->first();
	}
}