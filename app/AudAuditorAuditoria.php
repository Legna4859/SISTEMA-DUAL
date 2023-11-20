<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAuditorAuditoria extends Model
{
    //
    protected $table='aud_auditor_auditoria';
    protected $primaryKey='id_auditor_auditoria';
    protected $fillable=['id_auditoria','id_personal','id_categoria'];
    //
    public function getName(){
        return $this->hasOne('App\GnralPersonales','id_personal','id_personal');
    }
    public function getAbr(){
        return $this->hasOne('App\Abreviaciones_prof','id_personal','id_personal');
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
