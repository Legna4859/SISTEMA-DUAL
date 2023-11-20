<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAgendaActividadPersona extends Model
{
    //
    protected $table = 'aud_agenda_actividad_persona';
    protected $primaryKey='id_agenda_actividad_persona';
    protected $fillable=['id_agenda_actividad','id_personal'];
}
