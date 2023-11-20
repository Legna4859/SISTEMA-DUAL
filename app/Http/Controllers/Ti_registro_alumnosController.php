<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Mail;
use Session;
class Ti_registro_alumnosController extends Controller
{
    public function index(){

        $carreras=DB::select('SELECT * FROM gnral_carreras WHERE id_carrera != 9 and id_carrera != 11 and id_carrera != 15');
        return view('titulacion.jefe_titulacion.registrar_alumnos',compact('carreras'));

    }
    public  function registro_alumnos_carrera($id_carrera){

        $carrera=DB::selectOne('SELECT * FROM gnral_carreras where id_carrera='.$id_carrera.'');
        $registro_titulacion=DB::select('SELECT ti_tipos_desc.tipo_desc,ti_descuentos_alum.*,
       gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno FROM ti_descuentos_alum,
        ti_tipos_desc,gnral_alumnos  WHERE   gnral_alumnos.id_carrera='.$id_carrera.'
    and gnral_alumnos.id_alumno=ti_descuentos_alum.id_alumno and ti_descuentos_alum.id_liberado_titulado = 0 and
    ti_tipos_desc.id_tipo_desc=ti_descuentos_alum.id_tipo_desc');

        $alumnos=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.id_alumno,gnral_alumnos.nombre,gnral_alumnos.apaterno,
         gnral_alumnos.amaterno from gnral_alumnos 
         where        gnral_alumnos.id_semestre >= 9 and gnral_alumnos.id_carrera='.$id_carrera.' 
           and  gnral_alumnos.id_alumno NOT in (SELECT id_alumno FROM ti_descuentos_alum)');

        return view('titulacion.jefe_titulacion.alumnos_carrera',compact('carrera','registro_titulacion','alumnos'));

    }
    public function mostrar_datos_alumno($id_alumno){
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');
        $tipos_descuentos=DB::select('SELECT * FROM `ti_tipos_desc` ');
        $cuenta=$alumno->cuenta;
        $id_carrera=$alumno->id_carrera;
        if($id_carrera == 14){
            $sem_cero= substr($cuenta, 0, 2);
            if($sem_cero == "SC"){
                $year_cuenta= substr($cuenta, 2, 4);

            }else{
                $letra=substr($cuenta, 0, 1);
                if($letra == "C" || $letra == "R"){
                    $year_cuenta= substr($cuenta, 1, 4);

                }else{
                    $year_cuenta= substr($cuenta, 0, 4);
                }

            }
        }else{
            $letra=substr($cuenta, 0, 1);
            if($letra == "C" || $letra == "R"){
                $year_cuenta= substr($cuenta, 1, 4);

            }else{
                $year_cuenta= substr($cuenta, 0, 4);
            }
        }
        if($year_cuenta < 2010){
            $estado_titulacion=1;
        }else{
            $estado_titulacion=2;
        }
        $nacionalidades=DB::select('SELECT * FROM `ti_nacionalidad` ');
        $preparatorias=DB::select('SELECT ti_preparatatoria.*, ti_entidades_federativas.nom_entidad 
FROM `ti_preparatatoria`,ti_entidades_federativas 
where ti_preparatatoria.id_entidad_federativa=ti_entidades_federativas.id_entidad_federativa  
ORDER BY `ti_preparatatoria`.`preparatoria`  ASC ');

        return view('titulacion.jefe_titulacion.modal_agregar',compact('alumno','tipos_descuentos','estado_titulacion','nacionalidades','preparatorias'));
    }
    public function guardar_datos_alumno(Request $request){


        $this->validate($request, [
            'id_alumno' => 'required',
            'id_tipo_descuento' => 'required',
            'telefono' => 'required',
            'id_preparatoria' => 'required',
        ]);
        $id_alumno = $request->input('id_alumno');
        $id_tipo_descuento = $request->input('id_tipo_descuento');
        $telefono = $request->input('telefono');
        $id_nacionalidad = $request->input('id_nacionalidad');
        $id_preparatoria = $request->input('id_preparatoria');
        $fecha_actual = date("d-m-Y");
        $fecha_siguiente=date("d-m-Y",strtotime($fecha_actual."+ 3 days"));
        DB:: table('ti_descuentos_alum')->insert([
            'id_tipo_desc'=>$id_tipo_descuento,
            'fecha_registro'=>$fecha_actual,
            'fecha_entrego'=>$fecha_siguiente,
            'id_alumno'=>$id_alumno,
            'telefono'=>$telefono,
            'id_preparatoria'=>$id_preparatoria,
        ]);
        return back();
    }
    public function ver_datos_alumno_descuento($id_descuento_alum){
        $dato_alumno=DB::selectOne('SELECT ti_descuentos_alum.*,gnral_alumnos.cuenta,
       gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
       ti_preparatatoria.preparatoria, ti_entidades_federativas.nom_entidad,
       ti_tipos_desc.tipo_desc from ti_descuentos_alum,gnral_alumnos,ti_entidades_federativas,
                                    ti_preparatatoria, ti_tipos_desc where ti_descuentos_alum.id_descuento_alum='.$id_descuento_alum.'
        and ti_descuentos_alum.id_alumno=gnral_alumnos.id_alumno and 
                ti_preparatatoria.id_preparatoria = ti_descuentos_alum.id_preparatoria 
    and ti_preparatatoria.id_entidad_federativa = ti_entidades_federativas.id_entidad_federativa
                and ti_descuentos_alum.id_tipo_desc = ti_tipos_desc.id_tipo_desc  ');


        return view('titulacion.jefe_titulacion.ver_datos_alumnos_descuento',compact('dato_alumno'));


    }
    public function editar_datos_alumno($id_descuento_alum){
        $dato_alumno=DB::selectOne('SELECT ti_descuentos_alum.*,gnral_alumnos.cuenta,
       gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno from
       ti_descuentos_alum,gnral_alumnos where ti_descuentos_alum.id_descuento_alum='.$id_descuento_alum.' 
        and ti_descuentos_alum.id_alumno=gnral_alumnos.id_alumno ');

        $tipos_descuentos=DB::select('SELECT * FROM `ti_tipos_desc` ');
        $preparatorias=DB::select('SELECT ti_preparatatoria.*, ti_entidades_federativas.nom_entidad 
FROM `ti_preparatatoria`,ti_entidades_federativas 
where ti_preparatatoria.id_entidad_federativa=ti_entidades_federativas.id_entidad_federativa  
ORDER BY `ti_preparatatoria`.`preparatoria`  ASC ');

       return view('titulacion.jefe_titulacion.modal_editar',compact('dato_alumno','tipos_descuentos','nacionalidades','preparatorias'));

    }
    public function guardar_edicion_datos_alumno(Request $request){

        $this->validate($request, [
            'id_descuento_alum' => 'required',
            'id_tipo_descuento' => 'required',
            'fecha_ultimo' => 'required',
            'fecha_anterior'=>'required',
             'telefono'=>'required',

            'id_preparatoria'=>'required',
        ]);
        $id_descuento_alum = $request->input('id_descuento_alum');
        $id_tipo_descuento = $request->input('id_tipo_descuento');
        $fecha_ultimo = $request->input('fecha_ultimo');
        $fecha_anterior = $request->input('fecha_anterior');
        $fecha_actual = date("d-m-Y");
        $telefono = $request->input('telefono');
        $id_preparatoria = $request->input('id_preparatoria');

        DB::table('ti_descuentos_alum')
            ->where('id_descuento_alum', $id_descuento_alum)
            ->update(['id_tipo_desc' => $id_tipo_descuento,
                'fecha_entrego' => $fecha_ultimo,
                'telefono'=>$telefono,
                'id_preparatoria'=>$id_preparatoria,
                ]);

        $id_per = Session::get('usuario_alumno');

        DB:: table('ti_historial_mod_descuento_alum')->insert([
            'id_personal'=>$id_per,
            'id_descuento_alumn'=>$id_descuento_alum,
            'accion'=>"Modificar",
            'fecha_mod'=>$fecha_actual,
            'fecha_anterior'=>$fecha_anterior,
            'fecha_actual'=>$fecha_ultimo,
            'id_tipo_desc'=>$id_tipo_descuento,
            'telefono'=>$telefono,
            'id_preparatoria'=>$id_preparatoria,
        ]);
        return back();
    }
    public function eliminar_datos_alumno($id_descuento_alum){
        $dato_alumno=DB::selectOne('SELECT ti_descuentos_alum.*,gnral_alumnos.cuenta,
       gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno from
       ti_descuentos_alum,gnral_alumnos where ti_descuentos_alum.id_descuento_alum='.$id_descuento_alum.' 
        and ti_descuentos_alum.id_alumno=gnral_alumnos.id_alumno ');
        return view('titulacion.jefe_titulacion.modal_eliminar_registro_alumno',compact('dato_alumno'));
    }
    public function eliminacion_edicion_datos_alumno(Request $request){
        $id_descuento_alum = $request->input('id_descuento_alum');
        DB::delete('DELETE FROM ti_descuentos_alum WHERE id_descuento_alum='.$id_descuento_alum.' ');
        return back();

    }
    public function documentacion_requisitos_titulacion(){
        $id_usuario = Session::get('usuario_alumno');
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_usuario` = '.$id_usuario.'');
        $id_alumno=$alumno->id_alumno;

       return view('titulacion.alumno_titulacion.requisitos_titulacion_documentos',compact('alumno','id_alumno'));

    }
    public function estado_actual_fecha($id_alumno){
        $registro_alumno=DB::selectOne('SELECT * FROM `ti_descuentos_alum` WHERE `id_alumno` = '.$id_alumno.'');

        $fecha_limite=$registro_alumno->fecha_entrego;
        $fecha_actual = date("Y-m-d");
        $fecha_limite=date("Y-m-d",strtotime($fecha_limite));

        if($fecha_actual <= $fecha_limite) {
            $estado_titulacion=1;
        }else{
            $estado_titulacion=0;
        }
        return $estado_titulacion;
    }
    public function est_actual_doc_al($id_alumno){
        $registro_doc=DB::selectOne('SELECT COUNT(id_alumno)contar from ti_requisitos_titulacion where id_alumno='.$id_alumno.'');
        $estado_actual_doc=$registro_doc->contar;

        if($estado_actual_doc == 0){
            $status_doc_al=0;
        }else{
            $status_doc_al=1;
        }
        return $status_doc_al;
    }
    public function registrar_correo_electronico($id_alumno,$correo_electronico){

        DB:: table('ti_requisitos_titulacion')->insert(['id_alumno' =>$id_alumno,'correo_electronico'=>$correo_electronico]);

    }
    public function registrar_acta_nacimiento(Request $request, $id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "acta_nacimiento_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['evi_acta_nac' =>1, 'pdf_acta_nac' => $name, 'cal_acta_nac' => 0]);
    }
    public function registrar_curp_titulacion(Request $request, $id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "curp_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['evi_curp' =>1, 'pdf_curp' => $name, 'cal_curp' => 0]);
    }

    public function registrar_cert_prepa_titulacion(Request $request, $id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "certificado_prepa_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['evi_certificado_prep' =>1, 'pdf_certificado_prep' => $name, 'cal_certificado_prep' => 0]);
    }
    public function registrar_certificado_tec_titulacion(Request $request, $id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "certificado_tesvb_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['evi_certificado_tesvb' =>1, 'pdf_certificado_tesvb' => $name, 'cal_certificado_tesvb' => 0]);
    }
    public function registrar_constancia_ss_titulacion(Request $request, $id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "constancia_ss_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['evi_constancia_ss' =>1, 'pdf_constancia_ss' => $name, 'cal_constancia_ss' => 0]);
    }
    public function registrar_certificado_ingles(Request $request, $id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "certificado_ingles_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['evi_certificado_acred_ingles' =>1, 'pdf_certificado_acred_ingles' => $name, 'cal_certificado_acred_ingles' => 0]);
    }
    public function registrar_constancia_adeudo(Request $request, $id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "constancia_adeudo_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['evi_constancia_adeudo' =>1, 'pdf_constancia_adeudo' => $name]);
    }
    public function veri_constancia_ingles($id_alumno){
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');
        $cuenta=$alumno->cuenta;
        $id_carrera=$alumno->id_carrera;
        if($id_carrera == 14){
            $sem_cero= substr($cuenta, 0, 2);
            if($sem_cero == "SC"){
                $year_cuenta= substr($cuenta, 2, 4);

            }else{
                $year_cuenta= substr($cuenta, 0, 4);
            }
        }else{
            $year_cuenta= substr($cuenta, 0, 4);
        }
        if($year_cuenta < 2010){
            $estado_contancia=1;
        }else{
            $estado_contancia=2;
        }
        return $estado_contancia;

    }
    public function documentacion_alumno_titulacion($id_alumno){
        $documentacion=DB::select('SELECT *FROM ti_requisitos_titulacion where id_alumno='.$id_alumno.'');
        return $documentacion;
    }
    public  function status_certi_ingles($id_alumno){
        $estado_certi_in= DB::selectOne('SELECT COUNT(id_alumno) contar FROM in_certificado_acreditacion WHERE id_alumno='.$id_alumno.' and  enviado = 1');
        $estado_certi_in=$estado_certi_in->contar;
        $array_certificado=array();
        if($estado_certi_in == 0){
            $dat_cert['id_certificado_acreditacion'] =0;
            $dat_cert['pdf_certificado'] = "";
            $dat_cert['id_alumno'] =0;
            $dat_cert['estado_cert'] =1;

            array_push($array_certificado,$dat_cert);
        }else{
            $certificado_ingles=DB::selectOne('SELECT * FROM `in_certificado_acreditacion` WHERE `id_alumno` = '.$id_alumno.'');
            $dat_cert['id_certificado_acreditacion'] =$certificado_ingles->id_certificado_acreditacion;
            $dat_cert['pdf_certificado'] =$certificado_ingles->pdf_certificado;
            $dat_cert['id_alumno'] =$certificado_ingles->id_alumno;
            $dat_cert['estado_cert'] =2;
            array_push($array_certificado,$dat_cert);
        }
        return $array_certificado;
    }
    public function opciones_titulacion($id_alumno){
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.'');
        $cuenta=$alumno->cuenta;
        $id_carrera=$alumno->id_carrera;
        if($id_carrera == 14){
            $sem_cero= substr($cuenta, 0, 2);
            if($sem_cero == "SC"){
                $year_cuenta= substr($cuenta, 2, 4);

            }else{
                $year_cuenta= substr($cuenta, 0, 4);
            }
        }else{
            $year_cuenta= substr($cuenta, 0, 4);
        }
        if($year_cuenta < 2010 || $id_carrera == 6 || $id_carrera == 8){
            $opciones_titulacion=DB::select('SELECT ti_opciones_titulacion.*, ti_evi_opc_titulacion.descripcion 
FROM ti_opciones_titulacion,ti_evi_opc_titulacion WHERE 
ti_evi_opc_titulacion.id_evi_opc_ti=ti_opciones_titulacion.id_tipo_evidencia and
        ti_opciones_titulacion.id_opcion_titulacion != 7 ORDER BY `ti_opciones_titulacion`.`id_opcion_titulacion` ASC ');
        }else{
            $opciones_titulacion=DB::select('SELECT ti_opciones_titulacion.*, ti_evi_opc_titulacion.descripcion 
        FROM ti_opciones_titulacion,ti_evi_opc_titulacion WHERE 
        ti_evi_opc_titulacion.id_evi_opc_ti=ti_opciones_titulacion.id_tipo_evidencia ');
        }
        return $opciones_titulacion;
    }
    public function veri_egel_al($id_alumno){
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.'');
        $cuenta=$alumno->cuenta;
        $id_carrera=$alumno->id_carrera;
        if($id_carrera == 14){
            $sem_cero= substr($cuenta, 0, 2);
            if($sem_cero == "SC"){
                $year_cuenta= substr($cuenta, 2, 4);

            }else{
                $year_cuenta= substr($cuenta, 0, 4);
            }
        }else{
            $year_cuenta= substr($cuenta, 0, 4);
        }
        if($year_cuenta < 2010 || $id_carrera == 6 || $id_carrera == 8){
            $estado_al=0;
            }else{
            $estado_al=1;
        }
        return $estado_al;
    }
    public function veri_ante_2010($id_alumno){
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.'');
        $cuenta=$alumno->cuenta;
        $id_carrera=$alumno->id_carrera;
        if($id_carrera == 14){
            $sem_cero= substr($cuenta, 0, 2);
            if($sem_cero == "SC"){
                $year_cuenta= substr($cuenta, 2, 4);

            }else{
                $year_cuenta= substr($cuenta, 0, 4);
            }
        }else{
            $year_cuenta= substr($cuenta, 0, 4);
        }
        if($year_cuenta < 2010 ){
            $estado_al_year=0;
        }else{
            $estado_al_year=1;
        }
        return $estado_al_year;

    }

    public function registrar_opcion_titulacion(Request $request,$id_requisitos,$id_opcion_titulacion){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "opcion_titulacion_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['id_opcion_titulacion' =>$id_opcion_titulacion,
                'evi_opcion_titulacion' => 1,
                'pdf_opcion_titulacion' => $name, 'cal_opcion_titulacion' => 0]);
    }
    public function registrar_reporte_result_egel(Request $request,$id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "reporte_result_egel_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() .'/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'evi_reporte_result_egel' => 1,
                'pdf_reporte_result_egel' => $name, 'cal_reporte_result_egel' => 0]);
    }
    public function reg_opc_ti_sin_doc(Request $request,$id_requisitos,$id_opcion_titulacion){
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update(['id_opcion_titulacion' =>$id_opcion_titulacion,
                'evi_opcion_titulacion' => 2,
                'pdf_opcion_titulacion' => "", 'cal_opcion_titulacion' => 0]);
    }
    public function registrar_pago_titulo(Request $request,$id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "pago_titulo_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() .'/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'evi_pago_titulo' => 1,
                'pdf_pago_titulo' => $name, 'cal_pago_titulo' => 0]);
    }
    public function registrar_pago_constancia(Request $request,$id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "pago_constancia_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() .'/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'evi_pago_contancia' => 1,
                'pdf_pago_contancia' => $name, 'cal_pago_contancia' => 0]);
    }
    public function registrar_pago_derecho_ti(Request $request,$id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "pago_derecho_ti_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() .'/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'evi_pago_derecho_ti' => 1,
                'pdf_pago_derecho_ti' => $name, 'cal_pago_derecho_ti' => 0]);
    }
    public function registrar_pago_integrante_jurado(Request $request,$id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "pago_integrante_jurado_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() .'/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'evi_pago_integrante_jurado' => 1,
                'pdf_pago_integrante_jurado' => $name, 'cal_pago_integrante_jurado' => 0]);
    }
    public function registrar_pago_concepto_autenticacion(Request $request,$id_requisitos){

        $this->validate($request, [
            'file' => 'required',
        ]);

        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "pago_concepto_autenticacion" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() .'/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'evi_pago_concepto_autenticacion' => 1,
                'pdf_pago_concepto_autenticacion' => $name,
                'cal_pago_concepto_autenticacion' => 0]);
    }
    public function registrar_acta_residencia(Request $request,$id_requisitos){
        $this->validate($request, [
            'file' => 'required',
        ]);
        $documentacion=DB::selectOne('SELECT *FROM ti_requisitos_titulacion where id_requisitos='.$id_requisitos.'');

        $id_alumno=$documentacion->id_alumno;

        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno='.$id_alumno.' ');

        $file = $request->file('file');

        $name = "acta_residencia_" .$alumno->cuenta ."." . $file->getClientOriginalExtension();
        $file->move(public_path() .'/titulacion/', $name);

        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'evi_acta_residencia' => 1,
                'pdf_acta_residencia' => $name, 'cal_acta_residencia' => 0]);
    }
    public function guardar_enviar_doc_titulacion(Request $request,$id_requisitos){
        $fecha_actual = date("d-m-Y");
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
        Mail::send('titulacion.alumno_titulacion.notificacion_envio_doc',["jefe_correo"=>$jefe_correo,"nombre_alumno"=>$nombre_alumno,"correo_alumno"=>$correo_alumno], function($message)use($jefe_correo,$nombre_alumno,$correo_alumno)
        {
            $message->from($correo_alumno,$nombre_alumno);
            $message->to($jefe_correo,"")->subject('Notificación de envio de la documentación de requisitos de titulación');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        DB::table('ti_requisitos_titulacion')
            ->where('id_requisitos', $id_requisitos)
            ->update([
                'id_estado_enviado' => 1,
                'fecha_registro' => $fecha_actual,
                ]);
    }
    public function ver_documentacion_autorizada_alumno($id_alumno){
        $alumno=DB::selectOne('SELECT gnral_alumnos.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,
       gnral_alumnos.apaterno,gnral_alumnos.amaterno, gnral_carreras.nombre carrera
       FROM gnral_carreras,gnral_alumnos where gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
      and gnral_alumnos.id_alumno='.$id_alumno.'');
        /* $documentacion=DB::selectOne('SELECT * FROM `ti_requisitos_titulacion` WHERE `id_alumno` = '.$id_alumno.' ');
         $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` WHERE `id_alumno` = '.$id_alumno.' ORDER BY `promedio_preparatoria` DESC ');
         $descuento=DB::selectOne('SELECT ti_descuentos_alum.*,ti_tipos_desc.tipo_desc from ti_descuentos_alum,ti_tipos_desc
         where ti_descuentos_alum.id_tipo_desc=ti_tipos_desc.id_tipo_desc and ti_descuentos_alum.id_alumno='.$id_alumno.'');
         */
        return view('titulacion.alumno_titulacion.ver_doc_autorizada',compact('id_alumno','alumno'));

    }
    public function pruebas(){
        $alumno=DB::selectOne('SELECT * FROM `gnral_alumnos` where id_alumno=105');

    }

}
