<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

use App\Http\Requests;

class HrsDocentesController extends Controller
{

    public function index()
    {
        $id_periodo=Session::get('periodotrabaja');

        $docentes = DB::select('select distinct gnral_personales.nombre, gnral_personales.clave,gnral_personales.id_personal FROM 
            gnral_personales, gnral_horarios, gnral_periodo_carreras, gnral_periodos WHERE 
            gnral_personales.id_personal = gnral_horarios.id_personal AND 
            gnral_horarios.id_periodo_carrera = gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_periodo = gnral_periodos.id_periodo AND 
            gnral_periodos.id_periodo ='.$id_periodo.'');

        return view('horarios.horarios',compact('docentes'));
    }
    public function horarios_docentes($id_profesor)
    {

        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodotrabaja');
        $docente=DB::selectOne('select gnral_personales.nombre from gnral_personales where id_personal='.$id_profesor.'');
        $docenten=($docente->nombre);

        $horarios=DB::select('select gnral_horarios.id_horario_profesor from 
            gnral_horarios,gnral_periodo_carreras WHERE gnral_periodo_carreras.id_periodo='.$id_periodo.' AND 
            gnral_horarios.id_personal='.$id_profesor.' AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera ');
        $cuenta_hrs=count($horarios);

        $suma=DB::selectOne('select SUM(gnral_horarios.aprobado)num from gnral_horarios,gnral_periodo_carreras
        WHERE gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.aprobado=1 AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera');
        
        if($suma->num==$cuenta_hrs)
            $imprime=1;
        else
            $imprime=0;

        $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
        $docentes = DB::select('select distinct gnral_personales.nombre, gnral_personales.clave,gnral_personales.id_personal FROM 
            gnral_personales, gnral_horarios, gnral_periodo_carreras, gnral_periodos WHERE 
            gnral_personales.id_personal = gnral_horarios.id_personal AND 
            gnral_horarios.id_periodo_carrera = gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_periodo = gnral_periodos.id_periodo AND 
            gnral_periodos.id_periodo ='.$id_periodo.'');

        $horarios_doc = DB::select('
SELECT DISTINCT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,
hrs_rhps.id_semana,gnral_materias.nombre materia, 
gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
FROM
gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_aulas,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_cargo=gnral_cargos.id_cargo AND
hrs_aulas.id_aula=hrs_rhps.id_aula AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_materias_perfiles.id_materia_perfil=gnral_horas_profesores.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,
hrs_rhps.id_semana,gnral_materias.nombre materia, gnral_reticulas.clave, 
CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
FROM
gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_cargo=gnral_cargos.id_cargo AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_materias_perfiles.id_materia_perfil=gnral_horas_profesores.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
hrs_rhps.id_aula=0
UNION
SELECT DISTINCT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad,hrs_extra_clase.grupo,
gnral_cargos.abre,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
FROM
hrs_actividades_extras,gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,gnral_periodos,
gnral_periodo_carreras,gnral_carreras
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
gnral_cargos.id_cargo=hrs_horario_extra_clase.id_cargo AND
hrs_horario_extra_clase.id_aula=0
UNION
SELECT DISTINCT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad, hrs_extra_clase.grupo,gnral_cargos.abre,
hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
FROM
hrs_actividades_extras, gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,hrs_aulas,gnral_periodos,
gnral_periodo_carreras,gnral_carreras
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
gnral_cargos.id_cargo=hrs_horario_extra_clase.id_cargo AND
hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula');
$ver_totales = DB::select('select sum(uni_total.num) sumaa,nombre from (select COUNT(gnral_carreras.id_carrera)num,gnral_carreras.nombre,gnral_carreras.id_carrera 
FROM gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,hrs_rhps,gnral_materias,gnral_periodo_carreras,
gnral_periodos,gnral_carreras WHERE 
gnral_periodos.id_periodo='.$id_periodo.' AND 
gnral_horarios.id_personal='.$id_profesor.' AND 
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND 
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND 
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND 
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND 
gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND 
gnral_materias_perfiles.id_materia_perfil=gnral_horas_profesores.id_materia_perfil AND 
gnral_materias_perfiles.id_materia=gnral_materias.id_materia group by gnral_carreras.id_carrera,nombre
UNION
select COUNT(gnral_carreras.id_carrera) num,gnral_carreras.nombre carrera,gnral_carreras.id_carrera 
FROM
gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_periodos,
gnral_periodo_carreras,gnral_carreras
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase group by gnral_carreras.id_carrera,nombre) uni_total GROUP by id_carrera,nombre');

$tam=count($ver_totales);
$ssuma=0;
for ($i=0; $i < $tam; $i++) 
{ 
    $ssuma+=$ver_totales[$i]->sumaa;
}

    return view('horarios.horarios',compact('docentes','horarios_doc','semanas',
        'ver_totales','ssuma','docenten','imprime','id_profesor'))->with(['ver' => true]);
    }
    public function create()
    {
        //
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
