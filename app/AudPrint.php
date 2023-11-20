<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AudPrint extends Model
{
    //

    public static function getDataProgram($id){
        $data=new Collection();
        $auditorias=AudAuditorias::orderBy('fecha_i')->where('id_programa',$id)->select('id_auditoria','fecha_i','fecha_f')->get();

        $procesos=ri_proceso::orderBy('clave')->orderBy('des_proceso')->get();
        $procesos->map(function ($value) use ($auditorias,$id){
            $observacion=[];
            $fechas=[];
            foreach ($auditorias as $auditoria){
                $result=AudAuditoriaProceso::join('aud_auditoria','aud_auditoria.id_auditoria','=','aud_auditoria_proceso.id_auditoria')
                    ->join('aud_programa','aud_programa.id_programa','=','aud_auditoria.id_programa')
                    ->where("aud_auditoria.id_auditoria",$auditoria->id_auditoria)
                    ->where('aud_auditoria_proceso.id_proceso',$value->id_proceso)
                    ->where('aud_programa.id_programa',$id)
                    ->where('aud_auditoria.fecha_i','<=',$auditoria->fecha_i)
                    ->where('aud_auditoria.fecha_f','>=',$auditoria->fecha_f)
                    ->select('aud_auditoria.fecha_i','aud_auditoria_proceso.observacion');
                if ($result->count()>0){
                    $result_get=$result->get()[0];
                    array_push($fechas,"X");
                    if (isset($result_get->observacion))
                        if (strlen($result_get->observacion)>=1)
                            array_push($observacion,$result_get->observacion);
                }
                else{
                    array_push($fechas,"");
                }
            }
            $value['fechas']=$fechas;
            $value['observaciones']=implode(', ',$observacion);
            return $value;
        });

        $data->auditorias=$auditorias;
        $data->procesos=$procesos;
        $data->programa=AudProgramas::find($id);
        return $data;
    }

    public static function getFirmaPrograma($persona){
        if ($persona==1)
            $dato=DB::table('aud_auditores')
                ->where('aud_auditores.id_categoria','=',1)
                ->join('gnral_personales','gnral_personales.id_personal','=','aud_auditores.id_personal')
                ->join('abreviaciones_prof','gnral_personales.id_personal','=','abreviaciones_prof.id_personal')
                ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
                ->select('abreviaciones.titulo','gnral_personales.nombre')
                ->get();
        else if ($persona==2)
            $dato=DB::table('gnral_unidad_administrativa')
                ->where('gnral_unidad_administrativa.id_unidad_admin','=',1)
                ->join('gnral_unidad_personal','gnral_unidad_administrativa.id_unidad_admin','=','gnral_unidad_personal.id_unidad_admin')
                ->join('gnral_personales','gnral_personales.id_personal','=','gnral_unidad_personal.id_personal')
                ->join('abreviaciones_prof','gnral_personales.id_personal','=','abreviaciones_prof.id_personal')
                ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
                ->select('abreviaciones.titulo','gnral_personales.nombre')
                ->get();
        else if ($persona==3)
            $dato=DB::table('gnral_unidad_administrativa')
                ->where('gnral_unidad_administrativa.id_unidad_admin','=',3)
                ->join('gnral_unidad_personal','gnral_unidad_administrativa.id_unidad_admin','=','gnral_unidad_personal.id_unidad_admin')
                ->join('gnral_personales','gnral_personales.id_personal','=','gnral_unidad_personal.id_personal')
                ->join('abreviaciones_prof','gnral_personales.id_personal','=','abreviaciones_prof.id_personal')
                ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
                ->select('abreviaciones.titulo','gnral_personales.nombre')
                ->get();
        return $dato[0];
    }
    public static function getNoRows($input,$noChars){
        $rows=0;
        $sub_input=explode(PHP_EOL,$input);
        if (sizeof($sub_input)>1)
            for ($i=0;$i<sizeof($sub_input);$i++){
                if (strlen($sub_input[$i])>$noChars){
                    $rows+=(floor(strlen($sub_input[$i])/$noChars));
                }
                else{
                    $rows++;
                }
            }
        else
            $rows=ceil(strlen($input)/$noChars);
        return $rows*15;
    }
    public static function getNoRowsArray($input,$noChars){
        $mayor=0;
        for ($a=0;$a<sizeof($input);$a++){
            $rows=0;
            $sub_input=explode(PHP_EOL,$input[$a]);
            if (sizeof($sub_input)>1)
                for ($i=0;$i<sizeof($sub_input);$i++){
                    if (strlen($sub_input[$i])>$noChars){
                        $rows+=(floor(strlen($sub_input[$i])/$noChars));
                    }
                    else{
                        $rows++;
                    }
                }
            else
                $rows=ceil(strlen($input[$a])/$noChars);
            if ($rows>$mayor)
                $mayor=$rows;
        }
        return $mayor*15;
    }
    public static function getNoRowsArrayTable($input,$noChars){
        $mayor=0;
        for ($a=0;$a<sizeof($input);$a++){
            $rows=ceil(strlen($input[$a])/$noChars[$a]);
            if ($rows>$mayor)
                $mayor=$rows;
        }
        return $mayor*15;
    }
    public static function getNoRowsArrayFirms($input,$noChars){
        $mayor=0;
        for ($a=0;$a<sizeof($input);$a++){
            $rows=0;
            $sub_input=explode(PHP_EOL,$input[$a]);
            if (sizeof($sub_input)>1)
                for ($i=0;$i<sizeof($sub_input);$i++){
                    if (strlen($sub_input[$i])>$noChars){
                        $rows+=(ceil(strlen($sub_input[$i])/$noChars));
                    }
                    else{
                        $rows++;
                    }
                }
            else
                $rows=ceil(strlen($input[$a])/$noChars);
            if ($rows>$mayor)
                $mayor=$rows;
        }
        return $mayor*15;
    }
}
