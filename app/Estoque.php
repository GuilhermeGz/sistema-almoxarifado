<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estoque extends Model
{
    use SoftDeletes;
    protected $table = 'estoques';
    protected $fillable = ['material_id', 'deposito_id', 'setor_id','quantidade', 'codigo'];

    public function setor(){
        return $this->hasOne('App\Setor');
    }

}
