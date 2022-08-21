<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaFiscal extends Model
{
    public function itemMovimentos()
    {
        $this->hasMany('App\itemMovimento');
    }

    public function materiais()
    {
       return $this->belongsToMany('App\Material', 'material_notas');
    }

    public function emitente(){
        return $this->belongsTo('App\Emitente');
    }

    public function ordem_fornecimento(){
        return $this->belongsTo('App\OrdemFornecimento');
    }

    public static $rules = [

        'numero' => 'unique:nota_fiscals',

    ];

    public static $messages = [
        'numero.unique' => 'O numero da nota fiscal já está sendo utilizado!',
    ];

}
