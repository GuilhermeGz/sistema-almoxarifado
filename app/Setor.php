<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $fillable = ['nome'];

    public function estoques(){
        return $this->belongsToMany('App\Estoque');
    }

    public function unidade(){
        return $this->hasMany('App\Unidade');
    }
}
