<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AudValidarAgenda extends Model
{
    //
    static $horas_ocupadas=[];
    public static function checkRespons($people, $areas){
        $check=false;
        foreach ($people as $responsable) {
            foreach ($areas as $area){
                $jefe_area=GnralJefeUnidadAdministrativa::where('id_unidad_admin',$area)->select('id_personal')->get();
                $auditor=Gnral_Personales::join('aud_auditor_auditoria','aud_auditor_auditoria.id_personal','=','gnral_personales.id_personal')
                    ->where('aud_auditor_auditoria.id_auditor_auditoria','=',$responsable)
                    ->select('gnral_personales.id_personal')
                    ->get();
                if (sizeof($auditor)>0)
                    if ($jefe_area[0]->id_personal==$auditor[0]->id_personal)
                        $check=true;
            }
        }
        return $check;
    }
    public static function checkAvailability($people, $areas, $date, $evento){
        foreach ($people as $responsable){
            if ($evento!=0)
                $agendaAud=AudAgenda::join('aud_agenda_auditor','aud_agenda.id_agenda','=','aud_agenda_auditor.id_agenda')
                    ->where('aud_agenda_auditor.id_auditor_auditoria',$responsable)
                    ->where('aud_agenda.id_agenda','<>',$evento)
                    ->where('aud_agenda.fecha',$date)
                    ->get();
            else
                $agendaAud=AudAgenda::join('aud_agenda_auditor','aud_agenda.id_agenda','=','aud_agenda_auditor.id_agenda')
                    ->where('aud_agenda_auditor.id_auditor_auditoria',$responsable)
                    ->where('aud_agenda.fecha',$date)
                    ->get();
            foreach ($agendaAud as $agenda) {
                self::generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
            }
        }
        foreach ($areas as $area){
            if ($evento!=0)
                $agendaArea=AudAgenda::join('aud_agenda_area','aud_agenda.id_agenda','=','aud_agenda_area.id_agenda')
                    ->where('aud_agenda.id_agenda','<>',$evento)
                    ->where('aud_agenda_area.id_area',$area)
                    ->where('aud_agenda.fecha',$date)
                    ->get();
            else
                $agendaArea=AudAgenda::join('aud_agenda_area','aud_agenda.id_agenda','=','aud_agenda_area.id_agenda')
                    ->where('aud_agenda_area.id_area',$area)
                    ->where('aud_agenda.fecha',$date)
                    ->get();
            foreach ($agendaArea as $agenda) {
               self::generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
            }
        }
        if ($evento!=0)
            $agendaTareas=AudAgendaActividad::where('id_agenda_actividad','<>',$evento)
                ->where('fecha',$date)
                ->get();
        else
            $agendaTareas=AudAgendaActividad::where('fecha',$date)->get();

        foreach ($agendaTareas as $agenda) {
            self::generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
        }
        return self::$horas_ocupadas;
    }
    public static function checkInvolved($elementos){
        $areas=[];
        foreach ($elementos as $elemento){
            $area=AudAreaGeneral::join('aud_area_general_unidad','aud_area_general_unidad.id_area_general','=','aud_area_general.id_area_general')
                ->where('aud_area_general.id_area_general',$elemento)
                ->select('aud_area_general_unidad.id_unidad_admin')
                ->get();
            foreach ($area as $item){
                array_push($areas,$item->id_unidad_admin);
            }
        }
        return $areas;
    }
    public static function checkEnd($people, $areas, $date, $start){
        foreach ($people as $responsable) {
            $agendaAud = AudAgenda::join('aud_agenda_auditor','aud_agenda.id_agenda','=','aud_agenda_auditor.id_agenda')
                ->where('aud_agenda_auditor.id_auditor_auditoria',$responsable)
                ->where('aud_agenda.fecha', $date)
                ->where('aud_agenda.hora_i', '>', $start)
                ->orderBy('aud_agenda.hora_i', 'ASC')
                ->get();
            foreach ($agendaAud as $agenda) {
                self::generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
            }
        }

        foreach ($areas as $area){
            $agendaArea=AudAgenda::join('aud_agenda_area','aud_agenda.id_agenda','=','aud_agenda_area.id_agenda')
                ->where('aud_agenda.hora_i','>',$start)
                ->where('aud_agenda_area.id_area',$area)
                ->where('aud_agenda.fecha',$date)
                ->get();
            foreach ($agendaArea as $agenda) {
                self::generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
            }
        }
        return self::$horas_ocupadas;
    }
    public static function generateRange($start, $end){
        self::$horas_ocupadas=[];
        self::generateTimeRange(Carbon::parse($start),Carbon::parse($end));
        return self::$horas_ocupadas;
    }
    public static function generateTimeRange(Carbon $start_hour, Carbon $end_hour) {
        for($hour = $start_hour; $hour->lte($end_hour); $hour->addMinute('30')) {
            self::$horas_ocupadas[]=$hour->format('H').':'.$hour->format('i');
        }
    }

    public static function resolveResponsibles($responsibles,$date){
      //  dd($responsibles);
        if (sizeof($responsibles[0]->especificos)>0)
            return $responsibles[0]->especificos;
        else{
            $personas=[];
            foreach ($responsibles[0]->generales as $grupo){
                $responsables=AudPersonalGeneral::join('aud_personal_general_persona','aud_personal_general.id_personal_general','=','aud_personal_general_persona.id_personal_general')
                    ->where('aud_personal_general.id_personal_general',$grupo)
                    ->select('aud_personal_general_persona.id_personal')
                    ->get();
                //dd($responsables);
                foreach ($responsables as $responsable){
                    //dd($responsable);
                    array_push($personas,$responsable->id_personal);
                }
            }
            $people=AudAgenda::join('aud_auditoria','aud_agenda.id_auditoria','=','aud_auditoria.id_auditoria')
                ->join('aud_auditor_auditoria','aud_auditoria.id_auditoria','=','aud_auditor_auditoria.id_auditoria')
                ->where('aud_agenda.fecha',$date)
                ->get()
                ->pluck('id_auditor_auditoria')
                ->toArray();
         //   return $personas;

            //  dd($people);
            $coincidencias=array_intersect($personas,$people);
            if (sizeof($coincidencias)>0)
                return $personas;
            else
                return $people;
        }
    }

    public static function resolveAreas($areas){
        if (sizeof($areas[0]->especificos)>0)
            return $areas[0]->especificos;
        else{
            $array_resolve=[];
            foreach ($areas[0]->generales as $area) {
                $resolve=AudAreaGeneral::join('aud_area_general_unidad','aud_area_general.id_area_general','=','aud_area_general_unidad.id_area_general')
                    ->where('aud_area_general.id_area_general',$area)
                    ->select('aud_area_general_unidad.id_unidad_admin')
                    ->get();
                foreach ($resolve as $area){
                    array_push($array_resolve, $area->id_unidad_admin);
                }
            }
            return $array_resolve;
        }
    }

}
