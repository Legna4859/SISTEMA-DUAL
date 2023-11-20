<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_formulario_datostituladoController extends Controller
{

    public function formulario_datos_titulado_carrera(){
        $carreras=DB::select('SELECT * FROM `gnral_carreras` WHERE `id_carrera` 
                                         NOT IN (9,11,15) ');
        return view('titulacion.jefe_titulacion.formulario_datos_titulado.carreras_formulario',compact('carreras'));
    }
    public function autorizar_titulacion_alumnos($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE id_carrera='.$id_carrera.'');

        $alumnos=DB::select('SELECT ti_descuentos_alum.telefono,ti_reg_datos_alum.correo_electronico,ti_reg_datos_alum.no_cuenta cuenta, ti_reg_datos_alum.nombre_al nombre,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, gnral_carreras.nombre carrera, ti_fecha_jurado_alumn.*
from ti_descuentos_alum,ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras,ti_datos_alumno_reg_dep WHERE
ti_descuentos_alum.id_alumno = ti_reg_datos_alum.id_alumno and 
ti_reg_datos_alum.id_alumno= ti_fecha_jurado_alumn.id_alumno AND
ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno and 
 ti_reg_datos_alum.id_carrera='.$id_carrera.'
 and ti_reg_datos_alum.id_carrera=gnral_carreras.id_carrera and 
 ti_fecha_jurado_alumn.id_estado_enviado=4 AND
 ti_datos_alumno_reg_dep.id_autorizacion=0');
        return view('titulacion.jefe_titulacion.formulario_datos_titulado.alumnos_formulario',compact('alumnos','carrera','id_carrera'));


    }

public function formulario_datos_titulado_dato_alumno($id_alumno){
        $alumno=DB::selectOne('SELECT ti_descuentos_alum.telefono,ti_reg_datos_alum.correo_electronico,ti_reg_datos_alum.no_cuenta cuenta, ti_reg_datos_alum.nombre_al nombre,
       ti_reg_datos_alum.apaterno,ti_reg_datos_alum.mencion_honorifica men_honorifica, ti_reg_datos_alum.amaterno, gnral_carreras.id_carrera, gnral_carreras.nombre carrera, ti_fecha_jurado_alumn.*
from ti_descuentos_alum,ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras,ti_datos_alumno_reg_dep WHERE
ti_descuentos_alum.id_alumno = ti_reg_datos_alum.id_alumno and 
ti_reg_datos_alum.id_alumno= ti_fecha_jurado_alumn.id_alumno AND
ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno and 
 ti_reg_datos_alum.id_alumno= '.$id_alumno.'
 and ti_reg_datos_alum.id_carrera=gnral_carreras.id_carrera');


    $mencion_honorifica=$alumno->men_honorifica;

    if($mencion_honorifica == 1){
        $contar_reg_mencion=DB::selectOne('SELECT COUNT(id_mencion_honorifica)contar from ti_mencion_honorifica where id_alumno ='.$id_alumno.'');
        $contar_reg_mencion=$contar_reg_mencion->contar;
        if($contar_reg_mencion == 0){
            $max_libro=DB::selectOne('SELECT max(libro_registro) maximo_libro_mencion from ti_mencion_honorifica');
            $max_libro=$max_libro->maximo_libro_mencion;
            $max_num_reg=DB::selectOne('SELECT MAX(no_registro) numero_reg FROM ti_mencion_honorifica WHERE libro_registro ='.$max_libro.'');
            $max_num_reg=$max_num_reg->numero_reg;

            if($max_num_reg == 100 ){
                $numero_mencion_honorifica=1;
                $libro_mencion_honorifica=$max_libro+1;
            }else{
                $numero_mencion_honorifica=$max_num_reg+1;
                $libro_mencion_honorifica=$max_libro;
            }
        }
    }else{
        $numero_mencion_honorifica=0;
        $libro_mencion_honorifica=0;
    }

    $registro_titulo=DB::selectOne('SELECT COUNT(id_datos_alumno_reg_dep) contar FROM ti_datos_alumno_reg_dep where id_alumno ='.$id_alumno.'');
    $registro_titulo=$registro_titulo->contar;
    if($registro_titulo > 0){
        $max_libro=DB::selectOne('SELECT MAX(numero_libro_titulo) numero_max FROM ti_datos_alumno_reg_dep');
        $max_libro=$max_libro->numero_max;

        $max_numero = DB::selectOne('SELECT max(numero_foja_titulo) max_num_foja from ti_datos_alumno_reg_dep where numero_libro_titulo ='.$max_libro.'');
        $max_numero=$max_numero->max_num_foja;

        if($max_numero == 100){
            $contar_foja=DB::selectOne('SELECT COUNT(numero_foja_titulo) contar_foja 
FROM ti_datos_alumno_reg_dep where numero_foja_titulo = '.$max_numero.' and numero_libro_titulo = '.$max_libro.'');
            $contar_foja=$contar_foja->contar_foja;
            if($contar_foja == 10){
                $numero_foja_titulo=1;
                $numero_libro_titulo= $max_libro+1;
            }else{
                $numero_foja_titulo=100;
                $numero_libro_titulo= $max_libro;
            }

        }else{
            $contar_foja=DB::selectOne('SELECT COUNT(numero_foja_titulo) contar_foja 
FROM ti_datos_alumno_reg_dep where numero_foja_titulo = '.$max_numero.' and numero_libro_titulo = '.$max_libro.'');
            $contar_foja=$contar_foja->contar_foja;
            if($contar_foja == 10){
                $numero_foja_titulo=$max_numero+1;
                $numero_libro_titulo=$max_libro;
            }else{
                $numero_foja_titulo=$max_numero;
                $numero_libro_titulo=$max_libro;
            }

        }
    }else{
        $numero_foja_titulo=0;
        $numero_libro_titulo=0;
    }

    $registro_acta= DB::selectOne('SELECT count(id_acta_titulacion) contar from ti_acta_titulaciones where id_alumno = '.$id_alumno.'');
    $registro_acta =$registro_acta->contar;


    if($registro_acta == 0){
        $num_acta= DB::selectOne('SELECT MAX(numero_acta_titulacion) numero_acta from ti_acta_titulaciones');
        $num_acta=$num_acta->numero_acta+1;

        $num_libro_acta=DB::selectOne('SELECT MAX(numero_libro_acta_titulacion) num_libro_acta FROM ti_acta_titulaciones');
        $num_libro_acta=$num_libro_acta->num_libro_acta;

        $num_foja_acta =DB::selectOne('SELECT MAX(foja_acta_titulacion) num_foja_acta FROM ti_acta_titulaciones where numero_libro_acta_titulacion = '.$num_libro_acta.'');
        $num_foja_acta=$num_foja_acta->num_foja_acta;

        if($num_foja_acta == 100){
            $numero_libro_acta_titulacion=$num_libro_acta+1;
            $foja_acta_titulacion=1;
        }else{
            $numero_libro_acta_titulacion=$num_libro_acta;
            $foja_acta_titulacion=$num_foja_acta+1;

        }

    }else{
        $num_acta = 0;
        $numero_libro_acta_titulacion=0;
        $foja_acta_titulacion=0;
    }

    return view('titulacion.jefe_titulacion.formulario_datos_titulado.autorizar_alumno_titulacion',
        compact('alumno',
            'numero_mencion_honorifica', 'libro_mencion_honorifica',
        'numero_foja_titulo','numero_libro_titulo',
        'num_acta','numero_libro_acta_titulacion','foja_acta_titulacion'));




}
public function guardar_autorizacion_titulacion(Request $request){
    $this->validate($request,[
        'id_alumno' => 'required',
        'mencion_honorifica' => 'required',
        'numero_mencion_honorifica' => 'required',
        'libro_mencion_honorifica' => 'required',
        'numero_foja_titulo' => 'required',
        'numero_libro_titulo' => 'required',
        'num_acta' => 'required',
        'numero_libro_acta_titulacion' => 'required',
        'foja_acta_titulacion' => 'required',
    ]);

    $id_alumno = $request->input("id_alumno");
    $datos_alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` ='.$id_alumno.'');

    $mencion_honorifica = $request->input("mencion_honorifica");
    $numero_mencion_honorifica = $request->input("numero_mencion_honorifica");
    $libro_mencion_honorifica = $request->input("libro_mencion_honorifica");
    $numero_foja_titulo = $request->input("numero_foja_titulo");
    $numero_libro_titulo = $request->input("numero_libro_titulo");
    $num_acta = $request->input("num_acta");
    $numero_libro_acta_titulacion = $request->input("numero_libro_acta_titulacion");
    $foja_acta_titulacion = $request->input("foja_acta_titulacion");
    $fecha_actual =  date("Y-m-d H:i:s");

    if($mencion_honorifica == 1){
        DB:: table('ti_mencion_honorifica')->
        insert(['no_registro' =>$numero_mencion_honorifica,
            'libro_registro' =>$libro_mencion_honorifica,
            'fecha_registro_dato'=>$fecha_actual,
            'id_alumno'=>$id_alumno
        ]);
    }
    DB:: table('ti_datos_alumno_reg_dep')  ->where('id_alumno', $id_alumno)
        ->update([
            'numero_foja_titulo'=>$numero_foja_titulo,
            'numero_libro_titulo'=>$numero_libro_titulo,
            'id_autorizacion'=>1,
            'fecha_registro'=>$fecha_actual
        ]);
    DB:: table('ti_acta_titulaciones')->
    insert(['id_alumno' =>$id_alumno,
        'numero_acta_titulacion' =>$num_acta,
        'numero_libro_acta_titulacion'=>$numero_libro_acta_titulacion,
        'foja_acta_titulacion'=>$foja_acta_titulacion,
        'fecha_registro'=>$fecha_actual
    ]);



    return redirect('/titulacion/autorizar_titulacion_alumnos/'.$datos_alumno->id_carrera);
}
public function alumnos_registrar_datos_dep($id_carrera){
    $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE id_carrera='.$id_carrera.'');

    $alumnos=DB::select('SELECT ti_descuentos_alum.telefono,ti_reg_datos_alum.correo_electronico,ti_reg_datos_alum.no_cuenta cuenta, ti_reg_datos_alum.nombre_al nombre,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, gnral_carreras.nombre carrera, ti_fecha_jurado_alumn.*
from ti_descuentos_alum,ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras,ti_datos_alumno_reg_dep WHERE
ti_descuentos_alum.id_alumno = ti_reg_datos_alum.id_alumno and 
ti_reg_datos_alum.id_alumno= ti_fecha_jurado_alumn.id_alumno AND
ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno and 
 ti_reg_datos_alum.id_carrera='.$id_carrera.'
 and ti_reg_datos_alum.id_carrera=gnral_carreras.id_carrera and 
 ti_fecha_jurado_alumn.id_estado_enviado=4 AND
 ti_datos_alumno_reg_dep.id_autorizacion in (1,3)');

    return view('titulacion.jefe_titulacion.formulario_datos_titulado.registrar_datos_alumnos_autorizados',compact('alumnos','carrera','id_carrera'));

}
    public function formulario_registrar_datos_al_ti($id_alumno){

     $registro_datos=DB::selectOne('SELECT ti_reg_datos_alum.*,ti_tipo_estudiante.tipo_estudiante,
       ti_nacionalidad.nacionalidad, gnral_carreras.nombre as carrera,gnral_estados.nombre_estado,
       ti_opciones_titulacion.opcion_titulacion FROM ti_reg_datos_alum,ti_tipo_estudiante,
    gnral_carreras,gnral_estados, ti_opciones_titulacion, ti_nacionalidad
where ti_reg_datos_alum.id_tipo_estudiante= ti_tipo_estudiante.id_tipo_estudiante 
  and ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and
      gnral_estados.id_estado= ti_reg_datos_alum.entidad_federativa and 
      ti_reg_datos_alum.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion 
  and ti_reg_datos_alum.id_nacionalidad = ti_nacionalidad.id_nacionalidad 
  
  and ti_reg_datos_alum.id_alumno='.$id_alumno.'');
        $oficio_recursos='';
        $acta_titulacion='';


     $descuentos_alumn=DB::selectOne('SELECT ti_descuentos_alum.*,
       ti_preparatatoria.preparatoria, ti_entidades_federativas.nom_entidad 
from ti_descuentos_alum,ti_preparatatoria, ti_entidades_federativas 
where 
 ti_descuentos_alum.id_preparatoria = ti_preparatatoria.id_preparatoria 
  and ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa 
  and ti_descuentos_alum.id_alumno='.$id_alumno.'');


     $nacionalidades=DB::select('SELECT * FROM `ti_nacionalidad` ');
     $titulo_obtenido=DB::selectOne('SELECT * FROM `ti_tipo_titulo_obtenido` WHERE `id_carrera` ='.$registro_datos->id_carrera.'');

     $clave_carrera=DB::selectOne('SELECT * FROM `ti_clave_carrera` WHERE `id_carrera` ='.$registro_datos->id_carrera.'');
     $titulos_disponibles=DB::select('SELECT ti_numeros_titulos.* FROM `ti_numeros_titulos`, ti_reg_domo_titulos WHERE
                    ti_numeros_titulos.id_estado_numero_titulo= 0 and ti_numeros_titulos.id_reg_domo = ti_reg_domo_titulos.id_reg_domo and ti_reg_domo_titulos.id_estado_tomo=1 ORDER BY `ti_numeros_titulos`.`abreviatura_folio_titulo` ASC ');

      $curp=$registro_datos->curp_al;
        $al_año=substr($curp, 4,1); //sacar el año
        if($al_año == 9 || $al_año == 8  || $al_año == 7 || $al_año == 6)
        {
            $al_año2=substr($curp, 5,1);
            $amo="19".$al_año.$al_año2;
            $mes=substr($curp, 6,2);
            $dia=substr($curp, 8,2);
            $ano_diferencia  = date("Y") - $amo;

            $mes_diferencia =   date("m")-$mes;

            $dia_diferencia   =   date("d")- $dia;

            if ($dia_diferencia < 0 && $mes_diferencia == 0 || $mes_diferencia < 0)
            {
                $ano_diferencia=$ano_diferencia-1;
            }
            else{
                $ano_diferencia=$ano_diferencia;
            }
        }
        else if($al_año ==0 || $al_año == 1 || $al_año == 2){
            $al_año2=substr($curp, 5,1);
            $amo="20".$al_año.$al_año2;
            $mes=substr($curp, 6,2);
            $dia=substr($curp, 8,2);
            $ano_diferencia  = date("Y") - $amo;

            $mes_diferencia =   date("m")-$mes;

            $dia_diferencia   =   date("d")- $dia;

            if ($dia_diferencia < 0 && $mes_diferencia == 0 || $mes_diferencia < 0)
            {
                $ano_diferencia=$ano_diferencia-1;
            }
            else{
                $ano_diferencia=$ano_diferencia;
            }
        }
        $genero=substr($curp, 10,1);
        if($genero == "H"){
            $gener=1;
            $sex=1;
        }else{
            $gener=2;
            $sex=2;
        }

        $genero=DB::selectOne('SELECT * FROM `ti_genero` WHERE `id_genero` ='.$gener.'');
        $sexo=DB::selectOne('SELECT * FROM `ti_sexo` WHERE `id_sexo` ='.$sex.'');

        $edad=$ano_diferencia;
        $fecha_nacimiento=$dia."/".$mes."/".$amo;


        $reg_fecha_titulacion=DB::selectOne('SELECT ti_fecha_jurado_alumn.*, ti_horarios_dias.hora 
FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias = ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');



        $tipos_decisiones=DB::select('SELECT * FROM `ti_decisiones_jurado` ');


        $estado_reg=DB::selectOne('SELECT COUNT(id_datos_alumno_reg_dep)contar
FROM ti_datos_alumno_reg_dep where id_alumno ='.$id_alumno.' and id_autorizacion = 3');

        $estado_reg=$estado_reg->contar;
        if($estado_reg == 0){
            $estado_folio_titulo=0;
            $estado_reg_datos=0;
            $datos_alumnos=DB::selectOne('SELECT * FROM `ti_datos_alumno_reg_dep` WHERE `id_alumno` ='.$id_alumno.'');

        }
        else{
            $estado_autorizacion_reg= DB::selectOne('SELECT * FROM `ti_datos_alumno_reg_dep` WHERE `id_alumno` = '.$id_alumno.'');
            $estado_aut=$estado_autorizacion_reg->id_autorizacion;
            if($estado_autorizacion_reg->id_numero_titulo == 0){
                $estado_folio_titulo=0;
            }else{
                $estado_folio_titulo=1;
            }
            $datos_alumnos=DB::selectOne('SELECT ti_datos_alumno_reg_dep.*, ti_clave_carrera.clave,
       ti_nacionalidad.nacionalidad, ti_genero.genero, ti_sexo.sexo, ti_preparatatoria.preparatoria,   ti_entidades_federativas.nom_entidad,
       ti_numeros_titulos.abreviatura_folio_titulo, ti_tipo_titulo_obtenido.tipo_titulo, ti_decisiones_jurado.decision,
       ti_fundamento_legal_s_s.fundamento_legal, ti_autorizacion_reconocimiento.autorizacion_reconocimiento,
       ti_reg_datos_alum.fecha_ingreso_preparatoria,ti_reg_datos_alum.fecha_egreso_preparatoria,
        ti_reg_datos_alum.fecha_ingreso_tesvb,ti_reg_datos_alum.fecha_egreso_tesvb
FROM ti_datos_alumno_reg_dep,ti_clave_carrera, ti_nacionalidad, ti_genero, ti_sexo,ti_preparatatoria,ti_entidades_federativas, 
     ti_tipo_titulo_obtenido, ti_numeros_titulos,ti_autorizacion_reconocimiento, ti_fundamento_legal_s_s, ti_reg_datos_alum,ti_decisiones_jurado,ti_descuentos_alum
     WHERE ti_reg_datos_alum.id_carrera= ti_clave_carrera.id_carrera and  ti_reg_datos_alum.id_nacionalidad = ti_nacionalidad.id_nacionalidad and
ti_datos_alumno_reg_dep.id_genero = ti_genero.id_genero and ti_datos_alumno_reg_dep.id_sexo = ti_sexo.id_sexo 
and ti_descuentos_alum.id_preparatoria = ti_preparatatoria.id_preparatoria and
                ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa and 
                ti_datos_alumno_reg_dep.id_numero_titulo =ti_numeros_titulos.id_numero_titulo and
ti_datos_alumno_reg_dep.id_tipo_titulo = ti_tipo_titulo_obtenido.id_tipo_titulo and 
    ti_datos_alumno_reg_dep.id_decision = ti_decisiones_jurado.id_decision and 
    ti_fundamento_legal_s_s.id_fundamento_legal = ti_datos_alumno_reg_dep.id_fundamento_legal AND
    ti_reg_datos_alum.id_alumno=ti_datos_alumno_reg_dep.id_alumno and 
     ti_reg_datos_alum.id_alumno=ti_descuentos_alum.id_alumno  and 
    ti_autorizacion_reconocimiento.id_autorizacion_reconocimiento =ti_datos_alumno_reg_dep.id_autorizacion_reconocimiento
    and      ti_datos_alumno_reg_dep.id_alumno ='.$id_alumno.'');

            $oficio_recursos=DB::selectOne('SELECT *FROM ti_oficio_recursos WHERE id_alumno = '.$id_alumno.'');

            $acta_titulacion= DB::selectOne('SELECT *from ti_acta_titulaciones WHERE id_alumno ='.$id_alumno.'');


            if($estado_aut == 3){

                $estado_reg_datos=1;
            }
            if($estado_aut == 4){
                $estado_reg_datos=4;
            }
        }
       $tipos_estudios=DB::select('SELECT * FROM `ti_tipo_estudio_antecedente` ');
        $fundamentos_legal_s_s=DB::select('SELECT * FROM `ti_fundamento_legal_s_s` ');
        $autorizaciones_reconocimiento=DB::select('SELECT * FROM `ti_autorizacion_reconocimiento` ');
        $datos_mencion_honorifica=DB::selectOne('SELECT * FROM `ti_mencion_honorifica` WHERE id_alumno = '.$id_alumno.'');



     return view('titulacion.jefe_titulacion.formulario_datos_titulado.reg_datos_alumno',compact('autorizaciones_reconocimiento','fundamentos_legal_s_s','tipos_estudios','titulos_disponibles','nacionalidades','registro_datos','nacionalidades','genero','sexo','edad','fecha_nacimiento','reg_fecha_titulacion','titulo_obtenido','tipos_decisiones','id_alumno','estado_reg_datos','datos_alumnos','oficio_recursos','acta_titulacion','clave_carrera','descuentos_alumn','datos_mencion_honorifica','estado_folio_titulo'));
      }
      public function registrar_formulario_datos(Request $request,$id_alumno){


          $id_genero = $request->input("id_genero");
          $id_sexo = $request->input("id_sexo");
          $edad = $request->input("edad");
          $fecha_nacimiento = $request->input("fecha_nacimiento");
          $id_numero_titulo = $request->input("id_numero_titulacion");
          $id_tipo_titulo = $request->input("id_tipo_titulo");
          $id_decision = $request->input("id_decision");
          $id_fundamento_legal = $request->input("id_fundamento_legal");
          $id_autorizacion_reconocimiento = $request->input("id_autorizacion_reconocimiento");
          $numero_foja_titulo = $request->input("numero_foja_titulo");
          $numero_libro_titulo = $request->input("numero_libro_titulo");


          DB:: table('ti_datos_alumno_reg_dep')  ->where('id_alumno', $id_alumno)
              ->update([

              'id_genero'=>$id_genero,
              'id_sexo'=>$id_sexo,
              'edad'=>$edad,
              'fecha_nacimiento'=>$fecha_nacimiento,
              'id_numero_titulo'=>$id_numero_titulo,
              'id_tipo_titulo'=>$id_tipo_titulo,
              'id_decision'=>$id_decision,
              'id_fundamento_legal'=>$id_fundamento_legal,
              'id_autorizacion_reconocimiento'=>$id_autorizacion_reconocimiento,
                  'numero_foja_titulo'=>$numero_foja_titulo,
                  'numero_libro_titulo'=>$numero_libro_titulo,
              'id_autorizacion'=>3,
          ]);

          DB:: table('ti_numeros_titulos')  ->where('id_numero_titulo', $id_numero_titulo)
              ->update([
                  'id_estado_numero_titulo'=>1,
                  'id_alumno'=>$id_alumno,
                  'id_tipo_titulacion'=>1,
              ]);

          return back();
      }
      public function registrar_oficio_recursos(Request  $request, $id_alumno){
          $fecha_oficio_recurso = $request->input("fecha_oficio_recurso");
          $numero_oficio_recurso = $request->input("numero_oficio_recurso");
          DB:: table('ti_oficio_recursos')->insert([
              'id_alumno'=>$id_alumno,
              'fecha_oficio_recursos'=>$fecha_oficio_recurso,
              'numero_oficio_recursos'=>$numero_oficio_recurso,

          ]);
          return back();

      }
      public function modificar_oficio_recursos($id_alumno){
        $reg_oficio_recursos=DB::selectOne('SELECT * FROM `ti_oficio_recursos` WHERE `id_alumno` = '.$id_alumno.'');

        return view('titulacion.jefe_titulacion.formulario_datos_titulado.partials_modificacion_datos_oficio_recursos',compact('reg_oficio_recursos'));
      }
      public function guardar_modificacion_oficio_recursos(Request $request, $id_alumno){
          $fecha_oficio_recurso = $request->input("fecha_oficio_recurso");
          $numero_oficio_recurso = $request->input("numero_oficio_recurso");

          DB::table('ti_oficio_recursos')
              ->where('id_alumno', $id_alumno)
              ->update([
              'fecha_oficio_recursos'=>$fecha_oficio_recurso,
              'numero_oficio_recursos'=>$numero_oficio_recurso]);
          return back();


      }
      public function registrar_datos_acta_titulacion(Request $request, $id_alumno){

          $hora_conformidad_acta = $request->input("hora_conformidad_acta");
          $hora_levantamiento_acta = $request->input("hora_levantamiento_acta");



          $hoy = date("Y-m-d H:i:s");
          DB::table('ti_acta_titulaciones')
              ->where('id_alumno', $id_alumno)
              ->update([
              'hora_conformidad_acta'=>$hora_conformidad_acta,
              'hora_levantamiento_acta'=>$hora_levantamiento_acta,
              'id_autorizar'=>1,
              'fecha_registro'=>$hoy,
          ]);
          return back();
      }
      public function modificar_datos_acta_titulacion($id_alumno){
       $datos_acta=DB::selectOne('SELECT * FROM `ti_acta_titulaciones` WHERE `id_alumno` ='.$id_alumno.'');
          return view('titulacion.jefe_titulacion.formulario_datos_titulado.modificar_datos_acta',compact('datos_acta'));

      }
      public function guardar_modificacion_acta_titulacion(Request $request, $id_alumno){

          $hora_conformidad_acta = $request->input("hora_conformidad_acta");
          $hora_levantamiento_acta = $request->input("hora_levantamiento_acta");



          $hoy = date("Y-m-d H:i:s");

          DB::table('ti_acta_titulaciones')
              ->where('id_alumno', $id_alumno)
              ->update([
                  'hora_conformidad_acta'=>$hora_conformidad_acta,
                  'hora_levantamiento_acta'=>$hora_levantamiento_acta,
                  'fecha_registro'=>$hoy,
              ]);
          return back();
      }
      public function modificar_datos_estudiante_dep($id_alumno){


          $registro_datos=DB::selectOne('SELECT ti_datos_alumno_reg_dep.*, ti_clave_carrera.clave,
       ti_nacionalidad.nacionalidad, ti_genero.genero, ti_sexo.sexo, ti_preparatatoria.preparatoria,   ti_entidades_federativas.nom_entidad,
       ti_numeros_titulos.abreviatura_folio_titulo, ti_tipo_titulo_obtenido.tipo_titulo, ti_decisiones_jurado.decision,
       ti_fundamento_legal_s_s.fundamento_legal, ti_autorizacion_reconocimiento.autorizacion_reconocimiento,
       ti_reg_datos_alum.fecha_ingreso_preparatoria,ti_reg_datos_alum.fecha_egreso_preparatoria,
        ti_reg_datos_alum.fecha_ingreso_tesvb,ti_reg_datos_alum.fecha_egreso_tesvb,ti_reg_datos_alum.id_nacionalidad,
ti_descuentos_alum.id_preparatoria

FROM ti_datos_alumno_reg_dep,ti_clave_carrera, ti_nacionalidad, ti_genero, ti_sexo,ti_preparatatoria,ti_entidades_federativas, 
     ti_tipo_titulo_obtenido, ti_numeros_titulos,ti_autorizacion_reconocimiento, ti_fundamento_legal_s_s, ti_reg_datos_alum,ti_decisiones_jurado,ti_descuentos_alum
     WHERE ti_reg_datos_alum.id_carrera= ti_clave_carrera.id_carrera and  ti_reg_datos_alum.id_nacionalidad = ti_nacionalidad.id_nacionalidad and
ti_datos_alumno_reg_dep.id_genero = ti_genero.id_genero and ti_datos_alumno_reg_dep.id_sexo = ti_sexo.id_sexo 
and ti_descuentos_alum.id_preparatoria = ti_preparatatoria.id_preparatoria and
                ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa and
                ti_datos_alumno_reg_dep.id_numero_titulo =ti_numeros_titulos.id_numero_titulo and
ti_datos_alumno_reg_dep.id_tipo_titulo = ti_tipo_titulo_obtenido.id_tipo_titulo and 
    ti_datos_alumno_reg_dep.id_decision = ti_decisiones_jurado.id_decision and 
    ti_fundamento_legal_s_s.id_fundamento_legal = ti_datos_alumno_reg_dep.id_fundamento_legal AND
    ti_reg_datos_alum.id_alumno=ti_datos_alumno_reg_dep.id_alumno and 
     ti_reg_datos_alum.id_alumno=ti_descuentos_alum.id_alumno  and 
    ti_autorizacion_reconocimiento.id_autorizacion_reconocimiento =ti_datos_alumno_reg_dep.id_autorizacion_reconocimiento
    and      ti_datos_alumno_reg_dep.id_alumno ='.$id_alumno.'');



          $datos_alumno=DB::selectOne('SELECT ti_reg_datos_alum.*,ti_tipo_estudiante.tipo_estudiante,
       gnral_carreras.nombre as carrera,gnral_estados.nombre_estado,ti_opciones_titulacion.opcion_titulacion 
FROM ti_reg_datos_alum,ti_tipo_estudiante,gnral_carreras,gnral_estados, ti_opciones_titulacion 
where ti_reg_datos_alum.id_tipo_estudiante= ti_tipo_estudiante.id_tipo_estudiante
  and ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera  and
gnral_estados.id_estado= ti_reg_datos_alum.entidad_federativa 
  and ti_reg_datos_alum.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion and 
ti_reg_datos_alum.id_alumno ='.$id_alumno.'');



          $clave_carrera=DB::selectOne('SELECT * FROM `ti_clave_carrera` WHERE `id_carrera` ='.$datos_alumno->id_carrera.'');

          $nacionalidades=DB::select('SELECT * FROM `ti_nacionalidad` ');


          $curp=$datos_alumno->curp_al;
          $al_año=substr($curp, 4,1); //sacar el año
          if($al_año == 9 || $al_año == 8  || $al_año == 7 || $al_año == 6)
          {
              $al_año2=substr($curp, 5,1);
              $amo="19".$al_año.$al_año2;
              $mes=substr($curp, 6,2);
              $dia=substr($curp, 8,2);
              $ano_diferencia  = date("Y") - $amo;

              $mes_diferencia =   date("m")-$mes;

              $dia_diferencia   =   date("d")- $dia;

              if ($dia_diferencia < 0 && $mes_diferencia == 0 || $mes_diferencia < 0)
              {
                  $ano_diferencia=$ano_diferencia-1;
              }
              else{
                  $ano_diferencia=$ano_diferencia;
              }
          }
          else if($al_año ==0 || $al_año == 1 || $al_año == 2){
              $al_año2=substr($curp, 5,1);
              $amo="20".$al_año.$al_año2;
              $mes=substr($curp, 6,2);
              $dia=substr($curp, 8,2);
              $ano_diferencia  = date("Y") - $amo;

              $mes_diferencia =   date("m")-$mes;

              $dia_diferencia   =   date("d")- $dia;

              if ($dia_diferencia < 0 && $mes_diferencia == 0 || $mes_diferencia < 0)
              {
                  $ano_diferencia=$ano_diferencia-1;
              }
              else{
                  $ano_diferencia=$ano_diferencia;
              }
          }
          $genero=substr($curp, 10,1);
          if($genero == "H"){
              $gener=1;
              $sex=1;
          }else{
              $gener=2;
              $sex=2;
          }

          $genero=DB::selectOne('SELECT * FROM `ti_genero` WHERE `id_genero` ='.$gener.'');
          $sexo=DB::selectOne('SELECT * FROM `ti_sexo` WHERE `id_sexo` ='.$sex.'');
          $edad=$ano_diferencia;
          $fecha_nacimiento=$dia."/".$mes."/".$amo;
          $preparatorias=DB::select('SELECT ti_preparatatoria.*,ti_entidades_federativas.nom_entidad 
FROM ti_preparatatoria,ti_entidades_federativas 
where ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa 
ORDER BY ti_preparatatoria.preparatoria ASC  ');
          $antecedentes_estudios=DB::select('SELECT * FROM `ti_tipo_estudio_antecedente` ');
          $reg_fecha_titulacion=DB::selectOne('SELECT ti_fecha_jurado_alumn.*, ti_horarios_dias.hora 
FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias = ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');

          $folios_titulos_disponibles=DB::select('SELECT ti_numeros_titulos.* FROM `ti_numeros_titulos`, ti_reg_domo_titulos WHERE
                    ti_numeros_titulos.id_estado_numero_titulo= 0 and ti_numeros_titulos.id_reg_domo = ti_reg_domo_titulos.id_reg_domo and ti_reg_domo_titulos.id_estado_tomo=1 ORDER BY `ti_numeros_titulos`.`abreviatura_folio_titulo` ASC  ');
          $titulo_obtenido=DB::selectOne('SELECT * FROM `ti_tipo_titulo_obtenido` WHERE `id_carrera` ='.$datos_alumno->id_carrera.'');

          $tipos_decisiones=DB::select('SELECT * FROM `ti_decisiones_jurado` ');
          $fundamentos_legales=DB::select('SELECT * FROM `ti_fundamento_legal_s_s` ');
          $autorizaciones_reconocimientos=DB::select('SELECT * FROM `ti_autorizacion_reconocimiento` ');

          return view('titulacion.jefe_titulacion.formulario_datos_titulado.modificar_dat_estudiantes',compact('reg_fecha_titulacion','registro_datos','datos_alumno','clave_carrera','nacionalidades','genero','sexo','edad','fecha_nacimiento','preparatorias','antecedentes_estudios','folios_titulos_disponibles','titulo_obtenido','tipos_decisiones','fundamentos_legales','autorizaciones_reconocimientos'));

      }
      public function guardar_modificacion_dat_estudiante(Request $request, $id_alumno){



          $id_genero = $request->input("id_genero");
          $id_sexo = $request->input("id_sexo");
          $edad = $request->input("edad");
          $fecha_nacimiento = $request->input("fecha_nacimiento");

          $id_tipo_titulo = $request->input("id_tipo_titulo");
          $id_decision = $request->input("id_decision");

          $id_fundamento_legal = $request->input("id_fundamento_legal");
          $id_autorizacion_reconocimiento = $request->input("id_autorizacion_reconocimiento");

          $numero_foja_titulo = $request->input("numero_foja_titulo");
          $numero_libro_titulo = $request->input("numero_libro_titulo");


          DB:: table('ti_datos_alumno_reg_dep')  ->where('id_alumno', $id_alumno)
              ->update([

                  'id_genero'=>$id_genero,
                  'id_sexo'=>$id_sexo,
                  'edad'=>$edad,
                  'fecha_nacimiento'=>$fecha_nacimiento,

                  'id_tipo_titulo'=>$id_tipo_titulo,
                  'id_decision'=>$id_decision,
                  'id_fundamento_legal'=>$id_fundamento_legal,
                  'id_autorizacion_reconocimiento'=>$id_autorizacion_reconocimiento,
                  'numero_foja_titulo'=>$numero_foja_titulo,
                  'numero_libro_titulo'=>$numero_libro_titulo,
                  'id_autorizacion'=>3,
              ]);
          return back();

      }
      public function guardar_autorizaciondatos_registrados(Request $request, $id_alumno){
          DB::table('ti_datos_alumno_reg_dep')
              ->where('id_alumno', $id_alumno)
              ->update([
                  'id_autorizacion'=>4,
              ]);
          $id_carrera=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');
          $id_carrera=$id_carrera->id_carrera;
          return redirect('/titulacion/alumnos_registrar_datos_dep/'.$id_carrera);

      }
      public function alumnos_autorizados_carrera($id_carrera){
          $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE id_carrera='.$id_carrera.'');

          $alumnos=DB::select('SELECT ti_reg_datos_alum.no_cuenta cuenta, ti_reg_datos_alum.nombre_al nombre,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, gnral_carreras.nombre carrera, ti_datos_alumno_reg_dep.* 
from ti_reg_datos_alum, ti_datos_alumno_reg_dep, gnral_carreras 
WHERE ti_reg_datos_alum.id_alumno= ti_datos_alumno_reg_dep.id_alumno 
  and ti_reg_datos_alum.id_carrera='.$id_carrera.' and ti_reg_datos_alum.id_carrera=gnral_carreras.id_carrera 
  and ti_datos_alumno_reg_dep.id_autorizacion=4 and  ti_datos_alumno_reg_dep.id_liberado_titulado=0');

          $datos_alum=array();
          foreach ($alumnos as $alumno){
                  $datos_alumnos['id_alumno']=$alumno->id_alumno;
                  $datos_alumnos['cuenta']=$alumno->cuenta;
                  $datos_alumnos['nombre']=mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');
                  $dat_alum=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$alumno->id_alumno.'');

                  $datos_alumnos['correo_electronico']=$dat_alum->correo_electronico;
                  $datos_alumnos['telefono']=$dat_alum->telefono;
                  $datos_alumnos['estado_registro_datos']=4;
                  array_push($datos_alum,$datos_alumnos);
              }
          return view('titulacion.jefe_titulacion.formulario_datos_titulado.alumnos_autorizados_dat_dep',compact('datos_alum','carrera','id_carrera'));

      }
      public function formulario_datos_titulado_autorizado($id_alumno){
          $datos_alumnos=DB::selectOne('SELECT ti_datos_alumno_reg_dep.*, ti_clave_carrera.clave,
       ti_nacionalidad.nacionalidad, ti_genero.genero, ti_sexo.sexo, ti_preparatatoria.preparatoria,   ti_entidades_federativas.nom_entidad,
       ti_numeros_titulos.abreviatura_folio_titulo, ti_tipo_titulo_obtenido.tipo_titulo, ti_decisiones_jurado.decision,
       ti_fundamento_legal_s_s.fundamento_legal, ti_autorizacion_reconocimiento.autorizacion_reconocimiento,
       ti_reg_datos_alum.fecha_ingreso_preparatoria,ti_reg_datos_alum.fecha_egreso_preparatoria,
        ti_reg_datos_alum.fecha_ingreso_tesvb,ti_reg_datos_alum.fecha_egreso_tesvb,ti_reg_datos_alum.id_nacionalidad,
ti_descuentos_alum.id_preparatoria,ti_reg_datos_alum.mencion_honorifica

FROM ti_datos_alumno_reg_dep,ti_clave_carrera, ti_nacionalidad, ti_genero, ti_sexo,ti_preparatatoria,ti_entidades_federativas, 
     ti_tipo_titulo_obtenido, ti_numeros_titulos,ti_autorizacion_reconocimiento, ti_fundamento_legal_s_s, ti_reg_datos_alum,ti_decisiones_jurado,ti_descuentos_alum
     WHERE ti_reg_datos_alum.id_carrera= ti_clave_carrera.id_carrera and  ti_reg_datos_alum.id_nacionalidad = ti_nacionalidad.id_nacionalidad and
ti_datos_alumno_reg_dep.id_genero = ti_genero.id_genero and ti_datos_alumno_reg_dep.id_sexo = ti_sexo.id_sexo 
and ti_descuentos_alum.id_preparatoria = ti_preparatatoria.id_preparatoria and
                ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa and 
                ti_datos_alumno_reg_dep.id_numero_titulo =ti_numeros_titulos.id_numero_titulo and
ti_datos_alumno_reg_dep.id_tipo_titulo = ti_tipo_titulo_obtenido.id_tipo_titulo and 
    ti_datos_alumno_reg_dep.id_decision = ti_decisiones_jurado.id_decision and 
    ti_fundamento_legal_s_s.id_fundamento_legal = ti_datos_alumno_reg_dep.id_fundamento_legal AND
    ti_reg_datos_alum.id_alumno=ti_datos_alumno_reg_dep.id_alumno and 
     ti_reg_datos_alum.id_alumno=ti_descuentos_alum.id_alumno  and 
    ti_autorizacion_reconocimiento.id_autorizacion_reconocimiento =ti_datos_alumno_reg_dep.id_autorizacion_reconocimiento
    and      ti_datos_alumno_reg_dep.id_alumno ='.$id_alumno.'');


          $estado_titulo= DB::selectOne('SELECT *FROM ti_datos_alumno_reg_dep where id_alumno ='.$id_alumno.'');


          $registro_datos=DB::selectOne('SELECT ti_reg_datos_alum.*,ti_tipo_estudiante.tipo_estudiante,
       gnral_carreras.nombre as carrera,gnral_estados.nombre_estado,ti_opciones_titulacion.opcion_titulacion 
FROM ti_reg_datos_alum,ti_tipo_estudiante,gnral_carreras,gnral_estados, ti_opciones_titulacion 
where ti_reg_datos_alum.id_tipo_estudiante= ti_tipo_estudiante.id_tipo_estudiante
  and ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera  and
gnral_estados.id_estado= ti_reg_datos_alum.entidad_federativa 
  and ti_reg_datos_alum.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion and 
ti_reg_datos_alum.id_alumno='.$id_alumno.'');

          $oficio_recursos=DB::selectOne('SELECT *FROM ti_oficio_recursos WHERE id_alumno = '.$id_alumno.'');

          $acta_titulacion= DB::selectOne('SELECT *from ti_acta_titulaciones WHERE id_alumno ='.$id_alumno.'');
          $reg_fecha_titulacion=DB::selectOne('SELECT ti_fecha_jurado_alumn.*, ti_horarios_dias.hora 
FROM ti_fecha_jurado_alumn,ti_horarios_dias 
WHERE ti_fecha_jurado_alumn.id_horarios_dias = ti_horarios_dias.id_horarios_dias 
  and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');
          $datos_mencion_honorifica=DB::selectOne('SELECT * FROM `ti_mencion_honorifica` WHERE id_alumno = '.$id_alumno.'');

          return view('titulacion.jefe_titulacion.formulario_datos_titulado.dato_alumno_autorizado',compact('reg_fecha_titulacion','registro_datos','datos_alumnos','oficio_recursos','acta_titulacion','datos_mencion_honorifica','estado_titulo'));


      }
      public function registrar_datos_mencion(Request $request,$id_alumno){
          $hoy = date("Y-m-d H:i:s");

          $no_registro = $request->input("no_registro");
          $fecha_registro_mencion= $request->input("fecha_registro_mencion");
          $libro_registro= $request->input("libro_registro");
          DB:: table('ti_mencion_honorifica')->insert([
              'no_registro'=>$no_registro,
              'fecha_registro_mencion'=>$fecha_registro_mencion,
              'libro_registro'=>$libro_registro,
              'id_alumno'=>$id_alumno,
              'fecha_registro_dato'=>$hoy,

          ]);
          return back();
      }
      public function guardar_modificacion_mencion_honorifica(Request $request,$id_alumno){
          $hoy = date("Y-m-d H:i:s");

          $no_registro = $request->input("no_registro");
          $fecha_registro_mencion= $request->input("fecha_registro_mencion");
          $libro_registro= $request->input("libro_registro");

          DB::table('ti_mencion_honorifica')
              ->where('id_alumno', $id_alumno)
              ->update([
                  'no_registro'=>$no_registro,
                  'fecha_registro_mencion'=>$fecha_registro_mencion,
                  'libro_registro'=>$libro_registro,
                  'fecha_registro_dato'=>$hoy,
              ]);
          return back();
      }

      public function zaz(){
        /*
          $mencion_honorifica=$alumno->mencion_honorifica;
          if($mencion_honorifica == 1){
              $contar_reg_mencion=DB::selectOne('SELECT COUNT(id_mencion_honorifica)contar from ti_mencion_honorifica where id_alumno ='.$id_alumno.'');
              $contar_reg_mencion=$contar_reg_mencion->contar;
              if($contar_reg_mencion == 0){
                  $max_libro=DB::selectOne('SELECT max(libro_registro) maximo_libro_mencion from ti_mencion_honorifica');
                  $max_libro=$max_libro->maximo_libro_mencion;
                  $max_num_reg=DB::selectOne('SELECT MAX(no_registro) numero_reg FROM ti_mencion_honorifica WHERE libro_registro ='.$max_libro.'');
                  $max_num_reg=$max_num_reg->numero_reg;
                  $numero_siguiente=$max_num_reg+1;
                  DB:: table('ti_mencion_honorifica')->insert([
                      'id_alumno'=>$id_alumno,
                      'no_registro'=>$numero_siguiente,
                      'fecha_registro_mencion'=>$alumno->fecha_titulacion,
                      'libro_registro'=>$max_libro,
                      'fecha_registro_dato'=>$fecha_actual,
                      'id_alumno'=>$id_alumno,
                  ]);

              }
          }
          $registro_titulo=DB::selectOne('SELECT COUNT(id_datos_alumno_reg_dep) contar FROM ti_datos_alumno_reg_dep where id_alumno ='.$id_alumno.'');
          $registro_titulo=$registro_titulo->contar;
          if($registro_titulo == 0){
              $max_libro=DB::selectOne('SELECT MAX(numero_libro_titulo) numero_max FROM ti_datos_alumno_reg_dep');
              $max_libro=$max_libro->numero_max;

              $max_numero = DB::selectOne('SELECT max(numero_foja_titulo) max_num_foja from ti_datos_alumno_reg_dep where numero_libro_titulo ='.$max_libro.'');
              $max_numero=$max_numero->max_num_foja;

              if($max_numero == 100){
                  $numero_foja_titulo=1;
                  $numero_libro_titulo= $max_libro+1;
              }else{
                  $numero_foja_titulo=$max_numero+1;
                  $numero_libro_titulo=$max_libro;
              }
              DB:: table('ti_datos_alumno_reg_dep')->insert([
                  'id_alumno'=>$id_alumno,
                  'numero_foja_titulo'=>$numero_foja_titulo,
                  'numero_libro_titulo'=>$numero_libro_titulo,
                  'fecha_registro'=>$fecha_actual,
              ]);
          }
          $registro_acta= DB::selectOne('SELECT count(id_acta_titulacion) contar from ti_acta_titulaciones where id_alumno = '.$id_alumno.'');
          $registro_acta =$registro_acta->contar;

          if($registro_acta == 0){
              $num_acta= DB::selectOne('SELECT MAX(numero_acta_titulacion) numero_acta from ti_acta_titulaciones');
              $num_acta=$num_acta->numero_acta+1;

              $num_libro_acta=DB::selectOne('SELECT MAX(numero_libro_acta_titulacion) num_libro_acta FROM ti_acta_titulaciones');
              $num_libro_acta=$num_libro_acta->num_libro_acta;

              $num_foja_acta =DB::selectOne('SELECT MAX(foja_acta_titulacion) num_foja_acta FROM ti_acta_titulaciones where numero_libro_acta_titulacion = '.$num_libro_acta.'');
              $num_foja_acta=$num_foja_acta->num_foja_acta;

              if($num_foja_acta == 100){
                  $numero_libro_acta_titulacion=$num_libro_acta+1;
                  $foja_acta_titulacion=1;
              }else{
                  $numero_libro_acta_titulacion=$num_libro_acta;
                  $foja_acta_titulacion=$num_foja_acta+1;

              }
              DB:: table('ti_acta_titulaciones')->insert([
                  'id_alumno'=>$id_alumno,
                  'numero_acta_titulacion'=>$num_acta,
                  'numero_libro_acta_titulacion'=>$numero_libro_acta_titulacion,
                  'foja_acta_titulacion'=>$foja_acta_titulacion,
                  'fecha_registro'=>$fecha_actual,
                  'id_autorizar' =>0,
              ]);

          }
        */
      }
      public function liberacion_alumno($id_alumno){
        $datos_alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');
        return view('titulacion.jefe_titulacion.formulario_datos_titulado.modal_liberar_titulado',compact('datos_alumno'));
    }
    public function guardar_liberacion_alumno(Request $request){
        $id_alumno = $request->input("id_alumno");

        DB::table('ti_descuentos_alum')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_liberado_titulado'=>1,
            ]);

        DB::table('ti_requisitos_titulacion')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_liberado_titulado'=>1,
            ]);

        DB::table('ti_reg_datos_alum')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_liberado_titulado'=>1,
            ]);

        DB::table('ti_fecha_jurado_alumn')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_liberado_titulado'=>1,
            ]);
        DB::table('ti_datos_alumno_reg_dep')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_liberado_titulado'=>1,
            ]);
        $datos_alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');

        return redirect('/titulacion/alumnos_autorizados_carrera/'.$datos_alumno->id_carrera);
    }

}
