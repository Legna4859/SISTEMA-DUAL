<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_calendario_estudianteController extends Controller
{
    public function index(){
        dd("hola");
    }
    public function editar_titulo_cedula(){
        $profesores=DB::select('SELECT gnral_personales.id_personal,
       gnral_personales.nombre, gnral_personales.cedula,abreviaciones_prof.id_abreviacion_prof,abreviaciones.titulo 
from ti_jurado_alumno,gnral_personales,abreviaciones_prof,abreviaciones 
WHERE ti_jurado_alumno.id_personal=gnral_personales.id_personal and 
      gnral_personales.id_personal=abreviaciones_prof.id_personal and
      abreviaciones_prof.id_abreviacion= abreviaciones.id_abreviacion GROUP BY gnral_personales.id_personal ');
        //dd($profesores);

        $abreviaciones=DB::select('SELECT * FROM `abreviaciones` ORDER BY `abreviaciones`.`titulo` ASC ');
        return view('titulacion.jefe_titulacion.editar_titulo_cedula',compact('profesores','abreviaciones'));
    }
    public function guardar_agregar_titulo(Request $request){
        $this->validate($request,[
            'nombre_titulo' => 'required',
        ]);

        $nombre_titulo = $request->input("nombre_titulo");
        DB:: table('abreviaciones')->insert([
            'titulo'=>$nombre_titulo,
        ]);
        return back();
    }
    public function editar_titulo_profesor($id_abreviacion_prof){
       $profesor=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones_prof.*,abreviaciones.titulo
FROM gnral_personales,abreviaciones_prof,abreviaciones WHERE abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
    and abreviaciones_prof.id_personal = gnral_personales.id_personal and abreviaciones_prof.id_abreviacion_prof='.$id_abreviacion_prof.'');
        $abreviaciones=DB::select('SELECT * FROM `abreviaciones` ORDER BY `abreviaciones`.`titulo` ASC ');

        //dd($profesor);

        return view('titulacion.jefe_titulacion.modal_edicion_titulo_profesor',compact('profesor','abreviaciones'));
    }
    public function guardar_editar_titulo_profesor(Request $request){
        $this->validate($request,[
            'id_abreviacion_prof' => 'required',
            'id_abreviacion' => 'required',
        ]);

        $id_abreviacion_prof = $request->input("id_abreviacion_prof");
        $id_abreviacion = $request->input("id_abreviacion");

        DB::table('abreviaciones_prof')
            ->where('id_abreviacion_prof', $id_abreviacion_prof)
            ->update(['id_abreviacion'=>$id_abreviacion,
                ]);
        return back();
    }
    public function edita_cedula($id_personal){
        $profesor=DB::selectOne('SELECT * FROM `gnral_personales` WHERE `id_personal` ='.$id_personal.'');
        return view('titulacion.jefe_titulacion.modal_editar_cedula_jurado',compact('profesor'));
    }
    public function guardar_editar_cedula_profesor(Request $request){

        $this->validate($request,[
            'id_personal' => 'required',
            'cedula' => 'required',
        ]);

        $id_personal = $request->input("id_personal");
        $cedula = $request->input("cedula");

        DB::table('gnral_personales')
            ->where('id_personal', $id_personal)
            ->update(['cedula'=>$cedula,
            ]);
        return back();

    }
    public function calendario_estudiantes_autorizado(){
      $estado_consulta_dia=0;

      return view('titulacion.jefe_titulacion.consultar_dia',compact('estado_consulta_dia'));
    }
    public function calendario_estudiantes_autorizado_dia($fecha_dia){
        $dia_titulacion=DB::select("SELECT gnral_carreras.nombre carrera,ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.amaterno,ti_reg_datos_alum.id_carrera,ti_fecha_jurado_alumn.* 
from ti_fecha_jurado_alumn,ti_reg_datos_alum,gnral_carreras where ti_fecha_jurado_alumn.fecha_titulacion='$fecha_dia' 
    and ti_fecha_jurado_alumn.id_estado_enviado = 4 
     and ti_fecha_jurado_alumn.id_alumno=ti_reg_datos_alum.id_alumno 
                                               and ti_reg_datos_alum.id_carrera=gnral_carreras.id_carrera
                                               and ti_fecha_jurado_alumn.id_sala=1");




        $sala1=array();
        foreach ($dia_titulacion as $dia){
            $datos_alumno['id_fecha_jurado_alumn']= $dia->id_fecha_jurado_alumn;
            $datos_alumno['no_cuenta']= $dia->no_cuenta;
            $datos_alumno['nombre_al']= $dia->nombre_al;
            $datos_alumno['apaterno']= $dia->apaterno;
            $datos_alumno['amaterno']= $dia->amaterno;
            $datos_alumno['id_horarios_dias']= $dia->id_horarios_dias;
            $datos_alumno['carrera']= $dia->carrera;
            $presidente=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo ,ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$dia->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 1 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
    and gnral_personales.id_personal= abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            $nombre_presidente=$presidente->titulo.' '.$presidente->nombre;

            $secretario=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo ,ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$dia->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 2 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
    and gnral_personales.id_personal= abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            $nombre_secretario=$secretario->titulo.' '.$secretario->nombre;

            $vocal=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo ,ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$dia->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
    and gnral_personales.id_personal= abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            $nombre_vocal=$vocal->titulo.' '.$vocal->nombre;

            $suplente=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo ,ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$dia->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
    and gnral_personales.id_personal= abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            $nombre_suplente=$suplente->titulo.' '.$suplente->nombre;

            $datos_alumno['presidente']= $nombre_presidente;
            $datos_alumno['secretario']= $nombre_secretario;
            $datos_alumno['vocal']= $nombre_vocal;
            $datos_alumno['suplente']= $nombre_suplente;
            array_push($sala1,$datos_alumno);
        }

        $horas=DB::select('SELECT * FROM `ti_horarios_dias` ');
        $estado_consulta_dia=1;

        $dia1_titulacion=DB::select("SELECT gnral_carreras.nombre carrera,ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.amaterno,ti_reg_datos_alum.id_carrera,ti_fecha_jurado_alumn.* 
from ti_fecha_jurado_alumn,ti_reg_datos_alum,gnral_carreras where ti_fecha_jurado_alumn.fecha_titulacion='$fecha_dia' 
    and ti_fecha_jurado_alumn.id_estado_enviado = 4 
     and ti_fecha_jurado_alumn.id_alumno=ti_reg_datos_alum.id_alumno 
                                               and ti_reg_datos_alum.id_carrera=gnral_carreras.id_carrera
                                               and ti_fecha_jurado_alumn.id_sala=2");

        $sala2=array();
        foreach ($dia1_titulacion as $dia){
            $datos_alumno1['id_fecha_jurado_alumn']= $dia->id_fecha_jurado_alumn;
            $datos_alumno1['no_cuenta']= $dia->no_cuenta;
            $datos_alumno1['nombre_al']= $dia->nombre_al;
            $datos_alumno1['apaterno']= $dia->apaterno;
            $datos_alumno1['amaterno']= $dia->amaterno;
            $datos_alumno1['id_horarios_dias']= $dia->id_horarios_dias;
            $datos_alumno1['carrera']= $dia->carrera;
            $presidente=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo ,ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$dia->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 1 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
    and gnral_personales.id_personal= abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            $nombre_presidente=$presidente->titulo.' '.$presidente->nombre;

            $secretario=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo ,ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$dia->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 2 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
    and gnral_personales.id_personal= abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            $nombre_secretario=$secretario->titulo.' '.$secretario->nombre;

            $vocal=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo ,ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$dia->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
    and gnral_personales.id_personal= abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            $nombre_vocal=$vocal->titulo.' '.$vocal->nombre;

            $suplente=DB::selectOne('SELECT gnral_personales.nombre,abreviaciones.titulo ,ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones WHERE ti_jurado_alumno.id_alumno = '.$dia->id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal 
    and gnral_personales.id_personal= abreviaciones_prof.id_personal and 
        abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion');
            $nombre_suplente=$suplente->titulo.' '.$suplente->nombre;

            $datos_alumno1['presidente']= $nombre_presidente;
            $datos_alumno1['secretario']= $nombre_secretario;
            $datos_alumno1['vocal']= $nombre_vocal;
            $datos_alumno1['suplente']= $nombre_suplente;
            array_push($sala2,$datos_alumno1);
        }
        $fecha_dia=date("d/m/Y ",strtotime($fecha_dia));
        return view('titulacion.jefe_titulacion.consultar_dia',compact('estado_consulta_dia','sala1','horas','fecha_dia','sala2'));

    }
}
