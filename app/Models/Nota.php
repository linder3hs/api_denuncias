<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model 
{
    
    protected $table = 'notas';
    
	public $timestamps = false;
	
	public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuarios_id');
    }
	
}
