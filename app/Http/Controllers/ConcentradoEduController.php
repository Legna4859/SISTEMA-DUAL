<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;
use Session;
use App\Carreras;
use App\Gnral_Semestres;

class ConcentradoEduController extends Controller
{

    public function index()
    {
        $total_g=0;
        $id_periodo=Session::get('periodotrabaja');
        $periodo = DB::selectOne('select gnral_periodos.periodo from gnral_periodos where gnral_periodos.id_periodo='.$id_periodo.'');
        $periodo=($periodo->periodo);

        /*$totales = DB::selectOne('select COUNT(hrs_rhps.id_rhps) todas from 
            hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodos,gnral_periodo_carreras where 
            gnral_periodos.id_periodo='.$id_periodo.' AND 
            gnral_horas_profesores.id_hrs_profesor=hrs_rhps.id_hrs_profesor AND 
            gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo ');
        $totales=($totales->todas);*/

        $carreras = DB::select('select *from gnral_carreras where gnral_carreras.id_carrera <> 11 order by nombre');     
        $datos_carreras=array(); 
        $t_docente=0;
        $t_td=0;
        $t_sem=0;

        foreach($carreras as $carrera)
        {
                $grupos_carreras=0;
            $nombre['nombre_carrera']= $carrera->nombre;
            //$nombre['id_carrera']= $carrera->id_carrera;

            $semanas = DB::select('select COUNT(hrs_rhps.id_rhps) hrs from 
            hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodos,gnral_carreras,gnral_periodo_carreras where 
            gnral_carreras.id_carrera='.$carrera->id_carrera.' AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND 
            gnral_horas_profesores.id_hrs_profesor=hrs_rhps.id_hrs_profesor AND 
            gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo ');

            $no_alum=DB::select('select DISTINCT gnral_materias.id_materia,hrs_distribucion_horas.no_alum
            FROM 
            gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,
            hrs_distribucion_horas,
            gnral_periodos,gnral_carreras WHERE 
            gnral_carreras.id_carrera='.$carrera->id_carrera.' 
            AND gnral_periodos.id_periodo='.$id_periodo.' AND 
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            hrs_distribucion_horas.id_materia=gnral_materias.id_materia AND
            hrs_distribucion_horas.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera');
            $cuenta=count($no_alum);
            $cont=0;
            if($cuenta>0)
            {
                for ($i=0; $i < $cuenta; $i++) 
                { 
                    $cont+=$no_alum[$i]->no_alum;
                }
            }

            $nombre_sem=array();

                foreach($semanas as $semana)
                {
                    $t_sem=$t_sem+$semana->hrs;
                    $nombrem['hrs_semanas']= $semana->hrs;
                    array_push($nombre_sem, $nombrem);
                }
            $semestres = DB::select('select DISTINCT gnral_semestres.id_semestre from gnral_semestres,gnral_materias,gnral_materias_perfiles, 
                gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras   WHERE
                gnral_periodos.id_periodo='.$id_periodo.' AND
                gnral_carreras.id_carrera='.$carrera->id_carrera.' AND
                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                gnral_materias.id_semestre=gnral_semestres.id_semestre AND
                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera ORDER BY id_semestre');

                foreach($semestres as $semestre)
                {
                    $grupos = DB::select('select distinct gnral_horas_profesores.grupo from 
                            gnral_horas_profesores, gnral_horarios,gnral_materias_perfiles,gnral_materias,gnral_carreras,gnral_periodos,gnral_periodo_carreras
                            where gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
                            gnral_carreras.id_carrera='.$carrera->id_carrera.' AND
                            gnral_periodos.id_periodo='.$id_periodo.' AND
                            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                            and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                            and gnral_materias.id_semestre='.$semestre->id_semestre.'
                            and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                            and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                            AND gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');
                    $num_grupo=count($grupos);
                    $grupos_carreras=$grupos_carreras+$num_grupo;
                }
            $total_g=$total_g+$grupos_carreras;

            $t_docente=$grupos_carreras*$semana->hrs;
            $t_td=$t_td+$t_docente;
            $ver=true;
            $nombre['semanas']=$nombre_sem;
            $nombre['g_carreras']=$grupos_carreras;
            $nombre['t_docente']=$t_docente;
            $nombre['total_alumnos']=$cont;
            array_push($datos_carreras,$nombre);
        }
        //dd($datos_carreras);
        return view('formatos.con_edu',compact('periodo','totales','total_g','t_td','ver','t_sem'))->with('carreras',$datos_carreras);
    }

    public function excel()
    {

        Excel::create('Concentrado Estructura Educativa-'.date('d-m-Y'), function($excel) 
        {
            $excel->sheet('Concentrado', function($sheet) 
            {

                $total_g=0;
                $id_periodo=Session::get('periodotrabaja');
                $periodo = DB::selectOne('select gnral_periodos.periodo from gnral_periodos where gnral_periodos.id_periodo='.$id_periodo.'');
                $periodo=($periodo->periodo);              

                $totales = DB::selectOne('select COUNT(hrs_rhps.id_rhps) todas from 
                    hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodos,gnral_periodo_carreras where 
                    gnral_periodos.id_periodo='.$id_periodo.' AND 
                    gnral_horas_profesores.id_hrs_profesor=hrs_rhps.id_hrs_profesor AND 
                    gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo ');
                $totales=($totales->todas);

                $carreras = DB::select('select *from gnral_carreras where gnral_carreras.id_carrera <> 11 order by nombre');     
                $datos_carreras=array(); 
                $t_docente=0;
                $t_td=0;
                foreach($carreras as $carrera)
                {
                        $grupos_carreras=0;
                    $nombre['nombre_carrera']= $carrera->nombre;
                    //$nombre['id_carrera']= $carrera->id_carrera;

                    $semanas = DB::select('select COUNT(hrs_rhps.id_rhps) hrs from 
                    hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodos,gnral_carreras,gnral_periodo_carreras where 
                    gnral_carreras.id_carrera='.$carrera->id_carrera.' AND 
                    gnral_periodos.id_periodo='.$id_periodo.' AND 
                    gnral_horas_profesores.id_hrs_profesor=hrs_rhps.id_hrs_profesor AND 
                    gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
                    gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo ');

                    $nombre_sem=array();

                        foreach($semanas as $semana)
                        {
                            $nombrem['hrs_semanas']= $semana->hrs;
                            array_push($nombre_sem, $nombrem);
                        }
                    $semestres = DB::select('select DISTINCT gnral_semestres.id_semestre from gnral_semestres,gnral_materias,gnral_materias_perfiles, 
                        gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras   WHERE
                        gnral_periodos.id_periodo='.$id_periodo.' AND
                        gnral_carreras.id_carrera='.$carrera->id_carrera.' AND
                        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                        gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                        gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                        gnral_materias.id_semestre=gnral_semestres.id_semestre AND
                        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera ORDER BY id_semestre');

                        foreach($semestres as $semestre)
                        {
                            $grupos = DB::select('select distinct gnral_horas_profesores.grupo from 
                                    gnral_horas_profesores, gnral_horarios,gnral_materias_perfiles,gnral_materias,gnral_carreras,gnral_periodos,gnral_periodo_carreras
                                    where gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
                                    gnral_carreras.id_carrera='.$carrera->id_carrera.' AND
                                    gnral_periodos.id_periodo='.$id_periodo.' AND
                                    gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil
                                    and gnral_materias_perfiles.id_materia=gnral_materias.id_materia
                                    and gnral_materias.id_semestre='.$semestre->id_semestre.'
                                    and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                                    and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                                    AND gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');
                            $num_grupo=count($grupos);
                            $grupos_carreras=$grupos_carreras+$num_grupo;
                        }
                    $total_g=$total_g+$grupos_carreras;

                    $t_docente=$grupos_carreras*$semana->hrs;
                    $t_td=$t_td+$t_docente;

                    $nombre['semanas']=$nombre_sem;
                    $nombre['g_carreras']=$grupos_carreras;
                    $nombre['t_docente']=$t_docente;
                    array_push($datos_carreras,$nombre);
                }
                $sheet->setWidth(array(
                    'A' => 10,
                    'B' => 56.30,
                    'C' => 35,
                    'D' => 31,
                    'E' => 47,
                    'F' => 52,
                    'G' => 34,
                    'H' => 33,
                    'I' => 29,
                    'J' => 27,
                    'K' => 24,
                    'L' => 32
                ));
                $sheet->loadView('formatos.partials.con_edu',compact('periodo','totales','total_g','t_td'))->with('carreras',$datos_carreras);
            });

        })->export('xls');

        return back();
    }
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
