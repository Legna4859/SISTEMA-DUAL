<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAgendaActividadArea extends Model
{
    //
    protected $table = 'aud_agenda_actividad_area';
    protected $primaryKey='id_agenda_actividad_area';
    protected $fillable=['id_agenda_actividad','id_area'];
}
