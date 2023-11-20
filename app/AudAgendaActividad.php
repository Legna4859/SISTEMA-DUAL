<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAgendaActividad extends Model
{
    //
    protected $table = 'aud_agenda_actividad';
    protected $primaryKey='id_agenda_actividad';
    protected $fillable=['id_actividad','id_auditoria','fecha','hora_i','hora_f'];
}
