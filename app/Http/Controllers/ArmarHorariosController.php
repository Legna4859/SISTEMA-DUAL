<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Horarios;
use App\Gnral_Personales;
use App\Hrs_Aulas;
use App\Gnral_Cargos;
use App\Hrs_Rhps;
use App\Gnral_Horas_Profesores;
use App\Hrs_Act_Extra_Clases;
use App\Hrs_Aprobar_Plantilla_Edu;
use App\Hrs_Extra_Clase;
use App\Hrs_Horario_Extra_Clase;
use App\Extensiones\consultas;

use Session;

class ArmarHorariosController extends Controller
{
    public function index()
    {
        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');
        $falta_materia=0; $act="false";

        $act_gestion = DB::select('select distinct hrs_act_extra_clases.actividad,hrs_act_extra_clases.id_act_extra_clase from
            hrs_act_extra_clases where hrs_act_extra_clases.id_hrs_actividad_extra=20005
            and hrs_act_extra_clases.id_carrera='.$id_carrera.'
            AND hrs_act_extra_clases.actividad IS NOT NULL');


        $act_vincu = DB::select('select distinct hrs_act_extra_clases.actividad,hrs_act_extra_clases.id_act_extra_clase from
            hrs_act_extra_clases where hrs_act_extra_clases.id_hrs_actividad_extra=20006
            AND hrs_act_extra_clases.id_carrera='.$id_carrera.'
            AND hrs_act_extra_clases.actividad IS NOT NULL');


        $activo=0;
        $id_profesor=0;
        $personales = DB::select('select gnral_personales.id_personal,gnral_personales.nombre from
                gnral_personales,gnral_horarios,gnral_periodo_carreras,gnral_carreras,gnral_periodos WHERE
                gnral_carreras.id_carrera='.$id_carrera.' AND
                gnral_periodos.id_periodo='.$id_periodo.' AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                gnral_horarios.id_personal=gnral_personales.id_personal');

        return view('horarios.armar_horarios',compact('personales','activo','id_profesor',
            'act_gestion','act_vincu','falta_materia','act'));
    }
    public function comprobar_creditos(Request $request)
    {

        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');
        $id_materia=$request->get('mat');
        $id_profesor=$request->get('tprof');

        $creditos=DB::selectOne('select SUM(gnral_materias.hrs_practicas+gnral_materias.hrs_teoria)suma
            from gnral_materias WHERE gnral_materias.id_materia='.$id_materia.'');
        $creditos=($creditos->suma);

        $actual=DB::selectOne('select count(hrs_rhps.id_rhps)hrs from gnral_materias,gnral_materias_perfiles,
        gnral_horarios,gnral_horas_profesores,hrs_rhps,gnral_periodo_carreras,gnral_periodos,gnral_carreras
        WHERE
        gnral_carreras.id_carrera='.$id_carrera.' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_materias.id_materia='.$id_materia.' AND
        gnral_horas_profesores.grupo='.$request->get('selectGrupo').' AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');
        $actual=($actual->hrs);

        if($actual>0&&$actual<$creditos)
            Session::put('bloquear',true);
        else
            Session::put('bloquear',false);

        return $this->redireccionar($request);
    }
    public function redireccionar(Request $request)
    {
        $contar=0;
        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodotrabaja');
        $id_profesor=Session::get('id_profesor');

        $horarios=DB::select('select DISTINCT gnral_horarios.id_horario_profesor from gnral_horarios,
            gnral_periodo_carreras,gnral_horas_profesores,hrs_extra_clase WHERE gnral_periodo_carreras.id_periodo='.$id_periodo.' AND
            gnral_horarios.id_personal='.$id_profesor.' AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND(
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor or hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor )');
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

        $estado=!empty($request->get('estado'))?$request->get('estado'):0;
        //dd($estado);

        if($request->get('mat')==null)
            {$nombre_materia=0;}
        else
        {$materia=DB::selectOne('select gnral_materias.nombre from gnral_materias where gnral_materias.id_materia='.$request->get('mat').' ');
        $nombre_materia=isset($materia->nombre)?$materia->nombre:0;}

        $noti=Session::get('notificacion');
        Session::forget('notificacion');

        $variable_bloquear=Session::get("bloquear");

        $ok = !empty($variable_bloquear)?"true":"false";

        $checar_eliminar=Session::get('checa_elimina');
        Session::forget('checa_elimina');
        $checa_ok = !empty($checar_eliminar)?"true":"false";

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
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia group by gnral_carreras.id_carrera,nombre)');

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

        $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
        $dias = DB::select('select DISTINCT dia FROM hrs_semanas');

        $hrs_maximas=DB::selectOne('select horas_maxima from gnral_personales WHERE id_personal='.$id_profesor.'');
        $hrs_maximas=($hrs_maximas->horas_maxima);

        $consulta_datos = new consultas();
        $horarios= $consulta_datos->retornar($request);

        foreach($horarios as $horario)
        {
            if($horario->id_personal==$id_profesor)
            {
                $contar++;
            }
            $espe=DB::selectOne('select COUNT(gnral_materias.especial)es from
                gnral_materias,gnral_materias_perfiles,hrs_rhps,gnral_horas_profesores,gnral_horarios,
                gnral_periodo_carreras,gnral_carreras,gnral_periodos WHERE
                gnral_materias.id_materia='.$horario->idmat.' AND gnral_periodos.id_periodo='.$id_periodo.'
                AND gnral_carreras.id_carrera='.$id_carrera.'
                AND hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo ');
            $espe=($espe->es);
            $checa_esp=DB::selectOne('select COUNT(hrs_rhps.id_rhps)numero from
            hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_carreras,gnral_materias_perfiles,gnral_materias
            where hrs_rhps.id_semana='.$horario->id_semana.' AND
            gnral_materias.id_materia='.$horario->idmat.' AND
            gnral_periodos.id_periodo='.$id_periodo.' AND
            gnral_carreras.id_carrera='.$id_carrera.' AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
            gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
            gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
            gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia');
            $horario->checa_esp=$checa_esp->numero;

        }
        //se elimino la variable mensaje
        return view('horarios.partialsh.partial_armar_horarios',
            compact('horarios','id_profesor','semanas','dias',
                'hrs_maximas','id_carrera','contar','ver_totales','ssuma','noti','espe',
                'nombre_materia','ok','checa_ok','estado','imprime'));
    }
    public function mostrar_profesores($id_profesor)
    {


        Session::put('bloquear',false);
        Session::put('id_profesor',$id_profesor);
        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodotrabaja');

        $maximo=DB::selectOne('select DISTINCT max(hrs_rhps.id_rhps)maxi FROM hrs_rhps,gnral_horarios,
        gnral_horas_profesores,gnral_periodo_carreras,gnral_periodos,gnral_carreras WHERE
        gnral_horarios.id_personal='.$id_profesor.' AND gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_carreras.id_carrera='.$id_carrera.' AND hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor
        AND gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');
        $maximo=isset($maximo->maxi)?$maximo->maxi:0;
        if($maximo>0)
        {
            $gr_mat=DB::selectOne('select gnral_horas_profesores.grupo,gnral_materias.id_materia,gnral_materias.nombre FROM
                hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_materias_perfiles,gnral_materias WHERE
                hrs_rhps.id_rhps='.$maximo.' AND hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                gnral_materias_perfiles.id_materia=gnral_materias.id_materia ');

                $creditos=DB::selectOne('select SUM(gnral_materias.hrs_practicas+gnral_materias.hrs_teoria)suma
                    from gnral_materias WHERE gnral_materias.id_materia='.$gr_mat->id_materia.'');
                $creditos=($creditos->suma);

                $actual=DB::selectOne('select count(hrs_rhps.id_rhps)hrs from gnral_materias,gnral_materias_perfiles,
                gnral_horarios,gnral_horas_profesores,hrs_rhps,gnral_periodo_carreras,gnral_periodos,gnral_carreras
                WHERE
                gnral_carreras.id_carrera='.$id_carrera.' AND
                gnral_periodos.id_periodo='.$id_periodo.' AND
                gnral_horarios.id_personal='.$id_profesor.' AND
                gnral_materias.id_materia='.$gr_mat->id_materia.' AND
                gnral_horas_profesores.grupo='.$gr_mat->grupo.' AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
                gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
                hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor');
                $actual=($actual->hrs);

                if($actual>0&&$actual<$creditos)
                {
                    $falta_materia=$gr_mat->nombre;
                    $act="true";
                }

                else
                {
                    $falta_materia=" ";
                    $act="false";
                }
        }
        else
        {
            $falta_materia=0;
            $act="false";
        }

        $act_gestion = DB::select('select distinct hrs_act_extra_clases.actividad,hrs_act_extra_clases.id_act_extra_clase from
            hrs_act_extra_clases where hrs_act_extra_clases.id_hrs_actividad_extra=20005
            and
            hrs_act_extra_clases.id_carrera='.$id_carrera.'
            AND hrs_act_extra_clases.actividad IS NOT NULL');
        $act_vincu = DB::select('select distinct hrs_act_extra_clases.actividad,hrs_act_extra_clases.id_act_extra_clase from
            hrs_act_extra_clases where hrs_act_extra_clases.id_hrs_actividad_extra=20006
            AND hrs_act_extra_clases.id_carrera='.$id_carrera.'
            AND hrs_act_extra_clases.actividad IS NOT NULL');
        $activo=1;
        $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
       // $horas= DB::select('select DISTINCT hora FROM hrs_semanas ORDER BY hora ');
        $dias = DB::select('select DISTINCT dia FROM hrs_semanas');
        $hrs_maximas=DB::selectOne('select horas_maxima from gnral_personales WHERE id_personal='.$id_profesor.'');
        $hrs_maximas=($hrs_maximas->horas_maxima);
        $hrs_maximas_ingles=DB::select('select maximo_horas_ingles from gnral_personales WHERE id_personal='.$id_profesor.'');

        $cargos = DB::select('select *from gnral_cargos order by cargo');
        $extras = DB::select('select * FROM hrs_actividades_extras where id_hrs_actividad_extra <> 20007 and id_hrs_actividad_extra <> 20004 order by descripcion asc ');
        $personales = DB::select('select gnral_personales.id_personal,gnral_personales.nombre
                from
                gnral_personales,gnral_horarios,gnral_periodo_carreras,gnral_carreras,gnral_periodos
                WHERE
                gnral_carreras.id_carrera='.$id_carrera.' AND
                gnral_periodos.id_periodo='.$id_periodo.' AND
                gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
                gnral_horarios.id_personal=gnral_personales.id_personal');

         if($id_carrera==9 || $id_carrera==11)
            {
                $aulas = DB::select('select *from hrs_aulas order by nombre');
            }
        else
            {
                $aulas = DB::select('select * FROM hrs_aulas where id_carrera='.$id_carrera.' order by nombre');
            }
        $aula_comp= DB::select('select hrs_aulas.id_aula,hrs_aulas.nombre from hrs_aulas where comp=1');
        $tipo_cargo = DB::selectOne('select gnral_personales.id_cargo FROM gnral_personales WHERE gnral_personales.id_personal='.$id_profesor.'');
        $tipo_cargo= ($tipo_cargo->id_cargo);

        $materias = DB::select('select gnral_materias_perfiles.id_materia_perfil, gnral_materias.id_materia, gnral_materias.nombre,
         gnral_reticulas.clave
            FROM gnral_materias_perfiles, gnral_reticulas, gnral_materias
            WHERE gnral_materias_perfiles.id_materia = gnral_materias.id_materia
            AND gnral_materias.id_reticula = gnral_reticulas.id_reticula
            AND gnral_reticulas.id_carrera ='.$id_carrera.'
            AND gnral_materias_perfiles.id_personal = '.$id_profesor.' and
            gnral_materias_perfiles.mostrar=1');


        $dat_periodo=DB::select('select gnral_periodos.periodo,gnral_periodos.fecha_inicio, gnral_periodos.fecha_termino from gnral_periodos where id_periodo='.$id_periodo.'');

        $inicio_periodo=$dat_periodo[0]->fecha_inicio;
        //elimino la variable contar
        return view('horarios.armar_horarios',compact('hrs_maximas_ingles','hrs_maximas','personales','dias', 'id_profesor','tipo_cargo','materias','aulas','aula_comp','activo','cargos','id_carrera', 'extras','semanas','act_gestion','act_vincu','falta_materia','act','inicio_periodo'));
    }
/////////////////
    public function agrega_actividad($tipo,$id,$nombre)
    {
        $id_carrera=Session::get('carrera');

         $actividad = array(
        'id_hrs_actividad_extra' => $id,
        'actividad' => $nombre,
        'id_carrera' => $id_carrera
        );

        $agrega_act=Hrs_Act_Extra_Clases::create($actividad);
        $act_gestion = DB::select('select distinct hrs_act_extra_clases.actividad,hrs_act_extra_clases.id_act_extra_clase from
            hrs_act_extra_clases where hrs_act_extra_clases.id_hrs_actividad_extra=20005
            and
            hrs_act_extra_clases.id_carrera='.$id_carrera.'
            AND hrs_act_extra_clases.actividad IS NOT NULL');
        $act_vincu = DB::select('select distinct hrs_act_extra_clases.actividad,hrs_act_extra_clases.id_act_extra_clase from
            hrs_act_extra_clases where hrs_act_extra_clases.id_hrs_actividad_extra=20006
            AND hrs_act_extra_clases.id_carrera='.$id_carrera.'
            AND hrs_act_extra_clases.actividad IS NOT NULL');
         if($tipo==1)
         {

           return compact('act_gestion');
         }
         else
         {
            return compact('act_vincu');
         }
    }
////////////
    public function store(Request $request)
    {
        //dd($request->get('mat'));
        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodotrabaja');
        $id_periodo_carrera=DB::selectOne('select id_periodo_carrera from gnral_periodo_carreras where
            id_periodo='.$id_periodo.' and id_carrera='.$id_carrera.'');
        $id_periodo_carrera=($id_periodo_carrera->id_periodo_carrera);

            $this->validate($request,[
            'selectTipoHr' => 'required',
            'tprof' => 'required',
            'selectAula' => 'required'
        ]);
if($request->get('mat')<20000)
{

    $especial=DB::selectOne('select gnral_materias.especial num from gnral_materias
        WHERE gnral_materias.id_materia='.$request->get('mat').'');
    $especial=($especial->num);

    if($especial==0)
    {
        $m_grupo=DB::select('select gnral_horarios.id_personal,gnral_materias.id_semestre,gnral_horas_profesores.grupo FROM
        gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,gnral_periodo_carreras,gnral_carreras,gnral_periodos
        WHERE
        gnral_carreras.id_carrera='.$id_carrera.' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_materias.id_materia='.$request->get('mat').' AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia');
        if($m_grupo!=null)
        {
            $sem=DB::selectOne('select gnral_materias.id_semestre from gnral_materias where
                gnral_materias.id_materia='.$request->get('mat').'');
            $sem=($sem->id_semestre);

            foreach($m_grupo as $checa_grupo)
            {
                if($checa_grupo->id_semestre==$sem && $checa_grupo->grupo==$request->get('selectGrupo')
                    && $checa_grupo->id_personal!=$request->get('tprof'))
                {
                    //dd($m_grupo);
                    //DIFERENTE DOCENTE EN MISMO GRUPO
                    Session::put('notificacion',9);
                    //Session::put('ocupado_por',$c3->nombre);
                    return $this->redireccionar($request);
                }
            }
        }

        $comprueba1=DB::selectOne('select gnral_personales.id_personal FROM
        hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_carreras,gnral_periodos,gnral_periodo_carreras,gnral_personales
        WHERE
        hrs_rhps.id_aula='.$request->get('selectAula').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        hrs_rhps.id_semana='.$request->get('idsemana').' AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horarios.id_personal=gnral_personales.id_personal');
        $entrada_a=count($comprueba1);

        $comprueba2=DB::selectOne('select gnral_personales.id_personal FROM
        hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_personales WHERE
        hrs_rhps.id_semana='.$request->get('idsemana').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$request->get('tprof').' AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horarios.id_personal=gnral_personales.id_personal
        UNION
        SELECT gnral_personales.id_personal FROM
        hrs_horario_extra_clase,hrs_extra_clase,gnral_horarios,gnral_periodo_carreras,gnral_periodos,gnral_personales WHERE
        hrs_horario_extra_clase.id_semana='.$request->get('idsemana').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horarios.id_personal='.$request->get('tprof').' AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horarios.id_personal=gnral_personales.id_personal');
        $entrada_d=count($comprueba2);

        $comprueba3=DB::select('select CONCAT(gnral_materias.id_semestre,0,gnral_horas_profesores.grupo)grupo,gnral_personales.nombre FROM
        hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,
        gnral_periodos,gnral_personales,gnral_carreras,gnral_materias,gnral_materias_perfiles WHERE
        hrs_rhps.id_semana='.$request->get('idsemana').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_carreras.id_carrera='.$id_carrera.' AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horarios.id_personal=gnral_personales.id_personal AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia
        UNION
        SELECT hrs_extra_clase.grupo,gnral_personales.nombre FROM
        hrs_horario_extra_clase,hrs_extra_clase,gnral_horarios,gnral_periodo_carreras,
        gnral_periodos,gnral_personales,gnral_carreras WHERE
        hrs_horario_extra_clase.id_semana='.$request->get('idsemana').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_carreras.id_carrera='.$id_carrera.' AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_horarios.id_personal=gnral_personales.id_personal');
        if($comprueba3!=null)
        {
            $cuenta3=count($comprueba3);
            $sem=DB::selectOne('select gnral_materias.id_semestre from gnral_materias where
                gnral_materias.id_materia='.$request->get('mat').'');
            $sem=($sem->id_semestre);
            $sem .= "0".$request->get('selectGrupo');

            foreach($comprueba3 as $c3)
            {
                if($c3->grupo==$sem)
                {
                    //GRUPO OCUPADO
                    Session::put('notificacion',6);
                    //Session::put('ocupado_por',$c3->nombre);
                    //dd($c3->nombre);
                    return $this->redireccionar($request);
                }
            }
        }

        if($entrada_a>=1)
        {
            $checa_es=DB::select('select gnral_materias.especial from gnral_materias,hrs_rhps,gnral_horas_profesores,gnral_materias_perfiles,
                gnral_horarios,gnral_periodo_carreras,gnral_carreras,gnral_periodos WHERE hrs_rhps.id_semana='.$request->get('idsemana').' AND
                gnral_periodos.id_periodo='.$id_periodo.' AND gnral_carreras.id_carrera='.$id_carrera.' AND
                hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
                gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
                gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor
                AND gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
                gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera ');
            $checa = isset($checa_es->especial)?$checa_es->especial:0;
            if($checa==1)
            {   //solo materias especiales
                Session::put('notificacion',4);
                return $this->redireccionar($request);
            }
            else
            { //AULA OCUPADA
                if($request->get('selectAula')!=0)
                {
                    Session::put('notificacion',2);
                    return $this->redireccionar($request);
                }
            }
        }
         else if($entrada_d>=1)
        {
            //DOCENTE OCUPADO
            Session::put('notificacion',1);
            return $this->redireccionar($request);
        }
    }
    else if($especial==1)
    {
        $existe=DB::select('select gnral_materias.id_materia,hrs_rhps.id_aula,gnral_materias.especial,
        CONCAT(gnral_materias.id_semestre,0,gnral_horas_profesores.grupo)grupo,gnral_horarios.id_personal,gnral_carreras.id_carrera
        FROM hrs_rhps,
        gnral_materias_perfiles,gnral_materias,gnral_horas_profesores,gnral_horarios,gnral_carreras,gnral_periodos,gnral_periodo_carreras
        WHERE
        hrs_rhps.id_semana='.$request->get('idsemana').' AND
        gnral_carreras.id_carrera='.$id_carrera.' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo');

        if($existe!=null)
        {
            foreach($existe as $exis)
            {//dd($exis->grupo);
                if($exis->especial==1)
                {
                    if($exis->id_carrera==$id_carrera)
                    {
                        $sem=DB::selectOne('select gnral_materias.id_semestre from gnral_materias where
                        gnral_materias.id_materia='.$request->get('mat').'');
                        $sem=($sem->id_semestre);
                        $sem .= "0".$request->get('selectGrupo'); //grupo actual extraido de combos
                        //dd($sem);
                        if($exis->id_materia!=$request->get('mat')&&$exis->id_aula==$request->get('selectAula')&&$exis->grupo==$sem)
                        {
                            //dd("notifi 7");
                            //DIFERENTE MATERIA EN ESPECIAL
                            Session::put('notificacion',7);
                            return $this->redireccionar($request);
                        }
                        else if($exis->id_aula!=$request->get('selectAula')&&$exis->id_materia==$request->get('mat')&&$exis->grupo==$sem)
                        {
                            //dd("noti 8");
                            //DIFERENTE AULA EN ESPECIAL
                            Session::put('notificacion',8);
                            return $this->redireccionar($request);
                        }
                        else if($exis->grupo!=$sem&&$exis->id_materia==$request->get('mat')&&$exis->id_aula==$request->get('selectAula'))
                        {
                            //dd("noti 5");
                            //DIFERENTE GRUPO EN ESPECIAL
                            Session::put('notificacion',5);
                            return $this->redireccionar($request);
                        }
                    }
                }
            }
        }
    }
}
    $id_profesor = $request->get('tprof');
    $id_materia = $request->get('mat');

    $horarioo = DB::selectOne('select id_horario_profesor from gnral_horarios where
        id_periodo_carrera='.$id_periodo_carrera.' and id_personal='.$id_profesor.'');
    $horarioo=($horarioo->id_horario_profesor);

    $verificar1=DB::selectOne('select hrs_aprobar_plantilla_edu.id_aprobar_plantilla_edu from
        hrs_aprobar_plantilla_edu where hrs_aprobar_plantilla_edu.id_horario='.$horarioo.'');

    if($id_materia<20000)
    {
        if($verificar1==null)
        {
            $aprobar_horario = array(
            'id_horario' => $horarioo,
            'hrs_clase' => 0,
            'gestion' => 0,
            'investigacion' => 0,
            'vinculacion' => 0,
            'residencia' => 0,
            'tutorias' => 0
            );
            $agrega_aprueba_horario=Hrs_Aprobar_Plantilla_Edu::create($aprobar_horario);
        }
        else
        {
            $idhorario=array('hrs_clase' => 0);
            $gnral_hrs=array(
            'aprobado'=>0);
            Horarios::find($horarioo)->update($gnral_hrs);

            Hrs_Aprobar_Plantilla_Edu::find($verificar1->id_aprobar_plantilla_edu)->update($idhorario);
        }
    }

if($id_materia>20000 & $id_materia<=20007)
{

    if($verificar1!=null)
    {
        if($id_materia==20001)
        {
            $idhorario=array('residencia' => 0);
        }
        else if($id_materia==20002)
        {
            $idhorario=array('tutorias' => 0);
        }
        else if($id_materia==20003)
        {
            $idhorario=array('investigacion' => 0);
        }
        else if($id_materia==20005)
        {
            $idhorario=array('gestion' => 0);
        }
        else if($id_materia==20006)
        {
            $idhorario=array('vinculacion' => 0);
        }
        $gnral_hrs=array(
            'aprobado'=>0);
        Horarios::find($horarioo)->update($gnral_hrs);

        Hrs_Aprobar_Plantilla_Edu::find($verificar1->id_aprobar_plantilla_edu)->update($idhorario);
    }
    else
    {
        $aprobar_horario = array(
        'id_horario' => $horarioo,
        'hrs_clase' => 0,
        'gestion' => 0,
        'investigacion' => 0,
        'vinculacion' => 0,
        'residencia' => 0,
        'tutorias' => 0
        );
        $agrega_aprueba_horario=Hrs_Aprobar_Plantilla_Edu::create($aprobar_horario);
    }

    if($id_materia==20001 || $id_materia==20003)
    {
        //dd($verificar1);
        $this->validate($request,[
            'descripcion' => 'required'
        ]);

        $crea_act = array(
        'id_hrs_actividad_extra' => $id_materia,
        'actividad' => $request->get('descripcion'),
        'id_carrera' => $id_carrera
        );

        $agrega_act_extra=Hrs_Act_Extra_Clases::create($crea_act);

        $id=DB::selectOne('select max(hrs_act_extra_clases.id_act_extra_clase) max from hrs_act_extra_clases');
        $id=($id->max);

        $hrs_act_extra_clases = array(
        'id_act_extra_clase' => $id,
        'id_horario_profesor' => $horarioo,
        'grupo' => 0
        );

        $agrega_hrs_extra=Hrs_Extra_Clase::create($hrs_act_extra_clases);
        $toma_id=DB::selectOne('select id_extra_clase from
            hrs_extra_clase where id_act_extra_clase='.$id.' and id_horario_profesor='.$horarioo.' and grupo=0');
        $toma_id=($toma_id->id_extra_clase);

        $horario_extra = array(
        'id_extra_clase' => $toma_id,
        'id_semana' => $request->get('idsemana'),
        'id_cargo' =>  $request->get('selectTipoHr'),
        'id_aula' => $request->get('selectAula')
        );
        $agrega_horario_extra=Hrs_Horario_Extra_Clase::create($horario_extra);

        return $this->redireccionar($request);
    }
    else if($id_materia==20002) //tutorias
    {
        $grupo= $request->get('SelectGrupoT');

        $comprueba3=DB::select('select CONCAT(gnral_materias.id_semestre,0,gnral_horas_profesores.grupo)grupo,gnral_personales.nombre FROM
        hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,
        gnral_periodos,gnral_personales,gnral_carreras,gnral_materias,gnral_materias_perfiles WHERE
        hrs_rhps.id_semana='.$request->get('idsemana').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_carreras.id_carrera='.$id_carrera.' AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horarios.id_personal=gnral_personales.id_personal AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia
        UNION
        SELECT hrs_extra_clase.grupo,gnral_personales.nombre FROM
        hrs_horario_extra_clase,hrs_extra_clase,gnral_horarios,gnral_periodo_carreras,
        gnral_periodos,gnral_personales,gnral_carreras WHERE
        hrs_horario_extra_clase.id_semana='.$request->get('idsemana').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_carreras.id_carrera='.$id_carrera.' AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_horarios.id_personal=gnral_personales.id_personal');
        if($comprueba3!=null)
        {
            $cuenta3=count($comprueba3);
            foreach($comprueba3 as $c3)
            {
                if($c3->grupo==$grupo)
                {
                    //GRUPO OCUPADO
                    Session::put('notificacion',6);
                    //Session::put('ocupado_por',$c3->nombre);
                    //dd($c3->nombre);
                    return $this->redireccionar($request);
                }
            }
        }

        $sacar_act=DB::selectOne('select hrs_act_extra_clases.id_act_extra_clase from
            hrs_act_extra_clases where hrs_act_extra_clases.id_hrs_actividad_extra='.$id_materia.'');
        $sacar_act=($sacar_act->id_act_extra_clase);

        $hrs_act_extra_clases = array(
        'id_act_extra_clase' => $sacar_act,
        'id_horario_profesor' => $horarioo,
        'grupo' => $grupo
        );

        $agrega_hrs_extra=Hrs_Extra_Clase::create($hrs_act_extra_clases);

        $toma_id=DB::selectOne('select id_extra_clase from
            hrs_extra_clase where id_act_extra_clase='.$sacar_act.' and id_horario_profesor='.$horarioo.' and grupo='.$grupo.'');
        $toma_id=($toma_id->id_extra_clase);

        $horario_extra = array(
        'id_extra_clase' => $toma_id,
        'id_semana' => $request->get('idsemana'),
        'id_cargo' =>  $request->get('selectTipoHr'),
        'id_aula' => $request->get('selectAula')
        );
        $agrega_horario_extra=Hrs_Horario_Extra_Clase::create($horario_extra);

        return $this->redireccionar($request);

    }
    else if($id_materia==20006)
    {
       $this->validate($request,[
            'selectVinculacion' => 'required'
        ]);
        $act=$request->get('selectVinculacion');

        $hrs_act_extra_clases = array(
        'id_act_extra_clase' => $request->get('selectVinculacion'),
        'id_horario_profesor' => $horarioo,
        'grupo' => 0
        );

        $agrega_hrs_extra=Hrs_Extra_Clase::create($hrs_act_extra_clases);

        $toma_id=DB::selectOne('select id_extra_clase from
            hrs_extra_clase where id_act_extra_clase='.$act.' and id_horario_profesor='.$horarioo.' and grupo=0');
        $toma_id=($toma_id->id_extra_clase);

        $horario_extra = array(
        'id_extra_clase' => $toma_id,
        'id_semana' => $request->get('idsemana'),
        'id_cargo' =>  $request->get('selectTipoHr'),
        'id_aula' => $request->get('selectAula')
        );
        $agrega_horario_extra=Hrs_Horario_Extra_Clase::create($horario_extra);

        return $this->redireccionar($request);
    }
    else if($id_materia==20005) //gestion academica
    {
        $grupo= $request->get('SelectGrupoT');

       $this->validate($request,[
            'selectGestion' => 'required'
        ]);

        $comprueba3=DB::select('select CONCAT(gnral_materias.id_semestre,0,gnral_horas_profesores.grupo)grupo,gnral_personales.nombre FROM
        hrs_rhps,gnral_horas_profesores,gnral_horarios,gnral_periodo_carreras,
        gnral_periodos,gnral_personales,gnral_carreras,gnral_materias,gnral_materias_perfiles WHERE
        hrs_rhps.id_semana='.$request->get('idsemana').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_carreras.id_carrera='.$id_carrera.' AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horarios.id_personal=gnral_personales.id_personal AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia
        UNION
        SELECT hrs_extra_clase.grupo,gnral_personales.nombre FROM
        hrs_horario_extra_clase,hrs_extra_clase,gnral_horarios,gnral_periodo_carreras,
        gnral_periodos,gnral_personales,gnral_carreras WHERE
        hrs_horario_extra_clase.id_semana='.$request->get('idsemana').' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_carreras.id_carrera='.$id_carrera.' AND
        hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
        hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
        gnral_horarios.id_personal=gnral_personales.id_personal');
        if($comprueba3!=null)
        {
            $cuenta3=count($comprueba3);
            foreach($comprueba3 as $c3)
            {
                if($c3->grupo==$grupo)
                {
                    //GRUPO OCUPADO
                    Session::put('notificacion',6);
                    //Session::put('ocupado_por',$c3->nombre);
                    //dd($c3->nombre);
                    return $this->redireccionar($request);
                }
            }
        }

        $grupo= $request->get('SelectGrupoT');
        $act=$request->get('selectGestion');

        $hrs_act_extra_clases = array(
        'id_act_extra_clase' => $act,
        'id_horario_profesor' => $horarioo,
        'grupo' => $grupo
        );

        $agrega_hrs_extra=Hrs_Extra_Clase::create($hrs_act_extra_clases);

        $toma_id=DB::selectOne('select id_extra_clase from
            hrs_extra_clase where id_act_extra_clase='.$act.' and id_horario_profesor='.$horarioo.' and grupo='.$grupo.'');
        $toma_id=($toma_id->id_extra_clase);

        $horario_extra = array(
        'id_extra_clase' => $toma_id,
        'id_semana' => $request->get('idsemana'),
        'id_cargo' =>  $request->get('selectTipoHr'),
        'id_aula' => $request->get('selectAula')
        );
        $agrega_horario_extra=Hrs_Horario_Extra_Clase::create($horario_extra);
        return $this->redireccionar($request);
    }

}
else
{
    $id_grupo= $request->get('selectGrupo');

    $max_espe=DB::selectOne('select gnral_materias.especial from gnral_materias where
        gnral_materias.id_materia='.$id_materia.' ');
    $hrs=DB::selectOne('select sum(gnral_materias.hrs_practicas+gnral_materias.hrs_teoria)suma from
        gnral_materias where gnral_materias.id_materia='.$id_materia.'');
    $hrs=($hrs->suma);
    $materia_hrs=DB::selectOne('select COUNT(gnral_materias_perfiles.id_materia)num_hrs from gnral_materias,gnral_materias_perfiles,gnral_horas_profesores,hrs_rhps,gnral_horarios,gnral_periodo_carreras,gnral_periodos WHERE
        gnral_materias_perfiles.id_materia='.$id_materia.' AND
        gnral_periodos.id_periodo='.$id_periodo.' AND
        gnral_horas_profesores.grupo='.$id_grupo.' AND
        gnral_horarios.id_personal='.$id_profesor.' AND
        gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
        gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
        gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
        gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
        gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
        hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor GROUP BY gnral_materias_perfiles.id_materia');

    $comprobar1 = isset($materia_hrs->num_hrs)?$materia_hrs->num_hrs:0;

    if($comprobar1==$hrs)
    {
        //LIMITE DE HORAS
        Session::put('notificacion',3);
        return $this->redireccionar($request);
    }


    $mat_perfil = DB::selectOne('select id_materia_perfil FROM gnral_materias_perfiles
        WHERE id_personal='.$id_profesor.' AND id_materia='.$id_materia.' ');
    $mat_perfil=($mat_perfil->id_materia_perfil);

    $checar = DB::selectOne('select gnral_horas_profesores.id_hrs_profesor from
        gnral_horas_profesores WHERE
        gnral_horas_profesores.id_horario_profesor='.$horarioo.' AND
        gnral_horas_profesores.grupo='.$id_grupo.' AND
        gnral_horas_profesores.id_materia_perfil='.$mat_perfil.' ');
    $comprobar = isset($checar->id_hrs_profesor)?$checar->id_hrs_profesor:0;

    if($comprobar==0)
    {
        $hrs_prof1 = array(
        'id_horario_profesor' => $horarioo,
        'grupo' => $id_grupo,
        'id_materia_perfil' => $mat_perfil
        );

        $agrega_hrs_prof=Gnral_Horas_Profesores::create($hrs_prof1);

        $idhrs = DB::selectOne('select id_hrs_profesor from gnral_horas_profesores where
        id_horario_profesor='.$horarioo.' and grupo='.$id_grupo.' and id_materia_perfil='.$mat_perfil.'');
        $idhrs=($idhrs->id_hrs_profesor);
    }
    else
    {
        $checar=($checar->id_hrs_profesor);
        $idhrs=$checar;
    }

        $rhps = array(
            'id_semana' => $request->get('idsemana'),
            'id_cargo' => $request->get('selectTipoHr'),
            'id_aula' => $request->get('selectAula'),
            'id_hrs_profesor' => $idhrs
        );

        $agrega_rhps=Hrs_Rhps::create($rhps);
        //return $this->redireccionar($request);
        return( $this->comprobar_creditos($request));
}

    }
    public function edit($id)
    {
        //

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        //dd($request);
        $id_carrera=Session::get('carrera');
        $id_periodo=Session::get('periodotrabaja');

        $id_profesor=Session::get('id_profesor');
        $ultimo=$request->get('decision'); //1=materias
        $id=$request->get('idaula'); //idaula=idrhps

        if($ultimo==1)
        {
            $mat=DB::selectOne('select gnral_materias.nombre,gnral_materias.id_materia,
            gnral_horas_profesores.grupo,hrs_rhps.id_aula FROM hrs_rhps,gnral_horas_profesores,
            gnral_materias_perfiles,gnral_materias WHERE
            hrs_rhps.id_rhps='.$id.' AND
            hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
            gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
            gnral_materias_perfiles.id_materia=gnral_materias.id_materia');
           // dd($id);
            $nmat=($mat->nombre);
            Session::put('n_materia',$nmat);

            $sacar = DB::selectOne('select hrs_rhps.id_hrs_profesor from hrs_rhps where id_rhps='.$id.' ');
            $sacar=($sacar->id_hrs_profesor); //

            $horario=DB::selectOne('select gnral_horas_profesores.id_horario_profesor from gnral_horas_profesores
                where gnral_horas_profesores.id_hrs_profesor='.$sacar.'');
            //dd($horario->id_horario_profesor);

            $gnral_hrs=array(
            'aprobado'=>0);
            Horarios::find($horario->id_horario_profesor)->update($gnral_hrs);

            $idhorario=array('hrs_clase' => 0);
            $verificar1=DB::selectOne('select hrs_aprobar_plantilla_edu.id_aprobar_plantilla_edu from
            hrs_aprobar_plantilla_edu where hrs_aprobar_plantilla_edu.id_horario='.$horario->id_horario_profesor.'');
            Hrs_Aprobar_Plantilla_Edu::find($verificar1->id_aprobar_plantilla_edu)->update($idhorario);

            $sacar2 = DB::select('select hrs_rhps.id_rhps from hrs_rhps where hrs_rhps.id_hrs_profesor='.$sacar.' ');
            $contar = count($sacar2); //cuenta registros de hrs_profesor en rhps

            $request->request->add([
                'selectAula' => $mat->id_aula,
                'mat' => $mat->id_materia,
                'selectGrupo' => $mat->grupo ,
                'tprof' => $id_profesor,
                'estado' => 3 //eliminar
                ]);
                if($contar==1)//si solo hay un registro en rhps de ese hrs_profesor, borra tanto rhps como hrs_profesor
                {
                    Hrs_Rhps::destroy($id);
                    Gnral_Horas_Profesores::destroy($sacar);
                    return $this->comprobar_creditos($request);
                }
                else
                {
                    Hrs_Rhps::destroy($id);
                    return $this->comprobar_creditos($request);
                }
        }
        else
        {
            $materia=DB::selectOne('select hrs_act_extra_clases.id_hrs_actividad_extra from
                hrs_act_extra_clases,hrs_extra_clase,hrs_horario_extra_clase WHERE
                hrs_horario_extra_clase.id_hr_extra='.$id.' AND
                hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
                hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase ');
            $id_materia=($materia->id_hrs_actividad_extra);

            $sacar = DB::selectOne('select hrs_horario_extra_clase.id_extra_clase from hrs_horario_extra_clase where
                id_hr_extra='.$id.'');
            $sacar=($sacar->id_extra_clase);

            $horario=DB::selectOne('select hrs_extra_clase.id_horario_profesor from hrs_extra_clase
                where hrs_extra_clase.id_extra_clase='.$sacar.'');
            //dd($horario->id_horario_profesor);

            $gnral_hrs=array(
            'aprobado'=>0);
            Horarios::find($horario->id_horario_profesor)->update($gnral_hrs);

            $verificar1=DB::selectOne('select hrs_aprobar_plantilla_edu.id_aprobar_plantilla_edu from
            hrs_aprobar_plantilla_edu where hrs_aprobar_plantilla_edu.id_horario='.$horario->id_horario_profesor.'');
            //dd($horario->id_horario_profesor);

            if($verificar1==null)
            {
                $aprobar_horario = array(
                'id_horario' => $horario->id_horario_profesor,
                'hrs_clase' => 0,
                'gestion' => 0,
                'investigacion' => 0,
                'vinculacion' => 0,
                'residencia' => 0,
                'tutorias' => 0
                );
                $agrega_aprueba_horario=Hrs_Aprobar_Plantilla_Edu::create($aprobar_horario);
            }
            else
            {
                if($id_materia==20001)
                {
                    $idhorario=array('residencia' => 0);
                }
                else if($id_materia==20002)
                {
                    $idhorario=array('tutorias' => 0);
                }
                else if($id_materia==20003)
                {
                    $idhorario=array('investigacion' => 0);
                }
                else if($id_materia==20005)
                {
                    $idhorario=array('gestion' => 0);
                }
                else if($id_materia==20006)
                {
                    $idhorario=array('vinculacion' => 0);
                }
                Hrs_Aprobar_Plantilla_Edu::find($verificar1->id_aprobar_plantilla_edu)->update($idhorario);
            }
            $sacar2 = DB::select('select hrs_horario_extra_clase.id_hr_extra from hrs_horario_extra_clase
                where hrs_horario_extra_clase.id_extra_clase='.$sacar.' ');
            $contar = count($sacar2);
                if($contar==1)
                {
                    Hrs_Horario_Extra_Clase::destroy($id);
                    Hrs_Extra_Clase::destroy($sacar);
                    return $this->redireccionar($request);
                }
                else
                {
                    Hrs_Horario_Extra_Clase::destroy($id);
                    return $this->redireccionar($request);
                }
        }
    }
}
