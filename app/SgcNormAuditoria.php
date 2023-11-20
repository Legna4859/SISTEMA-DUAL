<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcNormAuditoria extends Model
{
    //
    protected $table = 'aud_normatividad_auditoria';
    protected $primaryKey='id_normatividad_auditoria';
    protected $fillable=['id_normatividad','id_auditoria'];
    public function getCriterio(){
        return $this->hasMany('App\SgcNormatividad','id_normatividad','id_normatividad');
    }
}
