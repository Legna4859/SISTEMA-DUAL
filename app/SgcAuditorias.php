<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcAuditorias extends Model
{
    protected $table = 'aud_auditoria';
    protected $primaryKey='id_auditoria';
    protected $fillable=['objetivo','alcance','criterios','fecha_i','fecha_f','id_programa'];
}
