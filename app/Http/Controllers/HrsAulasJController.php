<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Carreras;
use App\Hrs_Aulas;
use Session;

class HrsAulasJController extends Controller
{

    public function index()
    {
        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodotrabaja');

        //$aulas = DB::select('select *from hrs_aulas where id_carrera='.$id_carrera.'');
        $aulas=DB::select('select DISTINCT hrs_aulas.id_aula,hrs_aulas.nombre from 
            hrs_aulas,hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras WHERE 
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND gnral_periodo_carreras.id_carrera='.$id_carrera.' AND 
            hrs_rhps.id_aula=hrs_aulas.id_aula AND 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera ');
        return view('horarios.horarios_jefes_aulas',compact('aulas'));
    }

    public function horarios_aulas($id_aula)
    {
        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');
        
        $aula = DB::selectOne('select hrs_aulas.nombre from hrs_aulas WHERE id_aula='.$id_aula.'');
        $aulan = ($aula->nombre);

        $docentes= DB::select('select gnral_materias.nombre materia,
            CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
        gnral_personales.nombre,gnral_horarios.aprobado,gnral_carreras.nombre carr FROM
gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,
gnral_personales,hrs_rhps,gnral_periodo_carreras,gnral_carreras WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_rhps.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
UNION
SELECT hrs_actividades_extras.descripcion materia,hrs_extra_clase.grupo,
gnral_personales.nombre,gnral_horarios.aprobado,gnral_carreras.nombre carr FROM
hrs_horario_extra_clase,hrs_act_extra_clases,hrs_extra_clase,gnral_personales,gnral_horarios,
gnral_periodo_carreras,gnral_carreras,gnral_periodos,hrs_actividades_extras
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
hrs_horario_extra_clase.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase and
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra');

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

        $horario_aula = DB::select('
        SELECT hrs_rhps.id_semana,hrs_semanas.dia,hrs_semanas.hora,gnral_materias.nombre materia,
        CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,gnral_carreras.COLOR FROM
gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,hrs_rhps,gnral_periodo_carreras,hrs_semanas,gnral_carreras WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_rhps.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_semana=hrs_semanas.id_semana
UNION
SELECT hrs_horario_extra_clase.id_semana,hrs_semanas.dia,hrs_semanas.hora,hrs_actividades_extras.descripcion materia,
hrs_extra_clase.grupo,gnral_carreras.COLOR FROM
hrs_horario_extra_clase,hrs_semanas,hrs_act_extra_clases,hrs_extra_clase,gnral_horarios,
gnral_periodo_carreras,gnral_carreras,gnral_periodos,hrs_actividades_extras
WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_horario_extra_clase.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra 
ORDER BY id_semana,hora ASC');

$aulas = DB::select('select *from hrs_aulas where id_carrera='.$id_carrera.'');
$semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');

        return view('horarios.horarios_jefes_aulas',compact('aulas','horario_aula',
            'docentes','aulan','semanas','imprime','id_carrera','id_aula'))->with(['ver' => true]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
