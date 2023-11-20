<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class serv_doc_empresa_privada extends Model
{
    protected $table = 'serv_doc_empresa_privada';
    protected $primaryKey='id_empresa_privada';
    protected $fillable=['id_alumno','id_periodo','est_carta_aceptacion','coment_carta_aceptacion',
        'est_anexo_tecnico','coment_anexo_tecnico','est_curp','coment_curp','est_carnet','coment_carnet',
        'est_constancia_creditos','coment_costancia_creditos','est_solicitud_reg_autori','coment_solicitud_reg_autori',
        'id_estado_documentacion'];
}
