<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;

class Resi_revisar_anteproyectoController extends Controller
{
    public function index(){
        $id_profesor = Session::get('id_perso');
        $periodo=Session::get('periodo_actual');
       $carreras=DB::select('SELECT resi_revisores.*,gnral_carreras.nombre 
FROM resi_revisores,gnral_carreras WHERE resi_revisores.id_carrera=gnral_carreras.id_carrera 
and resi_revisores.id_periodo='.$periodo.' and resi_revisores.id_profesor='.$id_profesor.'');

       return view('residencia.carreras_revisores',compact('carreras'));
    }
    public function carrrera_revisor($id_revisores){
       $revisores=DB::selectOne('SELECT * FROM resi_revisores WHERE id_revisores = '.$id_revisores.'');

       $carrera=$revisores->id_carrera;
       $id_profesor=$revisores->id_profesor;
       $periodo=$revisores->id_periodo;

        $anteproyectos=DB::select('SELECT resi_anteproyecto.*,gnral_alumnos.nombre,gnral_alumnos.apaterno,
       gnral_alumnos.amaterno,gnral_alumnos.cuenta,resi_proyecto.nom_proyecto,resi_contar_evaluaciones.numero_evaluacion 
       from resi_anteproyecto,gnral_alumnos,resi_proyecto,resi_contar_evaluaciones where
        resi_anteproyecto.id_alumno=gnral_alumnos.id_alumno and gnral_alumnos.id_carrera='.$carrera.' 
        and resi_anteproyecto.id_periodo='.$periodo.'  and resi_anteproyecto.estado_enviado=1 and
       resi_proyecto.id_proyecto=resi_anteproyecto.id_proyecto AND
        resi_anteproyecto.id_anteproyecto = resi_contar_evaluaciones.id_anteproyecto and
            resi_anteproyecto.id_anteproyecto NOT IN (SELECT resi_anteproyecto_profesor.id_anteproyecto 
            from resi_anteproyecto_profesor where resi_anteproyecto_profesor.id_profesor='.$id_profesor.')');

return view('residencia.mostrar_anteproyectos',compact('anteproyectos','id_profesor'));
    }
    public function revisar_anteproyecto($id_anteproyecto,$id_profesor){
        //dd($id_profesor);
        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $numero_evaluacion=$numero_evaluacion->numero_evaluacion;
        if($numero_evaluacion == 1)
        {
          $numero=0;
        }
        else{
           $numero=$numero_evaluacion-1;
        }
        $comentario_portada=DB::selectOne('SELECT count(resi_comentarios_portada.id_comentario_portada) comentario_portada 
from resi_comentarios_portada where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_portada=$comentario_portada->comentario_portada;
       // dd($comentario_portada);


      $autorizado_portada=DB::selectOne('SELECT * FROM `resi_comentarios_portada` WHERE id_anteproyecto = '.$id_anteproyecto.' AND id_profesor ='.$id_profesor.' AND numero_evaluacion = '.$numero.'');
      $descripcion_comentario="Autorizado";
if($autorizado_portada== null){
    $autorizado_profesor = 0;
}
else {

    $autorizado_portada=$autorizado_portada->id_estado_evaluacion;
    if ($autorizado_portada == 1) {
        $autorizado_profesor = 1;
        if($comentario_portada ==0){

            DB:: table('resi_comentarios_portada')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => 1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);

        }
    } else {
        $autorizado_profesor = 0;
    }
}

        $autorizado_objetivos=DB::selectOne('SELECT * FROM resi_comentarios_objetivos WHERE id_anteproyecto = '.$id_anteproyecto.' AND id_profesor = '.$id_profesor.' AND numero_evaluacion ='.$numero.'');
$comentario_objetivos=DB::selectOne('SELECT count(resi_comentarios_objetivos.id_comentario_objetivos) comentario_objetivos 
from resi_comentarios_objetivos where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'');
//dd($autorizado_objetivos);
        $comentario_objetivos=$comentario_objetivos->comentario_objetivos;
        if($autorizado_objetivos== null){
           // $autorizado_profesor = 0;
        }
        else {

            $id_estado_evaluacion=$autorizado_objetivos->id_estado_evaluacion;
            if ($id_estado_evaluacion == 1) {
                if($comentario_objetivos ==0) {
                    $id_objetivos=$autorizado_objetivos->id_objetivos;
                    DB:: table('resi_comentarios_objetivos')->insert(['id_objetivos' => $id_objetivos,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => 1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);
                }

            }
        }

        $comentario_alcances=DB::selectOne('SELECT count(resi_comentarios_alcances.id_comentario_alcances) comentario_alcances 
from resi_comentarios_alcances where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_alcances=$comentario_alcances->comentario_alcances;
       //dd($comentario_alcances);
        $autorizado_alcances=DB::selectOne('SELECT * FROM resi_comentarios_alcances WHERE id_anteproyecto = '.$id_anteproyecto.' AND id_profesor = '.$id_profesor.' AND numero_evaluacion ='.$numero.'');
       // dd($autorizado_alcances);
        if($autorizado_alcances== null){
          //  $autorizado_profesor = 0;
        }
        else {

            $id_estado_evaluacion=$autorizado_alcances->id_estado_evaluacion;
            if ($id_estado_evaluacion == 1) {
                if($comentario_alcances ==0) {
                    $id_alcances = $autorizado_alcances->id_alcances;
                    DB:: table('resi_comentarios_alcances')->insert(['id_alcances' => $id_alcances, 'id_anteproyecto' => $id_anteproyecto, 'id_profesor' => $id_profesor, 'comentario' => $descripcion_comentario, 'id_estado_evaluacion' => 1, 'estado_evaluacion' => 1, 'numero_evaluacion' =>$numero_evaluacion]);
                }
            }
        }
        $comentario_justificacion=DB::selectOne('SELECT count(resi_comentarios_justificacion.id_comentario_justificacion) comentario_justificacion 
from resi_comentarios_justificacion where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
 and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_justificacion=$comentario_justificacion->comentario_justificacion;

        $autorizado_justificacion=DB::selectOne('SELECT * FROM resi_comentarios_justificacion WHERE id_anteproyecto = '.$id_anteproyecto.' AND id_profesor ='.$id_profesor.' AND numero_evaluacion ='.$numero.'');

        if($autorizado_justificacion== null){
            ///$autorizado_profesor = 0;
        }
        else {

            $id_estado_evaluacion=$autorizado_justificacion->id_estado_evaluacion;

            if ($id_estado_evaluacion == 1) {
                if($comentario_justificacion ==0) {
                    $id_justificacion=$autorizado_justificacion->id_justificacion;
                  //  dd($id_justificacion);
                    DB:: table('resi_comentarios_justificacion')->insert(['id_justificacion' => $id_justificacion,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' =>1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);
                }
            }
        }

        $comentario_marcoteorico=DB::selectOne('SELECT count(resi_comentarios_marcoteorico.id_comentario_marcoteorico) comentario_marcoteorico 
from resi_comentarios_marcoteorico where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_marcoteorico=$comentario_marcoteorico->comentario_marcoteorico;
       // dd($comentario_marcoteorico);
        $autorizado_marco_teorico=DB::selectOne('SELECT * FROM resi_comentarios_marcoteorico WHERE id_profesor = '.$id_profesor.' AND id_anteproyecto = '.$id_anteproyecto.' AND numero_evaluacion ='.$numero.'');
        //dd($autorizado_marco_teorico);
        if($autorizado_marco_teorico== null){
          //  $autorizado_profesor = 0;
        }
        else {

            $id_estado_evaluacion=$autorizado_marco_teorico->id_estado_evaluacion;

            if ($id_estado_evaluacion == 1) {
                if($comentario_marcoteorico ==0) {
                    $id_marco_teorico=$autorizado_marco_teorico->id_marco_teorico;
                    DB:: table('resi_comentarios_marcoteorico')->insert(['id_marco_teorico' => $id_marco_teorico,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => 1,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);
                }
            }
        }
        $comentario_cronograma=DB::selectOne('SELECT count(resi_comentarios_cronograma.id_comentario_cronograma) comentario_cronograma 
from resi_comentarios_cronograma where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_cronograma=$comentario_cronograma->comentario_cronograma;

        $autorizado_cronograma=DB::selectOne('SELECT * FROM resi_comentarios_cronograma WHERE id_anteproyecto = '.$id_anteproyecto.' AND id_profesor ='.$id_profesor.' AND numero_evaluacion ='.$numero.'');
        //dd($autorizado_cronograma);
        if($autorizado_cronograma== null){
           // $autorizado_profesor = 0;
        }
        else {

            $id_estado_evaluacion=$autorizado_cronograma->id_estado_evaluacion;
            if ($id_estado_evaluacion == 1) {
                if($comentario_cronograma ==0) {

                    DB:: table('resi_comentarios_cronograma')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => $id_estado_evaluacion,'estado_evaluacion'=>1,'numero_evaluacion'=>$numero_evaluacion]);
                }

            }
        }



//dd($autorizado_profesor);
        return redirect()->route('alumno_residencia', $id_anteproyecto);
      //  return view('residencia.revisar_anteproyecto.revisar_portada',compact('autorizado_profesor','anteproyecto_calificado','comentarios_profesores','comentario_portada','portada','id_profesor','id_anteproyecto','numero_evaluacion'));
    }
    public function ver_alumno_residencia($id_anteproyecto){
        $id_profesor = Session::get('id_perso');
        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $numero_evaluacion=$numero_evaluacion->numero_evaluacion;

        $comentario_portada=DB::selectOne('SELECT count(resi_comentarios_portada.id_comentario_portada) comentario_portada 
from resi_comentarios_portada where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_portada=$comentario_portada->comentario_portada;
        // dd($comentario_portada);
        $periodo=Session::get('periodo_actual');
        $portada=DB::selectOne('SELECT resi_anteproyecto.*,gnral_carreras.nombre carrera,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_alumnos.cuenta,resi_proyecto.nom_proyecto
 from resi_anteproyecto,gnral_alumnos,resi_proyecto,gnral_carreras where resi_anteproyecto.id_alumno=gnral_alumnos.id_alumno
 and gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
 and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.' and resi_anteproyecto.id_periodo='.$periodo.' 
 and resi_proyecto.id_proyecto=resi_anteproyecto.id_proyecto');
        $anteproyecto_calificado=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto)proy
 FROM resi_anteproyecto,resi_comentarios_portada,resi_comentarios_objetivos,resi_comentarios_marcoteorico,resi_contar_evaluaciones,
 resi_comentarios_justificacion,resi_comentarios_cronograma,resi_comentarios_alcances 
 where resi_comentarios_portada.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_portada.id_profesor='.$id_profesor.'
and resi_comentarios_portada.estado_evaluacion=1
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_objetivos.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_objetivos.id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.estado_evaluacion=1
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_marcoteorico.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_marcoteorico.id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.estado_evaluacion=1
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_justificacion.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_justificacion.id_profesor='.$id_profesor.'
and resi_comentarios_justificacion.estado_evaluacion=1
and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_cronograma.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_cronograma.id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.estado_evaluacion=1
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_alcances.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_alcances.id_profesor='.$id_profesor.'
and resi_comentarios_alcances.estado_evaluacion=1
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'
and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'
and resi_contar_evaluaciones.id_anteproyecto=resi_anteproyecto.id_anteproyecto');
        ///

        $anteproyecto_calificado=$anteproyecto_calificado->proy;
        $autorizado_portada=DB::selectOne('SELECT * FROM `resi_comentarios_portada` WHERE id_anteproyecto = '.$id_anteproyecto.' AND id_profesor ='.$id_profesor.' AND numero_evaluacion = '.$numero_evaluacion.'');
        if ($autorizado_portada == null){
            $autorizado_profesor=0;
        }
        else{
            $autorizado_portada=$autorizado_portada->id_estado_evaluacion;
            if($autorizado_portada ==1){
                $autorizado_profesor=1;
            }
            else{
                $autorizado_profesor=0;
            }
        }

        //dd($autorizado_profesor);
       /// return redirect()->route('alumno_residencia', $id_anteproyecto);
         return view('residencia.revisar_anteproyecto.revisar_portada',compact('autorizado_profesor','anteproyecto_calificado','comentario_portada','portada','id_profesor','id_anteproyecto','numero_evaluacion'));
    }


    public function revisar_portada(Request $request){
        //dd($request);
        $this->validate($request,[
            'id_profesor' => 'required',
            'comentario_portada' => 'required',
            'id_anteproyecto' => 'required',
            'id_estado_evaluacion' => 'required',
            'descripcion' => 'required',
        ]);

          $id_profesor = $request->input("id_profesor");
        $comentario_portada = $request->input("comentario_portada");
        $id_anteproyecto = $request->input("id_anteproyecto");
        $id_estado_evaluacion = $request->input("id_estado_evaluacion");
        $descripcion = $request->input("descripcion");
        $descripcion_comentario= strtoupper($descripcion);
        $contar_evaluaciones= DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $contar_evaluaciones=$contar_evaluaciones->numero_evaluacion;
        $contar_comentarios=DB::selectOne('SELECT COUNT(resi_comentarios_portada.id_comentario_portada)com_portada
 FROM resi_comentarios_portada WHERE id_anteproyecto ='.$id_anteproyecto.' and numero_evaluacion='.$contar_evaluaciones.'');
        $contar_comentarios=$contar_comentarios->com_portada;
        if($contar_comentarios ==2){
            DB::update('UPDATE resi_anteproyecto SET estado_revision =1 WHERE resi_anteproyecto.id_anteproyecto ='.$id_anteproyecto.'');
        }

       if($comentario_portada ==0){
           DB:: table('resi_comentarios_portada')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => $id_estado_evaluacion,'estado_evaluacion'=>1,'numero_evaluacion'=>$contar_evaluaciones]);
       }

       return back();
    }

    public function revisar_objetivos($id_anteproyecto,$id_profesor){
       //dd($id_profesor);
        $alumno=DB::selectOne('SELECT gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos,resi_anteproyecto WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'');
        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $numero_evaluacion=$numero_evaluacion->numero_evaluacion;

        $comentario_objetivos=DB::selectOne('SELECT count(resi_comentarios_objetivos.id_comentario_objetivos) comentario_objetivos 
from resi_comentarios_objetivos where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'');
           // dd($comentario_objetivos);
        $comentario_objetivos=$comentario_objetivos->comentario_objetivos;

        $objetivos=DB::selectOne('SELECT * FROM resi_objetivos WHERE id_anteproyecto ='.$id_anteproyecto.'');


        $comentarios_profesores_objetivos=DB::select('SELECT resi_comentarios_objetivos.*,gnral_personales.nombre 
FROM resi_comentarios_objetivos,gnral_personales 
WHERE gnral_personales.id_personal=resi_comentarios_objetivos.id_profesor 
and resi_comentarios_objetivos.id_anteproyecto= '.$id_anteproyecto.'
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'');
        $anteproyecto_calificado=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto)proy
 FROM resi_anteproyecto,resi_comentarios_portada,resi_comentarios_objetivos,resi_comentarios_marcoteorico,resi_contar_evaluaciones,
 resi_comentarios_justificacion,resi_comentarios_cronograma,resi_comentarios_alcances 
 where resi_comentarios_portada.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_portada.id_profesor='.$id_profesor.'
and resi_comentarios_portada.estado_evaluacion=1
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_objetivos.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_objetivos.id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.estado_evaluacion=1
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_marcoteorico.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_marcoteorico.id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.estado_evaluacion=1
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_justificacion.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_justificacion.id_profesor='.$id_profesor.'
and resi_comentarios_justificacion.estado_evaluacion=1
and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_cronograma.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_cronograma.id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.estado_evaluacion=1
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_alcances.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_alcances.id_profesor='.$id_profesor.'
and resi_comentarios_alcances.estado_evaluacion=1
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'
and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'
and resi_contar_evaluaciones.id_anteproyecto=resi_anteproyecto.id_anteproyecto');
        $anteproyecto_calificado=$anteproyecto_calificado->proy;
        $autorizado_objetivos=DB::selectOne('SELECT * FROM resi_comentarios_objetivos WHERE  id_anteproyecto = '.$id_anteproyecto.' AND id_profesor = '.$id_profesor.' and numero_evaluacion='.$numero_evaluacion.'');


        if($autorizado_objetivos== null){
            $autorizado_profesor = 0;
        }
        else {

            $autorizado_objetivos = $autorizado_objetivos->id_estado_evaluacion;
            //dd($autorizado_objetivos);
            if ($autorizado_objetivos == 1) {
                $autorizado_profesor = 1;

            } else {
                $autorizado_profesor = 0;
            }
        }
//dd($autorizado_profesor);
        return view('residencia.revisar_anteproyecto.revisar_objetivos',compact('autorizado_profesor','anteproyecto_calificado','alumno','comentarios_profesores_objetivos','comentario_objetivos','objetivos','id_profesor','id_anteproyecto','numero_evaluacion'));

    }
    public function guardar_comentarios_objetivos(Request $request){
//dd($request);
        $this->validate($request,[
            'id_profesor' => 'required',
            'comentario_objetivos' => 'required',
            'id_objetivos' => 'required',
            'id_anteproyecto' => 'required',
            'id_estado_evaluacion' => 'required',
            'descripcion' => 'required',
        ]);

        $id_profesor = $request->input("id_profesor");
        $id_objetivos = $request->input("id_objetivos");
        $comentario_objetivos = $request->input("comentario_objetivos");
        $id_anteproyecto = $request->input("id_anteproyecto");
        $id_estado_evaluacion = $request->input("id_estado_evaluacion");
        $descripcion = $request->input("descripcion");
        $descripcion_comentario= strtoupper($descripcion);
        $contar_evaluaciones= DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $contar_evaluaciones=$contar_evaluaciones->numero_evaluacion;
        $contar_comentarios=DB::selectOne('SELECT COUNT(resi_comentarios_objetivos.id_comentario_objetivos)com_objetivos 
FROM resi_comentarios_objetivos WHERE id_anteproyecto ='.$id_anteproyecto.'  and numero_evaluacion='.$contar_evaluaciones.'');
        $contar_comentarios=$contar_comentarios->com_objetivos;

        if($contar_comentarios ==2){
            DB::update("UPDATE resi_objetivos SET estado = 1 WHERE resi_objetivos.id_anteproyecto =$id_anteproyecto");
        }
        if($comentario_objetivos ==0){
            DB:: table('resi_comentarios_objetivos')->insert(['id_objetivos' => $id_objetivos,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => $id_estado_evaluacion,'estado_evaluacion'=>1,'numero_evaluacion'=>$contar_evaluaciones]);
        }
        return back();

    }
    public function revisar_alcances($id_anteproyecto,$id_profesor){
        //dd($id_profesor);
        $alumno=DB::selectOne('SELECT gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos,resi_anteproyecto WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'');
        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $numero_evaluacion=$numero_evaluacion->numero_evaluacion;
        $comentario_alcances=DB::selectOne('SELECT count(resi_comentarios_alcances.id_comentario_alcances) comentario_alcances 
from resi_comentarios_alcances where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_alcances=$comentario_alcances->comentario_alcances;
        $periodo=Session::get('periodo_actual');
        $alcances=DB::selectOne('SELECT * FROM resi_alcances WHERE id_anteproyecto = '.$id_anteproyecto.'');
        //dd($alcances);
        $comentarios_profesores_alcances=DB::select('SELECT resi_comentarios_alcances.*,gnral_personales.nombre 
FROM resi_comentarios_alcances,gnral_personales 
WHERE gnral_personales.id_personal=resi_comentarios_alcances.id_profesor 
and resi_comentarios_alcances.id_anteproyecto= '.$id_anteproyecto.'
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'');
        $anteproyecto_calificado=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto)proy
 FROM resi_anteproyecto,resi_comentarios_portada,resi_comentarios_objetivos,resi_comentarios_marcoteorico,resi_contar_evaluaciones,
 resi_comentarios_justificacion,resi_comentarios_cronograma,resi_comentarios_alcances 
 where resi_comentarios_portada.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_portada.id_profesor='.$id_profesor.'
and resi_comentarios_portada.estado_evaluacion=1
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_objetivos.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_objetivos.id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.estado_evaluacion=1
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_marcoteorico.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_marcoteorico.id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.estado_evaluacion=1
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_justificacion.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_justificacion.id_profesor='.$id_profesor.'
and resi_comentarios_justificacion.estado_evaluacion=1
and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_cronograma.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_cronograma.id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.estado_evaluacion=1
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_alcances.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_alcances.id_profesor='.$id_profesor.'
and resi_comentarios_alcances.estado_evaluacion=1
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'
and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'
and resi_contar_evaluaciones.id_anteproyecto=resi_anteproyecto.id_anteproyecto');
        $anteproyecto_calificado=$anteproyecto_calificado->proy;
//dd($comentarios_profesores_objetivos);
        $autorizado_alcances=DB::selectOne('SELECT * FROM resi_comentarios_alcances WHERE  id_anteproyecto = '.$id_anteproyecto.' AND id_profesor = '.$id_profesor.' and numero_evaluacion='.$numero_evaluacion.'');
        //$autorizado_portada=$autorizado_portada->estado_evaluacion;
      //  dd($autorizado_alcances);
        if($autorizado_alcances== null){
            $autorizado_profesor = 0;
        }
        else {

            $autorizado_alcances=$autorizado_alcances->id_estado_evaluacion;
            if ($autorizado_alcances == 1) {
                $autorizado_profesor = 1;
            } else {
                $autorizado_profesor = 0;
            }
        }
        return view('residencia.revisar_anteproyecto.revisar_alcances',compact('autorizado_profesor','anteproyecto_calificado','alumno','comentarios_profesores_alcances','comentario_alcances','alcances','id_profesor','id_anteproyecto','numero_evaluacion'));

    }
    public function guardar_comentarios_alcances(Request $request){
       // dd($request);
        $this->validate($request,[
            'id_profesor' => 'required',
            'comentario_alcances' => 'required',
            'id_alcances' => 'required',
            'id_anteproyecto' => 'required',
            'id_estado_evaluacion' => 'required',
            'descripcion' => 'required',
        ]);
        $id_profesor = $request->input("id_profesor");
        $id_alcances = $request->input("id_alcances");
        $comentario_alcances = $request->input("comentario_alcances");
        $id_anteproyecto = $request->input("id_anteproyecto");
        $id_estado_evaluacion = $request->input("id_estado_evaluacion");
        $descripcion = $request->input("descripcion");
        $descripcion_comentario= strtoupper($descripcion);
        $contar_evaluaciones= DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $contar_evaluaciones=$contar_evaluaciones->numero_evaluacion;
        $contar_comentarios=DB::selectOne('SELECT COUNT(resi_comentarios_alcances.id_comentario_alcances)com_alcances FROM resi_comentarios_alcances
 WHERE id_anteproyecto ='.$id_anteproyecto.' and numero_evaluacion='.$contar_evaluaciones.'');
        $contar_comentarios=$contar_comentarios->com_alcances;
        if($contar_comentarios ==2){
            DB::update("UPDATE resi_alcances SET estado = 1 WHERE resi_alcances.id_anteproyecto =$id_anteproyecto");
        }
        if($comentario_alcances ==0){
            DB:: table('resi_comentarios_alcances')->insert(['id_alcances' => $id_alcances,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => $id_estado_evaluacion,'estado_evaluacion'=>1,'numero_evaluacion'=>$contar_evaluaciones]);
        }
        return back();
    }
    public function revisar_justificacion($id_anteproyecto,$id_profesor){
        $alumno=DB::selectOne('SELECT gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos,resi_anteproyecto WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'');
        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $numero_evaluacion=$numero_evaluacion->numero_evaluacion;
        $comentario_justificacion=DB::selectOne('SELECT count(resi_comentarios_justificacion.id_comentario_justificacion) comentario_justificacion 
from resi_comentarios_justificacion where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
 and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_justificacion=$comentario_justificacion->comentario_justificacion;
        $periodo=Session::get('periodo_actual');
        $justificacion=DB::selectOne('SELECT * FROM resi_justificacion WHERE id_anteproyecto = '.$id_anteproyecto.'');

        $comentarios_profesores_justificacion=DB::select('SELECT resi_comentarios_justificacion.*,gnral_personales.nombre
 FROM resi_comentarios_justificacion,gnral_personales
  WHERE gnral_personales.id_personal=resi_comentarios_justificacion.id_profesor 
  and resi_comentarios_justificacion.id_anteproyecto='.$id_anteproyecto.'
  and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'');
        //dd($comentarios_profesores_justificacion);
        $anteproyecto_calificado=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto)proy
 FROM resi_anteproyecto,resi_comentarios_portada,resi_comentarios_objetivos,resi_comentarios_marcoteorico,resi_contar_evaluaciones,
 resi_comentarios_justificacion,resi_comentarios_cronograma,resi_comentarios_alcances 
 where resi_comentarios_portada.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_portada.id_profesor='.$id_profesor.'
and resi_comentarios_portada.estado_evaluacion=1
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_objetivos.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_objetivos.id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.estado_evaluacion=1
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_marcoteorico.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_marcoteorico.id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.estado_evaluacion=1
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_justificacion.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_justificacion.id_profesor='.$id_profesor.'
and resi_comentarios_justificacion.estado_evaluacion=1
and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_cronograma.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_cronograma.id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.estado_evaluacion=1
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_alcances.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_alcances.id_profesor='.$id_profesor.'
and resi_comentarios_alcances.estado_evaluacion=1
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'
and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'
and resi_contar_evaluaciones.id_anteproyecto=resi_anteproyecto.id_anteproyecto');
        $anteproyecto_calificado=$anteproyecto_calificado->proy;

        $autorizado_justificacion=DB::selectOne('SELECT * FROM resi_comentarios_justificacion WHERE  id_anteproyecto = '.$id_anteproyecto.' AND id_profesor = '.$id_profesor.' and numero_evaluacion='.$numero_evaluacion.'');
        if($autorizado_justificacion== null){
            $autorizado_profesor = 0;
        }
        else {

            $autorizado_justificacion=$autorizado_justificacion->id_estado_evaluacion;
            if ($autorizado_justificacion == 1) {
                $autorizado_profesor = 1;
            } else {
                $autorizado_profesor = 0;
            }
        }
        return view('residencia.revisar_anteproyecto.revisar_justificacion',compact('autorizado_profesor','anteproyecto_calificado','alumno','comentarios_profesores_justificacion','comentario_justificacion','justificacion','id_profesor','id_anteproyecto','numero_evaluacion'));

    }
    public function guardar_comentarios_justificacion(Request $request){
       // dd($request);
        $this->validate($request,[
            'id_profesor' => 'required',
            'comentario_justificacion' => 'required',
            'id_justificacion' => 'required',
            'id_anteproyecto' => 'required',
            'id_estado_evaluacion' => 'required',
            'descripcion' => 'required',
        ]);
        $id_profesor = $request->input("id_profesor");
        $id_justificacion = $request->input("id_justificacion");
        $comentario_justificacion = $request->input("comentario_justificacion");
        $id_anteproyecto = $request->input("id_anteproyecto");
        $id_estado_evaluacion = $request->input("id_estado_evaluacion");
        $descripcion = $request->input("descripcion");
        $descripcion_comentario= strtoupper($descripcion);
        $contar_evaluaciones= DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $contar_evaluaciones=$contar_evaluaciones->numero_evaluacion;
        $contar_comentarios=DB::selectOne('SELECT COUNT(resi_comentarios_justificacion.id_comentario_justificacion)com_justificacion 
FROM resi_comentarios_justificacion WHERE id_anteproyecto ='.$id_anteproyecto.' and numero_evaluacion='.$contar_evaluaciones.'');
        $contar_comentarios=$contar_comentarios->com_justificacion;

        if($contar_comentarios ==2){
            DB::update("UPDATE resi_justificacion SET estado = 1 WHERE resi_justificacion.id_anteproyecto=$id_anteproyecto");
        }
        if($comentario_justificacion ==0){
            DB:: table('resi_comentarios_justificacion')->insert(['id_justificacion' => $id_justificacion,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => $id_estado_evaluacion,'estado_evaluacion'=>1,'numero_evaluacion'=>$contar_evaluaciones]);
        }
        return back();
    }
    public function revisar_marcoteorico($id_anteproyecto,$id_profesor){
        $alumno=DB::selectOne('SELECT gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos,resi_anteproyecto WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'');
        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $numero_evaluacion=$numero_evaluacion->numero_evaluacion;
        $comentario_marcoteorico=DB::selectOne('SELECT count(resi_comentarios_marcoteorico.id_comentario_marcoteorico) comentario_marcoteorico 
from resi_comentarios_marcoteorico where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_marcoteorico=$comentario_marcoteorico->comentario_marcoteorico;
        $periodo=Session::get('periodo_actual');
        $marco_teorico=DB::selectOne('SELECT * FROM resi_marco_teorico WHERE id_anteproyecto = '.$id_anteproyecto.'');

        $comentarios_profesores_marcoteorico=DB::select('SELECT resi_comentarios_marcoteorico.*,gnral_personales.nombre 
FROM resi_comentarios_marcoteorico,gnral_personales 
WHERE gnral_personales.id_personal=resi_comentarios_marcoteorico.id_profesor
 and resi_comentarios_marcoteorico.id_anteproyecto='.$id_anteproyecto.'
 and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'');
        //dd($comentarios_profesores_justificacion);
        $anteproyecto_calificado=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto)proy
 FROM resi_anteproyecto,resi_comentarios_portada,resi_comentarios_objetivos,resi_comentarios_marcoteorico,resi_contar_evaluaciones,
 resi_comentarios_justificacion,resi_comentarios_cronograma,resi_comentarios_alcances 
 where resi_comentarios_portada.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_portada.id_profesor='.$id_profesor.'
and resi_comentarios_portada.estado_evaluacion=1
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_objetivos.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_objetivos.id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.estado_evaluacion=1
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_marcoteorico.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_marcoteorico.id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.estado_evaluacion=1
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_justificacion.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_justificacion.id_profesor='.$id_profesor.'
and resi_comentarios_justificacion.estado_evaluacion=1
and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_cronograma.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_cronograma.id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.estado_evaluacion=1
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_alcances.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_alcances.id_profesor='.$id_profesor.'
and resi_comentarios_alcances.estado_evaluacion=1
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'
and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'
and resi_contar_evaluaciones.id_anteproyecto=resi_anteproyecto.id_anteproyecto');
        $anteproyecto_calificado=$anteproyecto_calificado->proy;
        $autorizado_marco_teorico=DB::selectOne('SELECT * FROM resi_comentarios_marcoteorico WHERE  id_anteproyecto = '.$id_anteproyecto.' AND id_profesor = '.$id_profesor.' and numero_evaluacion='.$numero_evaluacion.'');
        if($autorizado_marco_teorico== null){
            $autorizado_profesor = 0;
        }
        else {

            $autorizado_marco_teorico=$autorizado_marco_teorico->id_estado_evaluacion;
            if ($autorizado_marco_teorico == 1) {
                $autorizado_profesor = 1;
            } else {
                $autorizado_profesor = 0;
            }
        }
        return view('residencia.revisar_anteproyecto.revisar_marcoteorico',compact('autorizado_profesor','anteproyecto_calificado','alumno','comentarios_profesores_marcoteorico','comentario_marcoteorico','marco_teorico','id_profesor','id_anteproyecto','numero_evaluacion'));

    }
    public function guardar_comentarios_marcoteorico(Request $request){
        //dd($request);
        $this->validate($request,[
            'id_profesor' => 'required',
            'comentario_marcoteorico' => 'required',
            'id_marcoteorico' => 'required',
            'id_anteproyecto' => 'required',
            'id_estado_evaluacion' => 'required',
            'descripcion' => 'required',
        ]);
        $id_profesor = $request->input("id_profesor");
        $id_marcoteorico = $request->input("id_marcoteorico");
        $comentario_marcoteorico = $request->input("comentario_marcoteorico");
        $id_anteproyecto = $request->input("id_anteproyecto");
        $id_estado_evaluacion = $request->input("id_estado_evaluacion");
        $descripcion = $request->input("descripcion");
        $descripcion_comentario= strtoupper($descripcion);
        $contar_evaluaciones= DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.' ');
        $contar_evaluaciones=$contar_evaluaciones->numero_evaluacion;
        $contar_comentarios=DB::selectOne('SELECT COUNT(resi_comentarios_marcoteorico.id_comentario_marcoteorico)com_marcoteorico
 FROM resi_comentarios_marcoteorico WHERE id_anteproyecto ='.$id_anteproyecto.' and numero_evaluacion='.$contar_evaluaciones.'');
        $contar_comentarios=$contar_comentarios->com_marcoteorico;

        if($contar_comentarios ==2){
            DB::update("UPDATE resi_marco_teorico SET estado = 1 WHERE resi_marco_teorico.id_anteproyecto = $id_anteproyecto");
        }
        if($comentario_marcoteorico ==0){
            DB:: table('resi_comentarios_marcoteorico')->insert(['id_marco_teorico' => $id_marcoteorico,'id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => $id_estado_evaluacion,'estado_evaluacion'=>1,'numero_evaluacion'=>$contar_evaluaciones]);
        }
        return back();
    }
    public function revisar_cronograma($id_anteproyecto,$id_profesor){
        $alumno=DB::selectOne('SELECT gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno from gnral_alumnos,resi_anteproyecto WHERE gnral_alumnos.id_alumno=resi_anteproyecto.id_alumno and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'');
        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $numero_evaluacion=$numero_evaluacion->numero_evaluacion;
        $comentario_cronograma=DB::selectOne('SELECT count(resi_comentarios_cronograma.id_comentario_cronograma) comentario_cronograma 
from resi_comentarios_cronograma where id_anteproyecto='.$id_anteproyecto.' and id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'');
        $comentario_cronograma=$comentario_cronograma->comentario_cronograma;
        $periodo=Session::get('periodo_actual');
        $cronograma=DB::select('SELECT * FROM resi_cronograma WHERE id_anteproyecto = '.$id_anteproyecto.' ORDER BY resi_cronograma.no_semana ASC');
//dd($cronograma);
        $comentarios_profesores_cronograma=DB::select('SELECT resi_comentarios_cronograma.*,gnral_personales.nombre 
FROM resi_comentarios_cronograma,gnral_personales WHERE gnral_personales.id_personal=resi_comentarios_cronograma.id_profesor 
and resi_comentarios_cronograma.id_anteproyecto='.$id_anteproyecto.'
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'');
        $anteproyecto_calificado=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto)proy
 FROM resi_anteproyecto,resi_comentarios_portada,resi_comentarios_objetivos,resi_comentarios_marcoteorico,resi_contar_evaluaciones,
 resi_comentarios_justificacion,resi_comentarios_cronograma,resi_comentarios_alcances 
 where resi_comentarios_portada.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_portada.id_profesor='.$id_profesor.'
and resi_comentarios_portada.estado_evaluacion=1
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_objetivos.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_objetivos.id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.estado_evaluacion=1
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_marcoteorico.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_marcoteorico.id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.estado_evaluacion=1
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_justificacion.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_justificacion.id_profesor='.$id_profesor.'
and resi_comentarios_justificacion.estado_evaluacion=1
and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_cronograma.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_cronograma.id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.estado_evaluacion=1
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_alcances.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_alcances.id_profesor='.$id_profesor.'
and resi_comentarios_alcances.estado_evaluacion=1
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'
and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'
and resi_contar_evaluaciones.id_anteproyecto=resi_anteproyecto.id_anteproyecto');
        $anteproyecto_calificado=$anteproyecto_calificado->proy;

        $autorizado_cronograma=DB::selectOne('SELECT * FROM resi_comentarios_cronograma WHERE  id_anteproyecto = '.$id_anteproyecto.' AND id_profesor = '.$id_profesor.' and numero_evaluacion='.$numero_evaluacion.'');
        if($autorizado_cronograma== null){
            $autorizado_profesor = 0;
        }
        else {

            $autorizado_cronograma=$autorizado_cronograma->id_estado_evaluacion;
            if ($autorizado_cronograma == 1) {
                $autorizado_profesor = 1;
            } else {
                $autorizado_profesor = 0;
            }
        }

        return view('residencia.revisar_anteproyecto.revisar_cronograma',compact('autorizado_profesor','anteproyecto_calificado','alumno','comentarios_profesores_cronograma','comentario_cronograma','cronograma','id_profesor','id_anteproyecto','numero_evaluacion'));

    }
    public function guardar_comentarios_cronograma(Request $request){
        $this->validate($request,[
            'id_profesor' => 'required',
            'comentario_cronograma' => 'required',
            'id_anteproyecto' => 'required',
            'id_estado_evaluacion' => 'required',
            'descripcion' => 'required',
        ]);
        $id_profesor = $request->input("id_profesor");
        $comentario_cronograma = $request->input("comentario_cronograma");
        $id_anteproyecto = $request->input("id_anteproyecto");
        $id_estado_evaluacion = $request->input("id_estado_evaluacion");
        $descripcion = $request->input("descripcion");
        $descripcion_comentario= strtoupper($descripcion);
        $contar_evaluaciones= DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
        $contar_evaluaciones=$contar_evaluaciones->numero_evaluacion;
        $contar_comentarios=DB::selectOne('SELECT COUNT(resi_comentarios_cronograma.id_comentario_cronograma)com_cronograma
 FROM resi_comentarios_cronograma WHERE id_anteproyecto ='.$id_anteproyecto.' and numero_evaluacion='.$contar_evaluaciones.' ');
        $contar_comentarios=$contar_comentarios->com_cronograma;

        if($contar_comentarios ==2){
            DB::update("UPDATE resi_cronograma SET estado = 1 WHERE resi_cronograma.id_anteproyecto = $id_anteproyecto");
        }
        if($comentario_cronograma ==0){
            DB:: table('resi_comentarios_cronograma')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor,'comentario' => $descripcion_comentario,'id_estado_evaluacion' => $id_estado_evaluacion,'estado_evaluacion'=>1,'numero_evaluacion'=>$contar_evaluaciones]);
        }
        return back();

    }
    public function enviar_anteproyecto_alumno($id_anteproyecto,$id_profesor){
//dd($id_anteproyecto,$id_profesor);

        $numero_evaluacion=DB::selectOne('SELECT * FROM resi_contar_evaluaciones WHERE id_anteproyecto = '.$id_anteproyecto.'');
       $numero_evaluacion=$numero_evaluacion->numero_evaluacion;
//dd($numero_evaluacion);
       $autorizacion_profesor=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto)proyecto
 FROM resi_anteproyecto,resi_comentarios_portada,resi_comentarios_objetivos,resi_comentarios_marcoteorico,resi_contar_evaluaciones,
 resi_comentarios_justificacion,resi_comentarios_cronograma,resi_comentarios_alcances 
 where resi_comentarios_portada.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_portada.id_profesor='.$id_profesor.'
and resi_comentarios_portada.id_estado_evaluacion=1
and resi_comentarios_portada.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_objetivos.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_objetivos.id_profesor='.$id_profesor.'
and resi_comentarios_objetivos.id_estado_evaluacion=1
and resi_comentarios_objetivos.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_marcoteorico.id_anteproyecto=resi_anteproyecto.id_anteproyecto 
and resi_comentarios_marcoteorico.id_profesor='.$id_profesor.'
and resi_comentarios_marcoteorico.id_estado_evaluacion=1
and resi_comentarios_marcoteorico.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_justificacion.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_justificacion.id_profesor='.$id_profesor.'
and resi_comentarios_justificacion.id_estado_evaluacion=1
and resi_comentarios_justificacion.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_cronograma.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_cronograma.id_profesor='.$id_profesor.'
and resi_comentarios_cronograma.id_estado_evaluacion=1
and resi_comentarios_cronograma.numero_evaluacion='.$numero_evaluacion.'
and resi_comentarios_alcances.id_anteproyecto=resi_anteproyecto.id_anteproyecto
and resi_comentarios_alcances.id_profesor='.$id_profesor.'
and resi_comentarios_alcances.id_estado_evaluacion=1
and resi_comentarios_alcances.numero_evaluacion='.$numero_evaluacion.'
and resi_anteproyecto.id_anteproyecto='.$id_anteproyecto.'
and resi_contar_evaluaciones.id_anteproyecto=resi_anteproyecto.id_anteproyecto');
       $autorizacion_profesor=$autorizacion_profesor->proyecto;
      //dd($autorizacion_profesor);

if($autorizacion_profesor == 1){
    $aceptado_profesor=DB::selectOne('SELECT count(id_aceptado) aceptar FROM resi_aceptado_anteproyecto WHERE id_anteproyecto ='.$id_anteproyecto.'');
    $aceptado_profesor=$aceptado_profesor->aceptar;
    //dd($aceptado_profesor);
    if($aceptado_profesor==2){

         DB::update("UPDATE resi_anteproyecto SET estado_enviado = 3 WHERE resi_anteproyecto.id_anteproyecto =$id_anteproyecto");
    }
    else{
        $contar_revisores=DB::selectOne('SELECT count(id_anteproyecto_profesor) contar_revisor FROM resi_anteproyecto_profesor where id_anteproyecto='.$id_anteproyecto.'');
        $contar_revisores=$contar_revisores->contar_revisor;
//dd($contar_revisores);
        if($contar_revisores == 2)
        {
            DB::update("UPDATE resi_anteproyecto SET estado_enviado =2 WHERE resi_anteproyecto.id_anteproyecto =$id_anteproyecto");

        }
    }
    DB:: table('resi_aceptado_anteproyecto')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor]);

}
else
{
    $contar_revisores=DB::selectOne('SELECT count(id_anteproyecto_profesor) contar_revisor FROM resi_anteproyecto_profesor where id_anteproyecto='.$id_anteproyecto.'');
    $contar_revisores=$contar_revisores->contar_revisor;
//dd($contar_revisores);
    if($contar_revisores == 2)
    {
        DB::update("UPDATE resi_anteproyecto SET estado_enviado =2 WHERE resi_anteproyecto.id_anteproyecto =$id_anteproyecto");

    }
}

       $autorizar_portada=DB::selectOne('SELECT count(id_comentario_portada) numero FROM resi_comentarios_portada WHERE id_anteproyecto = '.$id_anteproyecto.' AND numero_evaluacion = '.$numero_evaluacion.' and id_estado_evaluacion=1');
       $autorizar_portada=$autorizar_portada->numero;
      // dd($autorizar_portada);
       if($autorizar_portada == 3){
         DB::update('UPDATE resi_anteproyecto SET estado_aceptado_portada = 1 WHERE resi_anteproyecto.id_anteproyecto = '.$id_anteproyecto.'');
       }

       $autorizar_objetivos =DB::selectOne('SELECT count(id_comentario_objetivos) numero FROM resi_comentarios_objetivos WHERE id_anteproyecto = '.$id_anteproyecto.' AND numero_evaluacion = '.$numero_evaluacion.' and id_estado_evaluacion=1');
       $autorizar_objetivos=$autorizar_objetivos->numero;
      //  dd($autorizar_objetivos);
        if($autorizar_objetivos == 3){
         DB::update('UPDATE resi_objetivos SET estado_aceptado_objetivos =1 WHERE resi_objetivos.id_anteproyecto = '.$id_anteproyecto.'');
        }


        $autorizar_alcances= DB::selectOne('SELECT count(id_comentario_alcances)numero FROM resi_comentarios_alcances WHERE id_anteproyecto = '.$id_anteproyecto.' AND numero_evaluacion = '.$numero_evaluacion.' and id_estado_evaluacion=1');
       $autorizar_alcances=$autorizar_alcances->numero;
       //dd($autorizar_alcances);
        if($autorizar_alcances == 3){
            DB::update('UPDATE resi_alcances SET estado_aceptado_alcances = 1 WHERE resi_alcances.id_anteproyecto = '.$id_anteproyecto.'');
        }

       $autorizar_justificacion=DB::selectOne('SELECT count(id_comentario_justificacion)numero FROM resi_comentarios_justificacion WHERE id_anteproyecto = '.$id_anteproyecto.' AND numero_evaluacion = '.$numero_evaluacion.' and id_estado_evaluacion=1');
       $autorizar_justificacion=$autorizar_justificacion->numero;
       //dd($autorizar_justificacion);
        if($autorizar_justificacion == 3){
          DB::update('UPDATE resi_justificacion SET estado_aceptado_justificacion = 1 WHERE resi_justificacion.id_anteproyecto = '.$id_anteproyecto.'');
        }


        $autorizar_marco_teorico=DB::selectOne('SELECT count(id_comentario_marcoteorico) numero FROM resi_comentarios_marcoteorico WHERE id_anteproyecto = '.$id_anteproyecto.' AND numero_evaluacion = '.$numero_evaluacion.' and id_estado_evaluacion=1');
       $autorizar_marco_teorico=$autorizar_marco_teorico->numero;
       //dd($autorizar_marco_teorico);
        if($autorizar_marco_teorico == 3){
            DB::update('UPDATE resi_marco_teorico SET estado_aceptado_marco = 1 WHERE resi_marco_teorico.id_anteproyecto = '.$id_anteproyecto.'');
        }

       $autorizar_cronograma=DB::selectOne('SELECT count(id_comentario_cronograma) numero FROM resi_comentarios_cronograma WHERE id_anteproyecto = '.$id_anteproyecto.' AND numero_evaluacion =  '.$numero_evaluacion.' and id_estado_evaluacion=1');
      $autorizar_cronograma=$autorizar_cronograma->numero;
      //dd($autorizar_cronograma);
        if($autorizar_cronograma == 3){
       DB::update('UPDATE resi_cronograma SET estado_aceptado_cronograma=1 WHERE resi_cronograma.id_anteproyecto ='.$id_anteproyecto.' ');
        }


        DB:: table('resi_anteproyecto_profesor')->insert(['id_anteproyecto' => $id_anteproyecto,'id_profesor'=> $id_profesor]);
        return redirect('/residencia/revisores_anteproyecto');
    }

}
