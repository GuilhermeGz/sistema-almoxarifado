<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emitente extends Model
{
    public function notasFiscais()
    {
        $this->hasMany('App\NotaFiscal');
    }

    public static $rules = [

        'cnpj' => 'unique:emitentes|min:18|max:18',

    ];

    public static $messages = [
        'cnpj.unique' => 'O cnpj já foi utilizado!',
        'cnpj.*' => 'O cnpj deve possuir exatamente 14 caracteres',
    ];
}
