<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AudAgenda extends Model
{
    //
    protected $table = 'aud_agenda';
    protected $primaryKey='id_agenda';
    protected $fillable=['fecha','id_auditoria','hora_i','hora_f', 'criterios'];
    public function getAsign(){
        return $this->hasOne('App\SgcAsignaAudi','id_asigna_audi','id_asigna_audi');
    }
    public function getNombre(){
        return $this->hasMany('App\GnralPersonales','id_personal','id_auditor');
    }
    public function getAbrPer(){
        return $this->hasMany('App\Abreviaciones_prof','id_personal', 'id_auditor');
    }
    public function area(){
        return $this->hasMany('App\gnral_unidad_administrativa','id_unidad_admin','id_area');
    }


    public static function getProcesos($id){
        return DB::select("SELECT DISTINCT p.des_proceso as proceso FROM aud_agenda ag INNER JOIN aud_agenda_evento age on ag.id_agenda = age.id_agenda INNER JOIN aud_auditoria_proceso ap on ap.id_auditoria_proceso = age.id_auditoria_proceso INNER JOIN ri_proceso p on p.id_proceso = ap.id_proceso WHERE ag.id_agenda = ".$id." order by p.des_proceso asc");
    }
    public static function getAuditores($id){
        return DB::select("SELECT DISTINCT aa.id_categoria, av.titulo, p.nombre FROM aud_agenda ag INNER JOIN aud_agenda_evento age on ag.id_agenda = age.id_agenda INNER JOIN aud_auditor_auditoria aa on aa.id_auditor_auditoria = age.id_auditor_auditoria INNER JOIN gnral_personales p on p.id_personal = aa.id_personal INNER JOIN abreviaciones_prof ap on ap.id_personal = p.id_personal INNER JOIN abreviaciones av on av.id_abreviacion = ap.id_abreviacion WHERE ag.id_agenda = ".$id." order by aa.id_categoria, p,sexo, p.nombre");
    }
    public static function getAuditoresPlan($id){

    }


//SELECT DISTINCT av.titulo, p.nombre
//FROM aud_agenda ag
//INNER JOIN aud_agenda_evento age on ag.id_agenda = age.id_agenda
//INNER JOIN aud_auditor_auditoria aa on aa.id_auditor_auditoria = age.id_auditor_auditoria
//INNER JOIN gnral_personales p on p.id_personal = aa.id_personal
//INNER JOIN abreviaciones_prof ap on ap.id_personal = p.id_personal
//INNER JOIN abreviaciones av on av.id_abreviacion = ap.id_abreviacion
//WHERE ag.id_agenda = 54
}
