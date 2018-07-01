<?php

namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Authenticatable
{ 
    protected $table = 'karyawan';
    protected $guarded = [];
    protected $hidden = ['password','remember_token'];
	public $timestamps = false;
	
    public function cuti(){
    	return $this->hasMany('App\Models\Cuti');
    }
}
