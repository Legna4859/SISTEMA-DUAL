<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProfMatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');

        $relacion=DB::select('select DISTINCT gnral_perfiles.descripcion,gnral_personales.nombre,
            gnral_personales.cedula,gnral_materias.nombre materia,gnral_materias.unidades,
            concat(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo)grupo
            FROM gnral_personales,gnral_perfiles,gnral_horarios,gnral_horas_profesores,hrs_rhps,gnral_materias,
            gnral_materias_perfiles,
            gnral_periodo_carreras
            WHERE
            gnral_personales.id_perfil=gnral_perfiles.id_perfil AND
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            gnral_materias_perfiles.id_personal=gnral_personales.id_personal
            ORDER BY gnral_personales.nombre,grupo');
        return view('horarios.prof_mat',compact('relacion'));
    }
    public function hrs_carrera()
    {
        $cargos = DB::select('select *from gnral_cargos order by cargo');
        $ver=0;
        $categoria=0;
        return view('horarios.hrs_carrera',compact('cargos','ver','categoria'));

    }
    public  function categorias($categoria){
       // dd($categoria);
        $carreras = DB::select('select *from gnral_carreras where gnral_carreras.id_carrera <> 11 order by id_carrera');
        $datos_carreras=array();
        $id_periodo=Session::get('periodotrabaja');
        $total=0;
        foreach($carreras as $carrera)
        {
            $clase=DB::selectOne('select COUNT(hrs_rhps.id_rhps) hrs from 
            hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodos,gnral_carreras,gnral_periodo_carreras where 
            gnral_carreras.id_carrera='.$carrera->id_carrera.' AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND 
            hrs_rhps.id_cargo='.$categoria.' and 
            gnral_horas_profesores.id_hrs_profesor=hrs_rhps.id_hrs_profesor AND 
            gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

            $tutorias=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_tut FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
             hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20002 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $residencia=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_res FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20001 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $invest=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_inv FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20003 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $gestion=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_ges FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20005 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $vincula=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_vin FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20006 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $total=$clase->hrs+$tutorias->hrs_tut+$residencia->hrs_res+
                $gestion->hrs_ges+$vincula->hrs_vin+$invest->hrs_inv;

            $nombre['carrera']=$carrera->nombre;
            $nombre['clase']=$clase->hrs;
            $nombre['tutorias']=$tutorias->hrs_tut;
            $nombre['residencia']=$residencia->hrs_res;
            $nombre['gestion']=$gestion->hrs_ges;
            $nombre['vinculacion']=$vincula->hrs_vin;
            $nombre['investigacion']=$invest->hrs_inv;
            $nombre['totales']=$total;
            array_push($datos_carreras,$nombre);
        }
        $clase1=DB::selectOne('select COUNT(hrs_rhps.id_rhps) hrs from 
            hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodos,gnral_carreras,gnral_periodo_carreras where 
            gnral_periodos.id_periodo='.$id_periodo.' AND 
            hrs_rhps.id_cargo='.$categoria.' and 
            gnral_horas_profesores.id_hrs_profesor=hrs_rhps.id_hrs_profesor AND 
            gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

        $tutorias1=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_tut FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
             hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20002 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

        $residencia1=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_res FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20001 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

        $invest1=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_inv FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20003 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

        $gestion1=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_ges FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20005 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

        $vincula1=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_vin FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            hrs_horario_extra_clase.id_cargo='.$categoria.' and
            hrs_actividades_extras.id_hrs_actividad_extra=20006 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');
        $clase1=$clase1->hrs;
        $tutorias1=$tutorias1->hrs_tut;
        $residencia1=$residencia1->hrs_res;
        $gestion1=$gestion1->hrs_ges;
        $vincula1=$vincula1->hrs_vin;
        $invest1=$invest1->hrs_inv;
        $totales=$clase1+$tutorias1+$residencia1+$gestion1+$vincula1+$invest1;
        $cargos = DB::select('select *from gnral_cargos order by cargo');
 $ver=1;
        return view('horarios.hrs_carrera',compact('ver','cargos','categoria','clase1','tutorias1','residencia1','gestion1','vincula1','invest1','totales'))->with('carreras',$datos_carreras);
    }

   /* public function hrs_carrera()
    {
        $carreras = DB::select('select *from gnral_carreras where gnral_carreras.id_carrera <> 11 order by id_carrera');     
        $datos_carreras=array(); 
        $id_periodo=Session::get('periodotrabaja');
$total=0;
        foreach($carreras as $carrera)
        {
            $clase=DB::selectOne('select COUNT(hrs_rhps.id_rhps) hrs from 
            hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodos,gnral_carreras,gnral_periodo_carreras where 
            gnral_carreras.id_carrera='.$carrera->id_carrera.' AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND 
            gnral_horas_profesores.id_hrs_profesor=hrs_rhps.id_hrs_profesor AND 
            gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

            $tutorias=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_tut FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_actividades_extras.id_hrs_actividad_extra=20002 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $residencia=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_res FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_actividades_extras.id_hrs_actividad_extra=20001 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $invest=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_inv FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_actividades_extras.id_hrs_actividad_extra=20003 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $gestion=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_ges FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_actividades_extras.id_hrs_actividad_extra=20005 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $vincula=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) hrs_vin FROM
            hrs_horario_extra_clase,hrs_extra_clase,gnral_periodo_carreras,hrs_act_extra_clases,hrs_actividades_extras,gnral_horarios
            WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_periodo_carreras.id_carrera='.$carrera->id_carrera.' AND
            hrs_actividades_extras.id_hrs_actividad_extra=20006 AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

            $total=$clase->hrs+$tutorias->hrs_tut+$residencia->hrs_res+
            $gestion->hrs_ges+$vincula->hrs_vin+$invest->hrs_inv;

            $nombre['carrera']=$carrera->nombre;
            $nombre['clase']=$clase->hrs;
            $nombre['tutorias']=$tutorias->hrs_tut;
            $nombre['residencia']=$residencia->hrs_res;
            $nombre['gestion']=$gestion->hrs_ges;
            $nombre['vinculacion']=$vincula->hrs_vin;
            $nombre['investigacion']=$invest->hrs_inv;
            $nombre['totales']=$total;
            array_push($datos_carreras,$nombre);
        }
        return view('horarios.hrs_carrera')->with('carreras',$datos_carreras);
    }
*/
    public function excel()
    {
        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodotrabaja');
        $carreran=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$id_carrera.'');

        Excel::create('Profesores-Materias-', function($excel) 
        {
            $excel->sheet('PROF-MAT', function($sheet) 
            {
                            
                $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');

        $relacion=DB::select('select DISTINCT gnral_perfiles.descripcion,gnral_personales.nombre,
            gnral_personales.cedula,gnral_materias.nombre materia,gnral_materias.unidades,
            concat(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo)grupo
            FROM gnral_personales,gnral_perfiles,gnral_horarios,gnral_horas_profesores,hrs_rhps,gnral_materias,
            gnral_materias_perfiles,
            gnral_periodo_carreras
            WHERE
            gnral_personales.id_perfil=gnral_perfiles.id_perfil AND
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            gnral_materias_perfiles.id_personal=gnral_personales.id_personal
            ORDER BY gnral_personales.nombre,grupo');

                $sheet->setWidth(array(
                        'A' => 6,
                        'B' => 50,
                        'C' => 55,
                        'D' => 15,
                        'E' => 85,
                        'F' => 12,
                        'G' => 13
                    ));
                $sheet->loadView('horarios.partialsh.prof_mat_exel',compact('relacion')); 
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
