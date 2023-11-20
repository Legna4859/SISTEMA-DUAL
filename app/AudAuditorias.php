<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AudAuditorias extends Model
{
    //
    use SoftDeletes;
    protected $table = "aud_auditoria";
    protected $primaryKey = "id_auditoria";
    protected $fillable = ["objetivo", "alcance", "criterio", "fecha_i", "fecha_f","id_programa"];

    public function getProcesos(){
        return $this->hasMany('App\AudAuditoriaProceso','id_auditoria','id_auditoria');
    }

    public function getData($id){
        return $datos=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso','aud_auditoria_proceso.observacion')
            ->orderBy('ri_proceso.clave','ASC')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();
    }
    public static function getAuditores($id,$tipo){
        return DB::select("SELECT av.titulo, p.nombre FROM aud_auditor_auditoria aa INNER JOIN aud_auditoria a on a.id_auditoria = aa.id_auditoria INNER JOIN aud_programa pr on pr.id_programa = a.id_programa INNER JOIN gnral_personales p on p.id_personal = aa.id_personal INNER JOIN abreviaciones_prof ap on ap.id_personal = p.id_personal INNER JOIN abreviaciones av on av.id_abreviacion = ap.id_abreviacion WHERE a.id_auditoria= ".$id." AND aa.id_categoria = ".$tipo." ORDER BY p.sexo, p.nombre");
    }
}
