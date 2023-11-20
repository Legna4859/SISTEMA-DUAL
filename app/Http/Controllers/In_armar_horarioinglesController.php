<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;
class In_armar_horarioinglesController extends Controller
{
    public function index(){
        $periodo_ingles=Session::get('periodo_ingles');
        $profesores=DB::select('SELECT in_profesores_ingles.* 
from in_profesores_ingles,in_plantilla_periodo where 
in_profesores_ingles.id_profesores=in_plantilla_periodo.id_profesor 
and in_plantilla_periodo.id_periodo='.$periodo_ingles.'');
        $sin_consultar=0;
        $id_grupo=0;
        $id_profesor=0;
        $id_niveles=0;
        return view('ingles.armar_horarios_ingles',compact('profesores','sin_consultar','id_grupo','id_profesor','id_niveles'));
    }
    public function  horario_ingles($id_profesor){
        $niveles= DB::select('SELECT * FROM in_niveles_ingles');
        return response()->json($niveles);

    }
    public function horario_ingles_niveles($id_profesor,$id_niveles){
        $grupos= DB::select('SELECT * FROM in_grupo_ingles');
        return response()->json(($grupos));
    }
    public function ingles_niveles(){
        $grupos= DB::select('SELECT * FROM in_grupo_ingles');
        return response()->json(($grupos));
    }
    public function profesor_horarios($id_profesor,$id_niveles,$id_grupo){
         // dd($id_profesor,$id_niveles,$id_grupo);
        $periodo_ingles=Session::get('periodo_ingles');
        $registro=DB::selectOne('SELECT count(in_hrs_ingles_profesor.id_hrs_ingles_profesor) prof from in_hrs_ingles_profesor where id_profesor='.$id_profesor.' and id_nivel='.$id_niveles.' and id_grupo='.$id_grupo.' and id_periodo='.$periodo_ingles.'');
        $registro=$registro->prof;
       // dd($registro);
        if($registro ==0)
        {
            $registro_prof=DB::selectOne('SELECT count(in_hrs_ingles_profesor.id_hrs_ingles_profesor) profes from in_hrs_ingles_profesor where id_nivel='.$id_niveles.' and id_grupo='.$id_grupo.' and id_periodo='.$periodo_ingles.'');
            $registro_prof=$registro_prof->profes;
            //dd($registro_prof);
            if($registro_prof ==0){
                $nombress=0;
                $disponible_grupo=0;
            }
            else{
                $nom=DB::selectOne('SELECT in_profesores_ingles.* from
 in_hrs_ingles_profesor,in_profesores_ingles where in_hrs_ingles_profesor.id_nivel='.$id_niveles.'
 and in_hrs_ingles_profesor.id_grupo='.$id_grupo.' and in_hrs_ingles_profesor.id_periodo='.$periodo_ingles.' and
  in_profesores_ingles.id_profesores=in_hrs_ingles_profesor.id_profesor');
                $nombress=$nom;
                $disponible_grupo=1;

            }

        }
        else
        {
            $nombress=0;
            $disponible_grupo=0;

        }
        $profesores=DB::select('SELECT in_profesores_ingles.* 
from in_profesores_ingles,in_plantilla_periodo where 
in_profesores_ingles.id_profesores=in_plantilla_periodo.id_profesor 
and in_plantilla_periodo.id_periodo='.$periodo_ingles.'');
        $sin_consultar=1;
        $niveles=DB::select('SELECT * FROM in_niveles_ingles');
        $grupos=DB::select('SELECT * FROM in_grupo_ingles');
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
        $dias = DB::select('select DISTINCT dia FROM hrs_semanas');
        $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
        //dd($disponible_grupo);

        $maximo_horas=DB::selectOne('SELECT COUNT(in_hrs_horas_profesor.id_hrs_horas_profesor) contar_horas FROM in_hrs_horas_profesor WHERE id_grupo='.$id_grupo.' and id_nivel='.$id_niveles.' and in_hrs_horas_profesor.id_periodo='.$periodo_ingles.'');
        $maximo_horas=$maximo_horas->contar_horas;


//horas del profesor
        $horas_profesor=DB::selectOne('SELECT * FROM in_profesores_ingles WHERE id_profesores ='.$id_profesor.'');
        $horas_profesor=$horas_profesor->horas_maximas;
        $horas_maximas_profesor=DB::selectOne('SELECT count(in_hrs_horas_profesor.id_hrs_horas_profesor) horas 
from in_hrs_horas_profesor WHERE in_hrs_horas_profesor.id_profesor='.$id_profesor.' and in_hrs_horas_profesor.id_periodo='.$periodo_ingles.'');
        $horas_maximas_profesor=$horas_maximas_profesor->horas;
        if($horas_profesor == $horas_maximas_profesor){
            $horas_max_prof=1;
        }
        else{
            $horas_max_prof=0;
        }
        return view('ingles.armar_horarios_ingles',compact('horas_max_prof','maximo_horas','disponible_grupo','nombress','array_ingles','semanas','dias','id_grupo','id_profesor','id_niveles','sin_consultar','profesores','niveles','grupos'));
    }
    public function agregar_horas($id_semana,$id_grupo,$id_profesor,$id_niveles){
        $periodo_ingles=Session::get('periodo_ingles');
        $horas_profesor=DB::selectOne('SELECT count(id_hrs_horas_profesor) horas 
from in_hrs_horas_profesor WHERE id_profesor='.$id_profesor.' and id_nivel='.$id_niveles.' 
and id_periodo='.$periodo_ingles.' and id_grupo='.$id_grupo.'');
        $horas_profesor=$horas_profesor->horas;
        if($horas_profesor ==0){
            DB:: table('in_hrs_ingles_profesor')->insert(['id_profesor'=>$id_profesor,'id_grupo'=>$id_grupo,'id_nivel'=>$id_niveles,'id_periodo'=>$periodo_ingles]);
        }
        DB:: table('in_hrs_horas_profesor')->insert(['id_profesor'=>$id_profesor,'id_grupo'=>$id_grupo,'id_nivel'=>$id_niveles,'id_semana'=>$id_semana,'id_periodo'=>$periodo_ingles]);
        return back();
    }
    public function eliminar_horario_semana($id_registro_horario,$id_grupo,$id_profesor,$id_niveles){
        $periodo_ingles=Session::get('periodo_ingles');
        $contar_horas=DB::selectOne('SELECT COUNT(id_hrs_horas_profesor)horas FROM in_hrs_horas_profesor WHERE id_profesor = '.$id_profesor.' AND id_grupo ='.$id_grupo.' AND id_nivel = '.$id_niveles.' and id_periodo='.$periodo_ingles.'');
        $contar_horas=$contar_horas->horas;

        if($contar_horas==1){
            DB::delete('DELETE FROM in_hrs_ingles_profesor WHERE id_profesor='.$id_profesor.' and id_profesor='.$id_profesor.' and id_grupo='.$id_grupo.' and id_nivel='.$id_niveles.' and id_periodo='.$periodo_ingles.'');


        }
        DB::delete('DELETE FROM in_hrs_horas_profesor WHERE id_hrs_horas_profesor='.$id_registro_horario.'');

        return back();
    }
}
