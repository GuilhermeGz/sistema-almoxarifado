<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdemFornecimento extends Model
{
    protected $fillable = ['contrato','pregao','codigo'];

    public function notas_fiscais(){
        return $this->hasMany('App\NotaFiscal');
    }
}
