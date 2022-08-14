<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    public function solicitacao()
    {
        return $this->belongsTo('App\Unidade', 'unidade_id');
    }
}
