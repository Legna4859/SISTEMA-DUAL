<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudFortaleza extends Model
{
    //
    protected $table="aud_fortalezas";
    protected $primaryKey="id_fortaleza";
    protected $fillable=["punto_proceso", "descripcion_f", "id_informe"];

}
