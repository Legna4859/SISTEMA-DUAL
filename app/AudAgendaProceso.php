<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAgendaProceso extends Model
{
    //
    protected $table = 'aud_agenda_proceso';
    protected $primaryKey='id_agenda_proceso';
    protected $fillable=['id_agenda','id_auditoria_proceso'];
}
