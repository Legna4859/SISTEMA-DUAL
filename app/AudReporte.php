<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudReporte extends Model
{
    protected $table = 'aud_reportes';
    protected $primaryKey='id_reporte';
    protected $fillable=['id_agenda','id_auditado'];
}
