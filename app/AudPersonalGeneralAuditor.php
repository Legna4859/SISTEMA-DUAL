<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudPersonalGeneralAuditor extends Model
{
    //
    protected $table = 'aud_personal_general_auditor';
    protected $primaryKey='id_personal_general_auditor';
    protected $fillable=['id_personal_general','id_auditor_auditoria'];
}
