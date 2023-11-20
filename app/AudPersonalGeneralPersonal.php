<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudPersonalGeneralPersonal extends Model
{
    //
    protected $table = 'aud_personal_general_persona';
    protected $primaryKey='id_personal_general_persona';
    protected $fillable=['id_personal_general','id_personal'];
}
