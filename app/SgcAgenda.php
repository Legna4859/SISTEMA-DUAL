<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcAgenda extends Model
{
    protected $table = 'aud_agenda';
    protected $primaryKey='id_agenda';
    protected $fillable=['fecha','hora_i','hora_f','id_area','procesos','id_asigna_audi'];
    public function getAsign(){
        return $this->hasOne('App\SgcAsignaAudi','id_asigna_audi','id_asigna_audi');
    }
    public function getNombre(){
        return $this->hasMany('App\GnralPersonales','id_personal','id_auditor');
    }
    public function getAbrPer(){
        return $this->hasMany('App\Abreviaciones_prof','id_personal', 'id_auditor');
    }
    public function area(){
        return $this->hasMany('App\gnral_unidad_administrativa','id_unidad_admin','id_area');
    }
}
