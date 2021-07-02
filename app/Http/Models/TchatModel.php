<?php
// JeCodeLeSoir

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TchatModel extends Model
{
	protected $table = 'Tchat';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'message'
	];
}