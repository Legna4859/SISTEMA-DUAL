<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcReporteAuditoria extends Model
{
    protected $table = "aud_informe";
    protected $primaryKey = "id_informe";
    protected $fillable = ["contenido", "fecha", "id_programa"];
    //
}
