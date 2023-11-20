<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudAgendaArea extends Model
{
    //
    protected $table = 'aud_agenda_area';
    protected $primaryKey='id_agenda_area';
    protected $fillable=['id_agenda','id_area'];
}
