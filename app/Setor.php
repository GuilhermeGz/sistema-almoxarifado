<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setor extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome'];

    public function estoques(){
        return $this->hasMany('App\Estoque');
    }

    public function unidade(){
        return $this->hasMany('App\Unidade');
    }
}
