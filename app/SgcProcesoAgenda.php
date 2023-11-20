<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcProcesoAgenda extends Model
{
    //
    protected $table = "aud_procesos_agenda";
    protected $primaryKey = "id_aud_procesos_agenda";
    protected $fillable = ["id_proceso","id_agenda"];
}
