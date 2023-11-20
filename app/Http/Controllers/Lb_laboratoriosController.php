<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;

class Lb_laboratoriosController extends Controller
{
    public function  index(){
        $laboratorios=DB::select('Select *from lb_laboratorios');


        return view('laboratorios.ver_laboratorios',compact('laboratorios'));
    }
    public function  laboratorios($laboratorio,$fecha_inicial,$fecha_final){

        $fecha_inicial=date("Y-m-d ",strtotime($fecha_inicial));
        $fecha_final=date("Y-m-d ",strtotime($fecha_final));
        // dd($fecha_final);
        $id_periodo=Session::get('periodotrabaja');
        $horarios = DB::select("SELECT lb_profesores_materia.id_semana 
FROM gnral_personales,lb_profesores_materia WHERE
lb_profesores_materia.id_profesor=gnral_personales.id_personal 
and lb_profesores_materia.id_periodo=$id_periodo and lb_profesores_materia.id_laboratorio=$laboratorio
union SELECT lb_registro_laboratorio.id_semana from lb_registro_laboratorio 
WHERE lb_registro_laboratorio.id_laboratorio=$laboratorio 
and lb_registro_laboratorio.fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'
ORDER BY id_semana ASC");


//dd($horarios);
        /*$horarios = DB::select("SELECT hrs_rhps.id_semana FROM
gnral_horarios,gnral_horas_profesores,gnral_materias_perfiles,gnral_materias,hrs_rhps,gnral_periodo_carreras,hrs_semanas,gnral_carreras WHERE
gnral_periodo_carreras.id_periodo=$id_periodo AND
hrs_rhps.id_aula=$laboratorio AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor AND
gnral_horas_profesores.id_materia_perfil=gnral_materias_perfiles.id_materia_perfil AND
gnral_materias_perfiles.id_materia=gnral_materias.id_materia AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_rhps.id_hrs_profesor=gnral_horas_profesores.id_hrs_profesor AND
hrs_rhps.id_semana=hrs_semanas.id_semana
UNION
SELECT hrs_horario_extra_clase.id_semana FROM
hrs_horario_extra_clase,hrs_semanas,hrs_act_extra_clases,hrs_extra_clase,gnral_horarios,
gnral_periodo_carreras,gnral_carreras,gnral_periodos,hrs_actividades_extras
WHERE
gnral_periodo_carreras.id_periodo=$id_periodo AND
hrs_horario_extra_clase.id_aula=$laboratorio AND
gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera AND
gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_extra_clase.id_act_extra_clase=hrs_act_extra_clases.id_act_extra_clase AND
hrs_extra_clase.id_horario_profesor=gnral_horarios.id_horario_profesor AND
hrs_horario_extra_clase.id_extra_clase=hrs_extra_clase.id_extra_clase AND
hrs_horario_extra_clase.id_semana=hrs_semanas.id_semana AND
gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera AND
hrs_act_extra_clases.id_act_extra_clase=hrs_actividades_extras.id_hrs_actividad_extra
union SELECT lb_registro_laboratorio.id_semana from lb_registro_laboratorio 
WHERE lb_registro_laboratorio.id_laboratorio=$laboratorio 
and lb_registro_laboratorio.fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'
ORDER BY id_semana ASC");*/



        $array_horarios=array();
        $array_semana=array();
        foreach($horarios as $horario)
        {
            $horas['id_semana']=$horario->id_semana;
            array_push($array_horarios,$horas);
        }

        $sem=DB::select('select id_semana FROM hrs_semanas ');
        foreach($sem as $sem)
        {
            $semanas['id_semana']=$sem->id_semana;
            array_push($array_semana,$semanas);
        }

        $resultado=array();
        foreach ($array_semana as $vehiculo) {
            $esta=false;
            foreach ($array_horarios as $vehiculo2) {
                if ($vehiculo['id_semana']==$vehiculo2['id_semana']) {
                    $esta=true;
                    break;
                } // esta es la que se me olvidaba
            }
            if (!$esta) $resultado[]=$vehiculo;
        }
        $array_laboratorios=array();
        foreach ($resultado as $resultado)
        {
            $array_labor['id_semana']= $resultado['id_semana'];
            $array_labor['nombre']=0;
            $array_labor['carrera']=0;
            $array_labor['registro']=0;
            $array_labor['ofp']=3;

            array_push($array_laboratorios,$array_labor);
        }
        $horariosprofesor = DB::select("SELECT lb_profesores_materia.id_semana,lb_profesores_materia.descripcion,gnral_personales.nombre,2 fop,lb_profesores_materia.id_profesores_materia registro 
FROM gnral_personales,lb_profesores_materia WHERE
lb_profesores_materia.id_profesor=gnral_personales.id_personal 
and lb_profesores_materia.id_periodo=$id_periodo and lb_profesores_materia.id_laboratorio=$laboratorio
UNION SELECT lb_registro_laboratorio.id_semana,gnral_personales.nombre,lb_registro_laboratorio.descripcion_utilizar carrera,4 fop,lb_registro_laboratorio.id_reg_laboratorio registro 
from lb_registro_laboratorio,gnral_personales 
WHERE lb_registro_laboratorio.id_usuario=gnral_personales.id_personal 
and lb_registro_laboratorio.id_laboratorio=$laboratorio 
and lb_registro_laboratorio.fecha_registro BETWEEN '$fecha_inicial' AND '$fecha_final'
ORDER BY id_semana ASC");
//dd($horariosprofesor);
        foreach ($horariosprofesor as $horarioprof)
        {
            $array_labor['id_semana']= $horarioprof->id_semana;
            $array_labor['nombre']=$horarioprof->nombre;
            $array_labor['carrera']=$horarioprof->descripcion;
            $array_labor['registro']=$horarioprof->registro;
            $array_labor['ofp']=$horarioprof->fop;

            array_push($array_laboratorios,$array_labor);
        }
        foreach ($array_laboratorios as $key => $row) {
            $aux[$key] = $row['id_semana'];
        }
        array_multisort($aux, SORT_ASC, $array_laboratorios);
       // dd($array_laboratorios);


        $dias = DB::select('select DISTINCT dia FROM hrs_semanas');
        //$semanas= Hrs_semanas::all();
        $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
        $laboratorio=DB::selectOne('SELECT * FROM lb_laboratorios where id_laboratorio='.$laboratorio.'');
        $personales=DB::select('SELECT * FROM gnral_personales ORDER BY `gnral_personales`.`nombre` ASC ');
        $carreras=DB::select('SELECT * FROM gnral_carreras');


        return view('laboratorios.laboratorios',compact('carreras','semanas','array_laboratorios','dias','laboratorio','personales','fecha_inicial','fecha_final'));
    }
    public function apartarlab(Request $request){
        $this->validate($request,[
            'id_laboratorio' => 'required',
            'id_semana' => 'required',
            'fecha_registro' => 'required',
            'personal' => 'required',
            'descripcion' => 'required',

        ]);
        $id_laboratorio = $request->input("id_laboratorio");
        $id_semana = $request->input("id_semana");
        $fecha_registro = $request->input("fecha_registro");
        //dd($fecha_registro);
        $personal = $request->input("personal");
        $descripcion = $request->input("descripcion");
        DB:: table('lb_registro_laboratorio')->insert(['id_usuario'=>$personal,'id_semana'=>$id_semana,'descripcion_utilizar'=>$descripcion,'id_laboratorio'=>$id_laboratorio,'fecha_registro' =>$fecha_registro]);
        return back();

    }
    public function  eliminar($id){
        DB::delete('DELETE FROM lb_registro_laboratorio WHERE lb_registro_laboratorio.id_reg_laboratorio='.$id.'');
        return back();
    }
    public function eliminar_profesor($id)
    {
        DB::delete('DELETE FROM lb_profesores_materia WHERE lb_profesores_materia.id_profesores_materia='.$id.'');
        return back();
    }
    public function  materiaprofesor(Request $request)
    {
        $this->validate($request,[
            'id_laboratorio1' => 'required',
            'id_semana1' => 'required',
            'personal' => 'required',
            'descripcion' => 'required',

        ]);
        $id_periodo=Session::get('periodotrabaja');
        $id_laboratorio = $request->input("id_laboratorio1");
        $id_semana = $request->input("id_semana1");
        $personal = $request->input("personal");
        $descripcion = $request->input("descripcion");
        DB:: table('lb_profesores_materia')->insert(['id_profesor'=>$personal,'id_semana'=>$id_semana,'descripcion'=>$descripcion,'id_laboratorio'=>$id_laboratorio,'id_periodo' =>$id_periodo]);
        return back();

    }
}