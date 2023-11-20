<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Classes\PHPExcel;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;
use App\Carreras;
use App\Gnral_Cargos;
use Session;
use PHPExcel_Worksheet_Drawing;

class DocentesPlantillaVerController extends Controller
{

    public function index()
    {
   
        $id_carrera=0;
        $id_cargo=0;
        $carreras = DB::select('select *from gnral_carreras order by nombre');
        $cargos = DB::select('select *from gnral_cargos order by cargo');
        return view('plantilla.plantilla',compact('carreras','cargos','id_carrera','id_cargo'));
    }

    public function graficas($id_docente,$ciclo)
    {
        $jefe_division=session()->has('jefe_division')?session()->has('jefe_division'):false;
        $directivo=session()->has('directivo')?session()->has('directivo'):false;

        if($directivo==true)    
            $id_carrera=Session::get('carrera_admin');
        else
        $id_carrera=Session::get('carrera');

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
        SELECT gnral_horarios.id_personal,gnral_horas_profesores.id_hrs_profesor hrs_prof,hrs_rhps.id_rhps rhps,hrs_rhps.id_semana,
        gnral_materias.nombre materia, gnral_reticulas.clave, CONCAT(gnral_materias.id_semestre,"0",gnral_horas_profesores.grupo) grupo,
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
        SELECT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
        hrs_horario_extra_clase.id_semana,
        hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad,hrs_extra_clase.grupo,
        gnral_cargos.abre,"Sin Aula",gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
        FROM
        hrs_actividades_extras,gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,
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
        hrs_horario_extra_clase.id_aula=0 
        UNION
        SELECT gnral_horarios.id_personal,hrs_extra_clase.id_extra_clase hrs_prof,hrs_horario_extra_clase.id_hr_extra rhps,
        hrs_horario_extra_clase.id_semana,
        hrs_actividades_extras.descripcion materia,hrs_act_extra_clases.actividad, hrs_extra_clase.grupo,gnral_cargos.abre,
        hrs_aulas.nombre aula,gnral_carreras.id_carrera,gnral_carreras.nombre carrera,gnral_carreras.color,"PROF" estado
        FROM
        hrs_actividades_extras, gnral_horarios,hrs_extra_clase,hrs_horario_extra_clase,hrs_act_extra_clases,gnral_cargos,hrs_aulas,
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

        $vista_clase=DB::statement('create or replace view clase as (select COUNT(gnral_carreras.id_carrera)num,
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

        $vista_extra=DB::statement('create or replace view extra_clase as 
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

            $tam=count($ver_totales);
            $ssuma=0;
            for ($i=0; $i < $tam; $i++) 
            { 
                $ssuma+=$ver_totales[$i]->sumaa;
            }  
            return view('plantilla.partialsh.partial_ver_horarios',
                compact('ssuma','ver_totales','horarios_doc','semanas','nombre'));          
    }

    public function show($id_carrera,$id_cargo)

    {
        $id_periodo=Session::get('periodotrabaja');
        Session::put('carrera_admin',$id_carrera);
        $carreras = DB::select('select *from gnral_carreras order by nombre');
        $cargos = DB::select('select *from gnral_cargos order by cargo');

        if($id_carrera==0)
        {
            $id_carrera=Session::get('carrera');
        }

        $fecha_nuevo = DB::selectOne('select gp.fecha_inicio from gnral_periodos gp WHERE gp.id_periodo='.$id_periodo.'');
        $fecha_nuevo=($fecha_nuevo->fecha_inicio);

        $docentes= DB::select('select DISTINCT h.id_personal, h.id_horario_profesor, p.nombre, h.aprobado, 
            p.rfc, p.clave,p.fch_ingreso_tesvb,gf.descripcion
FROM gnral_horarios h, gnral_horas_profesores hp, hrs_rhps rp, gnral_personales p,gnral_perfiles gf,
gnral_periodo_carreras gpc,gnral_periodos gp,
gnral_carreras gc
WHERE rp.id_hrs_profesor = hp.id_hrs_profesor
AND hp.id_horario_profesor = h.id_horario_profesor
and p.id_personal=h.id_personal
AND gp.id_periodo='.$id_periodo.'
AND gc.id_carrera='.$id_carrera.'
AND rp.id_cargo ='.$id_cargo.'
AND gf.id_perfil=p.id_perfil
AND h.id_periodo_carrera=gpc.id_periodo_carrera
AND gpc.id_carrera=gc.id_carrera AND
gpc.id_periodo=gp.id_periodo
UNION
SELECT DISTINCT h.id_personal, h.id_horario_profesor, p.nombre, h.aprobado,p.rfc, p.clave,
p.fch_ingreso_tesvb,gf.descripcion
FROM gnral_horarios h, hrs_extra_clase ec, hrs_horario_extra_clase hec, gnral_personales p,gnral_perfiles gf,gnral_periodo_carreras gpc,gnral_periodos gp,
gnral_carreras gc
WHERE hec.id_extra_clase= ec.id_extra_clase
AND ec.id_horario_profesor = h.id_horario_profesor
and p.id_personal=h.id_personal
AND gp.id_periodo='.$id_periodo.'
AND gc.id_carrera='.$id_carrera.'
AND hec.id_cargo ='.$id_cargo.'
AND gf.id_perfil=p.id_perfil
AND h.id_periodo_carrera=gpc.id_periodo_carrera
AND gpc.id_carrera=gc.id_carrera AND
gpc.id_periodo=gp.id_periodo order by nombre ');
       $datos_docente=array();
       $total_plantilla=0;
        foreach($docentes as $docente)
        {
            $fecha_actual=date('Y/m/d');
            $fecha_periodo=$fecha_nuevo;
            $fech_ingr=$docente->fch_ingreso_tesvb;
            $año_in=date("Y", strtotime($fech_ingr)); 
            $mes_in=date("m", strtotime($fech_ingr)); 
            $mes_ac=date("m");
            $año_ac=date("Y");

            $nombre['nombre']= $docente->nombre;
            $nombre['id_personal']= $docente->id_personal;
            $nombre['clave']= $docente->clave;
            $nombre['descripcion']= $docente->descripcion;

                    if(strtolower($mes_in)==strtolower($mes_ac)&&strtolower($año_in)==strtolower($año_ac))
                    {
                        $contrato='NUEVO INGRESO';
                    }
                    else
                    {
                        $contrato="RECONTRATADO";
                    }

            $nombre['fch_ingreso_tesvb']= $docente->fch_ingreso_tesvb;
            $nombre['rfc']= $docente->rfc;
            $nombre['observaciones']= $contrato;
            $nombre['nuevo_c']= $fecha_nuevo;

 $materias = DB::select('select distinct gnral_materias_perfiles.id_materia_perfil mpf,gnral_materias.id_materia idm,
gnral_materias.nombre,gnral_materias.hrs_practicas hrs_p,gnral_materias.hrs_teoria hrs_t,
gnral_materias.hrs_practicas totales,"" actividad
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
                                hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
                                UNION
                                SELECT distinct hrs_actividades_extras.id_hrs_actividad_extra mpf,hrs_actividades_extras.id_hrs_actividad_extra idm,
                                hrs_actividades_extras.descripcion nombre,
                                COUNT(hrs_horario_extra_clase.id_semana) hrs_p,"0" hrs_t,COUNT(hrs_horario_extra_clase.id_semana) totales,hrs_act_extra_clases.actividad FROM
                                hrs_actividades_extras,hrs_act_extra_clases,hrs_extra_clase,gnral_horarios,gnral_periodos,gnral_carreras,
                                hrs_horario_extra_clase,
                                gnral_periodo_carreras WHERE
                                gnral_carreras.id_carrera='.$id_carrera.' AND
                                gnral_periodos.id_periodo='.$id_periodo.' AND
                                gnral_horarios.id_personal='.$docente->id_personal.' AND
                                hrs_horario_extra_clase.id_cargo='.$id_cargo.' AND
                                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                                hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
                                hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
                                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase
                                GROUP BY hrs_act_extra_clases.id_hrs_actividad_extra,mpf,idm,hrs_actividades_extras.descripcion');
            $nombre_materias=array();

            $cuenta=count($materias);
            for ($i=0; $i < $cuenta; $i++) 
            { 
                $materias[$i]->totales=($materias[$i]->hrs_p+$materias[$i]->hrs_t);
            }
//dd($materias);
$f_total=0;
            foreach($materias as $materia)
            {
                $idmateria=$materia->idm;
                if($idmateria<20000)
                {
                    $grupos=DB::select('select DISTINCT gnral_horas_profesores.grupo 
                    FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,
                    gnral_periodo_carreras,gnral_periodos 
                    WHERE
                    gnral_materias_perfiles.id_materia_perfil='.$materia->mpf.' AND
                    gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                    gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
                    gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                    gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                    gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

                    $no_grupos=count($grupos);
                    $total=$no_grupos*$materia->totales;
                }
                else
                {
                     $grupos=DB::select('select DISTINCT hrs_extra_clase.grupo
                    FROM hrs_act_extra_clases,hrs_extra_clase,
                    gnral_periodo_carreras,gnral_periodos,gnral_horarios,hrs_actividades_extras,hrs_horario_extra_clase
                    WHERE
                    hrs_actividades_extras.id_hrs_actividad_extra='.$materia->mpf.' AND
                    gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                    gnral_horarios.id_personal='.$docente->id_personal.' AND
                    gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                    hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
                    hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                    hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra
                    and hrs_horario_extra_clase.id_extra_clase = hrs_extra_clase.id_extra_clase');
                    $total=$materia->hrs_p;

                    if($idmateria==20001 || $idmateria==20003 || $idmateria==20006 || $idmateria==20005)
                    {
                        $no_grupos="N.A";         
                    }
                    else
                    {
                        $no_grupos=count($grupos);
                    }
                }
               $f_total=$f_total+$total;
                    $nombrem['nombre_materia']= $materia->nombre;
                    $nombrem['actividad']= $materia->actividad;
                    $nombrem['id_materia']= $materia->idm;
                    $nombrem['id_materia_perfil']= $materia->mpf;
                    $nombrem['no_grupos']=$no_grupos;
                    if($idmateria == 20002){
                        $nombrem['horas_totales']=2;
                    }else{
                        $nombrem['horas_totales']=$materia->totales;
                    }
                    $nombrem['total']=$total;
                    array_push($nombre_materias, $nombrem);
            }//foreach de materias
            $nombre['f_total']=$f_total;
            $nombre['materias']=$nombre_materias;
            array_push($datos_docente,$nombre);
            $total_plantilla=$total_plantilla+$f_total;
        }//foreach de docentes
        //elimino la variable ver_horario, ver_totales,horarios_do,semanas,'ssuma'
       // dd($datos_docente);
            return view('plantilla.plantilla',compact('carreras','cargos','id_carrera',
                'id_cargo','fecha_nuevo','total_plantilla'))->with(['ver' => true, 'docentes' => $datos_docente]);
    }

    public function excel($id_carr,$id_car)
    {
        Session::put('id_carrera',$id_carr);
        Session::put('id_cargo',$id_car);

         
        Excel::create('Plantilla Docente-'.date('d-m-Y'), function($excel) 
        {
            $excel->sheet('PLANTILLA D.', function($sheet) 
            {  
                $obj1 = new PHPExcel_Worksheet_Drawing;
                $obj1->setPath(public_path('img/edom.png')); //your image path
                $obj1->setWidth(225);
                $obj1->setCoordinates('B4');
                $obj1->setWorksheet($sheet);

                $obj2 = new PHPExcel_Worksheet_Drawing;
                $obj2->setPath(public_path('img/logo3.PNG')); //your image path
                $obj2->setWidth(300);
                $obj2->setCoordinates('L4');
                $obj2->setWorksheet($sheet);

            $id_carrera=Session::get('id_carrera');
            $id_cargo=Session::get('id_cargo');
        
        $impr_cargo="";
         $impr_cargo=DB::selectOne('select cargo from gnral_cargos where id_cargo='.$id_cargo.'');
         $impr_cargo=($impr_cargo->cargo);


            $jefatura="";
            $jefe=DB::selectOne('select DISTINCT concat(abreviaciones.titulo," ",gnral_personales.nombre)abre from 
                gnral_personales,gnral_jefes_periodos,abreviaciones,abreviaciones_prof
                where gnral_jefes_periodos.id_carrera='.$id_carrera.' AND
                gnral_jefes_periodos.id_personal=gnral_personales.id_personal AND
                abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion AND
                abreviaciones_prof.id_personal=gnral_personales.id_personal ORDER BY gnral_personales.id_personal DESC LIMIT 1');
            $jefe=($jefe->abre);

            $carreran=DB::selectOne('select gnral_carreras.nombre from gnral_carreras where id_carrera='.$id_carrera.'');
            $carreran=($carreran->nombre);

            if($id_carrera==9 || $id_carrera==11)
                $jefatura.=" JEFE DE DEPARTAMENTO DE ".$carreran;
            else
                $jefatura.=" JEFATURA DE LA DIVISIÓN DE ".$carreran;

            
            $id_periodo=Session::get('periodotrabaja');
            $periodo=DB::selectOne('select gnral_periodos.periodo from gnral_periodos where gnral_periodos.id_periodo='.$id_periodo.'');
            $periodo=($periodo->periodo);

        $fecha_nuevo = DB::selectOne('select gp.fecha_inicio from gnral_periodos gp WHERE gp.id_periodo='.$id_periodo.'');
        $fecha_nuevo=($fecha_nuevo->fecha_inicio);

        $docentes= DB::select('select DISTINCT h.id_personal, h.id_horario_profesor, p.nombre, h.aprobado, 
            p.rfc, p.clave,p.fch_ingreso_tesvb,gf.descripcion
FROM gnral_horarios h, gnral_horas_profesores hp, hrs_rhps rp, gnral_personales p,gnral_perfiles gf,
gnral_periodo_carreras gpc,gnral_periodos gp,
gnral_carreras gc
WHERE rp.id_hrs_profesor = hp.id_hrs_profesor
AND hp.id_horario_profesor = h.id_horario_profesor
and p.id_personal=h.id_personal
AND gp.id_periodo='.$id_periodo.'
AND gc.id_carrera='.$id_carrera.'
AND rp.id_cargo ='.$id_cargo.'
AND gf.id_perfil=p.id_perfil
AND h.id_periodo_carrera=gpc.id_periodo_carrera
AND gpc.id_carrera=gc.id_carrera AND
gpc.id_periodo=gp.id_periodo
UNION
SELECT DISTINCT h.id_personal, h.id_horario_profesor, p.nombre, h.aprobado,p.rfc, p.clave,
p.fch_ingreso_tesvb,gf.descripcion
FROM gnral_horarios h, hrs_extra_clase ec, hrs_horario_extra_clase hec, gnral_personales p,gnral_perfiles gf,gnral_periodo_carreras gpc,gnral_periodos gp,
gnral_carreras gc
WHERE hec.id_extra_clase= ec.id_extra_clase
AND ec.id_horario_profesor = h.id_horario_profesor
and p.id_personal=h.id_personal
AND gp.id_periodo='.$id_periodo.'
AND gc.id_carrera='.$id_carrera.'
AND hec.id_cargo ='.$id_cargo.'
AND gf.id_perfil=p.id_perfil
AND h.id_periodo_carrera=gpc.id_periodo_carrera
AND gpc.id_carrera=gc.id_carrera AND
gpc.id_periodo=gp.id_periodo order by nombre ');

       $datos_docente=array();
       $total_plantilla=0;
        foreach($docentes as $docente)
        {
            $fecha_actual=date('Y/m/d');
            $fecha_periodo=$fecha_nuevo;
            $fech_ingr=$docente->fch_ingreso_tesvb;
            $año_in=date("Y", strtotime($fech_ingr)); 
            $mes_in=date("m", strtotime($fech_ingr)); 
            $mes_ac=date("m");
            $año_ac=date("Y");

            $nombre['nombre']= $docente->nombre;
            $nombre['id_personal']= $docente->id_personal;
            $nombre['clave']= $docente->clave;
            $nombre['descripcion']= $docente->descripcion;

                    if(strtolower($mes_in)==strtolower($mes_ac)&&strtolower($año_in)==strtolower($año_ac))
                    {
                        $contrato='NUEVO INGRESO';
                    }
                    else
                    {
                        $contrato="RECONTRATADO";
                    }

            $nombre['fch_ingreso_tesvb']= $docente->fch_ingreso_tesvb;
            $nombre['rfc']= $docente->rfc;
            $nombre['observaciones']= $contrato;
            $nombre['nuevo_c']= $fecha_nuevo;

 $materias = DB::select('select distinct gnral_materias_perfiles.id_materia_perfil mpf,gnral_materias.id_materia idm,
gnral_materias.nombre,gnral_materias.hrs_practicas hrs_p,gnral_materias.hrs_teoria hrs_t,
gnral_materias.hrs_practicas totales
FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,gnral_periodo_carreras,gnral_periodos, gnral_carreras
                                WHERE
                                gnral_materias_perfiles.id_personal='.$docente->id_personal.' AND
                                gnral_carreras.id_carrera='.$id_carrera.' AND
                                gnral_periodos.id_periodo='.$id_periodo.' AND
                                gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                                gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera
                                UNION
                                SELECT distinct hrs_actividades_extras.id_hrs_actividad_extra mpf,hrs_actividades_extras.id_hrs_actividad_extra idm,
                                hrs_actividades_extras.descripcion nombre,
                                COUNT(hrs_horario_extra_clase.id_semana) hrs_p,"0" hrs_t,COUNT(hrs_horario_extra_clase.id_semana) totales FROM
                                hrs_actividades_extras,hrs_act_extra_clases,hrs_extra_clase,gnral_horarios,gnral_periodos,gnral_carreras,
                                hrs_horario_extra_clase,
                                gnral_periodo_carreras WHERE
                                gnral_carreras.id_carrera='.$id_carrera.' AND
                                gnral_periodos.id_periodo='.$id_periodo.' AND
                                gnral_horarios.id_personal='.$docente->id_personal.' AND
                                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                                hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                                hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
                                hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra AND
                                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase
                                GROUP BY hrs_act_extra_clases.id_hrs_actividad_extra,mpf,idm,hrs_actividades_extras.descripcion');

            $nombre_materias=array();

            $cuenta=count($materias);
            for ($i=0; $i < $cuenta; $i++) 
            { 
                $materias[$i]->totales=($materias[$i]->hrs_p+$materias[$i]->hrs_t);
            }

$f_total=0;
            foreach($materias as $materia)
            {
                $idmateria=$materia->idm;
                if($idmateria<20000)
                {
                    $grupos=DB::select('select DISTINCT gnral_horas_profesores.grupo 
                    FROM gnral_materias_perfiles,gnral_materias,gnral_horarios,gnral_horas_profesores,
                    gnral_periodo_carreras,gnral_periodos 
                    WHERE
                    gnral_materias_perfiles.id_materia_perfil='.$materia->mpf.' AND
                    gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                    gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
                    gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                    gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                    gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

                    $no_grupos=count($grupos);
                    $total=$no_grupos*$materia->totales;
                }
                else
                {
                     $grupos=DB::select('select DISTINCT hrs_extra_clase.grupo
                    FROM hrs_act_extra_clases,hrs_extra_clase,
                    gnral_periodo_carreras,gnral_periodos,gnral_horarios,hrs_actividades_extras,hrs_horario_extra_clase
                    WHERE
                    hrs_actividades_extras.id_hrs_actividad_extra='.$materia->mpf.' AND
                    gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
                    gnral_horarios.id_personal='.$docente->id_personal.' AND
                    gnral_periodo_carreras.id_carrera='.$id_carrera.' AND
                    gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                    gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                    hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
                    hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                    hrs_act_extra_clases.id_hrs_actividad_extra=hrs_actividades_extras.id_hrs_actividad_extra
                    and hrs_horario_extra_clase.id_extra_clase = hrs_extra_clase.id_extra_clase');

                    $total=$materia->hrs_p;

                    if($idmateria==20001 || $idmateria==20003 || $idmateria==20006 || $idmateria==20005)
                    {
                        $no_grupos="N.A";         
                    }
                    else
                    {
                        $no_grupos=count($grupos);
                    }
                }
               $f_total=$f_total+$total;
                    $nombrem['nombre_materia']= $materia->nombre;
                    $nombrem['id_materia']= $materia->idm;
                    $nombrem['id_materia_perfil']= $materia->mpf;
                    $nombrem['no_grupos']=$no_grupos;
                    if($idmateria == 20002){
                        $nombrem['horas_totales']=2;
                    }else{
                        $nombrem['horas_totales']=$materia->totales;
                    }

                    $nombrem['total']=$total;
                    array_push($nombre_materias, $nombrem);
            }//foreach de materias
            $nombre['f_total']=$f_total;
            $nombre['materias']=$nombre_materias;
            array_push($datos_docente,$nombre);
            $total_plantilla=$total_plantilla+$f_total;
        }//foreach de docentes

            $sheet->setWidth(array(
                    'A' =>5,
                    'B' => 55,
                    'C' => 60,
                    'D' => 14,
                    'E' => 28,
                    'F' => 31,
                    'G' => 26,
                    'H' => 21,
                    'I' => 18,
                    'J' => 23,
                    'K' => 24,
                    'L' => 48,
                    'M' => 25
                ));
                $etiqueta=DB::selectOne('SELECT * FROM etiqueta WHERE id_etiqueta = 1 ');
 $sheet->loadView('plantilla.partialsh.plantilla',compact('periodo','impr_cargo','fecha_nuevo','total_plantilla','jefatura','jefe','etiqueta'))->with(['docentes' => $datos_docente]);

                $obj3 = new PHPExcel_Worksheet_Drawing;
                $obj3->setPath(public_path('img/me.PNG')); //your image path
                $obj3->setWidth(300);
                $obj3->setCoordinates('B60');
                $obj3->setWorksheet($sheet);

                $obj4 = new PHPExcel_Worksheet_Drawing;
                $obj4->setPath(public_path('img/calidad-ambiental.png')); //your image path
                $obj4->setWidth(150);
                $obj4->setCoordinates('C60');
                $obj4->setWorksheet($sheet);

                $obj5 = new PHPExcel_Worksheet_Drawing;
                $obj5->setPath(public_path('img/secretaria.png')); //your image path
                $obj5->setWidth(650);
                $obj5->setCoordinates('K60');
                $obj5->setWorksheet($sheet);



                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('barra');
                $objDrawing->setDescription('barra');
                $objDrawing->setPath('img/barra-gris.png');
                $objDrawing->setOffsetX(280);
                $objDrawing->setCoordinates('B65');

                $objDrawing->setWorksheet($sheet);



               /*  $obj6 = new PHPExcel_Worksheet_Drawing;
                 $obj6->setPath(public_path('img/barra-gris.png')); //your image path
                 $obj6->setWidth(700);
                 $obj6->setCoordinates('C65');
                 $obj6->setWorksheet($sheet);
*/
                });

        })->export('xls');

        return back();
    }

}
