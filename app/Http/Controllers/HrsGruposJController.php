<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;

class HrsGruposJController extends Controller
{

    public function index()
    {
        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodotrabaja');

        $grupos = DB::select('select DISTINCT m.id_semestre, hp.grupo ,c.id_carrera FROM 
                gnral_periodos pe, gnral_carreras c, gnral_periodo_carreras pc, gnral_horarios h, gnral_materias m, 
                gnral_personales p, gnral_materias_perfiles mf, gnral_horas_profesores hp WHERE 
                mf.id_personal = p.id_personal AND 
                mf.id_materia = m.id_materia AND 
                mf.id_materia_perfil = hp.id_materia_perfil AND 
                hp.id_horario_profesor = h.id_horario_profesor AND 
                h.id_periodo_carrera = pc.id_periodo_carrera AND 
                pc.id_periodo = pe.id_periodo AND 
                pe.id_periodo ='.$id_periodo.' AND 
                pc.id_carrera = c.id_carrera AND 
                c.id_carrera ='.$id_carrera.'
                ORDER BY m.id_semestre ASC ');

        return view('horarios.horarios_jefes_grupos',compact('grupos'));
    }

    public function horarios_grupos($id_semestre,$grupo)
    {
       $id_periodo=Session::get('periodotrabaja');
       $id_carrera=Session::get('carrera');
       $id_semestre2=$id_semestre;
       $grupo2=$grupo;

        $docentes = DB::select('select DISTINCT gnral_materias.nombre materia,gnral_personales.nombre,
            gnral_horarios.aprobado," " act FROM 
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales, 
            hrs_rhps,gnral_periodo_carreras WHERE 
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND 
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND 
            gnral_materias.id_semestre='.$id_semestre.' AND 
            gnral_horas_profesores.grupo='.$grupo.' AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND  
            gnral_horarios.id_personal=gnral_personales.id_personal AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND 
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
            UNION
            select DISTINCT hrs_actividades_extras.descripcion materia,gnral_personales.nombre,
            gnral_horarios.aprobado,hrs_act_extra_clases.actividad act FROM 
            gnral_horarios,gnral_periodo_carreras,gnral_personales,
            hrs_extra_clase,hrs_act_extra_clases,hrs_horario_extra_clase,hrs_actividades_extras WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND 
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND 
            hrs_extra_clase.grupo='.$id_semestre.'0'.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra ');

$no_im=0;
$si_im=0;
$cuenta=count($docentes);

foreach($docentes as $docente)
{
    if($docente->aprobado==0)
        $no_im++;
    else
        $si_im++;
}
if($no_im>0)
$imprime=0;
else
    if($si_im==$cuenta)
        $imprime=1;


        $horario_grupo = DB::select('select DISTINCT hrs_rhps.id_semana,hrs_semanas.dia dia_materia,hrs_semanas.hora,
    gnral_materias.nombre materia,
            gnral_personales.nombre,"Sin Aula" aula,"0" id_aula FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            hrs_rhps,gnral_periodo_carreras,hrs_semanas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_materias.id_semestre='.$id_semestre.' AND
            gnral_horas_profesores.grupo='.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            hrs_rhps.id_semana=hrs_semanas.id_semana AND
            hrs_rhps.id_aula=0
            UNION
            select DISTINCT hrs_rhps.id_semana,hrs_semanas.dia dia_materia,hrs_semanas.hora,
    gnral_materias.nombre materia,
            gnral_personales.nombre,hrs_aulas.nombre aula,hrs_aulas.id_aula FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            hrs_rhps,gnral_periodo_carreras,hrs_semanas,hrs_aulas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_materias.id_semestre='.$id_semestre.' AND
            gnral_horas_profesores.grupo='.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            hrs_rhps.id_semana=hrs_semanas.id_semana AND
            hrs_rhps.id_aula=hrs_aulas.id_aula
            UNION
select DISTINCT hrs_horario_extra_clase.id_semana,hrs_semanas.dia,hrs_semanas.hora,hrs_actividades_extras.descripcion materia,
            gnral_personales.nombre,"Sin Aula" aula,"0" id_aula FROM
            gnral_horarios,hrs_extra_clase,hrs_act_extra_clases,hrs_actividades_extras,gnral_personales,
            hrs_horario_extra_clase,gnral_periodo_carreras,hrs_semanas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            hrs_extra_clase.grupo='.$id_semestre.'0'.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND                    
            hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_horario_extra_clase.id_aula=0
            UNION
            select DISTINCT hrs_horario_extra_clase.id_semana,hrs_semanas.dia,hrs_semanas.hora,hrs_actividades_extras.descripcion materia,
            gnral_personales.nombre,hrs_aulas.nombre aula,hrs_aulas.id_aula FROM
            gnral_horarios,hrs_extra_clase,hrs_act_extra_clases,hrs_actividades_extras,gnral_personales,
            hrs_horario_extra_clase,gnral_periodo_carreras,hrs_semanas,hrs_aulas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            hrs_extra_clase.grupo='.$id_semestre.'0'.$grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND                    
            hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula');

//dd($horario_grupo);
        //$semanas= DB::select('select * FROM hrs_semanas where hora IN (select hora FROM hrs_semanas where hora>="'.$max_clase[0]->hcmin.'" and hora<="'.$max_clase[0]->hcmax.'" group by hora)ORDER by hora,id_semana');
$semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');

        $grupos = DB::select('select DISTINCT m.id_semestre, hp.grupo ,c.id_carrera FROM 
                gnral_periodos pe, gnral_carreras c, gnral_periodo_carreras pc, gnral_horarios h, gnral_materias m, 
                gnral_personales p, gnral_materias_perfiles mf, gnral_horas_profesores hp WHERE 
                mf.id_personal = p.id_personal AND 
                mf.id_materia = m.id_materia AND 
                mf.id_materia_perfil = hp.id_materia_perfil AND 
                hp.id_horario_profesor = h.id_horario_profesor AND 
                h.id_periodo_carrera = pc.id_periodo_carrera AND 
                pc.id_periodo = pe.id_periodo AND 
                pe.id_periodo ='.$id_periodo.' AND 
                pc.id_carrera = c.id_carrera AND 
                c.id_carrera ='.$id_carrera.'
                ORDER BY m.id_semestre ASC ');
//dd($horario_grupo);
return view('horarios.horarios_jefes_grupos',compact('horario_grupo','grupos',
            'id_semestre2','grupo2','semanas','docentes','imprime','id_carrera'))->with(['ver' => true]);

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
