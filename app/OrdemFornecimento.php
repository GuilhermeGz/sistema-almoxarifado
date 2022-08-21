<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdemFornecimento extends Model
{
    use SoftDeletes;

    protected $fillable = ['contrato','pregao','codigo'];

    public function notas_fiscais(){
        return $this->hasMany('App\NotaFiscal');
    }
}
