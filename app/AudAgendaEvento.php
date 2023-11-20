<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAgendaEvento extends Model
{
    protected $table = 'aud_agenda_evento';
    protected $primaryKey='id_agenda_evento';
    protected $fillable=['id_agenda','id_auditoria_proceso','id_auditor_auditoria'];
}
