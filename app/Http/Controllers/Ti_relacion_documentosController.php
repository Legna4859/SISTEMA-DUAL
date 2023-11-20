<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_relacion_documentosController extends Controller
{
    public function index(){


        $estado_consulta_dia=0;
        return view('titulacion.jefe_titulacion.relacion_documentos.relacion_docu_carrera',compact('estado_consulta_dia'));
    }
    public function consultar_fecha_relacion_doc($fecha_dia){
        $fecha=$fecha_dia;
        $estado_consulta_dia=1;
        $fecha_dia=date("d/m/Y ",strtotime($fecha_dia));
        $contar_relacion_actas_ti=DB::selectOne("SELECT count(ti_reg_datos_alum.id_alumno)contar 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, ti_datos_alumno_reg_dep, gnral_carreras 
WHERE ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
  and ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno 
  and ti_fecha_jurado_alumn.fecha_titulacion ='$fecha' and 
      ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and
      ti_datos_alumno_reg_dep.id_autorizacion = 4  ");
        $contar_relacion_actas_ti=$contar_relacion_actas_ti->contar;
        $contar_relacion_mencion=DB::selectOne("SELECT count(ti_reg_datos_alum.id_alumno)contar 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, ti_datos_alumno_reg_dep, gnral_carreras 
WHERE ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
  and ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno 
  and ti_fecha_jurado_alumn.fecha_titulacion ='$fecha' and 
      ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and
      ti_datos_alumno_reg_dep.id_autorizacion = 4 and ti_reg_datos_alum.mencion_honorifica =1");
        $contar_relacion_mencion=$contar_relacion_mencion->contar;
        return view('titulacion.jefe_titulacion.relacion_documentos.relacion_docu_carrera',compact('estado_consulta_dia','fecha_dia','fecha','contar_relacion_actas_ti','contar_relacion_mencion'));

    }
    public function relacion_actas_titulacion($fecha){
        $consultar_reg=DB::selectOne("SELECT * FROM `ti_relacion_actas_titulacion` WHERE `fecha` =  '$fecha'");

        $alumnos=DB::select("SELECT ti_reg_datos_alum.id_alumno, 
       ti_reg_datos_alum.no_cuenta, ti_fecha_jurado_alumn.fecha_titulacion, 
       ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno,
       gnral_carreras.nombre carrera, ti_datos_alumno_reg_dep.id_numero_titulo 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, ti_datos_alumno_reg_dep, gnral_carreras 
WHERE ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
  and ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno 
  and ti_fecha_jurado_alumn.fecha_titulacion ='$fecha' and 
      ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and
      ti_datos_alumno_reg_dep.id_autorizacion = 4  ");

      if($consultar_reg == null){
        $estado_reg=0;
      }else{
          $estado_reg=1;
      }

        $dia_titulacion=  substr($fecha, 0, 2);
        $mes_titulacion=  substr($fecha, 3, 2);

        $year=  substr($fecha, 6, 4);
        if($mes_titulacion == 1){
            $mes_titulacion="enero";
        }
        if($mes_titulacion == 2){
            $mes_titulacion="febrero";
        }
        if($mes_titulacion == 3){
            $mes_titulacion="marzo";
        }
        if($mes_titulacion == 4){
            $mes_titulacion="abril";
        }
        if($mes_titulacion == 5){
            $mes_titulacion="mayo";
        }
        if($mes_titulacion == 6){
            $mes_titulacion="junio";
        }
        if($mes_titulacion == 7){
            $mes_titulacion="julio";
        }
        if($mes_titulacion == 8){
            $mes_titulacion="agosto";
        }
        if($mes_titulacion == 9){
            $mes_titulacion="septiembre";
        }
        if($mes_titulacion == 10){
            $mes_titulacion="octubre";
        }
        if($mes_titulacion == 11){
            $mes_titulacion="noviembre";
        }
        if($mes_titulacion == 12){
            $mes_titulacion="diciembre";
        }
        $fecha_solicitada=$dia_titulacion." de ".$mes_titulacion." de ".$year;

        return view('titulacion.jefe_titulacion.relacion_documentos.relacion_actas_alumnos',compact('consultar_reg','estado_reg','alumnos','fecha','fecha_solicitada'));

    }
    public function registrar_num_relac_acta_titulacion(Request $request){

        $fecha_titulacion = $request->input("fecha_titulacion");
        $numero_relacion_acta = $request->input("numero_relacion_acta");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_relacion_actas_titulacion')->insert([
            'fecha'=>$fecha_titulacion,
            'numero_oficio'=>$numero_relacion_acta,
            'id_estado'=>0,
            'fecha_registro'=>$hoy,
        ]);
        return back();
    }
    public function editar_num_relac_acta_titulacion(Request $request){

        $id_relacion_acta_titulacion = $request->input("id_relacion_acta_titulacion");
        $numero_relacion_acta1 = $request->input("numero_relacion_acta1");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_relacion_actas_titulacion')
            ->where('id_relacion_acta_titulacion', $id_relacion_acta_titulacion)
            ->update([
                'numero_oficio'=>$numero_relacion_acta1,
                'id_estado'=>0,
                'fecha_registro'=>$hoy,
            ]);
        return back();
    }
    public function autorizar_num_relac_acta_titulacion($id_relacion_acta_titulacion)
    {
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_relacion_actas_titulacion')
            ->where('id_relacion_acta_titulacion', $id_relacion_acta_titulacion)
            ->update([
                'id_estado'=>1,
                'fecha_registro'=>$hoy,
            ]);
        return back();
    }
    public function relacion_titulos($fecha){
        $consultar_reg=DB::selectOne("SELECT * FROM `ti_relacion_titulos` WHERE `fecha` =  '$fecha'");

        $alumnos=DB::select("SELECT ti_reg_datos_alum.id_alumno, 
       ti_reg_datos_alum.no_cuenta, ti_fecha_jurado_alumn.fecha_titulacion, 
       ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno,
       gnral_carreras.nombre carrera, ti_datos_alumno_reg_dep.id_numero_titulo 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, ti_datos_alumno_reg_dep, gnral_carreras 
WHERE ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
  and ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno 
  and ti_fecha_jurado_alumn.fecha_titulacion ='$fecha' and 
      ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera and
      ti_datos_alumno_reg_dep.id_autorizacion = 4  ");

        $array_alumnos=array();
        foreach ($alumnos as $alumno) {

            $dat_alumn['id_alumno']=$alumno->id_alumno;
            $dat_alumn['cuenta']=$alumno->no_cuenta;
            $dat_alumn['fecha_titulacion']=$alumno->fecha_titulacion;
            $dat_alumn['nombre']=$alumno->nombre_al." ".$alumno->apaterno." ".$alumno->amaterno;
            $dat_alumn['carrera']=$alumno->carrera;
            $dat_alumn['id_numero_titulo']=$alumno->id_numero_titulo;
            if($alumno->id_numero_titulo == 0){
                $dat_alumn['numero_titulo']="";
            }else{
                $numero_titulo=DB::selectOne('SELECT * FROM `ti_numeros_titulos` WHERE `id_numero_titulo` ='.$alumno->id_numero_titulo.'');
                $numero_titulo=$numero_titulo->abreviatura_folio_titulo;
                $dat_alumn['numero_titulo']=$numero_titulo;
            }
            array_push($array_alumnos,$dat_alumn);
        }


        if($consultar_reg == null){
            $estado_reg=0;
        }else{
            $estado_reg=1;
        }
        $dia_titulacion=  substr($fecha, 0, 2);
        $mes_titulacion=  substr($fecha, 3, 2);

        $year=  substr($fecha, 6, 4);
        if($mes_titulacion == 1){
            $mes_titulacion="enero";
        }
        if($mes_titulacion == 2){
            $mes_titulacion="febrero";
        }
        if($mes_titulacion == 3){
            $mes_titulacion="marzo";
        }
        if($mes_titulacion == 4){
            $mes_titulacion="abril";
        }
        if($mes_titulacion == 5){
            $mes_titulacion="mayo";
        }
        if($mes_titulacion == 6){
            $mes_titulacion="junio";
        }
        if($mes_titulacion == 7){
            $mes_titulacion="julio";
        }
        if($mes_titulacion == 8){
            $mes_titulacion="agosto";
        }
        if($mes_titulacion == 9){
            $mes_titulacion="septiembre";
        }
        if($mes_titulacion == 10){
            $mes_titulacion="octubre";
        }
        if($mes_titulacion == 11){
            $mes_titulacion="noviembre";
        }
        if($mes_titulacion == 12){
            $mes_titulacion="diciembre";
        }
        $fecha_solicitada=$dia_titulacion." de ".$mes_titulacion." de ".$year;

        return view('titulacion.jefe_titulacion.relacion_documentos.relacion_titulos_alumnos',compact('consultar_reg','estado_reg','array_alumnos','fecha','fecha_solicitada'));

    }
    public function registrar_num_relac_titulo(Request $request){
        $fecha_titulacion = $request->input("fecha_titulacion");
        $numero_relacion_titulo = $request->input("numero_relacion_titulo");
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_relacion_titulos')->insert([
            'fecha'=>$fecha_titulacion,
            'numero_oficio'=>$numero_relacion_titulo,
            'id_estado'=>0,
            'fecha_registro'=>$hoy,
        ]);
        return back();

    }
    public function editar_num_relac_titulos(Request $request){
        $id_relacion_titulo = $request->input("id_relacion_titulo");
        $numero_relacion_titulo = $request->input("numero_relacion_titulo1");
        $hoy = date("Y-m-d H:i:s");

        DB::table('ti_relacion_titulos')
            ->where('id_relacion_titulo', $id_relacion_titulo)
            ->update([
                'numero_oficio'=> $numero_relacion_titulo,
                'fecha_registro'=>$hoy,
            ]);
        return back();
    }
    public function autorizar_num_relac_titulos($id_relacion_titulo){
        $hoy = date("Y-m-d H:i:s");
        DB::table('ti_relacion_titulos')
            ->where('id_relacion_titulo', $id_relacion_titulo)
            ->update([
                'id_estado'=>1,
                'fecha_registro'=>$hoy,
            ]);
        return back();
    }
    public function relacion_mencion_honorifica($fecha){

        $consultar_reg=DB::selectOne("SELECT * FROM `ti_relacion_mencion_honorifica` WHERE `fecha` =  '$fecha'");

        $alumnos=DB::select("SELECT ti_reg_datos_alum.id_alumno, ti_reg_datos_alum.no_cuenta,
       ti_fecha_jurado_alumn.fecha_titulacion, ti_reg_datos_alum.nombre_al, ti_reg_datos_alum.apaterno,
       ti_reg_datos_alum.amaterno, gnral_carreras.nombre carrera, ti_datos_alumno_reg_dep.id_numero_titulo, 
       ti_mencion_honorifica.no_registro, ti_mencion_honorifica.libro_registro 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, ti_datos_alumno_reg_dep, gnral_carreras, ti_mencion_honorifica
WHERE ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno and
      ti_fecha_jurado_alumn.id_alumno = ti_datos_alumno_reg_dep.id_alumno and 
      ti_fecha_jurado_alumn.fecha_titulacion ='$fecha'
  and ti_reg_datos_alum.id_carrera = gnral_carreras.id_carrera 
  and ti_datos_alumno_reg_dep.id_autorizacion = 4 and 
      ti_reg_datos_alum.mencion_honorifica =1 and
      ti_mencion_honorifica.id_alumno = ti_reg_datos_alum.id_alumno  ");

        if($consultar_reg == null){
            $estado_reg=0;
        }else{
            $estado_reg=1;
        }

        $dia_titulacion=  substr($fecha, 0, 2);
        $mes_titulacion=  substr($fecha, 3, 2);

        $year=  substr($fecha, 6, 4);
        if($mes_titulacion == 1){
            $mes_titulacion="enero";
        }
        if($mes_titulacion == 2){
            $mes_titulacion="febrero";
        }
        if($mes_titulacion == 3){
            $mes_titulacion="marzo";
        }
        if($mes_titulacion == 4){
            $mes_titulacion="abril";
        }
        if($mes_titulacion == 5){
            $mes_titulacion="mayo";
        }
        if($mes_titulacion == 6){
            $mes_titulacion="junio";
        }
        if($mes_titulacion == 7){
            $mes_titulacion="julio";
        }
        if($mes_titulacion == 8){
            $mes_titulacion="agosto";
        }
        if($mes_titulacion == 9){
            $mes_titulacion="septiembre";
        }
        if($mes_titulacion == 10){
            $mes_titulacion="octubre";
        }
        if($mes_titulacion == 11){
            $mes_titulacion="noviembre";
        }
        if($mes_titulacion == 12){
            $mes_titulacion="diciembre";
        }
        $fecha_solicitada=$dia_titulacion." de ".$mes_titulacion." de ".$year;

        return view('titulacion.jefe_titulacion.relacion_documentos.relacion_mencion_honorifica',compact('consultar_reg','estado_reg','alumnos','fecha','fecha_solicitada'));


}
public function registrar_num_relac_mencion(Request $request){
    $fecha_titulacion = $request->input("fecha_titulacion");
    $numero_relacion_mencion_honorifica = $request->input("numero_relacion_mencion_honorifica");
    $hoy = date("Y-m-d H:i:s");
    DB::table('ti_relacion_mencion_honorifica')->insert([
        'fecha'=>$fecha_titulacion,
        'numero_oficio'=>$numero_relacion_mencion_honorifica,
        'id_estado'=>0,
        'fecha_registro'=>$hoy,
    ]);
    return back();
}
public function editar_num_relac_mencion_honorifica(Request $request){

    $id_relacion_mencion_honorifica = $request->input("id_relacion_mencion_honorifica");
    $numero_relacion_mencion_honorifica = $request->input("numero_mencion_honorifica1");
    $hoy = date("Y-m-d H:i:s");
    DB::table('ti_relacion_mencion_honorifica')
        ->where('id_relacion_mencion_honorifica', $id_relacion_mencion_honorifica)
        ->update([
            'numero_oficio'=>$numero_relacion_mencion_honorifica,
            'fecha_registro'=>$hoy,
        ]);
    return back();
}
public function autorizar_num_relac_mencion_honorifica(Request  $request, $id_relacion_mencion_honorifica){
    $hoy = date("Y-m-d H:i:s");
    DB::table('ti_relacion_mencion_honorifica')
        ->where('id_relacion_mencion_honorifica', $id_relacion_mencion_honorifica)
        ->update([
            'id_estado'=>1,
            'fecha_registro'=>$hoy,
        ]);
    return back();

}
}
