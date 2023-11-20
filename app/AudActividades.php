<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AudActividades extends Model
{
    use SoftDeletes;
    protected $table = 'aud_actividad';
    protected $primaryKey='id_actividad';
    protected $fillable=['descripcion','responsable','area'];
}
