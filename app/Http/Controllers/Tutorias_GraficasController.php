<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;
class Tutorias_GraficasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function genero(Request $request)
    {
        ///ALUMNOS EXPEDIENTE LLENO

        $alumnos=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M") as M, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F") as F');
        $totalcontestaron=$alumnos[0]->M+$alumnos[0]->F;
        //dd($totalcontestaron);


        Session::put('total_alumnos',$totalcontestaron);
        Session::put('total_mujeres',$alumnos[0]->F);
        Session::put('total_hombres',$alumnos[0]->M);


        $total=$alumnos[0]->M+$alumnos[0]->F;

        if($alumnos[0]->M == 0 || $total == 0){
            $res_h=0;
        }
        else{
            $res_h=($alumnos[0]->M*100)/($total);
        }
        if($alumnos[0]->F == 0 || $total == 0){
            $res_m=0;
        }
        else{
            $res_m=($alumnos[0]->F*100)/($total);
        }

        return response()->json(
            [["name"=>"Hombres","y"=>round($res_h)],
                ["name"=>"Mujeres","y"=>round($res_m)]],200
        );
    }
    public function generales(Request $request)
    {
         ///ESTADO CIVIL///
        $estadogen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Soltero") as soltero, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Casado") as casado,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Unión libre") as unionlibre,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Divorciado") as divorsiado, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Viudo") as viudo');
        $estadoF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Soltero" and exp_generales.sexo="F") as soltero, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Casado" and exp_generales.sexo="F") as casado,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Unión libre" and exp_generales.sexo="F") as unionlibre,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Divorciado" and exp_generales.sexo="F") as divorsiado, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Viudo" and exp_generales.sexo="F") as viudo');
        $estadoM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Soltero" and exp_generales.sexo="M") as soltero, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Casado" and exp_generales.sexo="M") as casado,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Unión libre" and exp_generales.sexo="M") as unionlibre,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Divorciado" and exp_generales.sexo="M") as divorsiado, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_civil_estados.desc_ec="Viudo" and exp_generales.sexo="M") as viudo');

        $nivelgen=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.nivel_economico="A/B") as AB, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.nivel_economico="C+") as CC,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.nivel_economico="C") as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.nivel_economico="C-") as CCC, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.nivel_economico="D+") as DD, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.nivel_economico="D") as D,  (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.nivel_economico="E") as E');
        $nivelF=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.nivel_economico="A/B") as AB, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.nivel_economico="C+") as CC,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.nivel_economico="C") as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.nivel_economico="C-") as CCC, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.nivel_economico="D+") as DD, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.nivel_economico="D") as D,  (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.nivel_economico="E") as E');
        $nivelM=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.nivel_economico="A/B") as AB, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.nivel_economico="C+") as CC,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.nivel_economico="C") as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.nivel_economico="C-") as CCC, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.nivel_economico="D+") as DD, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.nivel_economico="D") as D,  (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.nivel_economico="E") as E');

        $trabajagen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.trabaja=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.trabaja=2) as NOO');
        $trabajaF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.trabaja=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.trabaja=2) as NOO');
        $trabajaM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.trabaja=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.trabaja=2) as NOO');

        $academicogen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.estado=1) as R, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.estado=2) as I, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.estado=3) as S, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.estado=4) as BJ, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.estado=5) as BD');
        $academicoF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.estado=1) as R, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.estado=2) as I, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.estado=3) as S, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.estado=4) as BJ, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.estado=5) as BD');
        $academicoM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.estado=1) as R, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.estado=2) as I, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.estado=3) as S, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.estado=4) as BJ, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.estado=5) as BD');

        $becagen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.beca=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.beca=2) as NOO');
        $becaF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.beca=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.beca=2) as NOO');
        $becaM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.beca=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.beca=2) as NOO');

        $tbecagen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.id_expbeca=1) as Ma, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.id_expbeca=2) as Be, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.id_expbeca=3) as Pe, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.id_expbeca=4) as Ea');
        $tbecaF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.id_expbeca=1) as Ma, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.id_expbeca=2) as Be, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.id_expbeca=3) as Pe, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.id_expbeca=4) as Ea');
        $tbecaM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.id_expbeca=1) as Ma, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.id_expbeca=2) as Be, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.id_expbeca=3) as Pe, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.id_expbeca=4) as Ea');

        $hijosgen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.no_hijos=1) as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.no_hijos=2) as U, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.no_hijos=3) as D, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.no_hijos=4) as T, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.no_hijos=5) as M');
        $hijosF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.no_hijos=1) as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.no_hijos=2) as U, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.no_hijos=3) as D, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.no_hijos=4) as T, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_generales.no_hijos=5) as M');
        $hijosM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.no_hijos=1) as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.no_hijos=2) as U, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.no_hijos=3) as D, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.no_hijos=4) as T, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_generales.no_hijos=5) as M');
        $alumnos=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M") as M, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F") as F');
        $totalcontestaron=$alumnos[0]->M+$alumnos[0]->F;
        $hombres=$alumnos[0]->M;
        $mujeres=$alumnos[0]->F;

        if($estadogen[0]->soltero == 0 || $totalcontestaron == 0){
            $estadogen_soltero=0;
        }
        else{
            $estadogen_soltero=($estadogen[0]->soltero)*100/$totalcontestaron;
        }
        if($estadogen[0]->casado == 0 || $totalcontestaron == 0){
            $estadogen_casado=0;
        }
        else{
            $estadogen_casado=($estadogen[0]->casado)*100/$totalcontestaron;
        }

        if($estadogen[0]->unionlibre == 0 || $totalcontestaron == 0){
            $estadogen_unionlibre=0;
        }
        else{
            $estadogen_unionlibre=($estadogen[0]->unionlibre)*100/$totalcontestaron;
        }
        if($estadogen[0]->divorsiado == 0 || $totalcontestaron == 0 ){
            $estadogen_divorsiado=0;
        }else{
            $estadogen_divorsiado=($estadogen[0]->divorsiado*100)/$totalcontestaron;
        }
        if($estadogen[0]->viudo == 0 || $totalcontestaron == 0){
            $estadogen_viudo=0;
        }else{
            $estadogen_viudo=($estadogen[0]->viudo*100)/$totalcontestaron;

        }
        //////////////////////////////
        if($estadoF[0]->soltero == 0 || $mujeres == 0){
            $estadoF_soltero=0;
        }else{
            $estadoF_soltero=($estadoF[0]->soltero*100)/$mujeres;
        }
        if($estadoF[0]->casado == 0 || $mujeres == 0){
            $estadoF_casado=0;
        }else{
            $estadoF_casado=($estadoF[0]->casado*100)/$mujeres;
        }
        if($estadoF[0]->unionlibre == 0 || $mujeres == 0 ){
            $estadoF_unionlibre=0;
        }else{
            $estadoF_unionlibre=($estadoF[0]->unionlibre*100)/$mujeres;
        }
        if($estadoF[0]->divorsiado == 0 || $mujeres == 0){
            $estadoF_divorsiado=0;
        }else{
            $estadoF_divorsiado=($estadoF[0]->divorsiado*100)/$mujeres;
        }
        if($estadoF[0]->viudo == 0 || $mujeres == 0){
            $estadoF_viudo=0;
        }else{
            $estadoF_viudo=($estadoF[0]->viudo*100)/$mujeres;
        }
        //////
        if($estadoM[0]->soltero == 0 || $hombres == 0 ){
            $estadoM_soltero=0;
        }else{
            $estadoM_soltero=($estadoM[0]->soltero*100)/$hombres;
        }
        if($estadoM[0]->casado == 0  || $hombres == 0){
            $estadoM_casado=0;
        }else{
            $estadoM_casado=($estadoM[0]->casado*100)/$hombres;
        }
        if($estadoM[0]->unionlibre == 0 || $hombres == 0){
            $estadoM_unionlibre=0;
        }else{
            $estadoM_unionlibre=($estadoM[0]->unionlibre*100)/$hombres;
        }
        if($estadoM[0]->divorsiado == 0 || $hombres == 0){
            $estadoM_divorsiado=0;
        }else{
            $estadoM_divorsiado=($estadoM[0]->divorsiado*100)/$hombres;
        }
        if($estadoM[0]->viudo == 0 || $hombres == 0){
            $estadoM_viudo=0;
        }else{
            $estadoM_viudo=($estadoM[0]->viudo*100)/$hombres;
        }
        //////////////////////
        if( $nivelgen[0]->E == 0 || $totalcontestaron== 0){
            $nivelgen_e=0;
        }else{
            $nivelgen_e=($nivelgen[0]->E*100)/$totalcontestaron;
        }
        if( $nivelgen[0]->D == 0 || $totalcontestaron== 0){
            $nivelgen_d=0;
        }else{
            $nivelgen_d=($nivelgen[0]->D*100)/$totalcontestaron;
        }
        if( $nivelgen[0]->DD == 0 || $totalcontestaron== 0){
            $nivelgen_dd=0;
        }else{
            $nivelgen_dd=($nivelgen[0]->DD*100)/$totalcontestaron;
        }
        if( $nivelgen[0]->CCC == 0 || $totalcontestaron== 0){
            $nivelgen_ccc=0;
        }else{
            $nivelgen_ccc=($nivelgen[0]->CCC*100)/$totalcontestaron;
        }
        if( $nivelgen[0]->C == 0 || $totalcontestaron== 0){
            $nivelgen_c=0;
        }else{
            $nivelgen_c=($nivelgen[0]->C*100)/$totalcontestaron;
        }
        if( $nivelgen[0]->CC == 0 || $totalcontestaron== 0){
            $nivelgen_cc=0;
        }else{
            $nivelgen_cc=($nivelgen[0]->CC*100)/$totalcontestaron;
        }
        if( $nivelgen[0]->AB == 0 || $totalcontestaron== 0){
            $nivelgen_ab=0;
        }else{
            $nivelgen_ab=($nivelgen[0]->AB*100)/$totalcontestaron;
        }
        //////////////////////
        if( $nivelF[0]->E == 0 || $mujeres== 0){
            $nivelF_e=0;
        }else{
            $nivelF_e=($nivelF[0]->E*100)/$mujeres;
        }
        if( $nivelF[0]->D == 0 || $mujeres== 0){
            $nivelF_d=0;
        }else{
            $nivelF_d=($nivelF[0]->D*100)/$mujeres;
        }
        if( $nivelF[0]->DD == 0 || $mujeres== 0){
            $nivelF_dd=0;
        }else{
            $nivelF_dd=($nivelF[0]->DD*100)/$mujeres;
        }
        if( $nivelF[0]->CCC == 0 || $mujeres== 0){
            $nivelF_ccc=0;
        }else{
            $nivelF_ccc=($nivelF[0]->CCC*100)/$mujeres;
        }
        if( $nivelF[0]->C == 0 || $mujeres== 0){
            $nivelF_c=0;
        }else{
            $nivelF_c=($nivelF[0]->C*100)/$mujeres;
        }
        if( $nivelF[0]->CC == 0 || $mujeres== 0){
            $nivelF_cc=0;
        }else{
            $nivelF_cc=($nivelF[0]->CC*100)/$mujeres;
        }
        if( $nivelF[0]->AB == 0 || $mujeres== 0){
            $nivelF_ab=0;
        }else{
            $nivelF_ab=($nivelF[0]->AB*100)/$mujeres;
        }
        //////////////////////
        if( $nivelM[0]->E == 0 || $hombres== 0){
            $nivelM_e=0;
        }else{
            $nivelM_e=($nivelM[0]->E*100)/$hombres;
        }
        if( $nivelM[0]->D == 0 || $hombres== 0){
            $nivelM_d=0;
        }else{
            $nivelM_d=($nivelM[0]->D*100)/$hombres;
        }
        if( $nivelM[0]->DD == 0 || $hombres== 0){
            $nivelM_dd=0;
        }else{
            $nivelM_dd=($nivelM[0]->DD*100)/$hombres;
        }
        if( $nivelM[0]->CCC == 0 || $hombres== 0){
            $nivelM_ccc=0;
        }else{
            $nivelM_ccc=($nivelM[0]->CCC*100)/$hombres;
        }
        if( $nivelM[0]->C == 0 || $hombres== 0){
            $nivelM_c=0;
        }else{
            $nivelM_c=($nivelM[0]->C*100)/$hombres;
        }
        if( $nivelM[0]->CC == 0 || $hombres== 0){
            $nivelM_cc=0;
        }else{
            $nivelM_cc=($nivelM[0]->CC*100)/$hombres;
        }
        if( $nivelM[0]->AB == 0 || $hombres== 0){
            $nivelM_ab=0;
        }else{
            $nivelM_ab=($nivelM[0]->AB*100)/$hombres;
        }
        ////////
        if($trabajagen[0]->SI == 0 || $totalcontestaron== 0){
            $trabajagen_si=0;
        }else{
            $trabajagen_si=($trabajagen[0]->SI*100)/$totalcontestaron;
        }
        if($trabajagen[0]->NOO == 0 || $totalcontestaron== 0){
            $trabajagen_no=0;
        }else{
            $trabajagen_no=($trabajagen[0]->NOO*100)/$totalcontestaron;
        }
        /////
        if($trabajaF[0]->SI == 0 || $mujeres == 0){
            $trabajaF_si=0;
        }else{
            $trabajaF_si=($trabajaF[0]->SI*100)/$mujeres;
        }

        if($trabajaF[0]->NOO == 0 || $mujeres == 0){
            $trabajaF_no=0;
        }else{
            $trabajaF_no=($trabajaF[0]->NOO*100)/$mujeres;
        }
        ///////
        if($trabajaM[0]->SI == 0 || $hombres == 0){
            $trabajaM_si=0;
        }else{
            $trabajaM_si=($trabajaM[0]->SI*100)/$hombres;
        }

        if($trabajaM[0]->NOO == 0 || $hombres == 0){
            $trabajaM_no=0;
        }else{
            $trabajaM_no=($trabajaM[0]->NOO*100)/$hombres;
        }
        ///////
        if($becagen[0]->SI == 0 || $totalcontestaron== 0){
            $becagen_si=0;
        }else{
            $becagen_si=($becagen[0]->SI*100)/$totalcontestaron;
        }
        if($becagen[0]->NOO == 0 || $totalcontestaron== 0){
            $becagen_no=0;
        }else{
            $becagen_no=($becagen[0]->NOO*100)/$totalcontestaron;
        }
        ///////////
        if($becaF[0]->SI == 0 || $mujeres== 0){
            $becaF_si=0;
        }else{
            $becaF_si=($becaF[0]->SI*100)/$mujeres;
        }
        if($becaF[0]->NOO == 0 || $mujeres== 0){
            $becaF_no=0;
        }else{
            $becaF_no=($becaF[0]->NOO*100)/$mujeres;
        }
        ///////////
        if($becaM[0]->SI == 0 || $hombres== 0){
            $becaM_si=0;
        }else{
            $becaM_si=($becaM[0]->SI*100)/$hombres;
        }
        if($becaM[0]->NOO == 0 || $hombres== 0){
            $becaM_no=0;
        }else{
            $becaM_no=($becaM[0]->NOO*100)/$hombres;
        }
        ////////
        if($academicogen[0]->R == 0 || $totalcontestaron== 0 ){
            $academicogen_r=0;
        }else{
            $academicogen_r=($academicogen[0]->R*100)/$totalcontestaron;
        }
        if($academicogen[0]->I == 0 || $totalcontestaron== 0 ){
            $academicogen_i=0;
        }else{
            $academicogen_i=($academicogen[0]->I*100)/$totalcontestaron;
        }
        if($academicogen[0]->S == 0 || $totalcontestaron== 0 ){
            $academicogen_s=0;
        }else{
            $academicogen_s=($academicogen[0]->S*100)/$totalcontestaron;
        }
        if($academicogen[0]->BJ == 0 || $totalcontestaron== 0 ){
            $academicogen_bj=0;
        }else{
            $academicogen_bj=($academicogen[0]->BJ*100)/$totalcontestaron;
        }
        if($academicogen[0]->BD == 0 || $totalcontestaron== 0 ){
            $academicogen_bd=0;
        }else{
            $academicogen_bd=($academicogen[0]->BD*100)/$totalcontestaron;
        }
        ////////////
        if($academicoF[0]->R == 0 || $mujeres == 0){
            $academicoF_r=0;
        }else{
            $academicoF_r=($academicoF[0]->R*100)/$mujeres;
        }
        if($academicoF[0]->I == 0 || $mujeres == 0){
            $academicoF_i=0;
        }else{
            $academicoF_i=($academicoF[0]->I*100)/$mujeres;
        }
        if($academicoF[0]->S == 0 || $mujeres == 0){
            $academicoF_s=0;
        }else{
            $academicoF_s=($academicoF[0]->S*100)/$mujeres;
        }
        if($academicoF[0]->BJ == 0 || $mujeres == 0){
            $academicoF_bj=0;
        }else{
            $academicoF_bj=($academicoF[0]->BJ*100)/$mujeres;
        }
        if($academicoF[0]->BD == 0 || $mujeres == 0){
            $academicoF_bd=0;
        }else{
            $academicoF_bd=($academicoF[0]->BD*100)/$mujeres;
        }
        ////
        if($academicoM[0]->R == 0 || $hombres == 0){
            $academicoM_r=0;
        }else{
            $academicoM_r=($academicoM[0]->R*100)/$hombres;
        }
        if($academicoM[0]->I == 0 || $hombres == 0){
            $academicoM_i=0;
        }else{
            $academicoM_i=($academicoM[0]->I*100)/$hombres;
        }
        if($academicoM[0]->S == 0 || $hombres == 0){
            $academicoM_s=0;
        }else{
            $academicoM_s=($academicoM[0]->S*100)/$hombres;
        }
        if($academicoM[0]->BJ == 0 || $hombres){
            $academicoM_bj=0;
        }else{
            $academicoM_bj=($academicoM[0]->BJ*100)/$hombres;
        }
        if($academicoM[0]->BD == 0 || $hombres){
            $academicoM_bd=0;
        }else{
            $academicoM_bd=($academicoM[0]->BD*100)/$hombres;
        }
        //////
        $pbecagen_si = $becagen[0]->SI;
        if($tbecagen[0]->Ma == 0  || $pbecagen_si== 0){
            $tbecagen_ma=0;
        }
        else{
            $tbecagen_ma=($tbecagen[0]->Ma*100)/$pbecagen_si;
        }
        if($tbecagen[0]->Be == 0  || $pbecagen_si== 0){
            $tbecagen_be=0;
        }
        else{
            $tbecagen_be=($tbecagen[0]->Be*100)/$pbecagen_si;
        }
        if($tbecagen[0]->Pe == 0  || $pbecagen_si== 0){
            $tbecagen_pe=0;
        }
        else{
            $tbecagen_pe=($tbecagen[0]->Pe*100)/$pbecagen_si;
        }
        if($tbecagen[0]->Ea == 0  || $pbecagen_si== 0){
            $tbecagen_ea=0;
        }
        else{
            $tbecagen_ea=($tbecagen[0]->Ea*100)/$pbecagen_si;
        }

