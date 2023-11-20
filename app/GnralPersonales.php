<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GnralPersonales extends Model
{
    protected $table = 'gnral_personales';
    protected $primaryKey='id_personal';
    protected $fillable=['nombre','fch_nac'];
    public function getAbrPer(){
        return $this->hasMany('App\Abreviaciones_prof','id_personal', 'id_personal');
    }
}
