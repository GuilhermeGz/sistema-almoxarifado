<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    public static $rules = [
        'descricao' => 'required|min:5|max:255',
        'operacao' => 'numeric',
    ];

    public static $messages = [
        'operacao.numeric' => 'Escolha uma operação valido.',
        'descricao.required' => 'A descrição é obrigatória',
        'descricao.min' => 'A descrição deve ter no mínimo 5 caracteres.',
        'descricao.max' => 'A descrição deve ter no máximo 255 caracteres.',
    ];

    public function itemMovimentos()
    {
        $this->hasMany('App\itemMovimento');
    }
}
