<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcPrograma extends Model
{
    protected $table = "aud_programa";
    protected $primaryKey = "id_programa";
    protected $fillable = ["fecha_i", "fecha_f", "lugar", "alcance", "metodos", "responsabilidades"];
    //
}
