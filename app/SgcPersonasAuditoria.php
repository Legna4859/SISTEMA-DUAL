<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcPersonasAuditoria extends Model
{
    protected $table='aud_personas_auditoria';
    protected $primaryKey='id_personas_auditoria';
    protected $fillable=['id_personal','id_categoria'];
    //
    public function getName(){
        return $this->hasOne('App\GnralPersonales','id_personal','id_personal');
    }
    public function getAbr(){
        return $this->hasOne('App\Abreviaciones_prof','id_personal','id_personal');
    }
}
