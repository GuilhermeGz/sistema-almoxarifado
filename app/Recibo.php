<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    public function unidade()
    {
        return $this->belongsTo('App\Unidade', 'unidade_id');
    }
}
