<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcAsignaAudi extends Model
{
    protected $table = 'aud_asigna_audi';
    protected $primaryKey='id_asigna_audi';
    protected $fillable=['id_auditoria','id_auditor','id_categoria'];
    public function getNombre(){
        return $this->hasMany('App\GnralPersonales','id_personal','id_auditor');
    }
    public function getAbrPer(){
        return $this->hasMany('App\Abreviaciones_prof','id_personal', 'id_auditor');
    }
    public function getAgenda(){
        return $this->hasMany('App\SgcAgenda','id_asigna_audi','id_asigna_audi');
    }
    public function getAsign(){
        return $this->hasOne('App\SgcAsignaAudi','id_asigna_audi','id_asigna_audi');
    }
    public function getAuditoria(){
        return $this->hasOne('App\SgcAuditorias','id_auditoria','id_auditoria');
    }
}
