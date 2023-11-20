<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAgendaAuditor extends Model
{
    //
    protected $table = 'aud_agenda_auditor';
    protected $primaryKey='id_agenda_auditor';
    protected $fillable=['id_agenda','id_auditor_auditoria'];
}
