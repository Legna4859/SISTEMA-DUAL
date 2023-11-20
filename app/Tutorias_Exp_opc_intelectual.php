<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_opc_intelectual extends Model
{
    protected $table ="exp_opc_intelectual";
    protected $primaryKey="id_opc_intelectual";
    protected $fillable=["desc_opc"];
}
