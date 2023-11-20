<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudPersonalGeneral extends Model
{
    //
    protected $table = 'aud_personal_general';
    protected $primaryKey='id_personal_general';
    protected $fillable=['descripcion'];
}
