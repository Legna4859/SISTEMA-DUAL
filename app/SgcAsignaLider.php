<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SgcAsignaLider extends Model
{
    //
    protected $table = 'aud_asigna_audi';
    protected $primaryKey='id_asigna_audi';
    protected $fillable=['id_auditoria','id_auditor','id_categoria'];
}
