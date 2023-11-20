<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Carreras;
use App\Hrs_Aprobar_Plantilla_Edu;
use App\Gnral_Cargos;
use App\Horarios;
use Session;

class DocentesPlantillaEduController extends Controller
{

    public function index()
    {
        $id_carrera=0;
        $id_cargo=0;
        $carreras = DB::select('select *from gnral_carreras order by nombre');
        $cargos = DB::select('select *from gnral_cargos order by cargo');
        $docentes=array(
            'id_horario'=>1);
        return view('plantilla.plantilla_educativa',compact('carreras','cargos','id_carrera','id_cargo','docentes'));
    }

     public function graficas($id_docente,$ciclo)
    {
        $id_carrera=Session::get('carrera_g');

        if($ciclo==1)
            $periodos=DB::select('select gnral_periodos.id_periodo,gnral_periodos.periodo from gnral_periodos WHERE gnral_periodos.periodo LIKE "MARZO%" ');
        else
           $periodos=DB::select('select gnral_periodos.id_periodo,gnral_periodos.periodo from gnral_periodos WHERE gnral_periodos.periodo LIKE "SEPTIEM%" '); 
        
        $numero_periodos=count($periodos);

        $nombre=DB::selectOne('select gnral_personales.nombre from gnral_personales where id_personal='.$id_docente.'');
        $nombre=($nombre->nombre);
        
        $arregloclase="[";
        $arregloextra="[";
        $arreglototal="[";

        for ($i=0; $i < $numero_periodos ; $i++)
        {

            $id_periodo=$periodos[$i]->id_periodo;

        $act_extras=DB::select('select DISTINCT hrs_actividades_extras.id_hrs_actividad_extra, hrs_actividades_extras.descripcion
            from hrs_actividades_extras,hrs_act_extra_clases,
            hrs_extra_clase,gnral_horarios,gnral_periodo_carreras,hrs_horario_extra_clase,gnral_carreras,gnral_periodos WHERE 
            gnral_carreras.id_carrera='.$id_carrera.' AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND gnral_horarios.id_personal='.$id_docente.' AND 
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND 
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase');

            $hrs_clase=DB::selectOne('select COUNT(hrs_rhps.id_rhps) no_clase FROM 
            hrs_rhps,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_horarios.id_personal='.$id_docente.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');
            $numeroclase=isset($hrs_clase->no_clase)?$hrs_clase->no_clase:0;

            $hrs_extra_clase=DB::selectOne('select COUNT(hrs_horario_extra_clase.id_hr_extra) no_extra FROM
            hrs_horario_extra_clase,gnral_horarios,hrs_extra_clase,gnral_periodo_carreras WHERE
            gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_horarios.id_personal='.$id_docente.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase');
            $numeroextra=isset($hrs_extra_clase->no_extra)?$hrs_extra_clase->no_extra:0;

            $numerototal=$hrs_clase->no_clase+$hrs_extra_clase->no_extra;

            $arregloclase.=$numeroclase.",";
            $arregloextra.=$numeroextra.",";
            $arreglototal.=$numerototal.",";
        }
            $arregloclase.="]";
            $arregloextra.="]";
            $arreglototal.="]";

        return view('plantilla.partialsh.graficas',compact('periodos','nombre',
            'arregloclase','arregloextra','arreglototal','act_extras'));
    }
    public function aprobar($horario,$act)
    {     
        $id_periodo=Session::get('periodotrabaja');
        $carrera=Session::get('carrera_g');

        $plantilla=DB::selectOne('select * from hrs_aprobar_plantilla_edu where id_horario='.$horario.' ');

            if($act==20000)//clase
            {   
                if($plantilla->hrs_clase==0)
                $aprobaciones=array( 'hrs_clase' => 1);
                else
                 $aprobaciones=array( 'hrs_clase' => 0);   
            }
            if($act==20006)//vinculacion
            {   
                if($plantilla->vinculacion==0)
                $aprobaciones=array( 'vinculacion' => 1);
                else
                 $aprobaciones=array( 'vinculacion' => 0);   
            }
            if($act==20003)//investigacion
            {   
                if($plantilla->investigacion==0)
                $aprobaciones=array( 'investigacion' => 1);
                else
                 $aprobaciones=array( 'investigacion' => 0);   
            }
            if($act==20001)//residencia
            {   
                if($plantilla->residencia==0)
                $aprobaciones=array( 'residencia' => 1);
                else
                 $aprobaciones=array( 'residencia' => 0);   
            }
            if($act==20002)//tutorias
            {   
                if($plantilla->tutorias==0)
                $aprobaciones=array( 'tutorias' => 1);
                else
                 $aprobaciones=array( 'tutorias' => 0);   
            }
            if($act==20005)//gestion
            {   
                if($plantilla->gestion==0)
                $aprobaciones=array( 'gestion' => 1);
                else
                 $aprobaciones=array( 'gestion' => 0);   
            }
            //dd($aprobaciones);
        Hrs_Aprobar_Plantilla_Edu::find($plantilla->id_aprobar_plantilla_edu)->update($aprobaciones);

        $actividades=DB::select('select DISTINCT hrs_actividades_extras.id_hrs_actividad_extra 
            from hrs_actividades_extras,hrs_act_extra_clases,
            hrs_extra_clase,gnral_horarios,gnral_periodo_carreras,hrs_horario_extra_clase,gnral_carreras,gnral_periodos WHERE 
            gnral_carreras.id_carrera='.$carrera.' AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND gnral_horarios.id_horario_profesor='.$horario.' AND 
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND 
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase ');
        //dd(count($actividades));

        $clase=DB::selectOne('select count(hrs_rhps.id_rhps)hrs from hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_horas_profesores
        WHERE gnral_periodo_carreras.id_carrera='.$carrera.' AND
        gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_horario_profesor='.$horario.'
        AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera');
        if($clase->hrs>0)
            $actividades=count($actividades)+1;
        else
            $actividades=count($actividades);

        $tiene=DB::selectOne('select (hrs_clase+vinculacion+investigacion+gestion+tutorias+residencia)total 
            from hrs_aprobar_plantilla_edu WHERE id_horario='.$horario.' and 
            id_aprobar_plantilla_edu='.$plantilla->id_aprobar_plantilla_edu.' ');

        if($actividades!=$tiene->total)
        {
            $verde="false";
            $aprobado=array(
                'aprobado' => 0,
                );
            Horarios::find($horario)->update($aprobado);
        }
        else
        {
            $verde="true";
            $aprobado=array(
                'aprobado' => 1,
                );
            Horarios::find($horario)->update($aprobado);
        }
        //return back();
        return compact('verde');
    }

    public function plantilla_horarios($id_profesor)
    {
        $id_periodo=Session::get('periodotrabaja');
        $nombre=DB::selectOne('select gnral_personales.nombre from gnral_personales where gnral_personales.id_personal='.$id_profesor.'');
        $nombre=($nombre->nombre);

        $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
        $ver_horario=1;
        $horarios_doc = DB::select('
        SELECT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
        gnral_materias.nombre materia, 
        gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
        gnral_cargos.abre ,hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
        FROM
        hrs_semanas,gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_aulas,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
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
        SELECT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
        gnral_materias.nombre materia, gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
        gnral_cargos.abre ,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
        FROM
        hrs_semanas,gnral_materias,gnral_horas_profesores,gnral_cargos,hrs_aulas,hrs_rhps,gnral_horarios,gnral_materias_perfiles,
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
        hrs_rhps.id_aula NOT IN (SELECT hrs_aulas.id_aula FROM hrs_aulas)
        UNION
        SELECT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
        hrs_horario_extra_clase.id_semana,
        hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad,hrs_extra_clase.grupo,
        gnral_cargos.abre,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
        FROM
        hrs_actividades_extras,gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,hrs_semanas,gnral_cargos,hrs_aulas,
        gnral_periodos,
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
        hrs_horario_extra_clase.id_aula NOT IN (SELECT hrs_aulas.id_aula FROM hrs_aulas) 
        UNION
        SELECT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
        hrs_horario_extra_clase.id_semana,
        hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad, hrs_extra_clase.grupo,gnral_cargos.abre,
        hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
        FROM
        hrs_actividades_extras, gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,hrs_semanas,gnral_cargos,hrs_aulas,
        gnral_periodos,
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

        $vista_clase=DB::select('create or replace view clase as (select COUNT(gnral_carreras.id_carrera)num,
        gnral_carreras.nombre,gnral_carreras.id_carrera 
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
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia group by gnral_carreras.id_carrera,nombre) '); 

        $vista_extra=DB::select('create or replace view extra_clase as 
            (select COUNT(gnral_carreras.id_carrera) num,gnral_carreras.nombre carrera,gnral_carreras.id_carrera FROM 
                gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_periodos, 
                gnral_periodo_carreras,gnral_carreras WHERE gnral_periodos.id_periodo='.$id_periodo.' AND 
                gnral_horarios.id_personal='.$id_profesor.' AND 
                hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
                gnral_carreras.id_carrera=gnral_periodo_carreras.id_carrera AND 
                gnral_periodo_carreras.id_periodo_carrera=gnral_horarios.id_periodo_carrera AND 
                gnral_periodos.id_periodo=gnral_periodo_carreras.id_periodo AND 
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase 
                group by gnral_carreras.id_carrera,nombre)');    

        $ver_totales=DB::select('select clase.id_carrera,clase.nombre, (clase.num+extra_clase.num)sumaa 
            from clase JOIN extra_clase ON clase.id_carrera=extra_clase.id_carrera 
            UNION select clase.id_carrera,clase.nombre, (clase.num+0)sumaa from 
            clase LEFT OUTER JOIN extra_clase ON clase.id_carrera=extra_clase.id_carrera WHERE 
            clase.id_carrera not in (select extra_clase.id_carrera from extra_clase) 
            UNION select extra_clase.id_carrera,extra_clase.carrera, (extra_clase.num+0)sumaa from 
            extra_clase LEFT OUTER JOIN clase ON clase.id_carrera=extra_clase.id_carrera WHERE 
            extra_clase.id_carrera not in (select clase.id_carrera from clase) ');

//dd($ver_totales);
            $tam=count($ver_totales);
            $ssuma=0;
            for ($i=0; $i < $tam; $i++) 
            { 
                $ssuma+=$ver_totales[$i]->sumaa;
            }  
            return view('plantilla.partialsh.partial_ver_horarios',
                compact('ssuma','ver_totales','horarios_doc','semanas','nombre'));          
    }

    public function show($carrera,$id_cargo)
    {  
        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=$carrera;
        Session::put('carrera_g',$id_carrera);
        $carreras = DB::select('select *from gnral_carreras order by nombre');
        $cargos = DB::select('select *from gnral_cargos order by cargo');

         $docentes= DB::select('select DISTINCT gnral_horarios.id_personal,gnral_horarios.id_horario_profesor,
            gnral_personales.nombre,
            gnral_horarios.aprobado,gnral_cargos.cargo FROM gnral_horarios,gnral_cargos,gnral_periodo_carreras,
            gnral_carreras,
            gnral_periodos,gnral_personales,gnral_horas_profesores,hrs_rhps WHERE 
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND 
            hrs_rhps.id_cargo=gnral_cargos.id_cargo AND 
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            gnral_carreras.id_carrera='.$carrera.' AND gnral_periodos.id_periodo='.$id_periodo.' 
            AND hrs_rhps.id_cargo='.$id_cargo.' 
            AND gnral_horarios.id_personal=gnral_personales.id_personal 
            UNION
            SELECT DISTINCT gnral_horarios.id_personal,gnral_horarios.id_horario_profesor,gnral_personales.nombre,
            gnral_horarios.aprobado,gnral_cargos.cargo FROM 
            gnral_horarios,gnral_personales,gnral_cargos,hrs_extra_clase,hrs_horario_extra_clase,
            gnral_periodo_carreras,gnral_carreras,gnral_periodos WHERE 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
            hrs_horario_extra_clase.id_cargo=gnral_cargos.id_cargo AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            gnral_horarios.id_personal=gnral_personales.id_personal AND 
            gnral_carreras.id_carrera='.$carrera.' AND gnral_periodos.id_periodo='.$id_periodo.' 
            AND gnral_cargos.id_cargo='.$id_cargo.' order by nombre ');


        $datos_docente=array();
        $total=0;
        foreach ($docentes as $docente) 
        {
            $nombre['nombre']= $docente->nombre;
            $nombre['id_horario']= $docente->id_horario_profesor;
            $nombre['id_personal']= $docente->id_personal;
            $nombre['aprobado']= $docente->aprobado;
            $nombre['cargo']= $docente->cargo;

            //agregar hrs_aprbar_plantilla_edu
            $comprueba=DB::selectOne('select id_aprobar_plantilla_edu from hrs_aprobar_plantilla_edu where id_horario='.$docente->id_horario_profesor.'');
            $comprobar = isset($comprueba->id_aprobar_plantilla_edu)?$comprueba->id_aprobar_plantilla_edu:0;
            if($comprobar==0)
            {
                $aprobar_plantilla = array(
                'id_horario' => $docente->id_horario_profesor,
                'hrs_clase' => 0,
                'vinculacion' => 0,
                'investigacion' => 0,
                'gestion' =>0,
                'tutorias' =>0,
                'residencia' =>0
                    );
                $agrega_plantilla=Hrs_Aprobar_Plantilla_Edu::create($aprobar_plantilla);
            }

            $actividades=DB::select('select DISTINCT hrs_actividades_extras.id_hrs_actividad_extra, hrs_actividades_extras.descripcion 
            from hrs_actividades_extras,hrs_act_extra_clases,
            hrs_extra_clase,gnral_horarios,gnral_periodo_carreras,hrs_horario_extra_clase,gnral_carreras,gnral_periodos WHERE 
            gnral_carreras.id_carrera='.$carrera.' AND 
            gnral_periodos.id_periodo='.$id_periodo.' AND gnral_horarios.id_personal='.$docente->id_personal.' AND 
            hrs_horario_extra_clase.id_cargo='.$id_cargo.' AND
            hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND 
            hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
            hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND 
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND 
            hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase ');
            $cuenta=count($actividades);
 
            //dd($actividades);
            $nombre_actividades=array();

            foreach($actividades as $act_aprobar)
            {
                $nombrea['descripcion']= $act_aprobar->descripcion;
                $nombrea['id_hrs_actividad_extra']= $act_aprobar->id_hrs_actividad_extra;
                array_push($nombre_actividades, $nombrea);
            }
            $nombre['actividades']=$nombre_actividades;

            $hrs_clase=DB::select('select distinct gnral_materias_perfiles.id_materia_perfil mpf,
            gnral_materias.id_materia idm,
            gnral_materias.nombre,(gnral_materias.hrs_practicas+gnral_materias.hrs_teoria)totales
            FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,
            gnral_periodo_carreras,gnral_periodos, gnral_carreras,hrs_rhps
            WHERE
            gnral_materias_perfiles.id_personal='.$docente->id_personal.' AND
            gnral_carreras.id_carrera='.$id_carrera.' AND
            gnral_periodos.id_periodo='.$id_periodo.' AND
            hrs_rhps.id_cargo='.$id_cargo.' AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');
            $datos_clase=array();
            $count_m=count($hrs_clase);

            if($count_m>=1)
                $clase_a="true"; 
            else
                $clase_a="false";

            foreach($hrs_clase as $clase)
            {   
                $nombrem=array();
                $nombrem['nombre']=$clase->nombre;

                $grupos=DB::select('select DISTINCT concat(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo)grupo
                            FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,
                            gnral_periodo_carreras,gnral_periodos,hrs_rhps,gnral_carreras
                            WHERE
                            gnral_materias_perfiles.id_materia_perfil='.$clase->mpf.' AND
                            gnral_periodos.id_periodo='.$id_periodo.' AND
                            gnral_carreras.id_carrera='.$id_carrera.' AND 
                            gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera');
                $contarg=count($grupos);

                $primer=$clase->totales*$contarg;
                $nombrem['totales']=$primer;
                $nombrem['totales_mat']=$clase->totales;
                
                $datos_grupos=array();
                foreach($grupos as $grupo)
                {
                    $nombreg=array();
                    $nombreg['grupo']=$grupo->grupo;
                    array_push($datos_grupos,$nombreg);
                }
                $total=$total+$primer;
                $nombrem["grupos"]=$datos_grupos; 
                array_push($datos_clase,$nombrem);
            }
            $nombre["materias"]=$datos_clase;
            $nombre["clases"]=$clase_a;

            $aprobado_h=DB::selectOne('select hrs_aprobar_plantilla_edu.hrs_clase,hrs_aprobar_plantilla_edu.vinculacion,
            hrs_aprobar_plantilla_edu.investigacion,hrs_aprobar_plantilla_edu.gestion,hrs_aprobar_plantilla_edu.tutorias,
            hrs_aprobar_plantilla_edu.residencia from hrs_aprobar_plantilla_edu WHERE 
            hrs_aprobar_plantilla_edu.id_horario='.$docente->id_horario_profesor.' '); 
            $nombre['apro_h']= $aprobado_h->hrs_clase; 

            $ges_grachr=DB::select('select DISTINCT hrs_extra_clase.grupo,hrs_act_extra_clases.actividad act,
                COUNT(hrs_extra_clase.grupo)num from gnral_horarios,gnral_periodo_carreras,
                hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,hrs_actividades_extras WHERE 
                gnral_horarios.id_personal='.$docente->id_personal.' AND 
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND gnral_periodo_carreras.id_carrera='.$id_carrera.'
                AND hrs_act_extra_clases.id_hrs_actividad_extra=20005 
                AND hrs_horario_extra_clase.id_cargo='.$id_cargo.'
                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND 
                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor 
                AND hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
                hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra GROUP BY hrs_extra_clase.grupo,act'); 

            $aprobado_g=DB::selectOne('select hrs_aprobar_plantilla_edu.gestion,hrs_aprobar_plantilla_edu.vinculacion,
            hrs_aprobar_plantilla_edu.investigacion,hrs_aprobar_plantilla_edu.tutorias,
            hrs_aprobar_plantilla_edu.residencia from hrs_aprobar_plantilla_edu WHERE 
            hrs_aprobar_plantilla_edu.id_horario='.$docente->id_horario_profesor.' ');
            $nombre['apro_g']= $aprobado_g->gestion;

            $invest_grachr=DB::select('select DISTINCT hrs_act_extra_clases.actividad act,
                COUNT(hrs_act_extra_clases.actividad)num from gnral_horarios,gnral_periodo_carreras,
                hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,hrs_actividades_extras WHERE 
                gnral_horarios.id_personal='.$docente->id_personal.' AND 
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND 
                gnral_periodo_carreras.id_carrera='.$id_carrera.'
                AND hrs_act_extra_clases.id_hrs_actividad_extra=20003
                AND hrs_horario_extra_clase.id_cargo='.$id_cargo.' 
                AND hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor 
                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera
                AND hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
                hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra GROUP BY act');
            $aprobado_i=DB::selectOne('select hrs_aprobar_plantilla_edu.investigacion,hrs_aprobar_plantilla_edu.vinculacion,
            hrs_aprobar_plantilla_edu.gestion,hrs_aprobar_plantilla_edu.tutorias,
            hrs_aprobar_plantilla_edu.residencia from hrs_aprobar_plantilla_edu WHERE 
            hrs_aprobar_plantilla_edu.id_horario='.$docente->id_horario_profesor.' ');
            $nombre['apro_i']= $aprobado_i->investigacion;

            $resi_grachr=DB::select('select DISTINCT hrs_act_extra_clases.actividad act,
                COUNT(hrs_act_extra_clases.actividad)num from gnral_horarios,gnral_periodo_carreras,
                hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,hrs_actividades_extras WHERE 
                gnral_horarios.id_personal='.$docente->id_personal.' AND 
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND gnral_periodo_carreras.id_carrera='.$id_carrera.' 
                AND hrs_act_extra_clases.id_hrs_actividad_extra=20001 
                AND hrs_horario_extra_clase.id_cargo='.$id_cargo.'
                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                AND hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor 
                AND hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
                hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra GROUP BY act'); 
            $aprobado_r=DB::selectOne('select hrs_aprobar_plantilla_edu.residencia,hrs_aprobar_plantilla_edu.vinculacion,
            hrs_aprobar_plantilla_edu.investigacion,hrs_aprobar_plantilla_edu.gestion,hrs_aprobar_plantilla_edu.tutorias
            from hrs_aprobar_plantilla_edu WHERE 
            hrs_aprobar_plantilla_edu.id_horario='.$docente->id_horario_profesor.' '); 
            $nombre['apro_r']= $aprobado_r->residencia;     

            $tutor_grachr=DB::select('select DISTINCT hrs_extra_clase.grupo, COUNT(hrs_extra_clase.grupo)num from gnral_horarios,
                gnral_periodo_carreras,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases WHERE 
                gnral_horarios.id_personal='.$docente->id_personal.' AND 
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND gnral_periodo_carreras.id_carrera='.$id_carrera.'
                AND hrs_act_extra_clases.id_hrs_actividad_extra=20002 
                AND hrs_horario_extra_clase.id_cargo='.$id_cargo.' AND
                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND 
                hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera GROUP BY hrs_extra_clase.grupo ');  
            $aprobado_t=DB::selectOne('select hrs_aprobar_plantilla_edu.tutorias,hrs_aprobar_plantilla_edu.vinculacion,
            hrs_aprobar_plantilla_edu.investigacion,hrs_aprobar_plantilla_edu.gestion,
            hrs_aprobar_plantilla_edu.residencia from hrs_aprobar_plantilla_edu WHERE 
            hrs_aprobar_plantilla_edu.id_horario='.$docente->id_horario_profesor.' ');
            $nombre['apro_t']= $aprobado_t->tutorias;

            $vincul_grachr=DB::select('select DISTINCT hrs_act_extra_clases.actividad act,
                COUNT(hrs_act_extra_clases.actividad)num from gnral_horarios,gnral_periodo_carreras,
                hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,hrs_actividades_extras WHERE 
                gnral_horarios.id_personal='.$docente->id_personal.' AND 
                gnral_periodo_carreras.id_periodo='.$id_periodo.' AND gnral_periodo_carreras.id_carrera='.$id_carrera.'
                AND hrs_act_extra_clases.id_hrs_actividad_extra=20006 
                AND hrs_horario_extra_clase.id_cargo='.$id_cargo.'
                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera 
                AND hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor 
                AND hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND 
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND 
                hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra GROUP BY act'); 
            $aprobado_v=DB::selectOne('select hrs_aprobar_plantilla_edu.vinculacion,
            hrs_aprobar_plantilla_edu.investigacion,hrs_aprobar_plantilla_edu.gestion,hrs_aprobar_plantilla_edu.tutorias,
            hrs_aprobar_plantilla_edu.residencia from hrs_aprobar_plantilla_edu WHERE 
            hrs_aprobar_plantilla_edu.id_horario='.$docente->id_horario_profesor.' ');
            $nombre['apro_v']= $aprobado_v->vinculacion;

            $g_total=0;
            $i_total=0;
            $r_total=0;
            $t_total=0;
            $v_total=0;

            $nombre_gestion=array();
            $nombre_invest=array();
            $nombre_tutorias=array();
            $nombre_resi=array();
            $nombre_vinculacion=array();

            foreach($ges_grachr as $ges_gah)
            {
                    $nombreg['ges_grupo']= $ges_gah->grupo;
                    $nombreg['ges_act']= $ges_gah->act;
                    $nombreg['ges_t']= $ges_gah->num;

                    $g_total=$g_total+$ges_gah->num;

                    array_push($nombre_gestion, $nombreg);
            }
            foreach($invest_grachr as $invest_gah)
            {
                    $nombrei['inv_act']= $invest_gah->act;
                    $nombrei['inv_t']= $invest_gah->num;

                    $i_total=$i_total+$invest_gah->num;
                    array_push($nombre_invest, $nombrei);
            }
            foreach($resi_grachr as $resi_gah)
            {
                    $nombrer['res_act']= $resi_gah->act;
                    $nombrer['res_t']= $resi_gah->num;

                    $r_total=$r_total+$resi_gah->num;
                    array_push($nombre_resi, $nombrer);
            }
            foreach($tutor_grachr as $tutor_gah)
            {
                    $nombret['tut_grupo']= $tutor_gah->grupo;
                    $nombret['tut_t']= $tutor_gah->num;

                    $t_total=$t_total+$tutor_gah->num;
                    array_push($nombre_tutorias, $nombret);
            }
            foreach($vincul_grachr as $vincul_gah)
            {
                    $nombrev['vin_act']= $vincul_gah->act;
                    $nombrev['vin_t']= $vincul_gah->num;

                    $v_total=$v_total+$vincul_gah->num;
                    array_push($nombre_vinculacion, $nombrev);
            }

            $nombre['g_total']=$g_total;
            $nombre['i_total']=$i_total;
            $nombre['r_total']=$r_total;
            $nombre['t_total']=$t_total;
            $nombre['v_total']=$v_total;
            $nombre['h_total']=$total;
$total=0;
            $nombre['gestion']=$nombre_gestion;
            $nombre['investigacion']=$nombre_invest;
            $nombre['residencia']=$nombre_resi;
            $nombre['tutorias']=$nombre_tutorias;
            $nombre['vinculacion']=$nombre_vinculacion;
            array_push($datos_docente,$nombre);
           
        }
        //dd($datos_docente);

        return view('plantilla.plantilla_educativa',compact('carreras','cargos',
            'id_carrera','id_cargo'))->with(['ver' => true, 'docentes' => $datos_docente]); 
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
