<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_autorizar_doc_departamentoController extends Controller
{
    public function carrera_doc_requisitos(){
        $carreras=DB::select('SELECT * FROM `gnral_carreras` WHERE `id_carrera` 
                                         NOT IN (9,11,15) ');
        return view('titulacion.jefe_titulacion.autorizar_doc_requisitos.carrera_doc_requisitos',compact('carreras'));

    }
    public function index($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera`='.$id_carrera.'');

        $registros_titulacion=DB::select('SELECT ti_requisitos_titulacion.id_alumno,ti_requisitos_titulacion.fecha_registro,
       ti_requisitos_titulacion.id_estado_enviado,ti_requisitos_titulacion.correo_electronico
FROM ti_requisitos_titulacion, ti_descuentos_alum,gnral_alumnos 
WHERE ti_requisitos_titulacion.id_alumno= ti_descuentos_alum.id_alumno  and 
      gnral_alumnos.id_alumno= ti_descuentos_alum.id_alumno and gnral_alumnos.id_carrera ='.$id_carrera.'
                                                    and ti_requisitos_titulacion.id_estado_enviado IN(1,3)   ORDER BY ti_requisitos_titulacion.fecha_registro ASC ');
        $array_alumnos = array();
        foreach ($registros_titulacion as $registro){

            $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno, gnral_carreras.nombre carrera
       FROM gnral_carreras,gnral_alumnos where gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
      and gnral_alumnos.id_alumno='.$registro->id_alumno.'');

            $dat_alumnos['id_alumno'] = $alumno->id_alumno;
            $dat_alumnos['cuenta'] = $alumno->cuenta;
            $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');;
            $dat_alumnos['carrera'] = $alumno->carrera;
            $dat_alumnos['id_estado_enviado'] = $registro->id_estado_enviado;
            $dat_alumnos['correo_electronico'] = $registro->correo_electronico;
            array_push($array_alumnos, $dat_alumnos);

        }

       return view('titulacion.jefe_titulacion.autorizar_doc_requisitos.autorizar_requisitos_alumno',compact('array_alumnos','id_carrera','carrera'));
    }
    public function autorizar_alumno_doc_requisitos($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera`='.$id_carrera.'');

        $registros_titulacion=DB::select('SELECT ti_requisitos_titulacion.id_alumno,ti_requisitos_titulacion.fecha_registro,
       ti_requisitos_titulacion.id_estado_enviado,ti_requisitos_titulacion.correo_electronico
FROM ti_requisitos_titulacion, ti_descuentos_alum, gnral_alumnos WHERE ti_requisitos_titulacion.id_alumno= ti_descuentos_alum.id_alumno
                                                                   and gnral_alumnos.id_alumno = ti_descuentos_alum.id_alumno and gnral_alumnos.id_carrera='.$id_carrera.'
                                                    and ti_requisitos_titulacion.id_estado_enviado= 4 and ti_requisitos_titulacion.id_liberado_titulado=0   ORDER BY ti_requisitos_titulacion.fecha_registro ASC ');
        $array_alumnos = array();
        foreach ($registros_titulacion as $registro){

            $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno, gnral_carreras.nombre carrera
       FROM gnral_carreras,gnral_alumnos where gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
      and gnral_alumnos.id_alumno='.$registro->id_alumno.'');

            $dat_alumnos['id_alumno'] = $alumno->id_alumno;
            $dat_alumnos['cuenta'] = $alumno->cuenta;
            $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');;
            $dat_alumnos['carrera'] = $alumno->carrera;
            $dat_alumnos['id_estado_enviado'] = $registro->id_estado_enviado;
            $dat_alumnos['correo_electronico'] = $registro->correo_electronico;
            array_push($array_alumnos, $dat_alumnos);

        }
        return view('titulacion.jefe_titulacion.autorizar_doc_requisitos.proceso_autorizado',compact('array_alumnos','id_carrera','carrera'));

    }
    public function proceso_modificacion_doc_requisitos($id_carrera){
        $carrera=DB::selectOne('SELECT * FROM `gnral_carreras` WHERE `id_carrera`='.$id_carrera.'');

        $registros_titulacion=DB::select('SELECT ti_requisitos_titulacion.id_alumno,ti_requisitos_titulacion.fecha_registro,
       ti_requisitos_titulacion.id_estado_enviado,ti_requisitos_titulacion.correo_electronico 
FROM ti_requisitos_titulacion, ti_descuentos_alum, gnral_alumnos WHERE 
ti_requisitos_titulacion.id_alumno= ti_descuentos_alum.id_alumno 
and gnral_alumnos.id_alumno = ti_descuentos_alum.id_alumno and 
gnral_alumnos.id_carrera='.$id_carrera.'  and ti_requisitos_titulacion.id_estado_enviado=2 
         ORDER BY ti_requisitos_titulacion.fecha_registro ASC ');
        $array_alumnos = array();
        foreach ($registros_titulacion as $registro){

            $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno, gnral_carreras.nombre carrera
       FROM gnral_carreras,gnral_alumnos where gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
      and gnral_alumnos.id_alumno='.$registro->id_alumno.'');

            $dat_alumnos['id_alumno'] = $alumno->id_alumno;
            $dat_alumnos['cuenta'] = $alumno->cuenta;
            $dat_alumnos['nombre'] = mb_strtoupper($alumno->apaterno, 'utf-8') . " " . mb_strtoupper($alumno->amaterno, 'utf-8') . " " . mb_strtoupper($alumno->nombre, 'utf-8');;
            $dat_alumnos['carrera'] = $alumno->carrera;
            $dat_alumnos['id_estado_enviado'] = $registro->id_estado_enviado;
            $dat_alumnos['correo_electronico'] = $registro->correo_electronico;
            array_push($array_alumnos, $dat_alumnos);

        }
        return view('titulacion.jefe_titulacion.autorizar_doc_requisitos.proceso_modificacion',compact('array_alumnos','id_carrera','carrera'));

    }
    public function revisar_doc_requisitos($id_alumno){
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_carrera, gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno, gnral_carreras.nombre carrera
       FROM gnral_carreras,gnral_alumnos where gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
      and gnral_alumnos.id_alumno='.$id_alumno.'');
       /* $documentacion=DB::selectOne('SELECT * FROM `ti_requisitos_titulacion` WHERE `id_alumno` = '.$id_alumno.' ');
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` = '.$id_alumno.' ORDER BY `promedio_preparatoria` DESC ');
        $descuento=DB::selectOne('SELECT ti_descuentos_alum.*,ti_tipos_desc.tipo_desc from ti_descuentos_alum,ti_tipos_desc
        where ti_descuentos_alum.id_tipo_desc=ti_tipos_desc.id_tipo_desc and ti_descuentos_alum.id_alumno='.$id_alumno.'');
        */
        return view('titulacion.jefe_titulacion.autorizar_doc_requisitos.revisar_doc_requisitos_alumn',compact('id_alumno','alumno'));

    }
    public function ver_documentacion_autorizada($id_alumno){
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_carrera,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno, gnral_carreras.nombre carrera
       FROM gnral_carreras,gnral_alumnos where gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
      and gnral_alumnos.id_alumno='.$id_alumno.'');
        /* $documentacion=DB::selectOne('SELECT * FROM `ti_requisitos_titulacion` WHERE `id_alumno` = '.$id_alumno.' ');
         $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` = '.$id_alumno.' ORDER BY `promedio_preparatoria` DESC ');
         $descuento=DB::selectOne('SELECT ti_descuentos_alum.*,ti_tipos_desc.tipo_desc from ti_descuentos_alum,ti_tipos_desc
         where ti_descuentos_alum.id_tipo_desc=ti_tipos_desc.id_tipo_desc and ti_descuentos_alum.id_alumno='.$id_alumno.'');
         */
        return view('titulacion.jefe_titulacion.autorizar_doc_requisitos.ver_documentacion_autorizada_alumno',compact('id_alumno','alumno'));

    }
    public function guardar_validar_1(Request $request,$id_requisitos){
        $estado_acta_nac = $request->input("estado_acta_nac");

        if($estado_acta_nac  == 1){
            $comentario_acta_nac ="";
        }else{
            $comentario_acta_nac = $request->input("comentario_acta_nac");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_acta_nac' => $estado_acta_nac,
                'comentario_acta_nac' => $comentario_acta_nac,
                'cal_acta_nac'=>1]);
    }
    public function guardar_validar_2(Request $request,$id_requisitos){
        $estado_curp = $request->input("estado_curp");

        if($estado_curp  == 1){
            $comentario_curp ="";
        }else{
            $comentario_curp = $request->input("comentario_curp");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_curp' => $estado_curp,
                'comentario_curp' => $comentario_curp,
                'cal_curp'=>1]);
    }
    public function guardar_validar_3(Request $request,$id_requisitos){
        $estado_certificado_prep = $request->input("estado_certificado_prep");

        if($estado_certificado_prep  == 1){
            $comentario_certificado_prep ="";
        }else{
            $comentario_certificado_prep = $request->input("comentario_certificado_prep");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_certificado_prep' => $estado_certificado_prep,
                'comentario_certificado_prep' => $comentario_certificado_prep,
                'cal_certificado_prep'=>1]);
    }
    public function guardar_validar_4(Request $request,$id_requisitos){
        $estado_certificado_tesvb = $request->input("estado_certificado_tesvb");

        if($estado_certificado_tesvb  == 1){
            $comentario_certificado_tesvb ="";
        }else{
            $comentario_certificado_tesvb = $request->input("comentario_certificado_tesvb");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_certificado_tesvb' => $estado_certificado_tesvb,
                'comentario_certificado_tesvb' => $comentario_certificado_tesvb,
                'cal_certificado_tesvb'=>1]);
    }
    public function guardar_validar_5(Request $request,$id_requisitos){
        $estado_constancia_ss = $request->input("estado_constancia_ss");

        if($estado_constancia_ss  == 1){
            $comentario_constancia_ss ="";
        }else{
            $comentario_constancia_ss = $request->input("comentario_constancia_ss");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_constancia_ss' => $estado_constancia_ss,
                'comentario_constancia_ss' => $comentario_constancia_ss,
                'cal_constancia_ss'=>1]);
    }
    public function guardar_validar_6(Request $request,$id_requisitos){
        $estado_certificado_acred_ingles = $request->input("estado_certificado_acred_ingles");

        if($estado_certificado_acred_ingles  == 1){
            $comentario_certificado_acred_ingles ="";
        }else{
            $comentario_certificado_acred_ingles = $request->input("comentario_certificado_acred_ingles");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_certificado_acred_ingles' => $estado_certificado_acred_ingles,
                'comentario_certificado_acred_ingles' => $comentario_certificado_acred_ingles,
                'cal_certificado_acred_ingles'=>1]);
    }
    public function guardar_validar_7(Request $request,$id_requisitos){
        $estado_opcion_titulacion = $request->input("estado_opcion_titulacion");

        if($estado_opcion_titulacion  == 1){
            $comentario_opcion_titulacion ="";
        }else{
            $comentario_opcion_titulacion = $request->input("comentario_opcion_titulacion");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_opcion_titulacion' => $estado_opcion_titulacion,
                'comentario_opcion_titulacion' => $comentario_opcion_titulacion,
                'cal_opcion_titulacion'=>1]);
    }
    public function guardar_validar_8(Request $request,$id_requisitos){
        $estado_reporte_result_egel = $request->input("estado_reporte_result_egel");

        if($estado_reporte_result_egel  == 1){
            $comentario_reporte_result_egel ="";
        }else{
            $comentario_reporte_result_egel = $request->input("comentario_reporte_result_egel");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_reporte_result_egel' => $estado_reporte_result_egel,
                'comentario_reporte_result_egel' => $comentario_reporte_result_egel,
                'cal_reporte_result_egel'=>1]);
    }
    public function guardar_validar_9(Request $request,$id_requisitos){
        $estado_pago_titulo = $request->input("estado_pago_titulo");

        if($estado_pago_titulo  == 1){
            $comentario_pago_titulo ="";
        }else{
            $comentario_pago_titulo = $request->input("comentario_pago_titulo");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_pago_titulo' => $estado_pago_titulo,
                'comentario_pago_titulo' => $comentario_pago_titulo,
                'cal_pago_titulo'=>1]);
    }
    public function guardar_validar_10(Request $request,$id_requisitos){
        $estado_pago_contancia = $request->input("estado_pago_contancia");

        if($estado_pago_contancia  == 1){
            $comentario_pago_contancia ="";
        }else{
            $comentario_pago_contancia = $request->input("comentario_pago_contancia");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_pago_contancia' => $estado_pago_contancia,
                'comentario_pago_contancia' => $comentario_pago_contancia,
                'cal_pago_contancia'=>1]);
    }
    public function guardar_validar_11(Request $request,$id_requisitos){
        $estado_pago_derecho_ti = $request->input("estado_pago_derecho_ti");

        if($estado_pago_derecho_ti  == 1){
            $comentario_pago_derecho_ti ="";
        }else{
            $comentario_pago_derecho_ti = $request->input("comentario_pago_derecho_ti");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_pago_derecho_ti' => $estado_pago_derecho_ti,
                'comentario_pago_derecho_ti' => $comentario_pago_derecho_ti,
                'cal_pago_derecho_ti'=>1]);
    }
    public function guardar_validar_12(Request $request,$id_requisitos){
        $estado_pago_integrante_jurado = $request->input("estado_pago_integrante_jurado");

        if($estado_pago_integrante_jurado  == 1){
            $comentario_pago_integrante_jurado ="";
        }else{
            $comentario_pago_integrante_jurado = $request->input("comentario_pago_integrante_jurado");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_pago_integrante_jurado' => $estado_pago_integrante_jurado,
                'comentario_pago_integrante_jurado' => $comentario_pago_integrante_jurado,
                'cal_pago_integrante_jurado'=>1]);
    }
    public function guardar_validar_13(Request $request,$id_requisitos){
        $estado_acta_residencia = $request->input("estado_acta_residencia");

        if($estado_acta_residencia  == 1){
            $comentario_acta_residencia ="";
        }else{
            $comentario_acta_residencia = $request->input("comentario_acta_residencia");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_acta_residencia' => $estado_acta_residencia,
                'comentario_acta_residencia' => $comentario_acta_residencia,
                'cal_acta_residencia'=>1]);
    }
    public function guardar_validar_14(Request $request,$id_requisitos){
        $estado_pago_concepto_autenticacion = $request->input("estado_pago_concepto_autenticacion");

        if($estado_pago_concepto_autenticacion  == 1){
            $comentario_pago_concepto_autenticacion ="";
        }else{
            $comentario_pago_concepto_autenticacion = $request->input("comentario_pago_concepto_autenticacion");
        }
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['estado_pago_concepto_autenticacion' => $estado_pago_concepto_autenticacion,
                'comentario_pago_concepto_autenticacion' => $comentario_pago_concepto_autenticacion,
                'cal_pago_concepto_autenticacion'=>1]);
    }
    public function enviar_correcciones_alumno($id_requisitos){
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_carrera,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,ti_requisitos_titulacion.correo_electronico 
from gnral_alumnos,ti_requisitos_titulacion where gnral_alumnos.id_alumno = ti_requisitos_titulacion.id_alumno
                            and ti_requisitos_titulacion.id_requisitos='.$id_requisitos.'');
        $nombre_alumno="Estudiante: ".$alumno->cuenta.' '.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.jefe_titulacion.autorizar_doc_requisitos.notificacion_para_correcciones',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($jefe_correo,"Jefe(a) del Departamento de Titulación");
            $message->to($correo_alumno,"$nombre_alumno")->subject('Notificación de correcciones de la documentación de requisitos de titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['id_estado_enviado'=>2]);
        return redirect('/titulacion/autorizar_alumnos_doc_requisitos/'.$alumno->id_carrera);
    }
    public function  enviar_doc_correcciones(Request $request,$id_requisitos){

        $estado_acta_nac = $request->input("estado_acta_nac");
        $estado_curp = $request->input("estado_curp");
        $estado_certificado_prep = $request->input("estado_certificado_prep");
        $estado_certificado_tesvb = $request->input("estado_certificado_tesvb");
        $estado_constancia_ss = $request->input("estado_constancia_ss");
        $estado_certificado_acred_ingles = $request->input("estado_certificado_acred_ingles");
        $estado_opcion_titulacion = $request->input("estado_opcion_titulacion");
        $estado_reporte_result_egel = $request->input("estado_reporte_result_egel");
        $estado_pago_titulo = $request->input("estado_pago_titulo");
        $estado_pago_contancia = $request->input("estado_pago_contancia");
        $estado_pago_derecho_ti = $request->input("estado_pago_derecho_ti");
        $estado_pago_integrante_jurado = $request->input("estado_pago_integrante_jurado");
        $estado_pago_concepto_autenticacion = $request->input("estado_pago_concepto_autenticacion");
        if($estado_acta_nac == 2){
            $cal_acta=0;
        }else{
            $cal_acta=1;
        }
        if($estado_curp == 2){
            $cal_curp=0;
        }else{
            $cal_curp=1;
        }
        if($estado_certificado_prep == 2){
            $cal_certificado_prep=0;
        }else{
            $cal_certificado_prep=1;
        }
        if($estado_certificado_tesvb == 2){
            $cal_certificado_tesvb=0;
        }else{
            $cal_certificado_tesvb=1;
        }
        if($estado_constancia_ss == 2){
            $cal_constancia_ss=0;
        }else{
            $cal_constancia_ss=1;
        }
        if($estado_certificado_acred_ingles == 2){
            $cal_certificado_ingles=0;
        }else{
            $cal_certificado_ingles=1;
        }
        if($estado_opcion_titulacion == 2){
            $cal_opcion_titulacion=0;
        }else{
            $cal_opcion_titulacion=1;
        }
        if($estado_reporte_result_egel == 2){
            $cal_reporte_result_egel=0;
        }else{
            $cal_reporte_result_egel=1;
        }
        if($estado_pago_titulo == 2){
            $cal_pago_titulo=0;
        }else{
            $cal_pago_titulo=1;
        }
        if($estado_pago_contancia == 2){
            $cal_pago_contancia=0;
        }else{
            $cal_pago_contancia=1;
        }

        if($estado_pago_derecho_ti == 2){
            $cal_pago_derecho_ti=0;
        }else{
            $cal_pago_derecho_ti=1;
        }
        if($estado_pago_integrante_jurado == 2){
            $cal_pago_integrante_jurado=0;
          }else{
            $cal_pago_integrante_jurado=1;
           }
        if($estado_pago_concepto_autenticacion == 2){
            $cal_pago_concepto_autenticacion=0;
        }else{
            $cal_pago_concepto_autenticacion=1;
        }

        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,ti_requisitos_titulacion.correo_electronico 
from gnral_alumnos,ti_requisitos_titulacion where gnral_alumnos.id_alumno = ti_requisitos_titulacion.id_alumno
                            and ti_requisitos_titulacion.id_requisitos='.$id_requisitos.'');
        $nombre_alumno=$alumno->cuenta.' '.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.alumno_titulacion.notificacion_envio_correcciones_doc',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($correo_alumno,$nombre_alumno);
            $message->to($jefe_correo,"")->subject('Notificación de envio de correcciones de la documentación de requisitos de titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        $fecha_actual = date("d-m-Y");
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'id_estado_enviado' => 3,
                'cal_acta_nac' => $cal_acta,
                'cal_curp' => $cal_curp,
                'cal_certificado_prep' => $cal_certificado_prep,
                'cal_certificado_tesvb' => $cal_certificado_tesvb,
                'cal_constancia_ss' => $cal_constancia_ss,
                'cal_certificado_acred_ingles' => $cal_certificado_ingles,
                'cal_opcion_titulacion' => $cal_opcion_titulacion,
                'cal_reporte_result_egel' => $cal_reporte_result_egel,
                'cal_pago_titulo' => $cal_pago_titulo,
                'cal_pago_contancia' => $cal_pago_contancia,
                'cal_pago_derecho_ti' => $cal_pago_derecho_ti,
                'cal_pago_integrante_jurado' => $cal_pago_integrante_jurado,
                'cal_pago_concepto_autenticacion' => $cal_pago_concepto_autenticacion,
                'fecha_registro' => $fecha_actual,
            ]);
    }
    public function enviar_autorizacion_documentacion($id_requisitos){
        $jefe_titulacion=DB::selectOne('SELECT gnral_personales.* FROM
                               gnral_unidad_personal,gnral_personales WHERE
    gnral_unidad_personal.id_unidad_admin = 28 and
     gnral_personales.id_personal=gnral_unidad_personal.id_personal ');
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_carrera,gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno,ti_requisitos_titulacion.correo_electronico 
from gnral_alumnos,ti_requisitos_titulacion where gnral_alumnos.id_alumno = ti_requisitos_titulacion.id_alumno
                            and ti_requisitos_titulacion.id_requisitos='.$id_requisitos.'');

        $nombre_alumno="Estudiante: ".$alumno->cuenta.' '.$alumno->nombre.' '.$alumno->apaterno.' '.$alumno->amaterno;
        $correo_alumno=$alumno->correo_electronico;

        $jefe_correo=$jefe_titulacion->correo;
        Mail::send('titulacion.jefe_titulacion.autorizar_doc_requisitos.notificacion_autorizacion_doc',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($jefe_correo,"Jefe(a) del Departamento de Titulación ");
            $message->to($correo_alumno,"$nombre_alumno")->subject('Notificación de autorización de la documentación de requisitos de titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        $fecha_actual = date("d-m-Y");
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['id_estado_enviado'=>4,
                'fecha_registro' => $fecha_actual,]);
        DB::table('ti_descuentos_alum')
            ->where('id_alumno', $alumno->id_alumno)
            ->update(['id_liberado'=>1,
                'fecha_liberacion' => $fecha_actual,]);
        return redirect('/titulacion/autorizar_alumnos_doc_requisitos/'.$alumno->id_carrera);
    }
    public function modificar_correo_alumno($id_requisitos,$correo_electronico){
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['correo_electronico'=>$correo_electronico,
              ]);
    }


}
