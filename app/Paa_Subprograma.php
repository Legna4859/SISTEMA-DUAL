<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paa_Subprograma extends Model
{
    protected $table='pa_subprograma';
    protected $primaryKey='id_subprograma';
    protected $fillable=['nom_subprograma'];
}
