<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Personal;
use App\CategoriaAct;
use App\DocenteActividad;
use App\RegistroAlumnos;
use App\ActividadesComplementarias;
use Session;

class Tutorias_GraficasInstitucionController extends Controller
{
    //
    public function genero()
    {

        //ALUMNOS LLENARON EXPEDIENTE
        $EF=DB::table('gnral_alumnos')
            ->join('exp_generales','exp_generales.id_alumno','=','gnral_alumnos.id_alumno')
            ->where('exp_generales.sexo','F')
            ->select('gnral_alumnos.nombre')
            ->get()->count();
        $EM=DB::table('gnral_alumnos')
            ->join('exp_generales','exp_generales.id_alumno','=','gnral_alumnos.id_alumno')
            ->where('exp_generales.sexo','M')
            ->select('gnral_alumnos.nombre')
            ->get()->count();

        $totalcontestaron=$EF+$EM;

        Session::put('total_alumnos',$totalcontestaron==0?1:$totalcontestaron);
        Session::put('total_mujeres',$EF==0?1:$EF);
        Session::put('total_hombres',$EM==0?1:$EM);

        ///ALUMNOS TOTALES
        $F=DB::table('gnral_alumnos')
            ->join('eva_validacion_de_cargas','eva_validacion_de_cargas.id_alumno','=','gnral_alumnos.id_alumno')
            ->where('eva_validacion_de_cargas.id_periodo','=',Session::get('periodo_actual'))
            ->whereIn('eva_validacion_de_cargas.estado_validacion',[2,8,9])
            ->where('gnral_alumnos.genero','F')
            ->select('gnral_alumnos.id_alumno')
            ->distinct()
            ->get()->count();

        $M=DB::table('gnral_alumnos')
            ->join('eva_validacion_de_cargas','eva_validacion_de_cargas.id_alumno','=','gnral_alumnos.id_alumno')
            ->where('eva_validacion_de_cargas.id_periodo','=',Session::get('periodo_actual'))
            ->whereIn('eva_validacion_de_cargas.estado_validacion',[2,8,9])
            ->where('gnral_alumnos.genero','M')
            ->select('gnral_alumnos.id_alumno')
            ->distinct()
            ->get()->count();
        $total=$F+$M;


        return response()->json(
            [["name"=>"Hombres","y"=>round(($M*100)/($total==0?1:$total))],
                ["name"=>"Mujeres","y"=>round(($F*100)/($total==0?1:$total))]],200
        );
    }
    public function generales()
    {
        $estadogen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_civil_estados.desc_ec="Soltero") as soltero, (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_civil_estados.desc_ec="Casado") as casado,(select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_civil_estados.desc_ec="Unión libre") as unionlibre, (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_civil_estados.desc_ec="Divorciado") as divorsiado,(select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_civil_estados.desc_ec="Viudo") as viudo');

