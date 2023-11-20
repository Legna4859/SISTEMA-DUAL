<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudInforme extends Model
{
    //
    protected $table="aud_informe";
    protected $primaryKey="id_informe";
    protected $fillable=["id_auditoria","resumen","cierre","conclusiones"];

    public static function getPersonas($id)
    {
        $persona=collect([]);
        $persona->push(Gnral_Personales::join("gnral_unidad_personal","gnral_unidad_personal.id_personal","gnral_personales.id_personal")
            ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","gnral_unidad_personal.id_unidad_admin")
            ->where("gnral_unidad_administrativa.id_unidad_admin",3)
            ->select("nombre","jefe_descripcion")
            ->selectRaw("null as funciones")
            ->get()->first());

        $persona->push(Gnral_Personales::join("gnral_unidad_personal","gnral_unidad_personal.id_personal","gnral_personales.id_personal")
            ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","gnral_unidad_personal.id_unidad_admin")
            ->where("gnral_unidad_administrativa.id_unidad_admin",1)
            ->select("nombre","jefe_descripcion")
            ->selectRaw("'Y COORDINADOR(A) DEL SGC'as funciones")
            ->get()->first());
        $persona->push(Gnral_Personales::join("gnral_unidad_personal","gnral_unidad_personal.id_personal","gnral_personales.id_personal")
            ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","gnral_unidad_personal.id_unidad_admin")
            ->where("gnral_unidad_personal.id_personal",AudAuditorAuditoria::where('id_auditoria',$id)->where('id_categoria','1')->get()->first()->id_personal)
            ->select("nombre","jefe_descripcion")
            ->selectRaw("'Y AUDITOR LÍDER' as funciones")
            ->get()->first());

        $auditores=(Gnral_Personales::join("gnral_unidad_personal","gnral_unidad_personal.id_personal","gnral_personales.id_personal")
            ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","gnral_unidad_personal.id_unidad_admin")
            ->whereIn("gnral_unidad_personal.id_personal",AudAuditorAuditoria::where('id_auditoria',$id)->where('id_categoria','2')->get()->pluck('id_personal'))
            ->select("nombre","jefe_descripcion")
            ->selectRaw("'Y AUDITOR(A) DEL SGC' as funciones")
            ->get());

        foreach($auditores as $auditor)
            $persona->push($auditor);
        $auditados=AudAuditorAuditoria::join("aud_agenda_auditor","aud_agenda_auditor.id_auditor_auditoria","aud_auditor_auditoria.id_auditor_auditoria")
            ->join("aud_agenda","aud_agenda.id_agenda","aud_agenda_auditor.id_agenda")
            ->join("aud_agenda_area","aud_agenda_area.id_agenda","aud_agenda.id_agenda")
            ->join("aud_reportes","aud_reportes.id_agenda","aud_agenda.id_agenda")
            ->join("gnral_unidad_administrativa","aud_agenda_area.id_area","gnral_unidad_administrativa.id_unidad_admin")
            ->join("gnral_unidad_personal","gnral_unidad_personal.id_unidad_admin","gnral_unidad_administrativa.id_unidad_admin")
            ->join("gnral_personales","gnral_personales.id_personal","gnral_unidad_personal.id_personal")
            ->where('aud_auditor_auditoria.id_auditoria',$id)
            ->select("nombre","jefe_descripcion")
            ->selectRaw("null as funciones")
            ->distinct("nombre")
            ->get();
        return $persona->merge($auditados)->unique("nombre");
    }
    public static function getDatosInforme($idAuditoria, $idTipo)
    {
        return AudAgenda::where('id_auditoria',$idAuditoria)
            ->join("aud_reportes","aud_reportes.id_agenda","aud_agenda.id_agenda")
            ->join("aud_notas","aud_notas.id_reporte", "aud_reportes.id_reporte")
            ->where("aud_notas.id_clasificacion", $idTipo)
            ->where("aud_notas.autorizacion",1)
            ->select("aud_notas.resultado")
            ->selectRaw("TRIM(aud_notas.punto_proceso) as punto_proceso")
            ->orderByRaw("CAST(punto_proceso as unsigned)")
            ->orderBy("punto_proceso", "asc")
            //->select("aud_agenda.hora_i")
            //->join("aud_agenda_auditor","aud_agenda_auditor.id_auditor_auditoria","aud_auditor_auditoria.id_auditor_auditoria")
            // ->join("aud_agenda","aud_agenda.id_agenda","aud_agenda_auditor.id_agenda")

            ->get();
    }
    public static function getFortalezas($id)
    {
        return $fortalezas=AudFortaleza::join("aud_informe", "aud_informe.id_informe", "aud_fortalezas.id_informe")
            ->where("aud_informe.id_auditoria",$id)
            ->select("aud_fortalezas.*")
            ->get();
    }
}