/////////
        $qbecaF_si=$becaF[0]->SI;
        if($tbecaF[0]->Ma == 0 || $becaF[0]->SI == 0){
            $tbecaF_ma=0;
        }else{
            $tbecaF_ma=($tbecaF[0]->Ma*100)/$qbecaF_si;
        }

        if($tbecaF[0]->Be == 0 || $becaF[0]->SI == 0){
            $tbecaF_be=0;
        }else{
            $tbecaF_be=($tbecaF[0]->Be*100)/$qbecaF_si;
        }
        if($tbecaF[0]->Pe == 0 || $becaF[0]->SI == 0){
            $tbecaF_pe=0;
        }else{
            $tbecaF_pe=($tbecaF[0]->Pe*100)/$qbecaF_si;
        }
        if($tbecaF[0]->Ea == 0 || $becaF[0]->SI == 0){
            $tbecaF_ea=0;
        }else{
            $tbecaF_ea=($tbecaF[0]->Ea*100)/$qbecaF_si;
        }
        /////////
        $qbecaM_si=$becaM[0]->SI;
        if($tbecaM[0]->Ma == 0 ||  $qbecaM_si == 0){
            $tbecaM_ma=0;
        }else{
            $tbecaM_ma=($tbecaM[0]->Ma*100)/$qbecaM_si;
        }

        if($tbecaM[0]->Be == 0 ||  $qbecaM_si == 0){
            $tbecaM_be=0;
        }else{
            $tbecaM_be=($tbecaM[0]->Be*100)/$qbecaM_si;
        }
        if($tbecaM[0]->Pe == 0 ||  $qbecaM_si == 0){
            $tbecaM_pe=0;
        }else{
            $tbecaM_pe=($tbecaM[0]->Pe*100)/$qbecaM_si;
        }
        if($tbecaM[0]->Ea == 0 ||  $qbecaM_si == 0){
            $tbecaM_ea=0;
        }else {
            $tbecaM_ea = ($tbecaM[0]->Ea * 100) / $qbecaM_si;
        }

        //////////////
        if($hijosgen[0]->C == 0 || $totalcontestaron == 0){
            $hijosgen_c=0;
        }else{
            $hijosgen_c=($hijosgen[0]->C*100)/$totalcontestaron;
        }
        if($hijosgen[0]->U == 0 || $totalcontestaron == 0){
            $hijosgen_u=0;
        }else{
            $hijosgen_u=($hijosgen[0]->U*100)/$totalcontestaron;
        }
        if($hijosgen[0]->D == 0 || $totalcontestaron == 0){
            $hijosgen_d=0;
        }else{
            $hijosgen_d=($hijosgen[0]->D*100)/$totalcontestaron;
        }
        if($hijosgen[0]->T == 0 || $totalcontestaron == 0){
            $hijosgen_t=0;
        }else{
            $hijosgen_t=($hijosgen[0]->T*100)/$totalcontestaron;
        }
        if($hijosgen[0]->M == 0 || $totalcontestaron == 0){
            $hijosgen_m=0;
        }else{
            $hijosgen_m=($hijosgen[0]->M*100)/$totalcontestaron;
        }
        ////
        if($hijosF[0]->C == 0 || $mujeres == 0){
            $hijosF_c=0;
        }else{
            $hijosF_c=($hijosF[0]->C*100)/$mujeres;
        }
        if($hijosF[0]->U == 0 || $mujeres == 0){
            $hijosF_u=0;
        }else{
            $hijosF_u=($hijosF[0]->U*100)/$mujeres;
        }

        if($hijosF[0]->D == 0 || $mujeres == 0){
            $hijosF_d=0;
        }else{
            $hijosF_d=($hijosF[0]->D*100)/$mujeres;
        }
        if($hijosF[0]->T == 0 || $mujeres == 0){
            $hijosF_t=0;
        }else{
            $hijosF_t=($hijosF[0]->T*100)/$mujeres;
        }
        if($hijosF[0]->M == 0 || $mujeres == 0){
            $hijosF_m=0;
        }else{
            $hijosF_m=($hijosF[0]->M*100)/$mujeres;
        }
        ////
        if($hijosM[0]->C == 0 || $hombres == 0){
            $hijosM_c=0;
        }else{
            $hijosM_c=($hijosM[0]->C*100)/$hombres;
        }
        if($hijosM[0]->U == 0 || $hombres == 0){
            $hijosM_u=0;
        }else{
            $hijosM_u=($hijosM[0]->U*100)/$hombres;
        }

        if($hijosM[0]->D == 0 || $hombres == 0){
            $hijosM_d=0;
        }else{
            $hijosM_d=($hijosM[0]->D*100)/$hombres;
        }
        if($hijosM[0]->T == 0 || $hombres == 0){
            $hijosM_t=0;
        }else{
            $hijosM_t=($hijosM[0]->T*100)/$hombres;
        }
        if($hijosM[0]->M == 0 || $hombres == 0){
            $hijosM_m=0;
        }else{
            $hijosM_m=($hijosM[0]->M*100)/$hombres;
        }
        return response()->json(
            [
                [
                    [


                        ["name"=>"Soltero","y"=>round($estadogen_soltero)],["name"=>"Casado","y"=>round($estadogen_casado)],["name"=>"Unión libre","y"=>round($estadogen_unionlibre)],["name"=>"Divorsiado","y"=>round($estadogen_divorsiado)],["name"=>"Viudo","y"=>round($estadogen_viudo)]
                    ],
                    [

                        ["name"=>"Soltero","y"=>round($estadoF_soltero)],["name"=>"Casado","y"=>round($estadoF_casado)],["name"=>"Unión libre","y"=>round($estadoF_unionlibre)],["name"=>"Divorsiado","y"=>round($estadoF_divorsiado)],["name"=>"Viudo","y"=>round($estadoF_viudo)]
                    ],
                    [
                        ["name"=>"Soltero","y"=>round($estadoM_soltero)],["name"=>"Casado","y"=>round($estadoM_casado)],["name"=>"Unión libre","y"=>round($estadoM_unionlibre)],["name"=>"Divorsiado","y"=>round($estadoM_divorsiado)],["name"=>"Viudo","y"=>round($estadoM_viudo)]
                    ]
                ],
                [
                    [

                        ["name"=>"E","y"=>round($nivelgen_e)],["name"=>"D","y"=>round($nivelgen_d)],["name"=>"D+","y"=>round($nivelgen_dd)],["name"=>"C-","y"=>round($nivelgen_ccc)],["name"=>"C","y"=>round($nivelgen_c)],["name"=>"C+","y"=>round($nivelgen_cc)],["name"=>"A/B","y"=>round($nivelgen_ab)]
                    ],
                    [
                        ["name"=>"E","y"=>round($nivelF_e)],["name"=>"D","y"=>round($nivelF_d)],["name"=>"D+","y"=>round($nivelF_dd)],["name"=>"C-","y"=>round($nivelF_ccc)],["name"=>"C","y"=>round($nivelF_c)],["name"=>"C+","y"=>round($nivelF_cc)],["name"=>"A/B","y"=>round($nivelF_ab)]
                    ],
                    [
                        ["name"=>"E","y"=>round($nivelM_e)],["name"=>"D","y"=>round($nivelM_d)],["name"=>"D+","y"=>round($nivelM_dd)],["name"=>"C-","y"=>round($nivelM_ccc)],["name"=>"C","y"=>round($nivelM_c)],["name"=>"C+","y"=>round($nivelM_cc)],["name"=>"A/B","y"=>round($nivelM_ab)]
                    ],
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($trabajagen_si)],["name"=>"No","y"=>round($trabajagen_no)]
                    ],
                    [

                        ["name"=>"Si","y"=>round($trabajaF_si)],["name"=>"No","y"=>round($trabajaF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($trabajaM_si)],["name"=>"No","y"=>round($trabajaM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Regular","y"=>round($academicogen_r)],["name"=>"Irregular","y"=>round($academicogen_i)],["name"=>"Suspensión","y"=>round($academicogen_s)],["name"=>"Baja temporal  ","y"=>round($academicogen_bj)],["name"=>"Baja definitiva","y"=>round($academicogen_bd)]
                    ],
                    [
                        ["name"=>"Regular","y"=>round($academicoF_r)],["name"=>"Irregular","y"=>round($academicoF_i)],["name"=>"Suspensión","y"=>round($academicoF_s)],["name"=>"Baja temporal  ","y"=>round($academicoF_bj)],["name"=>"Baja definitiva","y"=>round($academicoF_bd)]
                    ],
                    [
                        ["name"=>"Regular","y"=>round($academicoM_r)],["name"=>"Irregular","y"=>round($academicoM_i)],["name"=>"Suspensión","y"=>round($academicoM_s)],["name"=>"Baja temporal  ","y"=>round($academicoM_bj)],["name"=>"Baja definitiva","y"=>round($academicoM_bd)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($becagen_si)],["name"=>"No","y"=>round($becagen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($becaF_si)],["name"=>"No","y"=>round($becaF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($becaM_si)],["name"=>"No","y"=>round($becaM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Manutención Federal","y"=>round($tbecagen_ma)],["name"=>"Benito Juárez","y"=>round($tbecagen_be)],["name"=>"Permanencia","y"=>round($tbecagen_pe)],["name"=>"Excelencia Académica","y"=>round($tbecagen_ea)]
                    ],
                    [
                        ["name"=>"Manutención Federal","y"=>round($tbecaF_ma)],["name"=>"Benito Juárez","y"=>round($tbecaF_be)],["name"=>"Permanencia","y"=>round($tbecaF_pe)],["name"=>"Excelencia Académica","y"=>round($tbecaF_ea)]
                    ],
                    [
                        ["name"=>"Manutención Federal","y"=>round($tbecaM_ma)],["name"=>"Benito Juárez","y"=>round($tbecaM_be)],["name"=>"Permanencia","y"=>round($tbecaM_pe)],["name"=>"Excelencia Académica","y"=>round($tbecaM_ea)]
                    ]
                ],
                [
                    [

                        ["name"=>"0","y"=>round($hijosgen_c)],["name"=>"1","y"=>round($hijosgen_u)],["name"=>"2","y"=>round($hijosgen_d)],["name"=>"3","y"=>round($hijosgen_t)],["name"=>"4 o más","y"=>round($hijosgen_m)]
                    ],
                    [
                        ["name"=>"0","y"=>round($hijosF_c)],["name"=>"1","y"=>round($hijosF_u)],["name"=>"2","y"=>round($hijosF_d)],["name"=>"3","y"=>round($hijosF_t)],["name"=>"4 o más","y"=>round($hijosF_m)]
                    ],
                    [
                        ["name"=>"0","y"=>round($hijosM_c)],["name"=>"1","y"=>round($hijosM_u)],["name"=>"2","y"=>round($hijosM_d)],["name"=>"3","y"=>round($hijosM_t)],["name"=>"4 o más","y"=>round($hijosM_m)]
                    ]
                ]

            ],200
        );
        /*
        return response()->json(
            ["categoria"=>array_pluck($nivel, 'nivel'),
                "cantidad"=>array_pluck($nivel, 'cant'),
                "cattrabaja"=>array_pluck($trabaja, 'trabajo'),
                "canttrabaja"=>array_pluck($trabaja, 'cant'),
                "catbeca"=>array_pluck($beca, 'beca'),
                "cantbeca"=>array_pluck($beca, 'cant'),
                "catestado"=>array_pluck($estado, 'estado'),
                "cantestado"=>array_pluck($estado, 'cant'),
                "catcivil"=>array_pluck($estado, 'estado'),
                "cantcivil"=>array_pluck($estado, 'cant')],200
        );*/
    }
    public function academico(Request $request)
    {
        $gustagen=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_antecedentes_academicos.tegusta_carrera_elegida=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_antecedentes_academicos.tegusta_carrera_elegida=2) as NOO');
        $gustaF=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_antecedentes_academicos.tegusta_carrera_elegida=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_antecedentes_academicos.tegusta_carrera_elegida=2) as NOO');
        $gustaM=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_antecedentes_academicos.tegusta_carrera_elegida=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_antecedentes_academicos.tegusta_carrera_elegida=2) as NOO');

        $estimulagen=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_antecedentes_academicos.teestimula_familia=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_antecedentes_academicos.teestimula_familia=2) as NOO');
        $estimulaF=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_antecedentes_academicos.teestimula_familia=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_antecedentes_academicos.teestimula_familia=2) as NOO');
        $estimulaM=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_antecedentes_academicos.teestimula_familia=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_antecedentes_academicos.teestimula_familia=2) as NOO');

        $otragen=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_antecedentes_academicos.otra_carrera_ini=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_antecedentes_academicos.otra_carrera_ini=2) as NOO');
        $otraF=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_antecedentes_academicos.otra_carrera_ini=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_antecedentes_academicos.otra_carrera_ini=2) as NOO');
        $otraM=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_antecedentes_academicos.otra_carrera_ini=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_antecedentes_academicos.otra_carrera_ini=2) as NOO');

        $bachgen=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_bachillerato.desc_bachillerato="Técnico") as T, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_bachillerato.desc_bachillerato="General") as G');
        $bachF=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_bachillerato.desc_bachillerato="Técnico") as T, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_bachillerato.desc_bachillerato="General") as G');
        $bachM=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_bachillerato.desc_bachillerato="Técnico") as T, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                     JOIN exp_asigna_alumnos ON exp_antecedentes_academicos.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_bachillerato.desc_bachillerato="General") as G');
        $alumnos=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M") as M, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F") as F');
        $total_al= $totalcontestaron=$alumnos[0]->M+$alumnos[0]->F;
           $mujeres=$alumnos[0]->F;
           $hombres=$alumnos[0]->M;
        if($gustagen[0]->SI == 0 || $total_al == 0){
            $gustagen_si=0;
        }
        else{
            $gustagen_si=($gustagen[0]->SI*100)/$total_al;
        }
        if($gustagen[0]->NOO == 0 || $total_al == 0){
            $gustagen_no=0;
        }
        else{
            $gustagen_no=($gustagen[0]->NOO*100)/$total_al;
        }
        ///////////
        if($gustaF[0]->SI == 0 || $mujeres == 0){
            $gustaF_si=0;
        }else{
            $gustaF_si= ($gustaF[0]->SI*100)/$mujeres;
        }
        if($gustaF[0]->NOO == 0 || $mujeres == 0){
            $gustaF_no=0;
        }else{
            $gustaF_no= ($gustaF[0]->NOO*100)/$mujeres;
        }
        ////////
        if($gustaM[0]->SI == 0 || $hombres == 0){
            $gustaM_si=0;

        }else{
            $gustaM_si=($gustaM[0]->SI*100)/$hombres;
        }
        if($gustaM[0]->NOO == 0 || $hombres == 0){
            $gustaM_no=0;

        }else{
            $gustaM_no=($gustaM[0]->NOO*100)/$hombres;
        }
        /////////
        if($estimulagen[0]->SI == 0 || $total_al == 0){
            $estimulagen_si=0;
        }else{
            $estimulagen_si=($estimulagen[0]->SI*100)/$total_al;
        }
        if($estimulagen[0]->NOO == 0 || $total_al == 0){
            $estimulagen_no=0;
        }else{
            $estimulagen_no=($estimulagen[0]->NOO*100)/$total_al;
        }
        ///////
        if($estimulaF[0]->SI == 0 || $mujeres == 0){
            $estimulaF_si=0;
        }else{
            $estimulaF_si=($estimulaF[0]->SI*100)/$mujeres;
        }
        if($estimulaF[0]->NOO == 0 || $mujeres == 0){
            $estimulaF_no=0;
        }else{
            $estimulaF_no=($estimulaF[0]->NOO*100)/$mujeres;
        }
        ///////
        if($estimulaM[0]->SI == 0 || $hombres == 0){
            $estimulaM_si=0;
        }else{
            $estimulaM_si=($estimulaM[0]->SI*100)/$hombres;
        }
        if($estimulaM[0]->NOO == 0 || $hombres == 0){
            $estimulaM_no=0;
        }else{
            $estimulaM_no=($estimulaM[0]->NOO*100)/$hombres;
        }