        $estadoF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="F" AND exp_civil_estados.desc_ec="Soltero") as soltero, (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="F" AND exp_civil_estados.desc_ec="Casado") as casado,(select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="F" AND exp_civil_estados.desc_ec="Unión libre") as unionlibre, (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="F" AND exp_civil_estados.desc_ec="Divorciado") as divorsiado,(select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="F" AND exp_civil_estados.desc_ec="Viudo") as viudo');
        $estadoM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="M" AND exp_civil_estados.desc_ec="Soltero") as soltero, (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="M" AND exp_civil_estados.desc_ec="Casado") as casado,(select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="M" AND exp_civil_estados.desc_ec="Unión libre") as unionlibre, (select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="M" AND exp_civil_estados.desc_ec="Divorciado") as divorsiado,(select COUNT(exp_generales.id_exp_general)
                     FROM exp_generales
                     JOIN exp_civil_estados ON exp_generales.id_estado_civil=exp_civil_estados.id_estado_civil
                     WHERE exp_generales.sexo="M" AND exp_civil_estados.desc_ec="Viudo") as viudo');

        $nivelgen=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.nivel_economico="A/B") as AB, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.nivel_economico="C+") as CC,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.nivel_economico="C") as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.nivel_economico="C-") as CCC, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.nivel_economico="D+") as DD, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.nivel_economico="D") as D,  (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.nivel_economico="E") as E');
        $nivelF=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.nivel_economico="A/B") as AB, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.nivel_economico="C+") as CC,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.nivel_economico="C") as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.nivel_economico="C-") as CCC, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.nivel_economico="D+") as DD, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.nivel_economico="D") as D,  (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.nivel_economico="E") as E');
        $nivelM=DB::select('Select (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.nivel_economico="A/B") as AB, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.nivel_economico="C+") as CC,(select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.nivel_economico="C") as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="M" AND exp_generales.nivel_economico="C-") as CCC, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.nivel_economico="D+") as DD, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.nivel_economico="D") as D,  (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.nivel_economico="E") as E');

        $trabajagen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.trabaja=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.trabaja=2) as NOO');
        $trabajaF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="F" AND exp_generales.trabaja=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="F" AND exp_generales.trabaja=2) as NOO');
        $trabajaM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="M" AND exp_generales.trabaja=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="M" AND exp_generales.trabaja=2) as NOO');

        $academicogen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.estado=1) as R, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.estado=2) as I, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.estado=3) as S, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.estado=4) as BJ, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.estado=5) as BD');
        $academicoF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="F" AND exp_generales.estado=1) as R, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="F" AND exp_generales.estado=2) as I, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="F" AND exp_generales.estado=3) as S, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE  exp_generales.sexo="F" AND exp_generales.estado=4) as BJ, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales

                      WHERE  exp_generales.sexo="F" AND exp_generales.estado=5) as BD');
        $academicoM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.estado=1) as R, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.estado=2) as I, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.estado=3) as S, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.estado=4) as BJ, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.estado=5) as BD');

        $becagen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.beca=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.beca=2) as NOO');
        $becaF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.beca=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.beca=2) as NOO');
        $becaM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.beca=1) as SI, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.beca=2) as NOO');

        $tbecagen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.id_expbeca=1) as Ma, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.id_expbeca=2) as Be, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.id_expbeca=3) as Pe, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.id_expbeca=4) as Ea');
        $tbecaF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.id_expbeca=1) as Ma, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.id_expbeca=2) as Be, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.id_expbeca=3) as Pe, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.id_expbeca=4) as Ea');
        $tbecaM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.id_expbeca=1) as Ma, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.id_expbeca=2) as Be, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.id_expbeca=3) as Pe, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.id_expbeca=4) as Ea');

        $hijosgen=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.no_hijos=1) as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.no_hijos=2) as U, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.no_hijos=3) as D, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.no_hijos=4) as T, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.no_hijos=5) as M');
        $hijosF=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.no_hijos=1) as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.no_hijos=2) as U, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.no_hijos=3) as D, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.no_hijos=4) as T, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="F" AND exp_generales.no_hijos=5) as M');
        $hijosM=DB::select('SELECT (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.no_hijos=1) as C, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.no_hijos=2) as U, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.no_hijos=3) as D, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.no_hijos=4) as T, (select COUNT(exp_generales.id_exp_general)
                      FROM exp_generales
                      WHERE exp_generales.sexo="M" AND exp_generales.no_hijos=5) as M');

        return response()->json(
            [
                [
                    [
                        ["name"=>"Soltero","y"=>round(($estadogen[0]->soltero)*100/Session::get('total_alumnos'))],["name"=>"Casado","y"=>round(($estadogen[0]->casado)*100/Session::get('total_alumnos'))],["name"=>"Unión libre","y"=>round(($estadogen[0]->unionlibre)*100/Session::get('total_alumnos'))],["name"=>"Divorsiado","y"=>round(($estadogen[0]->divorsiado)*100/Session::get('total_alumnos'))],["name"=>"Viudo","y"=>round(($estadogen[0]->viudo)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Soltero","y"=>round(($estadoF[0]->soltero)*100/Session::get('total_mujeres'))],["name"=>"Casado","y"=>round(($estadoF[0]->casado)*100/Session::get('total_mujeres'))],["name"=>"Unión libre","y"=>round(($estadoF[0]->unionlibre)*100/Session::get('total_mujeres'))],["name"=>"Divorsiado","y"=>round(($estadoF[0]->divorsiado)*100/Session::get('total_mujeres'))],["name"=>"Viudo","y"=>round(($estadoF[0]->viudo)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Soltero","y"=>round(($estadoM[0]->soltero)*100/Session::get('total_hombres'))],["name"=>"Casado","y"=>round(($estadoM[0]->casado)*100/Session::get('total_hombres'))],["name"=>"Unión libre","y"=>round(($estadoM[0]->unionlibre)*100/Session::get('total_hombres'))],["name"=>"Divorsiado","y"=>round(($estadoM[0]->divorsiado)*100/Session::get('total_hombres'))],["name"=>"Viudo","y"=>round(($estadoM[0]->viudo)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"E","y"=>round(($nivelgen[0]->E)*100/Session::get('total_alumnos'))],["name"=>"D","y"=>round(($nivelgen[0]->D)*100/Session::get('total_alumnos'))],["name"=>"D+","y"=>round(($nivelgen[0]->DD)*100/Session::get('total_alumnos'))],["name"=>"C-","y"=>round(($nivelgen[0]->CCC)*100/Session::get('total_alumnos'))],["name"=>"C","y"=>round(($nivelgen[0]->C)*100/Session::get('total_alumnos'))],["name"=>"C+","y"=>round(($nivelgen[0]->CC)*100/Session::get('total_alumnos'))],["name"=>"A/B","y"=>round(($nivelgen[0]->AB)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"E","y"=>round(($nivelF[0]->E)*100/Session::get('total_mujeres'))],["name"=>"D","y"=>round(($nivelF[0]->D)*100/Session::get('total_mujeres'))],["name"=>"D+","y"=>round(($nivelF[0]->DD)*100/Session::get('total_mujeres'))],["name"=>"C-","y"=>round(($nivelF[0]->CCC)*100/Session::get('total_mujeres'))],["name"=>"C","y"=>round(($nivelF[0]->C)*100/Session::get('total_mujeres'))],["name"=>"C+","y"=>round(($nivelF[0]->CC)*100/Session::get('total_mujeres'))],["name"=>"A/B","y"=>round(($nivelF[0]->AB)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"E","y"=>round(($nivelM[0]->E)*100/Session::get('total_hombres'))],["name"=>"D","y"=>round(($nivelM[0]->D)*100/Session::get('total_hombres'))],["name"=>"D+","y"=>round(($nivelM[0]->DD)*100/Session::get('total_hombres'))],["name"=>"C-","y"=>round(($nivelM[0]->CCC)*100/Session::get('total_hombres'))],["name"=>"C","y"=>round(($nivelM[0]->C)*100/Session::get('total_hombres'))],["name"=>"C+","y"=>round(($nivelM[0]->CC)*100/Session::get('total_hombres'))],["name"=>"A/B","y"=>round(($nivelM[0]->AB)*100/Session::get('total_hombres'))]
                    ],
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($trabajagen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($trabajagen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($trabajaF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($trabajaF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($trabajaM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($trabajaM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Regular","y"=>round(($academicogen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Irregular","y"=>round(($academicogen[0]->I)*100/Session::get('total_alumnos'))],["name"=>"Suspensión","y"=>round(($academicogen[0]->S)*100/Session::get('total_alumnos'))],["name"=>"Baja temporal  ","y"=>round(($academicogen[0]->BJ)*100/Session::get('total_alumnos'))],["name"=>"Baja definitiva","y"=>round(($academicogen[0]->BD)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Regular","y"=>round(($academicoF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Irregular","y"=>round(($academicoF[0]->I)*100/Session::get('total_mujeres'))],["name"=>"Suspensión","y"=>round(($academicoF[0]->S)*100/Session::get('total_mujeres'))],["name"=>"Baja temporal  ","y"=>round(($academicoF[0]->BJ)*100/Session::get('total_mujeres'))],["name"=>"Baja definitiva","y"=>round(($academicoF[0]->BD)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Regular","y"=>round(($academicoM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Irregular","y"=>round(($academicoM[0]->I)*100/Session::get('total_hombres'))],["name"=>"Suspensión","y"=>round(($academicoM[0]->S)*100/Session::get('total_hombres'))],["name"=>"Baja temporal  ","y"=>round(($academicoM[0]->BJ)*100/Session::get('total_hombres'))],["name"=>"Baja definitiva","y"=>round(($academicoM[0]->BD)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($becagen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($becagen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($becaF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($becaF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($becaM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($becaM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Manutención Federal","y"=>round(($tbecagen[0]->Ma)*100/($becagen[0]->SI==0?1:$becagen[0]->SI))],["name"=>"Benito Juárez","y"=>round(($tbecagen[0]->Be)*100/($becagen[0]->SI==0?1:$becagen[0]->SI))],["name"=>"Permanencia","y"=>round(($tbecagen[0]->Pe)*100/($becagen[0]->SI==0?1:$becagen[0]->SI))],["name"=>"Excelencia Académica","y"=>round(($tbecagen[0]->Ea)*100/($becagen[0]->SI==0?1:$becagen[0]->SI))]
                    ],
                    [
                        ["name"=>"Manutención Federal","y"=>round(($tbecaF[0]->Ma)*100/($becaF[0]->SI==0?1:$becaF[0]->SI))],["name"=>"Benito Juárez","y"=>round(($tbecaF[0]->Be)*100/($becaF[0]->SI==0?1:$becaF[0]->SI))],["name"=>"Permanencia","y"=>round(($tbecaF[0]->Pe)*100/($becaF[0]->SI==0?1:$becaF[0]->SI))],["name"=>"Excelencia Académica","y"=>round(($tbecaF[0]->Ea)*100/($becaF[0]->SI==0?1:$becaF[0]->SI))]
                    ],
                    [
                        ["name"=>"Manutención Federal","y"=>round(($tbecaM[0]->Ma)*100/($becaM[0]->SI==0?1:$becaM[0]->SI))],["name"=>"Benito Juárez","y"=>round(($tbecaM[0]->Be)*100/($becaM[0]->SI==0?1:$becaM[0]->SI))],["name"=>"Permanencia","y"=>round(($tbecaM[0]->Pe)*100/($becaM[0]->SI==0?1:$becaM[0]->SI))],["name"=>"Excelencia Académica","y"=>round(($tbecaM[0]->Ea)*100/($becaM[0]->SI==0?1:$becaM[0]->SI))]
                    ]
                ],
                [
                    [
                        ["name"=>"0","y"=>round(($hijosgen[0]->C)*100/Session::get('total_alumnos'))],["name"=>"1","y"=>round(($hijosgen[0]->U)*100/Session::get('total_alumnos'))],["name"=>"2","y"=>round(($hijosgen[0]->D)*100/Session::get('total_alumnos'))],["name"=>"3","y"=>round(($hijosgen[0]->T)*100/Session::get('total_alumnos'))],["name"=>"4 o más","y"=>round(($hijosgen[0]->M)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"0","y"=>round(($hijosF[0]->C)*100/Session::get('total_mujeres'))],["name"=>"1","y"=>round(($hijosF[0]->U)*100/Session::get('total_mujeres'))],["name"=>"2","y"=>round(($hijosF[0]->D)*100/Session::get('total_mujeres'))],["name"=>"3","y"=>round(($hijosF[0]->T)*100/Session::get('total_mujeres'))],["name"=>"4 o más","y"=>round(($hijosF[0]->M)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"0","y"=>round(($hijosM[0]->C)*100/Session::get('total_hombres'))],["name"=>"1","y"=>round(($hijosM[0]->U)*100/Session::get('total_hombres'))],["name"=>"2","y"=>round(($hijosM[0]->D)*100/Session::get('total_hombres'))],["name"=>"3","y"=>round(($hijosM[0]->T)*100/Session::get('total_hombres'))],["name"=>"4 o más","y"=>round(($hijosM[0]->M)*100/Session::get('total_hombres'))]
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
    public function academico()
    {
        $gustagen=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_antecedentes_academicos.tegusta_carrera_elegida=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_antecedentes_academicos.tegusta_carrera_elegida=2) as NOO');
        $gustaF=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_antecedentes_academicos.tegusta_carrera_elegida=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_antecedentes_academicos.tegusta_carrera_elegida=2) as NOO');
        $gustaM=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_antecedentes_academicos.tegusta_carrera_elegida=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_antecedentes_academicos.tegusta_carrera_elegida=2) as NOO');

        $estimulagen=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_antecedentes_academicos.teestimula_familia=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_antecedentes_academicos.teestimula_familia=2) as NOO');
        $estimulaF=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_antecedentes_academicos.teestimula_familia=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_antecedentes_academicos.teestimula_familia=2) as NOO');
        $estimulaM=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_antecedentes_academicos.teestimula_familia=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_antecedentes_academicos.teestimula_familia=2) as NOO');

        $otragen=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_antecedentes_academicos.otra_carrera_ini=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_antecedentes_academicos.otra_carrera_ini=2) as NOO');
        $otraF=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_antecedentes_academicos.otra_carrera_ini=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_antecedentes_academicos.otra_carrera_ini=2) as NOO');
        $otraM=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_antecedentes_academicos.otra_carrera_ini=1) as SI, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_antecedentes_academicos.otra_carrera_ini=2) as NOO');

        $bachgen=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                      WHERE exp_bachillerato.desc_bachillerato="Técnico") as T, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                      WHERE exp_bachillerato.desc_bachillerato="General") as G');
        $bachF=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                      WHERE exp_generales.sexo="F" AND exp_bachillerato.desc_bachillerato="Técnico") as T, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                      WHERE exp_generales.sexo="F" AND exp_bachillerato.desc_bachillerato="General") as G');
        $bachM=DB::select('SELECT (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos
                      JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                      WHERE exp_generales.sexo="M" AND exp_bachillerato.desc_bachillerato="Técnico") as T, (select COUNT(exp_antecedentes_academicos.id_alumno)
                      FROM exp_antecedentes_academicos JOIN exp_generales ON exp_generales.id_alumno=exp_antecedentes_academicos.id_alumno
                      JOIN exp_bachillerato ON exp_bachillerato.id_bachillerato=exp_antecedentes_academicos.id_bachillerato
                      WHERE exp_generales.sexo="M" AND exp_bachillerato.desc_bachillerato="General") as G');

        return response()->json(
            [
                [
                    [
                        ["name"=>"Si","y"=>round(($gustagen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($gustagen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($gustaF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($gustaF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($gustaM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($gustaM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($estimulagen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($estimulagen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($estimulaF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($estimulaF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($estimulaM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($estimulaM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($otragen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($otragen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($otraF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($otraF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($otraM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($otraM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Técnico","y"=>round(($bachgen[0]->T)*100/Session::get('total_alumnos'))],["name"=>"General","y"=>round(($bachgen[0]->G)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Técnico","y"=>round(($bachF[0]->T)*100/Session::get('total_mujeres'))],["name"=>"General","y"=>round(($bachF[0]->G)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Técnico","y"=>round(($bachM[0]->T)*100/Session::get('total_hombres'))],["name"=>"General","y"=>round(($bachM[0]->G)*100/Session::get('total_hombres'))]
                    ]
                ],
            ],200
        );
    }
    public function familiares()
    {

        $vivesgen=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_opc_vives.desc_opc="Con los padres") as CP,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_opc_vives.desc_opc="Con otros estudiantes") as CE,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_opc_vives.desc_opc="Con tios u otros familiares") as CT,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_opc_vives.desc_opc="Solo") as S');

        $vivesF=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_generales.sexo="F" AND exp_opc_vives.desc_opc="Con los padres") as CP,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_generales.sexo="F" AND exp_opc_vives.desc_opc="Con otros estudiantes") as CE,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_generales.sexo="F" AND exp_opc_vives.desc_opc="Con tios u otros familiares") as CT,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_generales.sexo="F" AND exp_opc_vives.desc_opc="Solo") as S');
        $vivesM=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_generales.sexo="M" AND exp_opc_vives.desc_opc="Con los padres") as CP,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_generales.sexo="M" AND exp_opc_vives.desc_opc="Con otros estudiantes") as CE,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_generales.sexo="M" AND exp_opc_vives.desc_opc="Con tios u otros familiares") as CT,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			JOIN exp_opc_vives ON exp_opc_vives.id_opc_vives=exp_datos_familiares.id_opc_vives
                      WHERE exp_generales.sexo="M" AND exp_opc_vives.desc_opc="Solo") as S');

        $etgen=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_datos_familiares.etnia_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_datos_familiares.etnia_indigena=2) as NOO');
        $etF=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_datos_familiares.etnia_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_datos_familiares.etnia_indigena=2) as NOO');
        $etM=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_datos_familiares.etnia_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_datos_familiares.etnia_indigena=2) as NOO');
        $hagen=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_datos_familiares.hablas_lengua_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_datos_familiares.hablas_lengua_indigena=2) as NOO');
        $haF=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_datos_familiares.hablas_lengua_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_datos_familiares.hablas_lengua_indigena=2) as NOO');
        $haM=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_datos_familiares.hablas_lengua_indigena=1) as SI,(select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_datos_familiares.hablas_lengua_indigena=2) as NOO');

        $ufgen=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_familia_union.desc_union="Unida") as U,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_familia_union.desc_union="Muy unida") as MU,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_familia_union.desc_union="Disfuncional") as D');
        $ufF=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_generales.sexo="F" AND exp_familia_union.desc_union="Unida") as U,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_generales.sexo="F" AND exp_familia_union.desc_union="Muy unida") as MU,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_generales.sexo="F" AND exp_familia_union.desc_union="Disfuncional") as D');
        $ufM=DB::select('SELECT (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_generales.sexo="M" AND exp_familia_union.desc_union="Unida") as U,  (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_generales.sexo="M" AND exp_familia_union.desc_union="Muy unida") as MU,
                      (select COUNT(exp_datos_familiares.id_alumno)
                      FROM exp_datos_familiares
                      JOIN exp_generales ON exp_generales.id_alumno=exp_datos_familiares.id_alumno
        			  JOIN exp_familia_union ON exp_datos_familiares.id_familia_union=exp_familia_union.id_familia_union
                      WHERE exp_generales.sexo="M" AND exp_familia_union.desc_union="Disfuncional") as D');


        return response()->json(
            [
                [
                    [
                        ["name"=>"Con los padres","y"=>round(($vivesgen[0]->CP)*100/Session::get('total_alumnos'))],["name"=>"Con otros estudiantes","y"=>round(($vivesgen[0]->CE)*100/Session::get('total_alumnos'))],["name"=>"Con tios u otros familiares","y"=>round(($vivesgen[0]->CT)*100/Session::get('total_alumnos'))],["name"=>"Solo","y"=>round(($vivesgen[0]->S)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Con los padres","y"=>round(($vivesF[0]->CP)*100/Session::get('total_mujeres'))],["name"=>"Con otros estudiantes","y"=>round(($vivesF[0]->CE)*100/Session::get('total_mujeres'))],["name"=>"Con tios u otros familiares","y"=>round(($vivesF[0]->CT)*100/Session::get('total_mujeres'))],["name"=>"Solo","y"=>round(($vivesF[0]->S)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Con los padres","y"=>round(($vivesM[0]->CP)*100/Session::get('total_hombres'))],["name"=>"Con otros estudiantes","y"=>round(($vivesM[0]->CE)*100/Session::get('total_hombres'))],["name"=>"Con tios u otros familiares","y"=>round(($vivesM[0]->CT)*100/Session::get('total_hombres'))],["name"=>"Solo","y"=>round(($vivesM[0]->S)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($etgen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($etgen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($etF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($etF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($etM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($etM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($hagen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($hagen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($haF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($haF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($haM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($haM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Disfuncional","y"=>round(($ufgen[0]->D)*100/Session::get('total_alumnos'))],["name"=>"Unida","y"=>round(($ufgen[0]->U)*100/Session::get('total_alumnos'))],["name"=>"Muy unida","y"=>round(($ufgen[0]->MU)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Disfuncional","y"=>round(($ufF[0]->D)*100/Session::get('total_mujeres'))],["name"=>"Unida","y"=>round(($ufF[0]->U)*100/Session::get('total_mujeres'))],["name"=>"Muy unida","y"=>round(($ufgen[0]->MU)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Disfuncional","y"=>round(($ufM[0]->D)*100/Session::get('total_hombres'))],["name"=>"Unida","y"=>round(($ufM[0]->U)*100/Session::get('total_hombres'))],["name"=>"Muy unida","y"=>round(($ufgen[0]->MU)*100/Session::get('total_alumnos'))]
                    ]
                ],
            ],200
        );
    }
    public function habitos()
    {

        $tigen=DB::select('SELECT (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE  exp_opc_tiempo.desc_opc="Menos de 1 hora") as M, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_opc_tiempo.desc_opc="1 hora") as U, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE  exp_opc_tiempo.desc_opc="2 horas") as D, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE  exp_opc_tiempo.desc_opc="3 horas") as T, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE  exp_opc_tiempo.desc_opc="Más de 4 horas") as C');

        $tiF=DB::select('SELECT (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="Menos de 1 hora") as M, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="1 hora") as U, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="2 horas") as D, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="3 horas") as T, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="F" AND exp_opc_tiempo.desc_opc="Más de 4 horas") as C');

        $tiM=DB::select('SELECT (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="Menos de 1 hora") as M, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="1 hora") as U, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="2 horas") as D, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="3 horas") as T, (select COUNT(exp_habitos_estudio.id_alumno)
                      FROM exp_habitos_estudio
                      JOIN exp_generales ON exp_generales.id_alumno=exp_habitos_estudio.id_alumno
        			  JOIN exp_opc_tiempo ON exp_opc_tiempo.id_opc_tiempo=exp_habitos_estudio.tiempo_empleado_estudiar
                      WHERE exp_generales.sexo="M" AND exp_opc_tiempo.desc_opc="Más de 4 horas") as C');

        return response()->json(
            [
                [
                    [
                        ["name"=>"Menos de 1 hora","y"=>round(($tigen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"1 hora","y"=>round(($tigen[0]->U)*100/Session::get('total_alumnos'))],["name"=>"2 horas","y"=>round(($tigen[0]->D)*100/Session::get('total_alumnos'))],["name"=>"3 horas","y"=>round(($tigen[0]->T)*100/Session::get('total_alumnos'))],["name"=>"Más de 4 horas","y"=>round(($tigen[0]->C)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Menos de 1 hora","y"=>round(($tiF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"1 hora","y"=>round(($tiF[0]->U)*100/Session::get('total_mujeres'))],["name"=>"2 horas","y"=>round(($tiF[0]->D)*100/Session::get('total_mujeres'))],["name"=>"3 horas","y"=>round(($tiF[0]->T)*100/Session::get('total_mujeres'))],["name"=>"Más de 4 horas","y"=>round(($tiF[0]->C)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Menos de 1 hora","y"=>round(($tiM[0]->M)*100/Session::get('total_hombres'))],["name"=>"1 hora","y"=>round(($tiM[0]->U)*100/Session::get('total_hombres'))],["name"=>"2 horas","y"=>round(($tiM[0]->D)*100/Session::get('total_hombres'))],["name"=>"3 horas","y"=>round(($tiM[0]->T)*100/Session::get('total_hombres'))],["name"=>"Más de 4 horas","y"=>round(($tiM[0]->C)*100/Session::get('total_alumnos'))]
                    ]
                ],

            ],200
        );

    }
    public function salud()
    {

        $degen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.practica_deporte=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.practica_deporte=2) as NOO');
        $deF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.practica_deporte=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.practica_deporte=2) as NOO');
        $deM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.practica_deporte=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.practica_deporte=2) as NOO');

        $argen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.practica_artistica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.practica_artistica=2) as NOO');
        $arF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.practica_artistica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.practica_artistica=2) as NOO');
        $arM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.practica_artistica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.practica_artistica=2) as NOO');
        $culturasgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.actividades_culturales=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.actividades_culturales=2) as NOO');
        $culturasF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.actividades_culturales=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.actividades_culturales=2) as NOO');
        $culturasM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.actividades_culturales=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.actividades_culturales=2) as NOO');

        $enfcgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.enfermedad_cronica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.enfermedad_cronica=2) as NOO');
        $enfcF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.enfermedad_cronica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.enfermedad_cronica=2) as NOO');
        $enfcM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.enfermedad_cronica=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.enfermedad_cronica=2) as NOO');

        $penfcgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.enf_cron_padre=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.enf_cron_padre=2) as NOO');
        $penfcF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.enf_cron_padre=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.enf_cron_padre=2) as NOO');
        $penfcM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.enf_cron_padre=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.enf_cron_padre=2) as NOO');
        $operaciongen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.operacion=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.operacion=2) as NOO');
        $operacionF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.operacion=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.operacion=2) as NOO');
        $operacionM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.operacion=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.operacion=2) as NOO');
        $visualgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.enfer_visual=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.enfer_visual=2) as NOO');
        $visualF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.enfer_visual=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.enfer_visual=2) as NOO');
        $visualM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.enfer_visual=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.enfer_visual=2) as NOO');
        $lentesgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.usas_lentes=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.usas_lentes=2) as NOO');
        $lentesF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.usas_lentes=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.usas_lentes=2) as NOO');
        $lentesM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.usas_lentes=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.usas_lentes=2) as NOO');

        $medgen=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.medicamento_controlado=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_formacion_integral.medicamento_controlado=2) as NOO');
        $medF=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.medicamento_controlado=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_formacion_integral.medicamento_controlado=2) as NOO');
        $medM=DB::select('SELECT (select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.medicamento_controlado=1) as SI,(select COUNT(exp_formacion_integral.id_alumno)
                      FROM exp_formacion_integral
                      JOIN exp_generales ON exp_generales.id_alumno=exp_formacion_integral.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_formacion_integral.medicamento_controlado=2) as NOO');

        return response()->json(
            [
                [
                    [
                        ["name"=>"Si","y"=>round(($degen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($degen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($deF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($deF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($deM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($deM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($argen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($argen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($arF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($arF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($arM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($arM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($culturasgen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($culturasgen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($culturasF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($culturasF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($culturasM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($culturasM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($enfcgen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($enfcgen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($enfcF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($enfcF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($enfcM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($enfcM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($penfcgen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($penfcgen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($penfcF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($penfcF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($penfcM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($penfcM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($operaciongen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($operaciongen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($operacionF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($operacionF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($operacionM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($operacionM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($visualgen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($visualgen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($visualF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($visualF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($visualM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($visualM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($lentesgen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($lentesgen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($lentesF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($lentesF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($lentesM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($lentesM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Si","y"=>round(($medgen[0]->SI)*100/Session::get('total_alumnos'))],["name"=>"No","y"=>round(($medgen[0]->NOO)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($medF[0]->SI)*100/Session::get('total_mujeres'))],["name"=>"No","y"=>round(($medF[0]->NOO)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Si","y"=>round(($medM[0]->SI)*100/Session::get('total_hombres'))],["name"=>"No","y"=>round(($medM[0]->NOO)*100/Session::get('total_hombres'))]
                    ]
                ],
            ],200
        );

    }
    public function area()
    {

        $traegen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.trabajo_equipo=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.trabajo_equipo=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.trabajo_equipo=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.trabajo_equipo=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.trabajo_equipo=5) as M');

        $traeF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.trabajo_equipo=5) as M');
        $traeM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.trabajo_equipo=5) as M');

        $rengen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.rendimiento_escolar=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.rendimiento_escolar=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.rendimiento_escolar=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.rendimiento_escolar=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.rendimiento_escolar=5) as M');

        $renF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="F" AND exp_area_psicopedagogica.rendimiento_escolar=5) as M');
        $renM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_generales.sexo="M" AND exp_area_psicopedagogica.rendimiento_escolar=5) as M');
        $comgen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.conocimiento_compu=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.conocimiento_compu=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.conocimiento_compu=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.conocimiento_compu=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE  exp_area_psicopedagogica.conocimiento_compu=5) as M');

        $comF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.conocimiento_compu=5) as M');
        $comM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.conocimiento_compu=5) as M');
        $retgen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.comprension=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.comprension=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.comprension=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.comprension=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.comprension=5) as M');

        $retF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.comprension=5) as M');
        $retM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.comprension=5) as M');

        $exagen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.preparacion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.preparacion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.preparacion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.preparacion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.preparacion=5) as M');

        $exaF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.preparacion=5) as M');
        $exaM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.preparacion=5) as M');
        $congen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.concentracion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.concentracion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.concentracion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.concentracion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.concentracion=5) as M');

        $conF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.concentracion=5) as M');
        $conM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.concentracion=5) as M');
        $bbgen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.busqueda_bibliografica=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.busqueda_bibliografica=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.busqueda_bibliografica=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.busqueda_bibliografica=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.busqueda_bibliografica=5) as M');

        $bbF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.busqueda_bibliografica=5) as M');
        $bbM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.busqueda_bibliografica=5) as M');
        $oigen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.otro_idioma=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.otro_idioma=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.otro_idioma=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.otro_idioma=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.otro_idioma=5) as M');

        $oiF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.otro_idioma=5) as M');
        $oiM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.otro_idioma=5) as M');
        $spgen=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.solucion_problemas=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.solucion_problemas=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.solucion_problemas=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.solucion_problemas=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_area_psicopedagogica.solucion_problemas=5) as M');

        $spF=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="F" AND exp_area_psicopedagogica.solucion_problemas=5) as M');
        $spM=DB::select('SELECT (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=1) as E,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=2) as MB, (select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=3) as B,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=4) as R,(select COUNT(exp_area_psicopedagogica.id_alumno)
                      FROM exp_area_psicopedagogica
                      JOIN exp_generales ON exp_generales.id_alumno=exp_area_psicopedagogica.id_alumno
                      WHERE exp_generales.sexo="M" AND exp_area_psicopedagogica.solucion_problemas=5) as M');


        return response()->json(
            [
                [
                    [
                        ["name"=>"Mala","y"=>round(($traegen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($traegen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($traegen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($traegen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($traegen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($traeF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($traeF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($traeF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($traeF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($traeF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($traeM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($traeM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($traeM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($traeM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($traeM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round(($rengen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($rengen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($rengen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($rengen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($rengen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($renF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($renF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($renF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($renF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($renF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($renM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($renM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($renM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($renM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($renM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round(($comgen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($comgen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($comgen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($comgen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($comgen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($comF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($comF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($comF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($comF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($comF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($comM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($comM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($comM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($comM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($comM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round(($retgen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($retgen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($retgen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($retgen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($retgen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($retF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($retF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($retF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($retF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($retF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($retM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($retM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($retM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($retM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($retM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round(($exagen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($exagen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($exagen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($exagen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($exagen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($exaF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($exaF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($exaF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($exaF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($exaF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($exaM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($exaM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($exaM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($exaM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($exaM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round(($congen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($congen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($congen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($congen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($congen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($conF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($conF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($conF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($conF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($conF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($conM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($conM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($conM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($conM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($conM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round(($bbgen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($bbgen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($bbgen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($bbgen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($bbgen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($bbF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($bbF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($bbF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($bbF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($bbF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($bbM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($bbM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($bbM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($bbM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($bbM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round(($oigen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($oigen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($oigen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($oigen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($oigen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($oiF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($oiF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($oiF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($oiF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($oiF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($oiM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($oiM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($oiM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($oiM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($oiM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],
                [
                    [
                        ["name"=>"Mala","y"=>round(($spgen[0]->M)*100/Session::get('total_alumnos'))],["name"=>"Regular","y"=>round(($spgen[0]->R)*100/Session::get('total_alumnos'))],["name"=>"Bien","y"=>round(($spgen[0]->B)*100/Session::get('total_alumnos'))],["name"=>"Muy bien","y"=>round(($spgen[0]->MB)*100/Session::get('total_alumnos'))],["name"=>"Excelente","y"=>round(($spgen[0]->E)*100/Session::get('total_alumnos'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($spF[0]->M)*100/Session::get('total_mujeres'))],["name"=>"Regular","y"=>round(($spF[0]->R)*100/Session::get('total_mujeres'))],["name"=>"Bien","y"=>round(($spF[0]->B)*100/Session::get('total_mujeres'))],["name"=>"Muy bien","y"=>round(($spF[0]->MB)*100/Session::get('total_mujeres'))],["name"=>"Excelente","y"=>round(($spF[0]->E)*100/Session::get('total_mujeres'))]
                    ],
                    [
                        ["name"=>"Mala","y"=>round(($spM[0]->M)*100/Session::get('total_hombres'))],["name"=>"Regular","y"=>round(($spM[0]->R)*100/Session::get('total_hombres'))],["name"=>"Bien","y"=>round(($spM[0]->B)*100/Session::get('total_hombres'))],["name"=>"Muy bien","y"=>round(($spM[0]->MB)*100/Session::get('total_hombres'))],["name"=>"Excelente","y"=>round(($spM[0]->E)*100/Session::get('total_hombres'))]
                    ]
                ],

            ],200
        );


    }
}
