<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;
class In_mostrar_horariosController extends Controller
{
public function index(){
    $periodo_ingles=Session::get('periodo_ingles');
    $periodo=DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles ='.$periodo_ingles.'');
    //dd($periodo);
    $profesores=DB::select('SELECT in_profesores_ingles.id_profesores,in_profesores_ingles.nombre,
in_profesores_ingles.apellido_paterno,in_profesores_ingles.apellido_materno,in_nivel_ingles.descripcion nivel_ingles,
in_titulo.descripcion titulo,in_profesores_ingles.fecha_emision_titulo,in_profesores_ingles.horas_maximas,
in_sexo.descripcion sexo FROM in_plantilla_periodo,in_profesores_ingles,in_titulo,in_sexo,in_nivel_ingles WHERE
 in_profesores_ingles.id_nivel_ingles=in_nivel_ingles.id_nivel_ingles and in_sexo.id_sexo=in_profesores_ingles.id_sexo 
and in_profesores_ingles.id_tipo_titulo=in_titulo.id_titulo and in_profesores_ingles.id_profesores=in_plantilla_periodo.id_profesor 
and in_plantilla_periodo.id_periodo='.$periodo_ingles.'');


    //dd($profesores);
    return view('ingles.horarios_facilitadores',compact('periodo','profesores'));
}
public function mostrar_horario_profesor($id_profesor){
    $periodo_ingles=Session::get('periodo_ingles');

    $horario_profesores=DB::select('SELECT in_hrs_horas_profesor.id_semana FROM in_hrs_horas_profesor where id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.'');

    $array_horario_ing=array();
    $array_semana=array();
    foreach($horario_profesores as $horario_profesor)
    {
        $horario_prof['id_semana']=$horario_profesor->id_semana;
        array_push($array_horario_ing,$horario_prof);
    }

    $sem=DB::select('select id_semana FROM hrs_semanas ');
    foreach($sem as $sem)
    {
        $semanas['id_semana']=$sem->id_semana;
        array_push($array_semana,$semanas);
    }

    $resultado_semana=array();
    foreach ($array_semana as $vehiculo) {
        $esta=false;
        foreach ($array_horario_ing as $vehiculo2) {
            if ($vehiculo['id_semana']==$vehiculo2['id_semana']) {
                $esta=true;
                break;
            } // esta es la que se me olvidaba
        }
        if (!$esta) $resultado_semana[]=$vehiculo;
    }
    $array_ingles=array();
    foreach ($resultado_semana as $resultado)
    {
        $array_ing['id_semana']= $resultado['id_semana'];
        $array_ing['nombre']=0;
        $array_ing['nivel']=0;
        $array_ing['id_nivel']=0;
        $array_ing['id_grupo']=0;
        $array_ing['grupo']=0;
        $array_ing['registro']=0;
        $array_ing['disponibilidad']=3;

        array_push($array_ingles,$array_ing);
    }
    $profesores_horario=DB::select('
SELECT in_hrs_horas_profesor.id_semana,in_profesores_ingles.*,in_grupo_ingles.descripcion grupo,
in_niveles_ingles.descripcion nivel,in_hrs_horas_profesor.id_hrs_horas_profesor,in_hrs_horas_profesor.id_grupo,in_hrs_horas_profesor.id_nivel
 FROM in_hrs_horas_profesor,in_profesores_ingles,in_niveles_ingles,in_grupo_ingles 
 where id_profesor='.$id_profesor.' and id_periodo='.$periodo_ingles.' 
 and in_hrs_horas_profesor.id_profesor=in_profesores_ingles.id_profesores
  and in_hrs_horas_profesor.id_grupo=in_grupo_ingles.id_grupo_ingles and 
  in_hrs_horas_profesor.id_nivel=in_niveles_ingles.id_niveles_ingles 
  ORDER BY in_hrs_horas_profesor.id_semana ASC');

    foreach ($profesores_horario as $profesor_hor)
    {
        $array_labor['id_semana']= $profesor_hor->id_semana;
        $array_labor['nombre']=$profesor_hor->nombre.' '.$profesor_hor->apellido_paterno.' '.$profesor_hor->apellido_materno;
        $array_labor['nivel']=$profesor_hor->nivel;
        $array_labor['id_nivel']=$profesor_hor->id_nivel;
        $array_labor['id_grupo']=$profesor_hor->id_grupo;
        $array_labor['grupo']=$profesor_hor->grupo;
        $array_labor['registro']=$profesor_hor->id_hrs_horas_profesor;
        $array_labor['disponibilidad']=2;

        array_push($array_ingles,$array_labor);
    }
    foreach ($array_ingles as $key => $row) {
        $aux[$key] = $row['id_semana'];
    }
    array_multisort($aux, SORT_ASC, $array_ingles);
    $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
    $profesor=DB::selectOne('SELECT * FROM `in_profesores_ingles` WHERE `id_profesores` ='.$id_profesor.' ');
    //dd($profesor);
    return view('ingles.profesor_nivel',compact('array_ingles','semanas','profesor'));
}
public function mostrar_horario_profesor_grupo(){
    $niveles= DB::select('SELECT * FROM in_niveles_ingles');
    $grupos=DB::selectOne('SELECT * FROM in_grupo_ingles');
    $sin_consultar=0;
    return view('ingles.mostrar_grupos_niveles',compact('niveles','grupos','sin_consultar'));
}
public function mostrar_grupo_nivel($id_grupo,$id_nivel){
    $periodo_ingles=Session::get('periodo_ingles');

    $horario_grupo=DB::select('SELECT * FROM in_hrs_horas_profesor WHERE id_grupo ='.$id_grupo.' AND id_nivel = '.$id_nivel.' AND id_periodo = '.$periodo_ingles.'');

    $array_horario_ing=array();
    $array_semana=array();
    foreach($horario_grupo as $horario_grupo)
    {
        $horario_prof['id_semana']=$horario_grupo->id_semana;
        array_push($array_horario_ing,$horario_prof);
    }

    $sem=DB::select('select id_semana FROM hrs_semanas ');
    foreach($sem as $sem)
    {
        $semanas['id_semana']=$sem->id_semana;
        array_push($array_semana,$semanas);
    }

    $resultado_semana=array();
    foreach ($array_semana as $vehiculo) {
        $esta=false;
        foreach ($array_horario_ing as $vehiculo2) {
            if ($vehiculo['id_semana']==$vehiculo2['id_semana']) {
                $esta=true;
                break;
            } // esta es la que se me olvidaba
        }
        if (!$esta) $resultado_semana[]=$vehiculo;
    }

    $array_ingles=array();
    foreach ($resultado_semana as $resultado)
    {
        $array_ing['id_semana']= $resultado['id_semana'];
        $array_ing['nivel']=0;
        $array_ing['grupo']=0;
        $array_ing['disponibilidad']=3;
        array_push($array_ingles,$array_ing);
    }
    $profesores_horario=DB::select('
SELECT in_grupo_ingles.descripcion grupo,in_niveles_ingles.descripcion nivel, in_hrs_horas_profesor.* 
FROM  in_hrs_horas_profesor,in_niveles_ingles,in_grupo_ingles 
WHERE in_hrs_horas_profesor.id_grupo = '.$id_grupo.' AND in_hrs_horas_profesor.id_nivel = '.$id_nivel.'
 AND in_hrs_horas_profesor.id_periodo = '.$periodo_ingles.' and in_hrs_horas_profesor.id_grupo=in_grupo_ingles.id_grupo_ingles
  and in_hrs_horas_profesor.id_nivel=in_niveles_ingles.id_niveles_ingles  
ORDER BY `in_hrs_horas_profesor`.`id_semana` ASC');
//dd($profesores_horario);
    foreach ($profesores_horario as $profesor_hor)
    {
        $array_labor['id_semana']= $profesor_hor->id_semana;
        $array_labor['nivel']=$profesor_hor->nivel;
        $array_labor['grupo']=$profesor_hor->grupo;
        $array_labor['disponibilidad']=2;

        array_push($array_ingles,$array_labor);
    }
    foreach ($array_ingles as $key => $row) {
        $aux[$key] = $row['id_semana'];
    }
    array_multisort($aux, SORT_ASC, $array_ingles);
    $niveles= DB::select('SELECT * FROM in_niveles_ingles');
    $grupos=DB::select('SELECT * FROM in_grupo_ingles');
    $sin_consultar=1;
    $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
    $profesor=DB::selectOne('SELECT in_profesores_ingles.* FROM in_hrs_ingles_profesor,in_profesores_ingles 
WHERE in_hrs_ingles_profesor.id_grupo = '.$id_grupo.' AND in_hrs_ingles_profesor.id_nivel = '.$id_nivel.' 
AND in_hrs_ingles_profesor.id_periodo = '.$periodo_ingles.'
 and in_hrs_ingles_profesor.id_profesor=in_profesores_ingles.id_profesores');
    if($profesor == null )
    {
     $no_horario=0;
    }
    else{
        $no_horario=1;
    }
    return view('ingles.mostrar_grupos_niveles',compact('niveles','grupos','sin_consultar','id_nivel','id_grupo','semanas','array_ingles','profesor','no_horario'));
}
}
