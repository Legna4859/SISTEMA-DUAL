<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudAuditoriaProceso extends Model
{
    //
    use SoftDeletes;
    protected $table = "aud_auditoria_proceso";
    protected $primaryKey = "id_auditoria_proceso";
    protected $fillable = ["id_auditoria", "id_proceso","observacion"];
    public function getProceso(){
        return $this->hasMany('App\ri_proceso','id_proceso','id_proceso')->orderBy('des_proceso');
    }
    public function getProcesos(){
        return $this->belongsTo('App\ri_proceso','id_proceso','id_proceso');
    }
}
