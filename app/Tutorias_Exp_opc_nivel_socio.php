<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_opc_nivel_socio extends Model
{
    protected $table ="exp_opc_nivel_socio";
    protected $primaryKey="id_nivel_economico";
    protected $fillable=["desc_opc"];
}