///////
        if($otragen[0]->SI ==0 || $total_al == 0){
            $otragen_si=0;
        }else{
            $otragen_si=($otragen[0]->SI*100)/$total_al;
        }
        if($otragen[0]->NOO ==0 || $total_al == 0){
            $otragen_no=0;
        }else{
            $otragen_no=($otragen[0]->NOO*100)/$total_al;
        }
        //////////
        if($otraF[0]->SI == 0 || $mujeres == 0){
            $otraF_si=0;
        }else{
            $otraF_si=($otraF[0]->SI*100)/$mujeres;
        }
        if($otraF[0]->NOO == 0 || $mujeres == 0){
            $otraF_no=0;
        }else{
            $otraF_no=($otraF[0]->NOO*100)/$mujeres;
        }
        ////////////////

        if($otraM[0]->SI ==0 || $hombres == 0){
            $otraM_si=0;
        }else{
            $otraM_si=($otraM[0]->SI*100)/$hombres;
        }
        if($otraM[0]->NOO ==0 || $hombres == 0){
            $otraM_no=0;
        }else{
            $otraM_no=($otraM[0]->NOO*100)/$hombres;
        }
        //////
        if($bachgen[0]->T == 0 || $total_al == 0){
            $bachgen_t=0;
        }else{
            $bachgen_t=($bachgen[0]->T*100)/$total_al;
        }
        if($bachgen[0]->G == 0 || $total_al == 0){
            $bachgen_g=0;
        }else{
            $bachgen_g=($bachgen[0]->G*100)/$total_al;
        }
        ////////
        if($bachF[0]->T == 0 || $mujeres == 0){
            $bachF_t=0;
        }else{
            $bachF_t=($bachF[0]->T*100)/$mujeres;
        }
        if($bachF[0]->G == 0 || $mujeres == 0){
            $bachF_g=0;
        }else{
            $bachF_g=($bachF[0]->G*100)/$mujeres;
        }
        ////////
        if($bachM[0]->T == 0 || $hombres == 0){
            $bachM_t=0;
        }else{
            $bachM_t=($bachM[0]->T*100)/$hombres;
        }
        if($bachM[0]->G == 0 || $hombres == 0){
            $bachM_g=0;
        }else{
            $bachM_g=($bachM[0]->G*100)/$hombres;
        }
        return response()->json(
            [
                [
                    [



                        ["name"=>"Si","y"=>round($gustagen_si)],["name"=>"No","y"=>round($gustagen_no)]
                    ],
                    [

                        ["name"=>"Si","y"=>round($gustaF_si)],["name"=>"No","y"=>round($gustaF_no)]
                    ],
                    [

                        ["name"=>"Si","y"=>round($gustaM_si)],["name"=>"No","y"=>round($gustaM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($estimulagen_si)],["name"=>"No","y"=>round($estimulagen_no)]
                    ],
                    [

                        ["name"=>"Si","y"=>round($estimulaF_si)],["name"=>"No","y"=>round($estimulaF_no)]
                    ],
                    [

                        ["name"=>"Si","y"=>round($estimulaM_si)],["name"=>"No","y"=>round($estimulaM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($otragen_si)],["name"=>"No","y"=>round($otragen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round( $otraF_si)],["name"=>"No","y"=>round($otraF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($otraM_si)],["name"=>"No","y"=>round($otraM_no)]
                    ]
                ],
                [
                    [
                        ["name"=>"Técnico","y"=>round($bachgen_t)],["name"=>"General","y"=>round($bachgen_g)]
                    ],
                    [
                        ["name"=>"Técnico","y"=>round($bachF_t)],["name"=>"General","y"=>round($bachF_g)]
                    ],
                    [
                        ["name"=>"Técnico","y"=>round($bachM_t)],["name"=>"General","y"=>round($bachM_g)]
                    ]
                ],
            ],200
        );
    }
    public function familiares(Request $request)
    {

        $vivesgen=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_vives.desc_opc="Con los padres") as CP,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_vives.desc_opc="Con otros estudiantes") as CE,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_vives.desc_opc="Con tios u otros familiares") as CT,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_vives.desc_opc="Solo") as S');

        $vivesF=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_vives.desc_opc="Con los padres") as CP,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_vives.desc_opc="Con otros estudiantes") as CE,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_vives.desc_opc="Con tios u otros familiares") as CT,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_vives.desc_opc="Solo") as S');
        $vivesM=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_vives.desc_opc="Con los padres") as CP,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_vives.desc_opc="Con otros estudiantes") as CE,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_vives.desc_opc="Con tios u otros familiares") as CT,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_vives.desc_opc="Solo") as S');

        $etgen=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_datos_familiares.etnia_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_datos_familiares.etnia_indigena=2) as NOO');
        $etF=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_datos_familiares.etnia_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_datos_familiares.etnia_indigena=2) as NOO');
        $etM=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_datos_familiares.etnia_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_datos_familiares.etnia_indigena=2) as NOO');
        $hagen=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_datos_familiares.hablas_lengua_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_datos_familiares.hablas_lengua_indigena=2) as NOO');
        $haF=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_datos_familiares.hablas_lengua_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_datos_familiares.hablas_lengua_indigena=2) as NOO');
        $haM=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_datos_familiares.hablas_lengua_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_datos_familiares.hablas_lengua_indigena=2) as NOO');

        $ufgen=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_familia_union.desc_union="Unida") as U,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_familia_union.desc_union="Muy unida") as MU,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_familia_union.desc_union="Disfuncional") as D');
        $ufF=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_familia_union.desc_union="Unida") as U,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_familia_union.desc_union="Muy unida") as MU,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_familia_union.desc_union="Disfuncional") as D');
        $ufM=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_familia_union.desc_union="Unida") as U,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_familia_union.desc_union="Muy unida") as MU,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                     JOIN exp_asigna_alumnos ON exp_datos_familiares.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_familia_union.desc_union="Disfuncional") as D');

        $alumnos=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M") as M, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F") as F');
        $totalcontestaron=$alumnos[0]->M+$alumnos[0]->F;
        $hombres=$alumnos[0]->M;
        $mujeres=$alumnos[0]->F;
        if($vivesgen[0]->CP == 0 ||  $totalcontestaron==0){
            $cp=0;
        }
        else{

            $cp=($vivesgen[0]->CP*100)/$totalcontestaron;
        }

        if($vivesgen[0]->CE == 0 ||  $totalcontestaron == 0){
            $ce=0;
        }
        else{

            $ce=($vivesgen[0]->CE*100)/$totalcontestaron;
        }
        if($vivesgen[0]->CT == 0 ||  $totalcontestaron == 0){
            $ct=0;
        }
        else{

            $ct=($vivesgen[0]->CT*100)/$totalcontestaron;
        }
        if($vivesgen[0]->S == 0 || $totalcontestaron == 0){
            $s=0;
        }
        else{

            $s=($vivesgen[0]->S*100)/$totalcontestaron;
        }
        /////////////
        if($vivesF[0]->CP == 0 || $mujeres == 0){
            $f_cp=0;
        }
        else{

            $f_cp=($vivesF[0]->CP*100)/$mujeres;
        }
        if($vivesF[0]->CE == 0 || $mujeres == 0){
            $f_ce=0;
        }
        else{

            $f_ce=($vivesF[0]->CE)*100/$mujeres;
        }
        if($vivesF[0]->CT == 0 || $mujeres == 0){
            $f_ct=0;
        }
        else{

            $f_ct=($vivesF[0]->CT)*100/$mujeres;
        }
        if($vivesF[0]->S == 0 || $mujeres == 0){
            $f_s=0;
        }
        else{

            $f_s=($vivesF[0]->S)*100/$mujeres;
        }

        /////////////
        if($vivesM[0]->CP == 0 || $hombres == 0){
            $m_cp=0;
        }
        else{

            $m_cp=($vivesM[0]->CP)*100/$hombres;
        }
        if($vivesM[0]->CE == 0 || $hombres == 0){
            $m_ce=0;
        }
        else{

            $m_ce=($vivesM[0]->CE)*100/$hombres;
        }
        if($vivesM[0]->CT == 0 || $hombres == 0){
            $m_ct=0;
        }
        else{

            $m_ct=($vivesM[0]->CT)*100/$hombres;
        }
        if($vivesM[0]->S == 0 || $hombres == 0){
            $m_s=0;
        }
        else{

            $m_s=($vivesM[0]->S)*100/$hombres;
        }

     if($etgen[0]->SI == 0 || $totalcontestaron == 0){
         $g_si=0;
     }else{
         $g_si=($etgen[0]->SI)*100/$totalcontestaron;
         
     }
        if($etgen[0]->NOO == 0 || $totalcontestaron == 0){
            $g_no=0;
        }else{
            $g_no=($etgen[0]->NOO)*100/$totalcontestaron;

        }

        if($etF[0]->SI == 0 || $mujeres == 0){
            $etF_si=0;
        }else{
            $etF_si=($etF[0]->SI)*100/$mujeres;

        }
        if($etF[0]->NOO == 0 || $mujeres == 0){
            $etF_no=0;
        }else{
            $etF_no=($etF[0]->NOO)*100/$mujeres;

        }
        ////
        if($etM[0]->SI == 0 || $hombres == 0){
            $etM_si=0;
        }else{
            $etM_si=($etM[0]->SI)*100/$hombres;

        }
        if($etM[0]->NOO == 0 || $hombres == 0){
            $etM_no=0;
        }else{
            $etM_no=($etM[0]->NOO)*100/$hombres;

        }

        ////
        if($hagen[0]->SI == 0 || $totalcontestaron == 0){
            $hagen_si=0;
        }else{
            $hagen_si=($hagen[0]->SI)*100/$totalcontestaron;

        }
        if($hagen[0]->NOO == 0 || $totalcontestaron == 0){
            $hagen_no=0;
        }else{
            $hagen_no=($hagen[0]->NOO)*100/$totalcontestaron;
        }

        ////
        if($haF[0]->SI == 0 || $mujeres == 0){
            $haF_si=0;
        }else{
            $haF_si=($haF[0]->SI)*100/$mujeres;

        }
        if($haF[0]->NOO == 0 || $mujeres == 0){
            $haF_no=0;
        }else{
            $haF_no=($haF[0]->NOO)*100/$mujeres;
        }
        ////
        if($haM[0]->SI == 0 || $hombres == 0){
            $haM_si=0;
        }else{
            $haM_si=($haM[0]->SI)*100/$hombres;

        }
        if($haM[0]->NOO == 0 || $hombres == 0){
            $haM_no=0;
        }else{
            $haM_no=($haM[0]->NOO)*100/$hombres;
        }
        /////
        if($ufgen[0]->D == 0 || $totalcontestaron == 0){
            $ufgen_d=0;
        }
        else{
            $ufgen_d=($ufgen[0]->D)*100/$totalcontestaron;
        }
        if($ufgen[0]->U == 0 || $totalcontestaron == 0){
            $ufgen_u=0;
        }
        else{
            $ufgen_u=($ufgen[0]->U)*100/$totalcontestaron;
        }
        if($ufgen[0]->MU == 0 || $totalcontestaron == 0){
            $ufgen_mu=0;
        }
        else{
            $ufgen_mu=($ufgen[0]->MU)*100/$totalcontestaron;
        }
        //////
        if($ufF[0]->D == 0 || $mujeres == 0){
            $ufF_d=0;
        }
        else{
            $ufF_d=($ufF[0]->D)*100/$mujeres;
        }
        if($ufF[0]->U == 0 || $mujeres == 0){
            $ufF_u=0;
        }
        else{
            $ufF_u=($ufF[0]->U)*100/$mujeres;
        }
        if($ufF[0]->MU == 0 || $mujeres == 0){
            $ufF_mu=0;
        }
        else{
            $ufF_mu=($ufF[0]->MU)*100/$mujeres;
        }
        //////////////////
        if($ufM[0]->D == 0 || $hombres == 0){
            $ufM_d=0;
        }
        else{
            $ufM_d=($ufM[0]->D)*100/$hombres;
        }
        if($ufM[0]->U == 0 || $hombres == 0){
            $ufM_u=0;
        }
        else{
            $ufM_u=($ufM[0]->U)*100/$hombres;
        }
        if($ufM[0]->MU == 0 || $hombres == 0){
            $ufM_mu=0;
        }
        else{
            $ufM_mu=($ufM[0]->MU)*100/$hombres;
        }
        return response()->json(
            [
                [
                    [

                        ["name"=>"Con los padres","y"=>round($cp)],["name"=>"Con otros estudiantes","y"=>round($ce)],["name"=>"Con tios u otros familiares","y"=>round($ct)],["name"=>"Solo","y"=>round($s)]
                    ],
                    [
                        ["name"=>"Con los padres","y"=>round($f_cp)],["name"=>"Con otros estudiantes","y"=>round($f_ce)],["name"=>"Con tios u otros familiares","y"=>round($f_ct)],["name"=>"Solo","y"=>round($f_s)]
                    ],
                    [
                        ["name"=>"Con los padres","y"=>round($m_cp)],["name"=>"Con otros estudiantes","y"=>round($m_ce)],["name"=>"Con tios u otros familiares","y"=>round($m_ct)],["name"=>"Solo","y"=>round($m_s)]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round($g_si)],["name"=>"No","y"=>round($g_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($etF_si)],["name"=>"No","y"=>round($etF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($etM_si)],["name"=>"No","y"=>round($etM_no)]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round($hagen_si)],["name"=>"No","y"=>round($hagen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($haF_si)],["name"=>"No","y"=>round($haF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($haM_si)],["name"=>"No","y"=>round($haM_no)]
                    ]
                ],
                [

                    [
                        ["name"=>"Disfuncional","y"=>round($ufgen_d)],["name"=>"Unida","y"=>round($ufgen_u)],["name"=>"Muy unida","y"=>round($ufgen_mu)]
                    ],
                    [

                        ["name"=>"Disfuncional","y"=>round($ufF_d)],["name"=>"Unida","y"=>round($ufF_u)],["name"=>"Muy unida","y"=>round($ufF_mu)]
                    ],
                    [
                        ["name"=>"Disfuncional","y"=>round($ufM_d)],["name"=>"Unida","y"=>round($ufM_u)],["name"=>"Muy unida","y"=>round($ufM_mu)]
                    ]
                ],
            ],200
        );
    }
    public function habitos(Request $request)
    {

        $tigen=DB::select('SELECT (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_tiempo.desc_opc="Menos de 1 hora") as M, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_tiempo.desc_opc="1 hora") as U, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_tiempo.desc_opc="2 horas") as D, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_tiempo.desc_opc="3 horas") as T, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_opc_tiempo.desc_opc="Más de 4 horas") as C');

        $tiF=DB::select('SELECT (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="Menos de 1 hora") as M, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="1 hora") as U, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="2 horas") as D, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="3 horas") as T, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="Más de 4 horas") as C');

        $tiM=DB::select('SELECT (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="Menos de 1 hora") as M, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="1 hora") as U, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="2 horas") as D, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="3 horas") as T, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                     JOIN exp_asigna_alumnos ON exp_habitos_estudio.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="Más de 4 horas") as C');

        $alumnos=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M") as M, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F") as F');
        $totalcontestaron=$alumnos[0]->M+$alumnos[0]->F;
        $hombres=$alumnos[0]->M;
        $mujeres=$alumnos[0]->F;
        if($tigen[0]->M == 0 || $totalcontestaron == 0){
            $tigen_m=0;
        }else{
            $tigen_m=($tigen[0]->M*100)/$totalcontestaron;
        }
        if($tigen[0]->U == 0 || $totalcontestaron == 0){
            $tigen_u=0;
        }else{
            $tigen_u=($tigen[0]->U*100)/$totalcontestaron;
        }
        if($tigen[0]->D == 0 || $totalcontestaron == 0){
            $tigen_d=0;
        }else{
            $tigen_d=($tigen[0]->D*100)/$totalcontestaron;
        }
        if($tigen[0]->T == 0 || $totalcontestaron == 0){
            $tigen_t=0;
        }else{
            $tigen_t=($tigen[0]->T*100)/$totalcontestaron;
        }
        if($tigen[0]->C == 0 || $totalcontestaron == 0){
            $tigen_c=0;
        }else{
            $tigen_c=($tigen[0]->C*100)/$totalcontestaron;
        }
        ////////
        if($tiF[0]->M == 0 || $mujeres == 0){
            $tiF_m=0;
        }
        else{
            $tiF_m=($tiF[0]->M*100)/$mujeres;
        }
        if($tiF[0]->U == 0 || $mujeres == 0){
            $tiF_u=0;
        }
        else{
            $tiF_u=($tiF[0]->U*100)/$mujeres;
        }
        if($tiF[0]->D == 0 || $mujeres == 0){
            $tiF_d=0;
        }
        else{
            $tiF_d=($tiF[0]->D*100)/$mujeres;
        }
        if($tiF[0]->T == 0 || $mujeres == 0){
            $tiF_t=0;
        }
        else{
            $tiF_t=($tiF[0]->T*100)/$mujeres;
        }
        if($tiF[0]->C == 0 || $mujeres == 0){
            $tiF_c=0;
        }
        else{
            $tiF_c=($tiF[0]->C*100)/$mujeres;
        }
        ///////////////
        if($tiM[0]->M == 0 || $hombres == 0){
            $tiM_m=0;
        }
        else{
            $tiM_m=($tiM[0]->M*100)/$hombres;
        }
        if($tiM[0]->U == 0 || $hombres == 0){
            $tiM_u=0;
        }
        else{
            $tiM_u=($tiM[0]->U*100)/$hombres;
        }
        if($tiM[0]->D == 0 || $hombres == 0){
            $tiM_d=0;
        }
        else{
            $tiM_d=($tiM[0]->D*100)/$hombres;
        }
        if($tiM[0]->T == 0 || $hombres == 0){
            $tiM_t=0;
        }
        else{
            $tiM_t=($tiM[0]->T*100)/$hombres;
        }
        if($tiM[0]->C == 0 || $hombres == 0){
            $tiM_c=0;
        }
        else{
            $tiM_c=($tiM[0]->C*100)/$hombres;
        }

        return response()->json(
            [
                [
                    [
                        ["name"=>"Menos de 1 hora","y"=>round($tigen_m)],["name"=>"1 hora","y"=>round($tigen_u)],["name"=>"2 horas","y"=>round($tigen_d)],["name"=>"3 horas","y"=>round($tigen_t)],["name"=>"Más de 4 horas","y"=>round($tigen_c)]
                    ],
                    [

                        ["name"=>"Menos de 1 hora","y"=>round($tiF_m)],["name"=>"1 hora","y"=>round($tiF_u)],["name"=>"2 horas","y"=>round($tiF_d)],["name"=>"3 horas","y"=>round($tiF_t)],["name"=>"Más de 4 horas","y"=>round($tiF_c)]
                    ],
                    [
                        ["name"=>"Menos de 1 hora","y"=>round($tiM_m)],["name"=>"1 hora","y"=>round($tiM_u)],["name"=>"2 horas","y"=>round($tiM_d)],["name"=>"3 horas","y"=>round($tiM_t)],["name"=>"Más de 4 horas","y"=>round($tiM_c)]
                    ]
                ],

            ],200
        );

    }
    public function salud(Request $request)
    {

        $degen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.practica_deporte=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.practica_deporte=2) as NOO');
        $deF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.practica_deporte=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.practica_deporte=2) as NOO');
        $deM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.practica_deporte=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.practica_deporte=2) as NOO');

        $argen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.practica_artistica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.practica_artistica=2) as NOO');
        $arF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.practica_artistica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.practica_artistica=2) as NOO');
        $arM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.practica_artistica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.practica_artistica=2) as NOO');
        $culturasgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.actividades_culturales=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.actividades_culturales=2) as NOO');
        $culturasF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.actividades_culturales=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.actividades_culturales=2) as NOO');
        $culturasM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.actividades_culturales=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.actividades_culturales=2) as NOO');

        $enfcgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.enfermedad_cronica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.enfermedad_cronica=2) as NOO');
        $enfcF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.enfermedad_cronica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.enfermedad_cronica=2) as NOO');
        $enfcM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.enfermedad_cronica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.enfermedad_cronica=2) as NOO');

        $penfcgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.enf_cron_padre=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.enf_cron_padre=2) as NOO');
        $penfcF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.enf_cron_padre=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.enf_cron_padre=2) as NOO');
        $penfcM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.enf_cron_padre=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.enf_cron_padre=2) as NOO');
        $operaciongen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.operacion=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.operacion=2) as NOO');
        $operacionF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.operacion=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.operacion=2) as NOO');
        $operacionM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.operacion=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.operacion=2) as NOO');
        $visualgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.enfer_visual=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.enfer_visual=2) as NOO');
        $visualF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.enfer_visual=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.enfer_visual=2) as NOO');
        $visualM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.enfer_visual=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.enfer_visual=2) as NOO');
        $lentesgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.usas_lentes=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.usas_lentes=2) as NOO');
        $lentesF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.usas_lentes=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.usas_lentes=2) as NOO');
        $lentesM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.usas_lentes=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.usas_lentes=2) as NOO');

        $medgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.medicamento_controlado=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_formacion_integral.medicamento_controlado=2) as NOO');
        $medF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.medicamento_controlado=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_formacion_integral.medicamento_controlado=2) as NOO');
        $medM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.medicamento_controlado=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                     JOIN exp_asigna_alumnos ON exp_formacion_integral.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_formacion_integral.medicamento_controlado=2) as NOO');

        $alumnos=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M") as M, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F") as F');
        $totalcontestaron=$alumnos[0]->M+$alumnos[0]->F;
        $hombres=$alumnos[0]->M;
        $mujeres=$alumnos[0]->F;
        if($degen[0]->SI == 0 || $totalcontestaron == 0)
        {
            $degen_si=0;
        }else{
            $degen_si=($degen[0]->SI*100)/$totalcontestaron;
        }
        if($degen[0]->NOO == 0 || $totalcontestaron == 0)
        {
            $degen_no=0;
        }else{
            $degen_no=($degen[0]->NOO*100)/$totalcontestaron;
        }
        ///////
        if($deF[0]->SI == 0 || $mujeres == 0){
            $deF_si=0;
        }else{
            $deF_si=($deF[0]->SI*100)/$mujeres;
        }
        if($deF[0]->NOO == 0 || $mujeres == 0){
            $deF_no=0;
        }else{
            $deF_no=($deF[0]->NOO*100)/$mujeres;
        }
        /////////
        if($deM[0]->SI == 0 || $hombres == 0){
            $deM_si=0;
        }else{
            $deM_si=($deM[0]->SI*100)/$hombres;
        }
        if($deM[0]->NOO == 0 || $hombres == 0){
            $deM_no=0;
        }else{
            $deM_no=($deM[0]->NOO*100)/$hombres;
        }
        ////
        if($argen[0]->SI == 0 || $totalcontestaron == 0){
            $argen_si=0;
        }else{

            $argen_si=($argen[0]->SI*100)/$totalcontestaron;
        }
        if($argen[0]->NOO == 0 || $totalcontestaron == 0){
            $argen_no=0;
        }else{

            $argen_no=($argen[0]->NOO*100)/$totalcontestaron;
        }
        /////
        if($arF[0]->SI == 0 || $mujeres == 0){
            $arF_si=0;
        }else{
            $arF_si=($arF[0]->SI*100)/$mujeres;
        }
        /////
        if($arF[0]->NOO == 0 || $mujeres == 0){
            $arF_no=0;
        }else{
            $arF_no=($arF[0]->NOO*100)/$mujeres;
        }
        /////
        if($arM[0]->SI == 0 || $hombres == 0){
            $arM_si=0;
        }else{
            $arM_si=($arM[0]->SI*100)/$hombres;
        }
        /////
        if($arM[0]->NOO == 0 || $hombres == 0){
            $arM_no=0;
        }else{
            $arM_no=($arM[0]->NOO*100)/$hombres;
        }
        ///
        if($culturasgen[0]->SI == 0 || $totalcontestaron == 0){
            $culturasgen_si=0;
        }else{
            $culturasgen_si=($culturasgen[0]->SI*100)/$totalcontestaron;
        }
        if($culturasgen[0]->NOO == 0 || $totalcontestaron == 0){
            $culturasgen_no=0;
        }else{
            $culturasgen_no=($culturasgen[0]->NOO*100)/$totalcontestaron;
        }
        if($culturasF[0]->SI == 0 || $mujeres == 0){
            $culturasF_si=0;
        }else{
            $culturasF_si=($culturasF[0]->SI*100)/$mujeres;
        }
        if($culturasF[0]->NOO == 0 || $mujeres == 0){
            $culturasF_no=0;
        }else{
            $culturasF_no=($culturasF[0]->NOO*100)/$mujeres;
        }
        ///////
        if($culturasM[0]->SI == 0 || $hombres == 0){
            $culturasM_si=0;
        }else{
            $culturasM_si=($culturasM[0]->SI*100)/$hombres;
        }
        if($culturasM[0]->NOO == 0 || $hombres == 0){
            $culturasM_no=0;
        }else{
            $culturasM_no=($culturasM[0]->NOO*100)/$hombres;
        }
        /////
        if($enfcgen[0]->SI == 0 || $totalcontestaron == 0){
            $enfcgen_si=0;
        }
        else{
            $enfcgen_si=($enfcgen[0]->SI*100)/$totalcontestaron;
        }
        if($enfcgen[0]->NOO == 0 || $totalcontestaron == 0){
            $enfcgen_no=0;
        }
        else{
            $enfcgen_no=($enfcgen[0]->NOO*100)/$totalcontestaron;
        }
        ////////////
        if($enfcF[0]->SI == 0 || $mujeres == 0){
            $enfcF_si=0;
        }else{
            $enfcF_si=($enfcF[0]->SI*100)/$mujeres;
        }
        if($enfcF[0]->NOO == 0 || $mujeres == 0){
            $enfcF_no=0;
        }else{
            $enfcF_no=($enfcF[0]->NOO*100)/$mujeres;
        }
        ////////////
        if($enfcM[0]->SI == 0 || $hombres == 0){
            $enfcM_si=0;
        }else{
            $enfcM_si=($enfcM[0]->SI*100)/$hombres;
        }
        if($enfcM[0]->NOO == 0 || $hombres == 0){
            $enfcM_no=0;
        }else{
            $enfcM_no=($enfcM[0]->NOO*100)/$hombres;
        }
        /////////
        if($penfcgen[0]->SI == 0 || $totalcontestaron == 0){
            $penfcgen_si=0;
        }else{
            $penfcgen_si=($penfcgen[0]->SI*100)/$totalcontestaron;
        }
        if($penfcgen[0]->NOO == 0 || $totalcontestaron == 0){
            $penfcgen_no=0;
        }else{
            $penfcgen_no=($penfcgen[0]->NOO*100)/$totalcontestaron;
        }
        ////////
        if($penfcF[0]->SI == 0 || $mujeres == 0){
            $penfcF_si=0;
        }else{
            $penfcF_si=($penfcF[0]->SI*100)/$mujeres;
        }
        if($penfcF[0]->NOO == 0 || $mujeres == 0){
            $penfcF_no=0;
        }else{
            $penfcF_no=($penfcF[0]->NOO*100)/$mujeres;
        }
        ////////
        if($penfcM[0]->SI == 0 || $hombres == 0){
            $penfcM_si=0;
        }else{
            $penfcM_si=($penfcM[0]->SI*100)/$hombres;
        }
        if($penfcM[0]->NOO == 0 || $hombres == 0){
            $penfcM_no=0;
        }else{
            $penfcM_no=($penfcM[0]->NOO*100)/$hombres;
        }
        //////
        if($operaciongen[0]->SI == 0 || $totalcontestaron == 0){
            $operaciongen_si=0;
        }else{
            $operaciongen_si=($operaciongen[0]->SI*100)/$totalcontestaron;
        }
        if($operaciongen[0]->NOO == 0 || $totalcontestaron == 0){
            $operaciongen_no=0;
        }else{
            $operaciongen_no=($operaciongen[0]->NOO*100)/$totalcontestaron;
        }
        ////////
        if($operacionF[0]->SI == 0 || $mujeres == 0){
            $operacionF_si=0;
        }else{
            $operacionF_si=($operacionF[0]->SI*100)/$mujeres;
        }
        if($operacionF[0]->NOO == 0 || $mujeres == 0){
            $operacionF_no=0;
        }else{
            $operacionF_no=($operacionF[0]->NOO*100)/$mujeres;
        }
        ////////
        if($operacionM[0]->SI == 0 || $hombres == 0){
            $operacionM_si=0;
        }else{
            $operacionM_si=($operacionM[0]->SI*100)/$hombres;
        }
        if($operacionM[0]->NOO == 0 || $hombres == 0){
            $operacionM_no=0;
        }else{
            $operacionM_no=($operacionM[0]->NOO*100)/$hombres;
        }
        //////
        if($visualgen[0]->SI == 0 || $totalcontestaron == 0){
            $visualgen_si=0;
        }else{
            $visualgen_si=($visualgen[0]->SI*100)/$totalcontestaron;
        }
        if($visualgen[0]->NOO == 0 || $totalcontestaron == 0){
            $visualgen_no=0;
        }else{
            $visualgen_no=($visualgen[0]->NOO*100)/$totalcontestaron;
        }
        /////////
        if($visualF[0]->SI == 0 || $mujeres ==0){
            $visualF_si=0;
        }else{
            $visualF_si=($visualF[0]->SI*100)/$mujeres;
        }
        if($visualF[0]->NOO == 0 || $mujeres ==0){
            $visualF_no=0;
        }else{
            $visualF_no=($visualF[0]->NOO*100)/$mujeres;
        }
        /////////
        if($visualM[0]->SI == 0 || $hombres ==0){
            $visualM_si=0;
        }else{
            $visualM_si=($visualM[0]->SI*100)/$hombres;
        }
        if($visualM[0]->NOO == 0 || $hombres ==0){
            $visualM_no=0;
        }else{
            $visualM_no=($visualM[0]->NOO*100)/$hombres;
        }
        ////////
        if($lentesgen[0]->SI == 0 || $totalcontestaron == 0){
            $lentesgen_si=0;
        }else{
            $lentesgen_si=($lentesgen[0]->SI*100)/$totalcontestaron;
        }
        if($lentesgen[0]->NOO == 0 || $totalcontestaron == 0){
            $lentesgen_no=0;
        }else{
            $lentesgen_no=($lentesgen[0]->NOO*100)/$totalcontestaron;
        }
        /////////////////////
        if($lentesF[0]->SI == 0 || $mujeres == 0){
            $lentesF_si=0;
        }else{
            $lentesF_si=($lentesF[0]->SI*100)/$mujeres;
        }
        if($lentesF[0]->NOO == 0 || $mujeres == 0){
            $lentesF_no=0;
        }else{
            $lentesF_no=($lentesF[0]->NOO*100)/$mujeres;
        }
        /////////////////////
        if($lentesM[0]->SI == 0 || $hombres == 0){
            $lentesM_si=0;
        }else{
            $lentesM_si=($lentesM[0]->SI*100)/$hombres;
        }
        if($lentesM[0]->NOO == 0 || $hombres == 0){
            $lentesM_no=0;
        }else{
            $lentesM_no=($lentesM[0]->NOO*100)/$hombres;
        }
        ///////////
        if($medgen[0]->SI == 0 || $totalcontestaron == 0){
            $medgen_si=0;
        }else{
            $medgen_si=($medgen[0]->SI*100)/$totalcontestaron;
        }
        if($medgen[0]->NOO == 0 || $totalcontestaron == 0){
            $medgen_no=0;
        }else{
            $medgen_no=($medgen[0]->NOO*100)/$totalcontestaron;
        }
        ///////////
        if($medF[0]->SI == 0 || $mujeres == 0){
            $medF_si=0;
        }else{
            $medF_si=($medF[0]->SI*100)/$mujeres;
        }
        if($medF[0]->NOO == 0 || $mujeres == 0){
            $medF_no=0;
        }else{
            $medF_no=($medF[0]->NOO*100)/$mujeres;
        }
        ///////////
        if($medM[0]->SI == 0 || $hombres == 0){
            $medM_si=0;
        }else{
            $medM_si=($medM[0]->SI*100)/$hombres;
        }
        if($medM[0]->NOO == 0 || $hombres == 0){
            $medM_no=0;
        }else{
            $medM_no=($medM[0]->NOO*100)/$hombres;
        }
        return response()->json(
            [
                [
                    [

                        ["name"=>"Si","y"=>round($degen_si)],["name"=>"No","y"=>round($degen_no)]
                    ],
                    [

                        ["name"=>"Si","y"=>round($deF_si)],["name"=>"No","y"=>round($deF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($deM_si)],["name"=>"No","y"=>round($deM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($argen_si)],["name"=>"No","y"=>round($argen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($arF_si)],["name"=>"No","y"=>round($arF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($arM_si)],["name"=>"No","y"=>round($arM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($culturasgen_si)],["name"=>"No","y"=>round($culturasgen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($culturasF_si)],["name"=>"No","y"=>round($culturasF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($culturasM_si)],["name"=>"No","y"=>round($culturasM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($enfcgen_si)],["name"=>"No","y"=>round($enfcgen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($enfcF_si)],["name"=>"No","y"=>round($enfcF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($enfcM_si)],["name"=>"No","y"=>round($enfcM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($penfcgen_si)],["name"=>"No","y"=>round($penfcgen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($penfcF_si)],["name"=>"No","y"=>round($penfcF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($penfcM_si)],["name"=>"No","y"=>round($penfcM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($operaciongen_si)],["name"=>"No","y"=>round($operaciongen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($operacionF_si)],["name"=>"No","y"=>round($operacionF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($operacionM_si)],["name"=>"No","y"=>round($operacionM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($visualgen_si)],["name"=>"No","y"=>round($visualgen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($visualF_si)],["name"=>"No","y"=>round($visualF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($visualM_si)],["name"=>"No","y"=>round($visualM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($lentesgen_si)],["name"=>"No","y"=>round($lentesgen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($lentesF_si)],["name"=>"No","y"=>round($lentesF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round( $lentesM_si)],["name"=>"No","y"=>round( $lentesM_no)]
                    ]
                ],
                [
                    [

                        ["name"=>"Si","y"=>round($medgen_si)],["name"=>"No","y"=>round($medgen_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($medF_si)],["name"=>"No","y"=>round($medF_no)]
                    ],
                    [
                        ["name"=>"Si","y"=>round($medM_si)],["name"=>"No","y"=>round($medM_no)]
                    ]
                ],
            ],200
        );

    }
    public function area(Request $request)
    {

        $traegen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.trabajo_equipo=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.trabajo_equipo=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.trabajo_equipo=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.trabajo_equipo=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.trabajo_equipo=5) as M');

        $traeF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=5) as M');
        $traeM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=5) as M');

        $rengen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.rendimiento_escolar=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.rendimiento_escolar=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.rendimiento_escolar=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.rendimiento_escolar=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.rendimiento_escolar=5) as M');

        $renF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=5) as M');
        $renM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=5) as M');
        $comgen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.conocimiento_compu=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.conocimiento_compu=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.conocimiento_compu=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.conocimiento_compu=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.conocimiento_compu=5) as M');

        $comF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=5) as M');
        $comM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=5) as M');
        $retgen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.comprension=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.comprension=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.comprension=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.comprension=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.comprension=5) as M');

        $retF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=5) as M');
        $retM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=5) as M');

        $exagen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.preparacion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.preparacion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.preparacion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.preparacion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.preparacion=5) as M');

        $exaF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=5) as M');
        $exaM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=5) as M');
        $congen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.concentracion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.concentracion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.concentracion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.concentracion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.concentracion=5) as M');

        $conF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=5) as M');
        $conM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=5) as M');
        $bbgen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.busqueda_bibliografica=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.busqueda_bibliografica=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.busqueda_bibliografica=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.busqueda_bibliografica=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.busqueda_bibliografica=5) as M');

        $bbF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=5) as M');
        $bbM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=5) as M');
        $oigen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.otro_idioma=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.otro_idioma=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.otro_idioma=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.otro_idioma=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.otro_idioma=5) as M');

        $oiF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=5) as M');
        $oiM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=5) as M');
        $spgen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.solucion_problemas=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.solucion_problemas=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.solucion_problemas=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.solucion_problemas=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_area_psicopedagogica.solucion_problemas=5) as M');

        $spF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=5) as M');
        $spM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                     JOIN exp_asigna_alumnos ON exp_area_psicopedagogica.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=5) as M');

        $alumnos=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="M") as M, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                     JOIN exp_asigna_alumnos ON exp_generales.id_alumno=exp_asigna_alumnos.id_alumno
                     JOIN exp_asigna_tutor ON exp_asigna_tutor.id_asigna_generacion=exp_asigna_alumnos.id_asigna_generacion
                      WHERE  exp_generales.id_carrera='.$request->id_carrera.' AND exp_asigna_alumnos.id_asigna_generacion='.$request->id_asigna_generacion.' AND exp_asigna_alumnos.deleted_at is null AND exp_generales.sexo="F") as F');
             $totalcontestaron=$alumnos[0]->M+$alumnos[0]->F;
            $hombres=$alumnos[0]->M;
            $mujeres=$alumnos[0]->F;
        if($traegen[0]->M == 0 || $totalcontestaron == 0 ){
            $traegen_m=0;
        }else{
            $traegen_m=($traegen[0]->M*100)/$totalcontestaron;
        }
        /////
        if($traegen[0]->R == 0 || $totalcontestaron == 0 ){
            $traegen_r=0;
        }else{
            $traegen_r=($traegen[0]->R*100)/$totalcontestaron;
        }
        /////
        if($traegen[0]->B == 0 || $totalcontestaron == 0 ){
            $traegen_b=0;
        }else{
            $traegen_b=($traegen[0]->B*100)/$totalcontestaron;
        }
        /////
        if($traegen[0]->MB == 0 || $totalcontestaron == 0 ){
            $traegen_mb=0;
        }else{
            $traegen_mb=($traegen[0]->MB*100)/$totalcontestaron;
        }
        /////
        if($traegen[0]->E == 0 || $totalcontestaron == 0 ){
            $traegen_e=0;
        }else{
            $traegen_e=($traegen[0]->E*100)/$totalcontestaron;
        }
        /////////
        if($traeF[0]->M == 0 || $mujeres == 0){
            $traeF_m=0;
        }else{
            $traeF_m=($traeF[0]->M*100)/$mujeres;
        }
        ///////////
        if($traeF[0]->R == 0 || $mujeres == 0){
            $traeF_r=0;
        }else{
            $traeF_r=($traeF[0]->R*100)/$mujeres;
        }
        ///////////
        if($traeF[0]->B == 0 || $mujeres == 0){
            $traeF_b=0;
        }else{
            $traeF_b=($traeF[0]->B*100)/$mujeres;
        }
        ///////////
        if($traeF[0]->MB == 0 || $mujeres == 0){
            $traeF_mb=0;
        }else{
            $traeF_mb=($traeF[0]->MB*100)/$mujeres;
        }
        ///////////
        if($traeF[0]->E == 0 || $mujeres == 0){
            $traeF_e=0;
        }else{
            $traeF_e=($traeF[0]->E*100)/$mujeres;
        }


        if($traeM[0]->M == 0 || $hombres == 0){
            $traeM_m=0;
        }else{
            $traeM_m=($traeM[0]->M*100)/$hombres;
        }
        ///////////
        if($traeM[0]->R == 0 || $hombres == 0){
            $traeM_r=0;
        }else{
            $traeM_r=($traeM[0]->R*100)/$hombres;
        }
        ///////////
        if($traeM[0]->B == 0 || $hombres == 0){
            $traeM_b=0;
        }else{
            $traeM_b=($traeM[0]->B*100)/$hombres;
        }
        ///////////
        if($traeM[0]->MB == 0 || $hombres == 0){
            $traeM_mb=0;
        }else{
            $traeM_mb=($traeM[0]->MB*100)/$hombres;
        }
        ///////////
        if($traeM[0]->E == 0 || $hombres == 0){
            $traeM_e=0;
        }else{
            $traeM_e=($traeM[0]->E*100)/$hombres;
        }
        ////////////
        if($rengen[0]->M == 0 || $totalcontestaron == 0){
            $rengen_m=0;
        }else{
            $rengen_m=($rengen[0]->M*100)/$totalcontestaron;
        }
        /////////
        if($rengen[0]->R == 0 || $totalcontestaron == 0){
            $rengen_r=0;
        }else{
            $rengen_r=($rengen[0]->R*100)/$totalcontestaron;
        }
        /////////
        if($rengen[0]->B == 0 || $totalcontestaron == 0){
            $rengen_b=0;
        }else{
            $rengen_b=($rengen[0]->B*100)/$totalcontestaron;
        }
        /////////
        if($rengen[0]->MB == 0 || $totalcontestaron == 0){
            $rengen_mb=0;
        }else{
            $rengen_mb=($rengen[0]->MB*100)/$totalcontestaron;
        }
        /////////
        if($rengen[0]->E == 0 || $totalcontestaron == 0){
            $rengen_e=0;
        }else{
            $rengen_e=($rengen[0]->E*100)/$totalcontestaron;
        }
        ////////////////////
        if($renF[0]->M == 0 || $mujeres == 0){
            $renF_m=0;
        }else{
            $renF_m=($renF[0]->M*100)/$mujeres;
        }
        ////////////////////
        if($renF[0]->R == 0 || $mujeres == 0){
            $renF_r=0;
        }else{
            $renF_r=($renF[0]->R*100)/$mujeres;
        }
        ////////////////////
        if($renF[0]->B == 0 || $mujeres == 0){
            $renF_b=0;
        }else{
            $renF_b=($renF[0]->B*100)/$mujeres;
        }
        ////////////////////
        if($renF[0]->MB == 0 || $mujeres == 0){
            $renF_mb=0;
        }else{
            $renF_mb=($renF[0]->MB*100)/$mujeres;
        }
        ////////////////////
        if($renF[0]->E == 0 || $mujeres == 0){
            $renF_e=0;
        }else{
            $renF_e=($renF[0]->E*100)/$mujeres;
        }

        ////////////////////
        if($renM[0]->M == 0 || $hombres== 0){
            $renM_m=0;
        }else{
            $renM_m=($renM[0]->M*100)/$hombres;
        }
        ////////////////////
        if($renM[0]->R == 0 || $hombres == 0){
            $renM_r=0;
        }else{
            $renM_r=($renM[0]->R*100)/$hombres;
        }
        ////////////////////
        if($renM[0]->B == 0 || $hombres == 0){
            $renM_b=0;
        }else{
            $renM_b=($renM[0]->B*100)/$hombres;
        }
        ////////////////////
        if($renM[0]->MB == 0 || $hombres == 0){
            $renM_mb=0;
        }else{
            $renM_mb=($renM[0]->MB*100)/$hombres;
        }
        ////////////////////
        if($renM[0]->E == 0 || $hombres == 0){
            $renM_e=0;
        }else{
            $renM_e=($renM[0]->E*100)/$hombres;
        }
        //////////
        if($comgen[0]->M == 0 || $totalcontestaron == 0){
            $comgen_m=0;
        }else{
            $comgen_m=($comgen[0]->M*100)/$totalcontestaron;
        }
        if($comgen[0]->R == 0 || $totalcontestaron == 0){
            $comgen_r=0;
        }else{
            $comgen_r=($comgen[0]->R*100)/$totalcontestaron;
        }

        if($comgen[0]->B == 0 || $totalcontestaron == 0){
            $comgen_b=0;
        }else{
            $comgen_b=($comgen[0]->B*100)/$totalcontestaron;
        }
        if($comgen[0]->MB == 0 || $totalcontestaron == 0){
            $comgen_mb=0;
        }else{
            $comgen_mb=($comgen[0]->MB*100)/$totalcontestaron;
        }
        if($comgen[0]->E == 0 || $totalcontestaron == 0){
            $comgen_e=0;
        }else{
            $comgen_e=($comgen[0]->E*100)/$totalcontestaron;
        }
        //////////////
        if($comF[0]->M == 0 || $mujeres == 0){
            $comF_m=0;
        }else{
            $comF_m=($comF[0]->M*100)/$mujeres;
        }
        if($comF[0]->R == 0 || $mujeres == 0){
            $comF_r=0;
        }else{
            $comF_r=($comF[0]->R*100)/$mujeres;
        }
        if($comF[0]->B == 0 || $mujeres == 0){
            $comF_b=0;
        }else{
            $comF_b=($comF[0]->B*100)/$mujeres;
        }
        if($comF[0]->MB == 0 || $mujeres == 0){
            $comF_mb=0;
        }else{
            $comF_mb=($comF[0]->MB*100)/$mujeres;
        }
        if($comF[0]->E == 0 || $mujeres == 0){
            $comF_e=0;
        }else{
            $comF_e=($comF[0]->E*100)/$mujeres;
        }
        ////////////////
        if($comM[0]->M == 0 || $hombres == 0){
            $comM_m=0;
        }else{
            $comM_m=($comM[0]->M*100)/$hombres;
        }
        if($comM[0]->R == 0 || $hombres == 0){
            $comM_r=0;
        }else{
            $comM_r=($comM[0]->R*100)/$hombres;
        }
        if($comM[0]->B == 0 || $hombres == 0){
            $comM_b=0;
        }else{
            $comM_b=($comM[0]->B*100)/$hombres;
        }
        if($comM[0]->MB == 0 || $hombres == 0){
            $comM_mb=0;
        }else{
            $comM_mb=($comM[0]->MB*100)/$hombres;
        }
        if($comM[0]->E == 0 || $hombres == 0){
            $comM_e=0;
        }else{
            $comM_e=($comM[0]->E*100)/$hombres;
        }
        ///////////
        if($retgen[0]->M == 0 || $totalcontestaron == 0){
            $retgen_m=0;
        }else{
            $retgen_m=($retgen[0]->M*100)/$totalcontestaron;
        }
        if($retgen[0]->R == 0 || $totalcontestaron == 0){
            $retgen_r=0;
        }else{
            $retgen_r=($retgen[0]->R*100)/$totalcontestaron;
        }
        if($retgen[0]->B == 0 || $totalcontestaron == 0){
            $retgen_b=0;
        }else{
            $retgen_b=($retgen[0]->B*100)/$totalcontestaron;
        }
        if($retgen[0]->MB == 0 || $totalcontestaron == 0){
            $retgen_mb=0;
        }else{
            $retgen_mb=($retgen[0]->MB*100)/$totalcontestaron;
        }
        if($retgen[0]->E == 0 || $totalcontestaron == 0){
            $retgen_e=0;
        }else{
            $retgen_e=($retgen[0]->E*100)/$totalcontestaron;
        }
        ////////////
        if($retF[0]->M == 0 || $mujeres == 0){
            $retF_m=0;
        }else{
            $retF_m=($retF[0]->M*100)/$mujeres;
        }
        if($retF[0]->R == 0 || $mujeres == 0){
            $retF_r=0;
        }else{
            $retF_r=($retF[0]->R*100)/$mujeres;
        }
        if($retF[0]->B == 0 || $mujeres == 0){
            $retF_b=0;
        }else{
            $retF_b=($retF[0]->B*100)/$mujeres;
        }
        /////////////
        if($retF[0]->MB == 0 || $mujeres == 0){
            $retF_mb=0;
        }else{
            $retF_mb=($retF[0]->MB*100)/$mujeres;
        }
        /////////////
        if($retF[0]->E == 0 || $mujeres == 0){
            $retF_e=0;
        }else{
            $retF_e=($retF[0]->E*100)/$mujeres;
        }
        ////////////////
        if($retM[0]->M == 0 || $hombres == 0){
            $retM_m=0;
        }else{
            $retM_m=($retM[0]->M*100)/$hombres;
        }
        if($retM[0]->R == 0 || $hombres == 0){
            $retM_r=0;
        }else{
            $retM_r=($retM[0]->R*100)/$hombres;
        }
        if($retM[0]->B == 0 || $hombres == 0){
            $retM_b=0;
        }else{
            $retM_b=($retM[0]->B*100)/$hombres;
        }
        /////////////
        if($retM[0]->MB == 0 || $hombres == 0){
            $retM_mb=0;
        }else{
            $retM_mb=($retM[0]->MB*100)/$hombres;
        }
        /////////////
        if($retM[0]->E == 0 || $hombres == 0){
            $retM_e=0;
        }else{
            $retM_e=($retM[0]->E*100)/$hombres;
        }
        ////////////////
        if($exagen[0]->M == 0 || $totalcontestaron == 0){
            $exagen_m=0;
        }else{
            $exagen_m=($exagen[0]->M*100)/$totalcontestaron;
        }
        if($exagen[0]->R == 0 || $totalcontestaron == 0){
            $exagen_r=0;
        }else{
            $exagen_r=($exagen[0]->R*100)/$totalcontestaron;
        }
        if($exagen[0]->B == 0 || $totalcontestaron == 0){
            $exagen_b=0;
        }else{
            $exagen_b=($exagen[0]->B*100)/$totalcontestaron;
        }
        if($exagen[0]->MB == 0 || $totalcontestaron == 0){
            $exagen_mb=0;
        }else{
            $exagen_mb=($exagen[0]->MB*100)/$totalcontestaron;
        }
        if($exagen[0]->E == 0 || $totalcontestaron == 0){
            $exagen_e=0;
        }else{
            $exagen_e=($exagen[0]->E*100)/$totalcontestaron;
        }
        //////////////////////////////////
        if($exaF[0]->M == 0 || $mujeres == 0){
            $exaF_m=0;
        }else{
            $exaF_m=($exaF[0]->M*100)/$mujeres;
        }
        if($exaF[0]->R == 0 || $mujeres == 0){
            $exaF_r=0;
        }else{
            $exaF_r=($exaF[0]->R*100)/$mujeres;
        }
        if($exaF[0]->B == 0 || $mujeres == 0){
            $exaF_b=0;
        }else{
            $exaF_b=($exaF[0]->B*100)/$mujeres;
        }
        if($exaF[0]->MB == 0 || $mujeres == 0){
            $exaF_mb=0;
        }else{
            $exaF_mb=($exaF[0]->MB*100)/$mujeres;
        }
        if($exaF[0]->E == 0 || $mujeres == 0){
            $exaF_e=0;
        }else{
            $exaF_e=($exaF[0]->E*100)/$mujeres;
        }
        ///////////////////////////////////////
        if($exaM[0]->M == 0 || $hombres == 0){
            $exaM_m=0;
        }else{
            $exaM_m=($exaM[0]->M*100)/$hombres;
        }
        if($exaM[0]->R == 0 || $hombres == 0){
            $exaM_r=0;
        }else{
            $exaM_r=($exaM[0]->R*100)/$hombres;
        }
        if($exaM[0]->B == 0 || $hombres == 0){
            $exaM_b=0;
        }else{
            $exaM_b=($exaM[0]->B*100)/$hombres;
        }
        if($exaM[0]->MB == 0 || $hombres == 0){
            $exaM_mb=0;
        }else{
            $exaM_mb=($exaM[0]->MB*100)/$hombres;
        }
        if($exaM[0]->E == 0 || $hombres == 0){
            $exaM_e=0;
        }else{
            $exaM_e=($exaM[0]->E*100)/$hombres;
        }
        /////////////////////////////
        if($congen[0]->M == 0 || $totalcontestaron == 0){
            $congen_m=0;
        } else{
            $congen_m=($congen[0]->M*100)/$totalcontestaron;
        }
        if($congen[0]->R == 0 || $totalcontestaron == 0){
            $congen_r=0;
        } else{
            $congen_r=($congen[0]->R*100)/$totalcontestaron;
        }
        if($congen[0]->B == 0 || $totalcontestaron == 0){
            $congen_b=0;
        } else{
            $congen_b=($congen[0]->B*100)/$totalcontestaron;
        }
        if($congen[0]->MB == 0 || $totalcontestaron == 0){
            $congen_mb=0;
        } else{
            $congen_mb=($congen[0]->MB*100)/$totalcontestaron;
        }
        if($congen[0]->E == 0 || $totalcontestaron == 0){
            $congen_e=0;
        } else{
            $congen_e=($congen[0]->E*100)/$totalcontestaron;
        }
        ///////////////////////////
        if($conF[0]->M == 0 || $mujeres === 0){
            $conF_m=0;
        }else{
            $conF_m=($conF[0]->M*100)/$mujeres;
        }
        if($conF[0]->R == 0 || $mujeres === 0){
            $conF_r=0;
        }else{
            $conF_r=($conF[0]->R*100)/$mujeres;
        }
        if($conF[0]->B == 0 || $mujeres === 0){
            $conF_b=0;
        }else{
            $conF_b=($conF[0]->B*100)/$mujeres;
        }
        if($conF[0]->MB == 0 || $mujeres === 0){
            $conF_mb=0;
        }else{
            $conF_mb=($conF[0]->MB*100)/$mujeres;
        }
        if($conF[0]->E == 0 || $mujeres === 0){
            $conF_e=0;
        }else{
            $conF_e=($conF[0]->E*100)/$mujeres;
        }
        ////////////
        if($conM[0]->M == 0 || $hombres === 0){
            $conM_m=0;
        }else{
            $conM_m=($conM[0]->M*100)/$hombres;
        }
        if($conM[0]->R == 0 || $hombres === 0){
            $conM_r=0;
        }else{
            $conM_r=($conM[0]->R*100)/$hombres;
        }
        if($conM[0]->B == 0 || $hombres === 0){
            $conM_b=0;
        }else{
            $conM_b=($conM[0]->B*100)/$hombres;
        }
        if($conM[0]->MB == 0 || $hombres === 0){
            $conM_mb=0;
        }else{
            $conM_mb=($conM[0]->MB*100)/$hombres;
        }
        if($conM[0]->E == 0 || $hombres === 0){
            $conM_e=0;
        }else{
            $conM_e=($conM[0]->E*100)/$hombres;
        }
        /////////////////////////////////////////////////////
        if($bbgen[0]->M == 0 || $totalcontestaron == 0){
            $bbgen_m=0;
        }else{
            $bbgen_m=($bbgen[0]->M*100)/$totalcontestaron;
        }
        if($bbgen[0]->R == 0 || $totalcontestaron == 0){
            $bbgen_r=0;
        }else{
            $bbgen_r=($bbgen[0]->R*100)/$totalcontestaron;
        }
        if($bbgen[0]->B == 0 || $totalcontestaron == 0){
            $bbgen_b=0;
        }else{
            $bbgen_b=($bbgen[0]->B*100)/$totalcontestaron;
        }
        if($bbgen[0]->MB == 0 || $totalcontestaron == 0){
            $bbgen_mb=0;
        }else{
            $bbgen_mb=($bbgen[0]->MB*100)/$totalcontestaron;
        }
        if($bbgen[0]->E == 0 || $totalcontestaron == 0){
            $bbgen_e=0;
        }else{
            $bbgen_e=($bbgen[0]->E*100)/$totalcontestaron;
        }
        //////////////////////////////////////////////////////
        if($bbF[0]->M == 0 || $mujeres == 0){
            $bbF_m=0;
        }else{
            $bbF_m=($bbF[0]->M*100)/$mujeres;
        }
        if($bbF[0]->R == 0 || $mujeres == 0){
            $bbF_r=0;
        }else{
            $bbF_r=($bbF[0]->R*100)/$mujeres;
        }
        if($bbF[0]->B == 0 || $mujeres == 0){
            $bbF_b=0;
        }else{
            $bbF_b=($bbF[0]->B*100)/$mujeres;
        }
        if($bbF[0]->MB == 0 || $mujeres == 0){
            $bbF_mb=0;
        }else{
            $bbF_mb=($bbF[0]->MB*100)/$mujeres;
        }
        if($bbF[0]->E == 0 || $mujeres == 0){
            $bbF_e=0;
        }else{
            $bbF_e=($bbF[0]->E*100)/$mujeres;
        }
        /////////////////////////////////////////
        if($bbM[0]->M == 0 || $hombres == 0){
            $bbM_m=0;
        }else{
            $bbM_m=($bbM[0]->M*100)/$hombres;
        }
        if($bbM[0]->R == 0 || $hombres == 0){
            $bbM_r=0;
        }else{
            $bbM_r=($bbM[0]->R*100)/$hombres;
        }
        if($bbM[0]->B == 0 || $hombres == 0){
            $bbM_b=0;
        }else{
            $bbM_b=($bbM[0]->B*100)/$hombres;
        }
        if($bbM[0]->MB == 0 || $hombres == 0){
            $bbM_mb=0;
        }else{
            $bbM_mb=($bbM[0]->MB*100)/$hombres;
        }
        if($bbM[0]->E == 0 || $hombres == 0){
            $bbM_e=0;
        }else{
            $bbM_e=($bbM[0]->E*100)/$hombres;
        }
        ////////////////////////////////////////////
        if($oigen[0]->M == 0 || $totalcontestaron == 0){
            $oigen_m=0;
        }else{
            $oigen_m=($oigen[0]->M*100)/$totalcontestaron;
        }
        if($oigen[0]->R == 0 || $totalcontestaron == 0){
            $oigen_r=0;
        }else{
            $oigen_r=($oigen[0]->R*100)/$totalcontestaron;
        }
        if($oigen[0]->B == 0 || $totalcontestaron == 0){
            $oigen_b=0;
        }else{
            $oigen_b=($oigen[0]->B*100)/$totalcontestaron;
        }
        if($oigen[0]->MB == 0 || $totalcontestaron == 0){
            $oigen_mb=0;
        }else{
            $oigen_mb=($oigen[0]->MB*100)/$totalcontestaron;
        }
        if($oigen[0]->E == 0 || $totalcontestaron == 0){
            $oigen_e=0;
        }else{
            $oigen_e=($oigen[0]->E*100)/$totalcontestaron;
        }
        /////////////////////////////
        if($oiF[0]->M == 0 || $mujeres == 0){
            $oiF_m=0;
        }else{
            $oiF_m=($oiF[0]->M*100)/$mujeres;
        }
        if($oiF[0]->R == 0 || $mujeres == 0){
            $oiF_r=0;
        }else{
            $oiF_r=($oiF[0]->R*100)/$mujeres;
        }
        if($oiF[0]->B == 0 || $mujeres == 0){
            $oiF_b=0;
        }else{
            $oiF_b=($oiF[0]->B*100)/$mujeres;
        }
        if($oiF[0]->MB == 0 || $mujeres == 0){
            $oiF_mb=0;
        }else{
            $oiF_mb=($oiF[0]->MB*100)/$mujeres;
        }
        if($oiF[0]->E == 0 || $mujeres == 0){
            $oiF_e=0;
        }else{
            $oiF_e=($oiF[0]->E*100)/$mujeres;
        }
        /////////////
        if($oiM[0]->M == 0 || $hombres == 0){
            $oiM_m=0;
        }else{
            $oiM_m=($oiM[0]->M*100)/$hombres;
        }
        if($oiM[0]->R == 0 || $hombres == 0){
            $oiM_r=0;
        }else{
            $oiM_r=($oiM[0]->R*100)/$hombres;
        }
        if($oiM[0]->B == 0 || $hombres == 0){
            $oiM_b=0;
        }else{
            $oiM_b=($oiM[0]->B*100)/$hombres;
        }
        if($oiM[0]->MB == 0 || $hombres == 0){
            $oiM_mb=0;
        }else{
            $oiM_mb=($oiM[0]->MB*100)/$hombres;
        }
        if($oiM[0]->E == 0 || $hombres == 0){
            $oiM_e=0;
        }else{
            $oiM_e=($oiM[0]->E*100)/$hombres;
        }
        /////////////////////////////////////////
        if($spgen[0]->M == 0 || $totalcontestaron == 0){
            $spgen_m=0;
        }else{
            $spgen_m=($spgen[0]->M*100)/$totalcontestaron;
        }
        if($spgen[0]->R == 0 || $totalcontestaron == 0){
            $spgen_r=0;
        }else{
            $spgen_r=($spgen[0]->R*100)/$totalcontestaron;
        }
        if($spgen[0]->B == 0 || $totalcontestaron == 0){
            $spgen_b=0;
        }else{
            $spgen_b=($spgen[0]->B*100)/$totalcontestaron;
        }
        if($spgen[0]->MB == 0 || $totalcontestaron == 0){
            $spgen_mb=0;
        }else{
            $spgen_mb=($spgen[0]->MB*100)/$totalcontestaron;
        }
        if($spgen[0]->E == 0 || $totalcontestaron == 0){
            $spgen_e=0;
        }else{
            $spgen_e=($spgen[0]->E*100)/$totalcontestaron;
        }
        ////////////////////////////////////////////////////////////////////////////////////////

        if($spF[0]->M == 0 || $mujeres === 0){
            $spF_m=0;
        }else{
            $spF_m=($spF[0]->M*100)/$mujeres;
        }
        if($spF[0]->R == 0 || $mujeres === 0){
            $spF_r=0;
        }else{
            $spF_r=($spF[0]->R*100)/$mujeres;
        }
        if($spF[0]->B == 0 || $mujeres === 0){
            $spF_b=0;
        }else{
            $spF_b=($spF[0]->B*100)/$mujeres;
        }
        if($spF[0]->MB == 0 || $mujeres === 0){
            $spF_mb=0;
        }else{
            $spF_mb=($spF[0]->MB*100)/$mujeres;
        }
        if($spF[0]->E == 0 || $mujeres === 0){
            $spF_e=0;
        }else{
            $spF_e=($spF[0]->E*100)/$mujeres;
        }

        ////////////////////////////////
        if($spM[0]->M == 0 || $hombres === 0){
            $spM_m=0;
        }else{
            $spM_m=($spM[0]->M*100)/$hombres;
        }
        if($spM[0]->R == 0 || $hombres === 0){
            $spM_r=0;
        }else{
            $spM_r=($spM[0]->R*100)/$hombres;
        }
        if($spM[0]->B == 0 || $hombres === 0){
            $spM_b=0;
        }else{
            $spM_b=($spM[0]->B*100)/$hombres;
        }
        if($spM[0]->MB == 0 || $hombres === 0){
            $spM_mb=0;
        }else{
            $spM_mb=($spM[0]->MB*100)/$hombres;
        }
        if($spM[0]->E == 0 || $hombres === 0){
            $spM_e=0;
        }else{
            $spM_e=($spM[0]->E*100)/$hombres;
        }
        return response()->json(
            [
                [
                    [
                        ["name"=>"Mala","y"=>round($traegen_m)],["name"=>"Regular","y"=>round($traegen_r)],["name"=>"Bien","y"=>round($traegen_b)],["name"=>"Muy bien","y"=>round($traegen_mb)],["name"=>"Excelente","y"=>round($traegen_e)]
                    ],
                    [
                         ["name"=>"Mala","y"=>round($traeF_m)],["name"=>"Regular","y"=>round($traeF_r)],["name"=>"Bien","y"=>round($traeF_b)],["name"=>"Muy bien","y"=>round($traeF_mb)],["name"=>"Excelente","y"=>round($traeF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($traeM_m)],["name"=>"Regular","y"=>round($traeM_r)],["name"=>"Bien","y"=>round($traeM_b)],["name"=>"Muy bien","y"=>round($traeM_mb)],["name"=>"Excelente","y"=>round($traeM_e)]
                    ]
                ],
                [
                    [

                        ["name"=>"Mala","y"=>round($rengen_m)],["name"=>"Regular","y"=>round($rengen_r)],["name"=>"Bien","y"=>round($rengen_b)],["name"=>"Muy bien","y"=>round($rengen_mb)],["name"=>"Excelente","y"=>round($rengen_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($renF_m)],["name"=>"Regular","y"=>round($renF_r)],["name"=>"Bien","y"=>round($renF_b)],["name"=>"Muy bien","y"=>round($renF_mb)],["name"=>"Excelente","y"=>round($renF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($renM_m)],["name"=>"Regular","y"=>round($renM_r)],["name"=>"Bien","y"=>round($renM_b)],["name"=>"Muy bien","y"=>round($renM_mb)],["name"=>"Excelente","y"=>round($renM_e)]
                    ]
                ],
                [
                    [

                        ["name"=>"Mala","y"=>round($comgen_m)],["name"=>"Regular","y"=>round($comgen_r)],["name"=>"Bien","y"=>round($comgen_b)],["name"=>"Muy bien","y"=>round($comgen_mb)],["name"=>"Excelente","y"=>round($comgen_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($comF_m)],["name"=>"Regular","y"=>round($comF_r)],["name"=>"Bien","y"=>round( $comF_b)],["name"=>"Muy bien","y"=>round($comF_mb)],["name"=>"Excelente","y"=>round($comF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($comM_m)],["name"=>"Regular","y"=>round($comM_r)],["name"=>"Bien","y"=>round($comM_b)],["name"=>"Muy bien","y"=>round($comM_mb)],["name"=>"Excelente","y"=>round($comM_e)]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round($retgen_m)],["name"=>"Regular","y"=>round($retgen_r)],["name"=>"Bien","y"=>round($retgen_b)],["name"=>"Muy bien","y"=>round( $retgen_mb)],["name"=>"Excelente","y"=>round($retgen_e)]
                    ],
                    [

                        ["name"=>"Mala","y"=>round($retF_m)],["name"=>"Regular","y"=>round($retF_r)],["name"=>"Bien","y"=>round($retF_b)],["name"=>"Muy bien","y"=>round($retF_mb)],["name"=>"Excelente","y"=>round($retF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($retM_m)],["name"=>"Regular","y"=>round($retM_r)],["name"=>"Bien","y"=>round($retM_b)],["name"=>"Muy bien","y"=>round($retM_mb)],["name"=>"Excelente","y"=>round($retM_e)]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round($exagen_m)],["name"=>"Regular","y"=>round($exagen_r)],["name"=>"Bien","y"=>round($exagen_b)],["name"=>"Muy bien","y"=>round($exagen_mb)],["name"=>"Excelente","y"=>round($exagen_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($exaF_m)],["name"=>"Regular","y"=>round($exaF_r)],["name"=>"Bien","y"=>round($exaF_b)],["name"=>"Muy bien","y"=>round($exaF_mb)],["name"=>"Excelente","y"=>round($exaF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($exaM_m)],["name"=>"Regular","y"=>round($exaM_r)],["name"=>"Bien","y"=>round($exaM_b)],["name"=>"Muy bien","y"=>round($exaM_mb)],["name"=>"Excelente","y"=>round($exaM_e)]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round($congen_m)],["name"=>"Regular","y"=>round($congen_r)],["name"=>"Bien","y"=>round($congen_b)],["name"=>"Muy bien","y"=>round( $congen_mb)],["name"=>"Excelente","y"=>round($congen_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($conF_m)],["name"=>"Regular","y"=>round($conF_r)],["name"=>"Bien","y"=>round($conF_b)],["name"=>"Muy bien","y"=>round($conF_mb)],["name"=>"Excelente","y"=>round($conF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($conF_m)],["name"=>"Regular","y"=>round($conM_r)],["name"=>"Bien","y"=>round($conM_b)],["name"=>"Muy bien","y"=>round($conM_mb)],["name"=>"Excelente","y"=>round($conM_e)]
                    ]
                ],
                [
                    [

                        ["name"=>"Mala","y"=>round($bbgen_m)],["name"=>"Regular","y"=>round($bbgen_r)],["name"=>"Bien","y"=>round( $bbgen_b)],["name"=>"Muy bien","y"=>round($bbgen_mb)],["name"=>"Excelente","y"=>round($bbgen_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($bbF_m)],["name"=>"Regular","y"=>round($bbF_r)],["name"=>"Bien","y"=>round($bbF_b)],["name"=>"Muy bien","y"=>round($bbF_mb)],["name"=>"Excelente","y"=>round($bbF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($bbM_m)],["name"=>"Regular","y"=>round($bbM_r)],["name"=>"Bien","y"=>round($bbM_b)],["name"=>"Muy bien","y"=>round($bbM_mb)],["name"=>"Excelente","y"=>round($bbM_e)]
                    ]
                ],
                [
                    [

                        ["name"=>"Mala","y"=>round($oigen_m)],["name"=>"Regular","y"=>round($oigen_r)],["name"=>"Bien","y"=>round( $oigen_b)],["name"=>"Muy bien","y"=>round($oigen_mb)],["name"=>"Excelente","y"=>round($oigen_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($oiF_m)],["name"=>"Regular","y"=>round($oiF_r)],["name"=>"Bien","y"=>round($oiF_b)],["name"=>"Muy bien","y"=>round($oiF_mb)],["name"=>"Excelente","y"=>round($oiF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($oiM_m)],["name"=>"Regular","y"=>round($oiM_r)],["name"=>"Bien","y"=>round($oiM_b)],["name"=>"Muy bien","y"=>round($oiM_mb)],["name"=>"Excelente","y"=>round($oiM_e)]
                    ]
                ],
                [
                    [

                        ["name"=>"Mala","y"=>round($spgen_m)],["name"=>"Regular","y"=>round($spgen_r)],["name"=>"Bien","y"=>round($spgen_b)],["name"=>"Muy bien","y"=>round($spgen_mb)],["name"=>"Excelente","y"=>round($spgen_e)]
                    ],
                    [

                        ["name"=>"Mala","y"=>round($spF_m)],["name"=>"Regular","y"=>round($spF_r)],["name"=>"Bien","y"=>round($spF_b)],["name"=>"Muy bien","y"=>round($spF_mb)],["name"=>"Excelente","y"=>round($spF_e)]
                    ],
                    [
                        ["name"=>"Mala","y"=>round($spM_m)],["name"=>"Regular","y"=>round($spM_r)],["name"=>"Bien","y"=>round($spM_b)],["name"=>"Muy bien","y"=>round($spM_mb)],["name"=>"Excelente","y"=>round($spM_e)]
                    ]
                ],

            ],200
        );


    }

}
