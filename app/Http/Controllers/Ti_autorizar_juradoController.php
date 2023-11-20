<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_autorizar_juradoController extends Controller
{
    public function carrera_jurado(){
        $carreras=DB::select('SELECT * FROM `gnral_carreras` WHERE `id_carrera` 
                                         NOT IN (9,11,15) ');

        return view('titulacion.jefe_titulacion.autorizar_tercer_parte.carrera_jurado',compact('carreras'));
    }
    public function index($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera`='.$id_carrera.' ');
        $alumnos_autorizar_jurado=DB::select('SELECT ti_reg_datos_alum.correo_electronico,
       ti_reg_datos_alum.telefono,ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al, gnral_carreras.nombre carrera,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_fecha_jurado_alumn.* 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras  where ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
    and ti_fecha_jurado_alumn.id_estado_enviado in (1,3) and gnral_carreras.id_carrera = ti_reg_datos_alum.id_carrera and gnral_carreras.id_carrera = '.$id_carrera.'  ORDER BY ti_fecha_jurado_alumn.fecha_registro ASC');

        return view('titulacion.jefe_titulacion.autorizar_tercer_parte.proceso_revision_jurado',compact('alumnos_autorizar_jurado','id_carrera','carrera'));
    }
    public function revisar_jurado_estudiante($id_alumno){
       $datos_alumno=DB::selectOne('SELECT ti_reg_datos_alum.id_alumno,ti_reg_datos_alum.mencion_honorifica,ti_reg_datos_alum.correo_electronico,
       ti_reg_datos_alum.telefono,ti_sala.nombre_sala, ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al, 
       gnral_carreras.nombre carrera, ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_fecha_jurado_alumn.* 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras, ti_sala 
where ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno and 
      ti_fecha_jurado_alumn.id_sala = ti_sala.id_sala and gnral_carreras.id_carrera = ti_reg_datos_alum.id_carrera and
      ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');

        $dato_presidente=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*, abreviaciones.titulo 
FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones 
WHERE abreviaciones.id_abreviacion= abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal= gnral_personales.id_personal 
  and ti_jurado_alumno.id_alumno = '.$id_alumno.' AND ti_jurado_alumno.id_tipo_jurado = 1 
  and gnral_personales.id_personal= ti_jurado_alumno.id_personal ');
        $dato_secretario=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*, abreviaciones.titulo 
FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones 
WHERE abreviaciones.id_abreviacion= abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal= gnral_personales.id_personal 
  and ti_jurado_alumno.id_alumno = '.$id_alumno.' AND ti_jurado_alumno.id_tipo_jurado = 2 
  and gnral_personales.id_personal= ti_jurado_alumno.id_personal ');
        $dato_vocal=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*, abreviaciones.titulo 
FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones 
WHERE abreviaciones.id_abreviacion= abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal= gnral_personales.id_personal 
  and ti_jurado_alumno.id_alumno = '.$id_alumno.' AND ti_jurado_alumno.id_tipo_jurado = 3 
  and gnral_personales.id_personal= ti_jurado_alumno.id_personal ');
        $dato_suplente=DB::selectOne('SELECT gnral_personales.nombre,gnral_personales.cedula, ti_jurado_alumno.*, abreviaciones.titulo 
FROM ti_jurado_alumno, gnral_personales, abreviaciones_prof, abreviaciones 
WHERE abreviaciones.id_abreviacion= abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal= gnral_personales.id_personal 
  and ti_jurado_alumno.id_alumno = '.$id_alumno.' AND ti_jurado_alumno.id_tipo_jurado = 4 
  and gnral_personales.id_personal= ti_jurado_alumno.id_personal ');

        $hora=DB::selectOne('SELECT *from ti_horarios_dias where id_horarios_dias='.$datos_alumno->id_horarios_dias.'');
        return view('titulacion.jefe_titulacion.autorizar_tercer_parte.revision_jurado_estudiante',compact('datos_alumno', 'dato_presidente','dato_secretario','dato_vocal','dato_suplente','hora','id_alumno'));
    }
    public function dia_titulacion($fecha_titulacion,$id_alumno,$id_sala){

        $alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` ='.$id_alumno.'');
        $id_carrera=$alumno->id_carrera;
        $nombre_carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        $nombre_carrera=$nombre_carrera->nombre;
        $nombre_sala=DB::selectOne('SELECT * FROM `ti_sala` WHERE `id_sala` ='.$id_sala.'');
        $nombre_sala=$nombre_sala->nombre_sala;



//dd($lunes);


        $dia_titulacion=DB::select("SELECT gnral_carreras.nombre carrera,ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,ti_reg_datos_alum.amaterno,ti_reg_datos_alum.id_carrera,ti_fecha_jurado_alumn.*, ti_sala.nombre_sala 
from ti_fecha_jurado_alumn,ti_reg_datos_alum,gnral_carreras, ti_sala where ti_fecha_jurado_alumn.fecha_titulacion='$fecha_titulacion'
    and ti_fecha_jurado_alumn.id_estado_enviado = 4 
     and ti_fecha_jurado_alumn.id_alumno=ti_reg_datos_alum.id_alumno 
                                               and ti_reg_datos_alum.id_carrera=gnral_carreras.id_carrera
                                                and ti_fecha_jurado_alumn.id_sala =$id_sala
                                                and ti_fecha_jurado_alumn.id_sala = ti_sala.id_sala");
        //dd($dia_titulacion);
   $alumnos=array();
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
            array_push($alumnos,$datos_alumno);
        }
//dd($alumnos);
        $horas=DB::select('SELECT * FROM `ti_horarios_dias` ');

        return view('titulacion.jefe_titulacion.autorizar_tercer_parte.modal_dia_titulacion',compact('alumnos','horas','nombre_carrera','nombre_sala'));

    }
    public function enviar_modificaciones_jurado($id_alumno){
        $datos_alumno=DB::selectOne('SELECT ti_reg_datos_alum.correo_electronico, ti_reg_datos_alum.telefono,
       ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al, gnral_carreras.nombre carrera, 
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_fecha_jurado_alumn.* 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras 
where ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
  and gnral_carreras.id_carrera = ti_reg_datos_alum.id_carrera and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');

        return view('titulacion.jefe_titulacion.autorizar_tercer_parte.modal_comentario_modificacion',compact('datos_alumno'));
    }
    public function guardar_modificaciones_jurado(Request $request,$id_alumno){
        $this->validate($request, [
            'comentario_modificacion' => 'required',

        ]);
        $comentario_modificacion = $request->input('comentario_modificacion');
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.id_carrera,ti_reg_datos_alum.correo_electronico,ti_reg_datos_alum.nombre_al,
       ti_reg_datos_alum.apaterno,ti_reg_datos_alum.amaterno, ti_reg_datos_alum.no_cuenta 
FROM ti_reg_datos_alum, ti_fecha_jurado_alumn where ti_reg_datos_alum.id_alumno= ti_fecha_jurado_alumn.id_alumno 
                and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');
        $nombre_alumno="Estudiante: ".$alumno->no_cuenta.' '.$alumno->nombre_al.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.jefe_titulacion.autorizar_tercer_parte.notificacion_modificacion_jurado',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($jefe_correo,"Jefe(a) del Departamento de Titulación");
            $message->to($correo_alumno,"$nombre_alumno")->subject('Notificación de  modificación de los integrantes de jurados de titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        $fecha_actual =  date("Y-m-d H:i:s");
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_alumno', $id_alumno)
            ->update(['id_estado_enviado'=>2,
                'fecha_registro'=>$fecha_actual,
                'comentario'=>$comentario_modificacion,
            ]);
        return redirect('/titulacion/autorizar_jurado_estudiantes_carrera/'.$alumno->id_carrera);
    }
    public function guardar_autorizacion_jurado(Request $request, $id_alumno){

        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT ti_fecha_jurado_alumn.fecha_titulacion,ti_reg_datos_alum.mencion_honorifica,ti_reg_datos_alum.id_carrera,ti_reg_datos_alum.correo_electronico,ti_reg_datos_alum.nombre_al,
       ti_reg_datos_alum.apaterno,ti_reg_datos_alum.amaterno, ti_reg_datos_alum.no_cuenta 
FROM ti_reg_datos_alum, ti_fecha_jurado_alumn where ti_reg_datos_alum.id_alumno= ti_fecha_jurado_alumn.id_alumno 
                and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'');
        $nombre_alumno="Estudiante: ".$alumno->no_cuenta.' '.$alumno->nombre_al.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.jefe_titulacion.autorizar_tercer_parte.notificacion_autorizacion_jurado',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($jefe_correo,"Jefe(a) del Departamento de Titulación");
            $message->to($correo_alumno,"$nombre_alumno")->subject('Notificación de autorización del jurado  para la titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        $fecha_actual =  date("Y-m-d H:i:s");
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_alumno', $id_alumno)
            ->update(['id_estado_enviado'=>4,
                'fecha_registro'=>$fecha_actual,
            ]);
        $verificar_reg=DB::selectOne('SELECT COUNT(id_datos_alumno_reg_dep)verificar FROM ti_datos_alumno_reg_dep where id_alumno='.$id_alumno.'');
       $verificar_reg=$verificar_reg->verificar;
       if($verificar_reg == 0){
           DB:: table('ti_datos_alumno_reg_dep')->insert([
               'fecha_registro' =>$fecha_actual,
               'id_alumno'=>$id_alumno]);
       }



        return redirect('/titulacion/autorizar_jurado_estudiantes_carrera/'.$alumno->id_carrera);
    }

    public function calendario_estudiantes_autorizado(){

    }
    public function proceso_modificacion_jurado($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera`='.$id_carrera.' ');
        $alumnos_modificacion=DB::select('SELECT ti_reg_datos_alum.correo_electronico,
       ti_reg_datos_alum.telefono,ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al, gnral_carreras.nombre carrera,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_fecha_jurado_alumn.* 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras  where ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
    and ti_fecha_jurado_alumn.id_estado_enviado = 2 and gnral_carreras.id_carrera = ti_reg_datos_alum.id_carrera and gnral_carreras.id_carrera = '.$id_carrera.' ORDER BY ti_fecha_jurado_alumn.fecha_registro ASC');

        return view('titulacion.jefe_titulacion.autorizar_tercer_parte.proceso_modificacion_jurado',compact('alumnos_modificacion','carrera','id_carrera'));
    }
    public function autorizados_jurado($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera`='.$id_carrera.' ');

        $alumnos_autorizados=DB::select('SELECT ti_reg_datos_alum.correo_electronico,
       ti_reg_datos_alum.telefono,ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al, gnral_carreras.nombre carrera,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_fecha_jurado_alumn.* 
from ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras  where ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
    and ti_fecha_jurado_alumn.id_estado_enviado = 4 and gnral_carreras.id_carrera = ti_reg_datos_alum.id_carrera and gnral_carreras.id_carrera = '.$id_carrera.' and ti_fecha_jurado_alumn.id_liberado_titulado=0  ORDER BY ti_fecha_jurado_alumn.fecha_registro ASC');
        return view('titulacion.jefe_titulacion.autorizar_tercer_parte.proceso_autorizacion_jurado',compact('alumnos_autorizados','id_carrera','carrera'));

    }
    public function enviar_jurado_mod(Request $request,$id_alumno){
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.apaterno,
       ti_reg_datos_alum.amaterno,ti_reg_datos_alum.correo_electronico, ti_fecha_jurado_alumn.* 
from ti_reg_datos_alum,ti_fecha_jurado_alumn 
WHERE ti_fecha_jurado_alumn.id_alumno=ti_reg_datos_alum.id_alumno and 
      ti_reg_datos_alum.id_alumno='.$id_alumno.'');

        $nombre_alumno=$alumno->no_cuenta.' '.$alumno->nombre_al.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.alumno_titulacion.tercera_etapa.notificaxion_envio_mod',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($correo_alumno,$nombre_alumno);
            $message->to($jefe_correo,"")->subject('Notificación de envio de modificacion del jurado para la autorización');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        $fecha_hoy = date("Y-m-d H:i:s");
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_alumno', $id_alumno)
            ->update([
                'id_estado_enviado' => 3,
                'fecha_registro' => $fecha_hoy,
            ]);
        return back();
    }
    public function ver_jurado_estudiante_autorizado($id_alumno){
        $datos_alumno=DB::selectOne('SELECT ti_reg_datos_alum.mencion_honorifica honorifica,
       ti_reg_datos_alum.correo_electronico, ti_reg_datos_alum.telefono, 
       ti_reg_datos_alum.no_cuenta,ti_reg_datos_alum.nombre_al,ti_reg_datos_alum.id_carrera, gnral_carreras.nombre carrera,
       ti_reg_datos_alum.apaterno, ti_reg_datos_alum.amaterno, ti_fecha_jurado_alumn.*,ti_sala.nombre_sala
from ti_reg_datos_alum, ti_fecha_jurado_alumn, gnral_carreras,ti_sala where 
ti_reg_datos_alum.id_alumno = ti_fecha_jurado_alumn.id_alumno 
        and gnral_carreras.id_carrera = ti_reg_datos_alum.id_carrera 
                    and ti_fecha_jurado_alumn.id_alumno='.$id_alumno.'
                    and ti_sala.id_sala=ti_fecha_jurado_alumn.id_sala');

        $dato_presidente=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 1 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
        $dato_secretario=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 2 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
        $dato_vocal=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 3 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');
        $dato_suplente=DB::selectOne('SELECT gnral_personales.nombre, ti_jurado_alumno.*  
    FROM ti_jurado_alumno, gnral_personales WHERE ti_jurado_alumno.id_alumno = '.$id_alumno.' 
        AND ti_jurado_alumno.id_tipo_jurado = 4 and gnral_personales.id_personal= ti_jurado_alumno.id_personal');

        $hora=DB::selectOne('SELECT *from ti_horarios_dias where id_horarios_dias='.$datos_alumno->id_horarios_dias.'');
        return view('titulacion.jefe_titulacion.autorizar_tercer_parte.ver_jurado_autorizado_alumno',compact('datos_alumno', 'dato_presidente','dato_secretario','dato_vocal','dato_suplente','hora','id_alumno'));

    }
    public function oficio_notificacion_jurado(Request $request, $id_fecha_jurado_alumn){
        $this->validate($request, [
            'fecha_oficio_jefe' => 'required',
            'numero_oficio_jefe' => 'required',

        ]);
        $fecha_oficio_jefe = $request->input('fecha_oficio_jefe');
        $numero_oficio_jefe = $request->input('numero_oficio_jefe');

        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'oficio_noti_jurado_jefe' => $numero_oficio_jefe,
                'fecha_oficio_noti_jurado_jefe' => $fecha_oficio_jefe,
                'id_oficio_noti_jurado_jefe' => 1
            ]);
        return back();

    }
    public function guardar_editar_datos_oficio_notificacion_jefe(Request $request, $id_fecha_jurado_alumn){
        $this->validate($request, [
            'fecha_oficio_jefes' => 'required',
            'numero_oficio_jefes' => 'required',

        ]);
        $fecha_oficio_jefe = $request->input('fecha_oficio_jefes');
        $numero_oficio_jefe = $request->input('numero_oficio_jefes');

        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'oficio_noti_jurado_jefe' => $numero_oficio_jefe,
                'fecha_oficio_noti_jurado_jefe' => $fecha_oficio_jefe,
                'id_oficio_noti_jurado_jefe' => 1
            ]);
        return back();
    }
    public function autorizar_datos_oficio_notificacion_jefe(Request $request, $id_fecha_jurado_alumn){
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'id_oficio_noti_jurado_jefe' => 2
            ]);
        return back();
    }
    public function guardar_datos_oficio_notificacion_estudiante(Request $request, $id_fecha_jurado_alumn){
        $this->validate($request, [
            'fecha_oficio_estudiante' => 'required',
            'numero_oficio_estudiante' => 'required',

        ]);
        $fecha_oficio_estudiante = $request->input('fecha_oficio_estudiante');
        $numero_oficio_estudiante = $request->input('numero_oficio_estudiante');

        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'oficio_noti_jurado_estudiante' => $numero_oficio_estudiante,
                'fecha_oficio_noti_jurado_estudiante' => $fecha_oficio_estudiante,
                'id_oficio_noti_jurado_estudiante' => 1
            ]);
        return back();
    }
    public function guardar_editar_datos_oficio_notificacion_estudiante(Request $request, $id_fecha_jurado_alumn){

        $this->validate($request, [
            'fecha_oficio_estudiantes' => 'required',
            'numero_oficio_estudiantes' => 'required',

        ]);
        $fecha_oficio_estudiantes = $request->input('fecha_oficio_estudiantes');
        $numero_oficio_estudiantes = $request->input('numero_oficio_estudiantes');

        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'oficio_noti_jurado_estudiante' => $numero_oficio_estudiantes,
                'fecha_oficio_noti_jurado_estudiante' => $fecha_oficio_estudiantes,
                'id_oficio_noti_jurado_estudiante' => 1
            ]);
        return back();
    }
    public function autorizar_datos_oficio_notificacion_estudiante(Request $request, $id_fecha_jurado_alumn ){
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'id_oficio_noti_jurado_estudiante' => 2
            ]);
        return back();
    }
    public function guardar_datos_mencion_honorifica(Request $request, $id_fecha_jurado_alumn){

        $this->validate($request, [
            'fecha_honorifica' => 'required',
            'numero_honorifica' => 'required',

        ]);
        $fecha_honorifica = $request->input('fecha_honorifica');
        $numero_honorifica = $request->input('numero_honorifica');

        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'mencion_honorifica' => $numero_honorifica,
                'fecha_mencion_honorifica' => $fecha_honorifica,
                'id_mencion_honorifica' => 1
            ]);
        return back();
    }
    public function guardar_editar_datos_oficio_mencion_honorifica(Request $request, $id_fecha_jurado_alumn){
        $this->validate($request, [
            'fecha_honorificas' => 'required',
            'numero_honorificas' => 'required',

        ]);
        $fecha_honorifica = $request->input('fecha_honorificas');
        $numero_honorifica = $request->input('numero_honorificas');

        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'mencion_honorifica' => $numero_honorifica,
                'fecha_mencion_honorifica' => $fecha_honorifica,
                'id_mencion_honorifica' => 1
            ]);
        return back();
    }
    public function autorizar_oficio_mencion_honorifica(Request $request,$id_fecha_jurado_alumn){
        DB::table('ti_fecha_jurado_alumn')
            ->where('id_fecha_jurado_alumn', $id_fecha_jurado_alumn)
            ->update([
                'id_mencion_honorifica' => 2,
            ]);
        return back();
    }

}
