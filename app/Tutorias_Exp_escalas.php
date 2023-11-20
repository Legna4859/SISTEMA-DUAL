<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Exp_escalas extends Model
{
    protected $table ="exp_escalas";
    protected $primaryKey="id_escala";
    public $timestamps = false;
    protected $fillable=["desc_escala"];
}
