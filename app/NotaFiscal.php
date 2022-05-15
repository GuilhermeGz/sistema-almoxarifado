<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notaFiscal extends Model
{
    public function itemMovimentos()
    {
        $this->hasMany('App\itemMovimento');
    }

    public function materiais()
    {
       return $this->belongsToMany('App\Material', 'material_notas');
    }

}