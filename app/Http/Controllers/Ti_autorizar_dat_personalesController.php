<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_autorizar_dat_personalesController extends Controller
{

    public function index(){
        $carreras=DB::select('SELECT * FROM `gnral_carreras` WHERE `id_carrera` 
                                         NOT IN (9,11,15) ');

      return view('titulacion.jefe_titulacion.autorizar_seg_parte.carreras_seg_parte',compact('carreras'));
    }
    public function carrera_alum_reg_datos($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');

        $registro_alumnos=DB::select('SELECT ti_reg_datos_alum.*, gnral_carreras.nombre carrera FROM ti_reg_datos_alum,gnral_carreras 
WHERE ti_reg_datos_alum.id_estado_enviado in (1,3) and gnral_carreras.id_carrera=ti_reg_datos_alum.id_carrera and ti_reg_datos_alum.id_carrera='.$id_carrera.' ');

        return view('titulacion.jefe_titulacion.autorizar_seg_parte.proceso_revision_datos_personales',compact('registro_alumnos','id_carrera','carrera'));
    }
    public function revisar_datos_generales($id_alumno){
        return view('titulacion.jefe_titulacion.autorizar_seg_parte.revision_alumno',compact('id_alumno'));
    }
    public function enviar_modificaciones($id_reg_dato_alum,$comentario_modificacion){
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_carrera,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,ti_reg_datos_alum.correo_electronico 
from gnral_alumnos,ti_reg_datos_alum where gnral_alumnos.id_alumno = ti_reg_datos_alum.id_alumno
                            and ti_reg_datos_alum.id_reg_dato_alum='.$id_reg_dato_alum.'');
        $nombre_alumno="Estudiante: ".$alumno->cuenta.' '.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.jefe_titulacion.autorizar_seg_parte.notificacion_modificacion_envio',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($jefe_correo,"Jefe(a) del Departamento de Titulación");
            $message->to($correo_alumno,"$nombre_alumno")->subject('Notificación de  modificación de los datos personales para titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        $fecha_actual =  date("Y-m-d H:i:s");
        DB::table('ti_reg_datos_alum')
            ->where('id_reg_dato_alum', $id_reg_dato_alum)
            ->update(['id_estado_enviado'=>2,
                'fecha_envio'=>$fecha_actual,
                'comentario'=>$comentario_modificacion,
                ]);
        return redirect('/titulacion/carrera_alum_reg_datos/'.$alumno->id_carrera);

    }
    public function enviar_autorizacion($id_reg_dato_alum){
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_carrera,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,ti_reg_datos_alum.correo_electronico,ti_reg_datos_alum.id_tipo_donacion 
from gnral_alumnos,ti_reg_datos_alum where gnral_alumnos.id_alumno = ti_reg_datos_alum.id_alumno
                            and ti_reg_datos_alum.id_reg_dato_alum='.$id_reg_dato_alum.'');

        $nombre_alumno="Estudiante: ".$alumno->cuenta.' '.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;

            Mail::send('titulacion.jefe_titulacion.autorizar_seg_parte.notificacion_autorizacion_datos',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
            {
                $message->from($jefe_correo,"Jefe(a) del Departamento de Titulación");
                $message->to($correo_alumno,"$nombre_alumno")->subject('Notificación de  autorización de los datos personales para titulación');
                // $message->attach(public_path('pdf/fracciones/'.$name));
            });
            $fecha_actual =  date("Y-m-d H:i:s");
            DB::table('ti_reg_datos_alum')
                ->where('id_reg_dato_alum', $id_reg_dato_alum)
                ->update(['id_estado_enviado'=>4,
                    'fecha_envio'=>$fecha_actual,
                ]);


        return redirect('/titulacion/carrera_alum_reg_datos/'.$alumno->id_carrera);
    }
    public function autorizacion_informacion($id_reg_dato_alum){
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_carrera,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,ti_reg_datos_alum.correo_electronico,ti_reg_datos_alum.id_tipo_donacion 
from gnral_alumnos,ti_reg_datos_alum where gnral_alumnos.id_alumno = ti_reg_datos_alum.id_alumno
                            and ti_reg_datos_alum.id_reg_dato_alum='.$id_reg_dato_alum.'');

        $nombre_alumno="Estudiante: ".$alumno->cuenta.' '.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;

        if($alumno->id_tipo_donacion == 1){
            Mail::send('titulacion.jefe_titulacion.autorizar_seg_parte.notificacion_autorizacion_datos',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
            {
                $message->from($jefe_correo,"Jefe(a) del Departamento de Titulación");
                $message->to($correo_alumno,"$nombre_alumno")->subject('Notificación de  autorización de los datos personales para titulación');
                // $message->attach(public_path('pdf/fracciones/'.$name));
            });
            $fecha_actual =  date("Y-m-d H:i:s");
            DB::table('ti_reg_datos_alum')
                ->where('id_reg_dato_alum', $id_reg_dato_alum)
                ->update(['id_estado_enviado'=>4,
                    'fecha_envio'=>$fecha_actual,
                ]);
        }else{
            Mail::send('titulacion.jefe_titulacion.autorizar_seg_parte.notificacion_autorizacion_datos',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
            {
                $message->from($jefe_correo,"Jefe(a) del Departamento de Titulación");
                $message->to($correo_alumno,"$nombre_alumno")->subject('Notificación de  autorización de los datos personales para titulación');
                // $message->attach(public_path('pdf/fracciones/'.$name));
            });

            $fecha_actual =  date("Y-m-d H:i:s");
            DB::table('ti_reg_datos_alum')
                ->where('id_reg_dato_alum', $id_reg_dato_alum)
                ->update(['id_estado_enviado'=>4,
                    'fecha_envio'=>$fecha_actual,
                ]);
        }

        return redirect('/titulacion/autorizar_datos_personales');
    }
    public function autorizacion_entrega_cd(){
       $alumnos=DB::select('SELECT ti_reg_datos_alum.*, ti_opciones_titulacion.opcion_titulacion 
FROM ti_reg_datos_alum, ti_opciones_titulacion WHERE ti_reg_datos_alum.id_opcion_titulacion = ti_opciones_titulacion.id_opcion_titulacion 
            and ti_reg_datos_alum.id_estado_enviado = 4 ORDER by ti_reg_datos_alum.apaterno desc,ti_reg_datos_alum.amaterno desc,ti_reg_datos_alum.nombre_al desc');

        $registro_titulacion=DB::select('SELECT ti_reg_datos_alum.*, ti_opciones_titulacion.opcion_titulacion  
FROM ti_reg_datos_alum,ti_opciones_titulacion WHERE ti_opciones_titulacion.id_opcion_titulacion= ti_reg_datos_alum.id_opcion_titulacion 
                                                and  ti_reg_datos_alum.id_estado_enviado = 5  and ti_reg_datos_alum.id_enviado_biblioteca = 0
ORDER by ti_reg_datos_alum.apaterno desc,ti_reg_datos_alum.amaterno desc,ti_reg_datos_alum.nombre_al desc');

        $reg_titulacion= array();
        foreach ($registro_titulacion as $registro_titulacion){

            $dat['id_reg_dato_alum']=$registro_titulacion->id_reg_dato_alum;
            $dat['no_cuenta']=$registro_titulacion->no_cuenta;
            $dat['nombre']=$registro_titulacion->nombre_al.' '.$registro_titulacion->apaterno.' '.$registro_titulacion->amaterno;
            $dat['id_enviado_biblioteca']=$registro_titulacion->id_enviado_biblioteca;
            $dat['id_alumno']=$registro_titulacion->id_alumno;
            $datos=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE `id_alumno` ='.$registro_titulacion->id_alumno.'');

            $presidente=DB::selectOne('SELECT * FROM `gnral_personales` WHERE `id_personal` ='.$datos->asesor.'');
            $secretario=DB::selectOne('SELECT * FROM `gnral_personales` WHERE `id_personal` ='.$datos->revisor.'');
            $presidente=$presidente->nombre;
            $secretario=$secretario->nombre;
            $dat['presidente']=$presidente;
            $dat['secretario']=$secretario;
            $dat['pdf_reporte_titulacion']=$datos->pdf_reporte_titulacion;
            if($registro_titulacion->id_opcion_titulacion == 1 || $registro_titulacion->id_opcion_titulacion == 3 || $registro_titulacion->id_opcion_titulacion == 5 || $registro_titulacion->id_opcion_titulacion == 6){
                 $estado_archivo=1;
            }else{
                $estado_archivo=0;
            }
            $dat['estado_archivo']=$estado_archivo;
            $dat['opcion_titulacion']=$registro_titulacion->opcion_titulacion;
            array_push($reg_titulacion,$dat);
        }

        return view('titulacion.jefe_titulacion.autorizar_seg_parte.autorizar_centro_informacion',compact('alumnos','reg_titulacion'));

    }
    public function mostrar_datos_alumno_informacion($id_reg_dato_alum){
        $dato_alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_reg_dato_alum` = '.$id_reg_dato_alum.'');

        if($dato_alumno->id_opcion_titulacion == 1 || $dato_alumno->id_opcion_titulacion == 3 || $dato_alumno->id_opcion_titulacion == 5 || $dato_alumno->id_opcion_titulacion == 6 )
        {
            $estado_archivo= 1;
        }else{
            $estado_archivo= 0;
        }

        $personales=DB::select('SELECT * FROM `gnral_personales` ORDER BY `gnral_personales`.`nombre` ASC ');
        $personas=DB::select('SELECT * FROM `gnral_personales` ORDER BY `gnral_personales`.`nombre` ASC ');

        return view('titulacion.jefe_titulacion.autorizar_seg_parte.mostrar_datos_centro',compact('dato_alumno','personales','personas','estado_archivo'));

    }
    public function autorizar_estudiante(Request $request)
    {

       // dd($request);
        $id_reg_dato_alum = $request->input('id_reg_dato_alum');
        $id_opcion_titulacion = $request->input('id_opcion_titulacion');
        $estado_archivo = $request->input('estado_archivo');
        $presidente = $request->input('presidente');
        $secretario = $request->input('secretario');
        $fecha_actual = date("Y-m-d H:i:s");


        $registro_alumnos = DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_reg_dato_alum` = ' . $id_reg_dato_alum . '');
        $cuenta = $registro_alumnos->no_cuenta;
        $id_alumno = $registro_alumnos->id_alumno;





        /* if($id_opcion_titulacion == 7){
             DB:: table('ti_fecha_jurado_alumn')->insert([
                 'id_alumno'=>$id_alumno,
                 'fecha_registro'=>$fecha_actual,
                 'asesor'=>$presidente,
                 'revisor'=>$secretario,

             ]);
         }else{*/
        if ($estado_archivo == 1) {

            $file = $request->file('file');
            $name = "reporte_titulacion_" . $cuenta . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/titulacion/', $name);
        DB:: table('ti_fecha_jurado_alumn')->insert([
            'id_alumno' => $id_alumno,
            'fecha_registro' => $fecha_actual,
            'asesor' => $presidente,
            'revisor' => $secretario,
            'pdf_reporte_titulacion' => $name,
        ]);
       }else{

            DB:: table('ti_fecha_jurado_alumn')->insert([
                'id_alumno' => $id_alumno,
                'fecha_registro' => $fecha_actual,
                'asesor' => $presidente,
                'revisor' => $secretario,
                'pdf_reporte_titulacion' => "",
            ]);
        }

        DB:: table('ti_jurado_alumno')->insert([
            'id_alumno'=>$id_alumno,
            'id_tipo_jurado'=>1,
            'fecha_registro'=>$fecha_actual,
            'id_personal'=>$presidente,

        ]);
        DB:: table('ti_jurado_alumno')->insert([
            'id_alumno'=>$id_alumno,
            'id_tipo_jurado'=>2,
            'fecha_registro'=>$fecha_actual,
            'id_personal'=>$secretario,

        ]);
        DB::table('ti_reg_datos_alum')
            ->where('id_reg_dato_alum', $id_reg_dato_alum)
            ->update(['id_estado_enviado' => 5,
                'fecha_envio' => $fecha_actual,
            ]);
        return back();
    }
    public function proceso_modificacion_datos_alumno($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        $registro_alumnos=DB::select('SELECT ti_reg_datos_alum.*, gnral_carreras.nombre carrera FROM ti_reg_datos_alum,gnral_carreras 
WHERE ti_reg_datos_alum.id_estado_enviado=2 and gnral_carreras.id_carrera=ti_reg_datos_alum.id_carrera and  ti_reg_datos_alum.id_carrera='.$id_carrera.' ');

        return view('titulacion.jefe_titulacion.autorizar_seg_parte.proceso_modificacion_datos_alumno',compact('registro_alumnos','id_carrera','carrera'));
    }
    public function faltante_datos_alumno($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        $registro_alumnos=DB::select('SELECT ti_reg_datos_alum.*, gnral_carreras.nombre carrera FROM ti_reg_datos_alum,gnral_carreras 
WHERE ti_reg_datos_alum.id_estado_enviado=4 and gnral_carreras.id_carrera=ti_reg_datos_alum.id_carrera and  ti_reg_datos_alum.id_carrera='.$id_carrera.'');

        return view('titulacion.jefe_titulacion.autorizar_seg_parte.proceso_faltante_entregar_centro_informacion',compact('registro_alumnos','id_carrera','carrera'));
    }
    public function autorizados_datos_alumno($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carrera.'');
        $registro_alumnos=DB::select('SELECT ti_reg_datos_alum.*, gnral_carreras.nombre carrera FROM ti_reg_datos_alum,gnral_carreras 
WHERE ti_reg_datos_alum.id_estado_enviado=5 and gnral_carreras.id_carrera=ti_reg_datos_alum.id_carrera and  ti_reg_datos_alum.id_carrera='.$id_carrera.' and ti_reg_datos_alum.id_liberado_titulado =0  
ORDER BY `ti_reg_datos_alum`.`fecha_registro`  DESC');

        return view('titulacion.jefe_titulacion.autorizar_seg_parte.proceso_autorizados_datos_alumno',compact('registro_alumnos','id_carrera','carrera'));
    }
    public  function ver_datos_personales_alumno_ti($id_alumno,$id_carrera){
       return view('titulacion.jefe_titulacion.autorizar_seg_parte.mostrar_datos_autorizados_alumno_ti',compact('id_alumno','id_carrera'));
    }
    public  function ver_datos_per_ti_aut($id_alumno,$id_carrera){
        return view('titulacion.jefe_titulacion.autorizar_seg_parte.mostrar_dat_aut_alum_ti',compact('id_alumno','id_carrera'));
    }
    public function editar_reporte_titulacion($id_alumno){
        $dato_alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');
        if($dato_alumno->id_opcion_titulacion == 1 || $dato_alumno->id_opcion_titulacion == 3 || $dato_alumno->id_opcion_titulacion == 5 || $dato_alumno->id_opcion_titulacion == 6 )
        {
            $estado_archivo= 1;
        }else{
            $estado_archivo= 0;
        }

        $personales=DB::select('SELECT * FROM `gnral_personales` ORDER BY `gnral_personales`.`nombre` ASC ');
        $personas=DB::select('SELECT * FROM `gnral_personales` ORDER BY `gnral_personales`.`nombre` ASC ');
        $dat_reg_fecha=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE `id_alumno` ='.$id_alumno.'');

        return view('titulacion.jefe_titulacion.autorizar_seg_parte.modal_mod_datos_reporte_informacion',compact('dato_alumno','personales','personas','dat_reg_fecha','estado_archivo'));


    }
    public function modificar_datos_estudiante(Request $request){

        $id_reg_dato_alum=$request->input('id_reg_dato_alum');
        $id_opcion_titulacion=$request->input('id_opcion_titulacion');
        $presidente=$request->input('presidente');
        $secretario=$request->input('secretario');
        $fecha_actual =  date("Y-m-d H:i:s");
        $estado_archivo = $request->input('estado_archivo');



        $registro_alumnos=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_reg_dato_alum` = '.$id_reg_dato_alum.'');
        $cuenta=$registro_alumnos->no_cuenta;
        $id_alumno=$registro_alumnos->id_alumno;

        if($estado_archivo == 1) {


            $file = $request->file('file');
            $name = "reporte_titulacion_" . $cuenta . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/titulacion/', $name);
            DB::table('ti_fecha_jurado_alumn')
                ->where('id_alumno', $id_alumno)
                ->update([
                    'fecha_registro' => $fecha_actual,
                    'asesor' => $presidente,
                    'revisor' => $secretario,
                    'pdf_reporte_titulacion' => $name,
                ]);
        }else{
            DB::table('ti_fecha_jurado_alumn')
                ->where('id_alumno', $id_alumno)
                ->update([
                    'fecha_registro' => $fecha_actual,
                    'asesor' => $presidente,
                    'revisor' => $secretario,
                    'pdf_reporte_titulacion' => "",
                ]);
        }

        //if($id_opcion_titulacion == 7){
            DB::table('ti_fecha_jurado_alumn')
                ->where('id_alumno', $id_alumno)
                ->update([
                    'fecha_registro'=>$fecha_actual,
                    'asesor'=>$presidente,
                    'revisor'=>$secretario,
                ]);
       // }else{


       // }
        return back();
    }
    public function enviar_reporte_titulacion($id_alumno)
    {
        $reg_alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_alumno` = '.$id_alumno.'');

    return view('titulacion.jefe_titulacion.autorizar_seg_parte.enviar_reporte_centro_informacion',compact('reg_alumno'));
    }
    public function guardar_enviar_datos_estudiante_informacion(Request $request){
        $id_reg_dato_alum=$request->input('id_reg_dato_alum');

        $datos_jefe_titulacion=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,  gnral_personales.sexo
from abreviaciones, abreviaciones_prof, gnral_personales,gnral_unidad_personal 
where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal = gnral_personales.id_personal 
  and gnral_unidad_personal.id_personal=gnral_personales.id_personal 
  and gnral_unidad_personal.id_unidad_admin= 28');
        $nombre_jefe_titulacion=$datos_jefe_titulacion->titulo.' '.$datos_jefe_titulacion->nombre;
        $sexo_jefe_titulacion=$datos_jefe_titulacion->sexo;

        $datos_director_general=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,gnral_personales.sexo 
from abreviaciones, abreviaciones_prof, gnral_personales,gnral_unidad_personal 
where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal = gnral_personales.id_personal 
  and gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin= 3');
        $nombre_director_general=$datos_director_general->titulo.' '.$datos_director_general->nombre;
        $sexo_director_general=$datos_director_general->sexo;

        $datos_director_academico=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,gnral_personales.sexo 
from abreviaciones, abreviaciones_prof, gnral_personales,gnral_unidad_personal 
where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal = gnral_personales.id_personal 
  and gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin= 5');
        $nombre_director_academico=$datos_director_academico->titulo.' '.$datos_director_academico->nombre;
        $sexo_director_academico=$datos_director_academico->sexo;

        $datos_subdirector_servicios=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,gnral_personales.sexo 
from abreviaciones, abreviaciones_prof, gnral_personales,gnral_unidad_personal 
where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal = gnral_personales.id_personal 
  and gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin= 16');
        $nombre_subdirector_servicios=$datos_subdirector_servicios->titulo.' '.$datos_subdirector_servicios->nombre;
        $sexo_subdirector_servicios=$datos_subdirector_servicios->sexo;

        $datos_jefe_personal=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,gnral_personales.sexo 
from abreviaciones, abreviaciones_prof, gnral_personales,gnral_unidad_personal 
where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal = gnral_personales.id_personal 
  and gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin= 23');
        $nombre_jefe_personal=$datos_jefe_personal->titulo.' '.$datos_jefe_personal->nombre;
        $sexo_jefe_personal=$datos_jefe_personal->sexo;


        $datos_jefe_recursos=DB::selectOne('SELECT abreviaciones.titulo, gnral_personales.nombre,gnral_personales.sexo 
from abreviaciones, abreviaciones_prof, gnral_personales,gnral_unidad_personal 
where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
  and abreviaciones_prof.id_personal = gnral_personales.id_personal 
  and gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin= 24');
        $nombre_jefe_recursos=$datos_jefe_recursos->titulo.' '.$datos_jefe_recursos->nombre;
        $sexo_jefe_recursos=$datos_jefe_recursos->sexo;


        $dat_alumno=DB::selectOne('SELECT * FROM `ti_reg_datos_alum` WHERE `id_reg_dato_alum` ='.$id_reg_dato_alum.'');
        $id_jefe_division=$dat_alumno->id_jefe_division;

        $datos_jefe_division=DB::selectOne('SELECT abreviaciones.titulo,gnral_personales.nombre,gnral_personales.sexo 
FROM abreviaciones, abreviaciones_prof,gnral_personales where abreviaciones.id_abreviacion=abreviaciones_prof.id_abreviacion 
                                                          and abreviaciones_prof.id_personal=gnral_personales.id_personal 
                                                          and gnral_personales.id_personal='.$id_jefe_division.'');
        $nombre_jefe_division=$datos_jefe_division->titulo.' '.$datos_jefe_division->nombre;
        $sexo_jefe_division=$datos_jefe_division->sexo;

        DB::table('ti_reg_datos_alum')
            ->where('id_reg_dato_alum', $id_reg_dato_alum)
            ->update([
                'nombre_jefe_division'=>$nombre_jefe_division,
                'sexo_jefe_division'=>$sexo_jefe_division,

                'nombre_director_general'=>$nombre_director_general,
                'sexo_director_general'=>$sexo_director_general,

                'nombre_director_academico'=>$nombre_director_academico,
                'sexo_director_academico'=>$sexo_director_academico,

                'nombre_subdirector_servicios'=>$nombre_subdirector_servicios,
                'sexo_subdirector_servicios'=>$sexo_subdirector_servicios,

                'nombre_jefe_titulacion'=>$nombre_jefe_titulacion,
                'sexo_jefe_titulacion'=>$sexo_jefe_titulacion,

                'nombre_jefe_personal'=>$nombre_jefe_personal,
                'sexo_jefe_personal'=>$sexo_jefe_personal,

                'nombre_jefe_recursos'=>$nombre_jefe_recursos,
                'sexo_jefe_recursos'=>$sexo_jefe_recursos,

                'id_enviado_biblioteca'=>1,
            ]);

        return back();

    }
    public function documento_titulacion_autorizado(){
        $carreras=DB::select('SELECT * FROM `gnral_carreras` WHERE id_carrera !=9 and id_carrera !=11 and id_carrera !=15 ORDER BY `nombre` ASC');
        return view('titulacion.jefe_titulacion.autorizar_seg_parte.carrera_centro_informacion',compact('carreras'));
    }
    public  function carrera_informacion($id_carera){
        $registro_titulacion=DB::select('SELECT ti_reg_datos_alum.*,ti_opciones_titulacion.opcion_titulacion  
FROM ti_reg_datos_alum,ti_opciones_titulacion WHERE ti_reg_datos_alum.id_carrera ='.$id_carera.' and ti_reg_datos_alum.id_estado_enviado = 5 
 and ti_reg_datos_alum.id_enviado_biblioteca=1 and ti_reg_datos_alum.id_opcion_titulacion in  (1,3,5,6) 
 and ti_opciones_titulacion.id_opcion_titulacion = ti_reg_datos_alum.id_opcion_titulacion
ORDER by ti_reg_datos_alum.nom_proyecto desc');


        $reg_titulacion= array();
        foreach ($registro_titulacion as $registro_titulacion){

            $dat['id_reg_dato_alum']=$registro_titulacion->id_reg_dato_alum;
            $dat['no_cuenta']=$registro_titulacion->no_cuenta;
            $dat['nombre']=$registro_titulacion->nombre_al.' '.$registro_titulacion->apaterno.' '.$registro_titulacion->amaterno;
            $dat['id_enviado_biblioteca']=$registro_titulacion->id_enviado_biblioteca;
            $dat['id_alumno']=$registro_titulacion->id_alumno;
            $dat['nom_proyecto']=$registro_titulacion->nom_proyecto;
            $datos=DB::selectOne('SELECT * FROM `ti_fecha_jurado_alumn` WHERE `id_alumno` ='.$registro_titulacion->id_alumno.'');

            $presidente=DB::selectOne('SELECT * FROM `gnral_personales` WHERE `id_personal` ='.$datos->asesor.'');
            $secretario=DB::selectOne('SELECT * FROM `gnral_personales` WHERE `id_personal` ='.$datos->revisor.'');
            $presidente=$presidente->nombre;
            $secretario=$secretario->nombre;
            $dat['presidente']=$presidente;
            $dat['secretario']=$secretario;
            $dat['opcion_titulacion']=$registro_titulacion->opcion_titulacion;
            $dat['pdf_reporte_titulacion']=$datos->pdf_reporte_titulacion;
            array_push($reg_titulacion,$dat);
        }
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera` = '.$id_carera.'');

 return view('titulacion.jefe_titulacion.autorizar_seg_parte.alumnos_carrera_centro_informacion',compact('reg_titulacion','carrera'));


    }





}
