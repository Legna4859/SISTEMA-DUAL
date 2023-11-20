<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudProgramas extends Model
{
    //
    use SoftDeletes;
    protected $table = "aud_programa";
    protected $primaryKey = "id_programa";
    protected $fillable = ["fecha_i", "fecha_f", "lugar", "alcance", "objetivo", "metodos", "responsabilidades","recursos","requisitos","criterios"];
}
