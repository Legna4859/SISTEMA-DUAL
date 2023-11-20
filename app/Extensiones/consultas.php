<?php 

namespace App\Extensiones;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ArmarHorariosController;
use App\Http\Requests;
use App\Gnral_Horarios;
use App\Gnral_Personales;
use App\Hrs_Aulas;
use App\Gnral_Cargos;
use App\Hrs_Rhps;
use App\Gnral_Horas_Profesores;
use App\Hrs_Act_Extra_Clases;
use App\Hrs_Extra_Clase;
use App\Hrs_Horario_Extra_Clase;
use Session;

class consultas 
{
    public function retornar(Request $request)
    {
        //dd($request);
         $id_profesor = $request->get('tprof');
        $id_mat = $request->get('mat');
        $id_aula = $request->get('selectAula');

        if($id_mat<20000)
            $id_grupo = $request->get('selectGrupo');
        
        if(isset($id_grupo))
        {
            if(isset($id_aula))
            {
                return ( $this->prof_aula_grupo($id_aula,$id_grupo,$id_mat,$id_profesor));
            }
            else
            {
                return ( $this->profesor_grupo($id_grupo,$id_mat,$id_profesor));
            }
        }
        else if(isset($id_aula))
        {
            return ( $this->profesor_aula($id_aula,$id_profesor));
        }
        else if(isset($id_profesor))
        {
            return ( $this->profesor($id_profesor));
        }
    }
    public function profesor($id_profesor)
    {
        $id_periodo=Session::get('periodotrabaja');

        $horarios = DB::select('SELECT DISTINCT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
gnral_materias.id_materia idmat,gnral_materias.nombre materia, gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",
    gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
gnral_carreras.color,"0" estado,gnral_materias.especial,"0" checa_esp
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
SELECT DISTINCT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
gnral_materias.id_materia idmat,gnral_materias.nombre materia, gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",
    gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"0" estado,gnral_materias.especial,"0" checa_esp
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
SELECT DISTINCT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad,
hrs_extra_clase.grupo,
gnral_cargos.abre,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"0" estado,"0" especial,"0" checa_esp
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
SELECT DISTINCT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad, 
hrs_extra_clase.grupo,gnral_cargos.abre,
hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"0" estado,"0" especial,"0" checa_esp
FROM
hrs_actividades_extras, gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,
hrs_aulas,gnral_periodos,
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

return($horarios);

    }
    public function profesor_aula($id_aula,$id_profesor)
    {
        $id_periodo=Session::get('periodotrabaja');

        $horarios=DB::select('select DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps, 
hrs_rhps.id_semana,gnral_materias.nombre materia,gnral_materias.id_materia idmat, 
gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
gnral_carreras.color,"1" estado,gnral_materias.especial,"0" checa_esp
FROM
gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_aulas,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas,gnral_personales
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
gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
gnral_horarios.id_personal=gnral_personales.id_personal
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
gnral_materias.nombre materia, gnral_materias.id_materia idmat,gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"1" estado,gnral_materias.especial,"0" checa_esp
FROM
gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas,gnral_personales
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
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_rhps.id_aula=0
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.descripcion materia,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad,hrs_extra_clase.grupo,
gnral_cargos.abre,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"1" estado,"0" especial,"0" checa_esp
FROM
hrs_actividades_extras,gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,gnral_periodos,
gnral_periodo_carreras,gnral_carreras,gnral_personales
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
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_horario_extra_clase.id_aula=0
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.descripcion materia,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad, hrs_extra_clase.grupo,gnral_cargos.abre,
hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"1" estado,"0" especial,"0" checa_esp
FROM
hrs_actividades_extras, gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,hrs_aulas,
gnral_periodos,
gnral_periodo_carreras,gnral_carreras,gnral_personales
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
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula
UNION
select DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
gnral_materias.nombre materia,gnral_materias.id_materia idmat,gnral_reticulas.clave,  CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
"0",hrs_aulas.nombre ,gnral_carreras.id_carrera,
gnral_carreras.nombre,gnral_carreras.color ,"2" estado ,gnral_materias.especial,"0" checa_esp
FROM
gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,hrs_rhps,
gnral_periodo_carreras,gnral_reticulas,gnral_personales,gnral_carreras,hrs_aulas WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_rhps.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_rhps.id_aula=hrs_aulas.id_aula AND
hrs_rhps.id_semana NOT IN 
            (SELECT hrs_rhps.id_semana semana FROM
        hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores,gnral_periodos
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
        /*
        UNION
        SELECT hrs_rhps.id_semana semana FROM
        gnral_horas_profesores,hrs_rhps,gnral_horarios,
        gnral_periodos,gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_rhps.id_aula=0
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
        gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_horario_extra_clase.id_aula=0
        */
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
         gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase)
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps, 
hrs_horario_extra_clase.id_semana,hrs_actividades_extras.descripcion materia,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad,
hrs_extra_clase.grupo,"0",hrs_aulas.nombre,hrs_act_extra_clases.id_carrera ,
gnral_carreras.nombre,gnral_carreras.color,"2" estado,"0" especial,"0" checa_esp FROM
hrs_horario_extra_clase,hrs_act_extra_clases,hrs_extra_clase,gnral_horarios,
gnral_periodo_carreras,hrs_actividades_extras,gnral_personales,gnral_carreras,hrs_aulas
WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_horario_extra_clase.id_aula='.$id_aula.' AND
hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
hrs_act_extra_clases.id_carrera=gnral_carreras.id_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
hrs_horario_extra_clase.id_semana NOT IN 
            (SELECT hrs_rhps.id_semana semana FROM
        hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores,gnral_periodos
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
     /*  
      UNION
        SELECT hrs_rhps.id_semana semana FROM
        gnral_horas_profesores,hrs_rhps,gnral_horarios,
        gnral_periodos,gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_rhps.id_aula=0
        
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
        gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_horario_extra_clase.id_aula=0
        */
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
         gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase)');
        $contar=count($horarios);

       return($horarios);
    }
    public function profesor_grupo($id_grupo,$id_mat,$id_profesor)
    {
        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');
        $semestre=DB::selectOne('select gnral_materias.id_semestre from gnral_materias WHERE gnral_materias.id_materia='.$id_mat.'');
        $semestre=($semestre->id_semestre);

        $horarios=DB::select('select DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,
            hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,gnral_materias.nombre materia,gnral_materias.id_materia idmat, 
            gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
gnral_carreras.color,"1" estado,gnral_materias.especial,"0" checa_esp
FROM
gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_aulas,hrs_rhps,gnral_horarios,gnral_materias_perfiles,gnral_personales,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_cargo=gnral_cargos.id_cargo AND
hrs_aulas.id_aula=hrs_rhps.id_aula AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_materias_perfiles.id_materia_perfil=gnral_horas_profesores.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
gnral_materias.nombre materia, gnral_materias.id_materia idmat,gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,"Sin Aula" aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"1" estado,gnral_materias.especial,"0" checa_esp
FROM
gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_rhps,gnral_horarios,gnral_materias_perfiles,gnral_personales,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_cargo=gnral_cargos.id_cargo AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
gnral_materias_perfiles.id_materia_perfil=gnral_horas_profesores.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
hrs_rhps.id_aula=0
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.descripcion materia,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad,hrs_extra_clase.grupo,
gnral_cargos.abre,"Sin Aula" aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"1" estado,"0" especial,"0" checa_esp
FROM
hrs_actividades_extras,gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,gnral_periodos,gnral_personales,
gnral_periodo_carreras,gnral_carreras
WHERE
gnral_periodos.id_periodo='.$id_periodo.' AND
gnral_horarios.id_personal='.$id_profesor.' AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND
gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
gnral_cargos.id_cargo=hrs_horario_extra_clase.id_cargo AND
hrs_horario_extra_clase.id_aula=0 
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.descripcion materia,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad, hrs_extra_clase.grupo,gnral_cargos.abre,
hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"1" estado,"0" especial,"0" checa_esp
FROM
hrs_actividades_extras, gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,
hrs_aulas,gnral_periodos,
gnral_periodo_carreras,gnral_carreras,gnral_personales
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
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula
UNION
select DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
gnral_materias.nombre materia,gnral_materias.id_materia idmat,gnral_reticulas.clave,  CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre,hrs_aulas.nombre aula,gnral_carreras.id_carrera,
gnral_carreras.nombre,gnral_carreras.color,"3" estado,gnral_materias.especial,"0" checa_esp FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,
            gnral_personales,gnral_cargos,
            hrs_rhps,gnral_periodo_carreras,hrs_semanas,gnral_reticulas,gnral_carreras,hrs_aulas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_materias.id_semestre='.$semestre.' AND
            gnral_horas_profesores.grupo='.$id_grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            hrs_rhps.id_semana=hrs_semanas.id_semana AND
            hrs_rhps.id_cargo=gnral_cargos.id_cargo AND
            hrs_rhps.id_aula=hrs_aulas.id_aula AND
            gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            hrs_rhps.id_semana NOT IN 
            (SELECT hrs_rhps.id_semana semana FROM
        hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores,gnral_periodos
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
       /*
        UNION
        SELECT hrs_rhps.id_semana semana FROM
        gnral_horas_profesores,hrs_rhps,gnral_horarios,
        gnral_periodos,gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_rhps.id_aula=0
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
        gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_horario_extra_clase.id_aula=0
        */
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
         gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase) 
             UNION
             SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps, 
             hrs_horario_extra_clase.id_semana,hrs_actividades_extras.descripcion materia, hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad,
hrs_extra_clase.grupo,gnral_cargos.abre,hrs_aulas.nombre aula,gnral_carreras.id_carrera,
gnral_carreras.nombre,gnral_carreras.color,"3" estado,"0" especial,"0" checa_esp FROM
            gnral_personales,hrs_semanas,hrs_horario_extra_clase,hrs_actividades_extras,hrs_act_extra_clases,hrs_extra_clase,
            gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_cargos,hrs_aulas WHERE
            gnral_periodos.id_periodo='.$id_periodo.' AND
            gnral_carreras.id_carrera='.$id_carrera.' AND
            hrs_extra_clase.grupo='.$semestre.'0'.$id_grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
            hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula AND
            hrs_horario_extra_clase.id_cargo=gnral_cargos.id_cargo AND hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
            hrs_horario_extra_clase.id_semana NOT IN 
            (SELECT hrs_rhps.id_semana semana FROM
        hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores,gnral_periodos
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
        /*
        UNION
        SELECT hrs_rhps.id_semana semana FROM
        gnral_horas_profesores,hrs_rhps,gnral_horarios,
        gnral_periodos,gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_rhps.id_aula=0
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
        gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_horario_extra_clase.id_aula=0
        */
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
         gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase)
ORDER BY `id_semana` ASC');

        return($horarios);
    }
    public function prof_aula_grupo($id_aula,$id_grupo,$id_mat,$id_profesor)
    {
        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');

        $semestre=DB::selectOne('select gnral_materias.id_semestre from gnral_materias WHERE gnral_materias.id_materia='.$id_mat.'');
        $semestre=($semestre->id_semestre);

        $horarios=DB::select('select DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,
hrs_rhps.id_semana,gnral_materias.nombre materia,gnral_materias.id_materia idmat,gnral_reticulas.clave, 
CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,hrs_aulas.nombre aula,gnral_carreras.id_carrera,
gnral_carreras.nombre carrera,gnral_carreras.color,"1" estado,gnral_materias.especial,"0" checa_esp
FROM
gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_aulas,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas,gnral_personales
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
gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
gnral_horarios.id_personal=gnral_personales.id_personal
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,gnral_materias.nombre materia,gnral_materias.id_materia idmat, gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
gnral_cargos.abre ,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
gnral_carreras.color,"1" estado,gnral_materias.especial,"0" checa_esp
FROM
gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
gnral_periodos,gnral_periodo_carreras,gnral_carreras,gnral_reticulas,gnral_personales
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
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
hrs_rhps.id_aula=0
UNION 
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.descripcion materia,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad,hrs_extra_clase.grupo,
gnral_cargos.abre,"Sin Aula",gnral_carreras.id_carrera,
gnral_carreras.nombre carrera,gnral_carreras.color,"1" estado,"0" especial,"0" checa_esp
FROM
hrs_actividades_extras,gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,
gnral_cargos,gnral_periodos,
gnral_periodo_carreras,gnral_carreras,gnral_personales
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
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_horario_extra_clase.id_aula=0 
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,hrs_horario_extra_clase.id_semana,
hrs_actividades_extras.descripcion materia,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad, hrs_extra_clase.grupo,gnral_cargos.abre,
hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,
gnral_carreras.color,"1" estado,"0" especial,"0" checa_esp
FROM
hrs_actividades_extras, gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,
hrs_aulas,gnral_periodos,
gnral_periodo_carreras,gnral_carreras,gnral_personales
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
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula
UNION
select DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,
hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,gnral_materias.nombre materia,gnral_materias.id_materia idmat,gnral_reticulas.clave,  
CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,"0",hrs_aulas.nombre,gnral_carreras.id_carrera,
gnral_carreras.nombre,gnral_carreras.color,"2" estado,gnral_materias.especial,"0" checa_esp FROM
gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,hrs_rhps,
gnral_periodo_carreras,gnral_reticulas,gnral_personales,gnral_carreras,hrs_aulas WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_rhps.id_aula='.$id_aula.' AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_aula=hrs_aulas.id_aula AND
gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_rhps.id_semana NOT IN 
            (SELECT hrs_rhps.id_semana semana FROM
        hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores,gnral_periodos
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
        /*
        UNION
        SELECT hrs_rhps.id_semana semana FROM
        gnral_horas_profesores,hrs_rhps,gnral_horarios,
        gnral_periodos,gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_rhps.id_aula=0
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
        gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_horario_extra_clase.id_aula=0
        */
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
         gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase)
UNION
SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps, hrs_horario_extra_clase.id_semana,hrs_actividades_extras.descripcion,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad,
hrs_extra_clase.grupo,"0",hrs_aulas.nombre ,gnral_carreras.id_carrera,gnral_carreras.nombre,
gnral_carreras.color,"2" estado,"0" especial,"0" checa_esp FROM
hrs_horario_extra_clase,hrs_act_extra_clases,hrs_extra_clase,gnral_horarios,
gnral_periodo_carreras,hrs_actividades_extras,gnral_personales,gnral_carreras,hrs_aulas
WHERE
gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
hrs_horario_extra_clase.id_aula='.$id_aula.' AND
hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
gnral_horarios.id_personal=gnral_personales.id_personal AND
hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
hrs_horario_extra_clase.id_semana NOT IN 
            (SELECT hrs_rhps.id_semana semana FROM
        hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores,gnral_periodos
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
        /*
        UNION
        SELECT hrs_rhps.id_semana semana FROM
        gnral_horas_profesores,hrs_rhps,gnral_horarios,
        gnral_periodos,gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_rhps.id_aula=0
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
        gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_horario_extra_clase.id_aula=0
        */
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
         gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase)
UNION
select DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,gnral_horas_profesores.id_hrs_profesor hrs_prof,
hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,gnral_materias.nombre materia,gnral_materias.id_materia idmat,gnral_reticulas.clave,  
CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,"0",hrs_aulas.nombre,
gnral_carreras.id_carrera,
gnral_carreras.nombre,gnral_carreras.color,"3" estado,gnral_materias.especial,"0" checa_esp FROM
            gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_personales,
            hrs_rhps,gnral_periodo_carreras,hrs_semanas,gnral_reticulas,gnral_carreras,hrs_aulas WHERE
            gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_materias.id_semestre='.$semestre.' AND
            gnral_horas_profesores.grupo='.$id_grupo.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            hrs_rhps.id_semana=hrs_semanas.id_semana AND
            hrs_rhps.id_aula=hrs_aulas.id_aula AND
            gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            hrs_rhps.id_semana NOT IN 
            (SELECT hrs_rhps.id_semana semana FROM
        hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores,gnral_periodos
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
      /*
        UNION
        SELECT hrs_rhps.id_semana semana FROM
        gnral_horas_profesores,hrs_rhps,gnral_horarios,
        gnral_periodos,gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_rhps.id_aula=0
        */
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
        gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        gnral_horarios.id_personal=gnral_personales.id_personal AND
        hrs_horario_extra_clase.id_aula=0
        
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
         gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase) AND
        gnral_horarios.id_personal=gnral_personales.id_personal AND
        hrs_rhps.id_semana NOT IN (select hrs_rhps.id_semana FROM
                gnral_horarios,gnral_horas_profesores,hrs_rhps,
                gnral_periodo_carreras WHERE
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                hrs_rhps.id_aula='.$id_aula.' AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
                UNION
                SELECT hrs_horario_extra_clase.id_semana FROM
                hrs_horario_extra_clase,hrs_extra_clase,gnral_horarios,
                gnral_periodo_carreras
                WHERE
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                hrs_horario_extra_clase.id_aula='.$id_aula.' AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase)
             UNION 
             SELECT DISTINCT gnral_horarios.id_personal,gnral_personales.nombre,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps, hrs_horario_extra_clase.id_semana,hrs_actividades_extras.descripcion,hrs_actividades_extras.id_hrs_actividad_extra idmat,hrs_act_extra_clases.actividad,
hrs_extra_clase.grupo,"0",hrs_aulas.nombre,gnral_carreras.id_carrera,
gnral_carreras.nombre,gnral_carreras.color,"3" estado,"0" especial,"0" checa_esp FROM
            gnral_personales,hrs_semanas,hrs_horario_extra_clase,hrs_actividades_extras,hrs_act_extra_clases,hrs_extra_clase,
            gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,hrs_aulas WHERE
            gnral_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodos.id_periodo='.$id_periodo.' AND
            hrs_extra_clase.grupo='.$semestre.'0'.$id_grupo.' AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            gnral_horarios.id_personal=gnral_personales.id_personal AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
            hrs_horario_extra_clase.id_aula=hrs_aulas.id_aula AND
            hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
            hrs_horario_extra_clase.id_semana NOT IN 
            (SELECT hrs_rhps.id_semana semana FROM
        hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores,gnral_periodos
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera
        UNION
        SELECT hrs_rhps.id_semana semana FROM
        gnral_horas_profesores,hrs_rhps,gnral_horarios,
        gnral_periodos,gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_horario_profesor=gnral_horas_profesores.id_horario_profesor AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_rhps.id_aula=0
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
        gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_horario_extra_clase.id_aula=0
        UNION
        SELECT hrs_horario_extra_clase.id_semana semana FROM
         gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,gnral_periodos,
        gnral_periodo_carreras
        WHERE
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND
        gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase)AND
        hrs_horario_extra_clase.id_semana NOT IN (select hrs_rhps.id_semana FROM
                gnral_horarios,gnral_horas_profesores,hrs_rhps,
                gnral_periodo_carreras WHERE
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                hrs_rhps.id_aula='.$id_aula.' AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
                UNION
                SELECT hrs_horario_extra_clase.id_semana FROM
                hrs_horario_extra_clase,hrs_extra_clase,gnral_horarios,
                gnral_periodo_carreras
                WHERE
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                hrs_horario_extra_clase.id_aula='.$id_aula.' AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase)');

return($horarios);
    }


}
