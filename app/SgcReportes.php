<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcReportes extends Model
{
    //
    protected $table = 'aud_reportes';
    protected $primaryKey='id_reporte';
    protected $fillable=['id_agenda','id_auditado','fecha','auditado'];
    public function getAgenda(){
        return $this->belongsTo('App\SgcAgenda','id_agenda','id_agenda');
    }
}
