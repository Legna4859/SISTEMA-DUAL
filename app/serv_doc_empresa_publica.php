<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class serv_doc_empresa_publica extends Model
{
    protected $table = 'serv_doc_empresa_publica';
    protected $primaryKey='id_empresa_publica';
    protected $fillable=['est_curp','coment_curp','est_carnet','coment_carnet',
        'est_constancia_creditos','coment_constancia_creditos','est_solicitud_reg_autorizacion',
        'coment_solicitud_reg_autorizacion','id_periodo','id_alumno','id_estado_documentacion'];
}
