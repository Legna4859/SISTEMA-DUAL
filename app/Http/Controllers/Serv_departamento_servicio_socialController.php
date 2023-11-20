<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Mail;
use Illuminate\Support\Facades\Auth;
class Serv_departamento_servicio_socialController extends Controller
{
    public  function index(){
        $periodo = Session::get('periodo_actual');
        $autorizaciones = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_alumnos.id_carrera')
            ->whereIn('serv_datos_alumnos.id_estado_enviado',[1,3])
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','serv_tipo_empresa.tipo_empresa','gnral_carreras.nombre as carrera')
            ->get();
        $modificaciones = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_alumnos.id_carrera')
            ->where('serv_datos_alumnos.id_estado_enviado','=',2)
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','serv_tipo_empresa.tipo_empresa','gnral_carreras.nombre as carrera')
            ->get();

        $autorizados = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_alumnos.id_carrera')
            ->where('serv_datos_alumnos.id_estado_enviado','=',4)
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','serv_tipo_empresa.tipo_empresa','gnral_carreras.nombre as carrera')
            ->get();

        return view('servicio_social.departamento_servicio.revision_documentacion_primera_etapa',compact('autorizaciones','modificaciones','autorizados'));
    }
    public function autorizacion_documentacion($id_datos_alumnos){
        //dd($id_datos_alumnos);
        $datos_alumno = DB::table('serv_datos_alumnos')
            ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
            ->get();
        $tipo_empresa=$datos_alumno[0]->id_tipo_empresa;
        $id_alumno=$datos_alumno[0]->id_alumno;
        if($tipo_empresa ==1 ){
            $documentacion = DB::table('serv_doc_empresa_privada')
                ->where('serv_doc_empresa_privada.id_alumno','=',$id_alumno)
                ->get();
        }
        elseif($tipo_empresa == 2){
            $documentacion = DB::table('serv_doc_empresa_publica')
                ->where('serv_doc_empresa_publica.id_alumno','=',$id_alumno)
                ->get();

        }
//dd($documentacion);
        $registro_tipo_empresa = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->where('serv_datos_alumnos.id_alumno','=',$id_alumno)
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','serv_tipo_empresa.tipo_empresa')
            ->get();
       ///dd($registro_tipo_empresa);

        return view('servicio_social.departamento_servicio.autorizacion_primera_etapa',compact('tipo_empresa','documentacion','registro_tipo_empresa'));

    }
    public function autorizada_documentacion_serv($id_datos_alumnos){
        //dd($id_datos_alumnos);
        $datos_alumno = DB::table('serv_datos_alumnos')
            ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
            ->get();
        $tipo_empresa=$datos_alumno[0]->id_tipo_empresa;
        $id_alumno=$datos_alumno[0]->id_alumno;
        if($tipo_empresa ==1 ){
            $documentacion = DB::table('serv_doc_empresa_privada')
                ->where('serv_doc_empresa_privada.id_alumno','=',$id_alumno)
                ->get();
        }
        elseif($tipo_empresa == 2){
            $documentacion = DB::table('serv_doc_empresa_publica')
                ->where('serv_doc_empresa_publica.id_alumno','=',$id_alumno)
                ->get();

        }
//dd($documentacion);
        $registro_tipo_empresa = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->where('serv_datos_alumnos.id_alumno','=',$id_alumno)
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','serv_tipo_empresa.tipo_empresa')
            ->get();
        ///dd($registro_tipo_empresa);

        return view('servicio_social.departamento_servicio.documentos_autorizados_serv',compact('tipo_empresa','documentacion','registro_tipo_empresa'));

    }
    public function enviar_primeraetapa(Request $request,$id_datos_alumnos){
        //dd($request);
        $datos_alumno = DB::table('serv_datos_alumnos')
            ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
            ->get();
        $tipo_empresa=$datos_alumno[0]->id_tipo_empresa;
        $id_alumno=$datos_alumno[0]->id_alumno;
        $correo=$datos_alumno[0]->correo_electronico;
        if($tipo_empresa ==1 ) {

            $carta_aceptacion = $request->input("carta_aceptacion");
            if ($carta_aceptacion == 2) {
                $comentario_carta = "";
            } elseif ($carta_aceptacion == 1) {
                $comentario_carta = $request->input("comentario_carta");
            }
//////////
            $anexo_tecnico = $request->input("anexo_tecnico");
            if ($anexo_tecnico == 2) {
                $comentario_anexo = "";
            } elseif ($anexo_tecnico == 1) {
                $comentario_anexo = $request->input("comentario_anexo");
            }
            ///////////
            $curp = $request->input("curp");
            if ($curp == 2) {
                $comentario_curp = "";
            } elseif ($curp == 1) {
                $comentario_curp = $request->input("comentario_curp");
            }
            //////////////
            $carnet = $request->input("carnet");
            if ($carnet == 2) {
                $comentario_carnet = "";
            } elseif ($carnet == 1) {
                $comentario_carnet = $request->input("comentario_carnet");
            }
            /////////////
            $constancia_creditos = $request->input("constancia_creditos");
            if ($constancia_creditos == 2) {
                $comentario_constancia_creditos = "";
            } elseif ($constancia_creditos == 1) {
                $comentario_constancia_creditos = $request->input("comentario_constancia_creditos");
            }
            //////////////
            $solicitud_registro = $request->input("solicitud_registro");
            if ($solicitud_registro == 2) {
                $comentario_solicitud_registro = "";
            } elseif ($solicitud_registro == 1) {
                $comentario_solicitud_registro = $request->input("comentario_solicitud_registro");
            }
            if($carta_aceptacion ==2  && $anexo_tecnico == 2 && $curp == 2 && $carnet == 2 && $constancia_creditos == 2 && $solicitud_registro ==2){
                ////mensaje
                $usuario="c.computo@vbravo.tecnm.mx";
                Mail::send('servicio_social.primera_etapa.partials.mensaje_departamento_autorizacion',["correo"=>$correo], function($message)use($usuario,$correo)
                {
                    $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
                    $message->to($correo,"")->subject('Notificacion de Autorización de Documentacion del Servicio Social');
                    // $message->attach(public_path('pdf/fracciones/'.$name));
                });
                DB::table('serv_datos_alumnos')
                    ->where('id_datos_alumnos', $id_datos_alumnos)
                    ->update(['id_estado_enviado' => 4 ]);
                DB::table('serv_doc_empresa_privada')
                    ->where('id_alumno', $id_alumno)
                    ->update(['est_carta_aceptacion' => $carta_aceptacion,'coment_carta_aceptacion' =>$comentario_carta,
                        'est_anexo_tecnico' => $anexo_tecnico,'coment_anexo_tecnico' =>$comentario_anexo,
                        'est_curp' => $curp,'coment_curp' =>$comentario_curp,
                        'est_carnet' => $carnet,'coment_carnet' =>$comentario_carnet,
                        'est_constancia_creditos' => $constancia_creditos,'coment_costancia_creditos' =>$comentario_constancia_creditos,
                        'est_solicitud_reg_autori' => $solicitud_registro,'coment_solicitud_reg_autori' =>$comentario_solicitud_registro]);
            }
            else{
                ////mensaje
                $usuario="c.computo@vbravo.tecnm.mx";
                Mail::send('servicio_social.primera_etapa.partials.mensaje_departamento_modificacion',["correo"=>$correo], function($message)use($usuario,$correo)
                {
                    $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
                    $message->to($correo,"")->subject('Notificacion de Modificacion de Documentacion del Servicio Social');
                    // $message->attach(public_path('pdf/fracciones/'.$name));
                });

                DB::table('serv_datos_alumnos')
                    ->where('id_datos_alumnos', $id_datos_alumnos)
                    ->update(['id_estado_enviado' => 2 ]);

                DB::table('serv_doc_empresa_privada')
                    ->where('id_alumno', $id_alumno)
                    ->update(['est_carta_aceptacion' => $carta_aceptacion,'coment_carta_aceptacion' =>$comentario_carta,
                        'est_anexo_tecnico' => $anexo_tecnico,'coment_anexo_tecnico' =>$comentario_anexo,
                        'est_curp' => $curp,'coment_curp' =>$comentario_curp,
                        'est_carnet' => $carnet,'coment_carnet' =>$comentario_carnet,
                        'est_constancia_creditos' => $constancia_creditos,'coment_costancia_creditos' =>$comentario_constancia_creditos,
                        'est_solicitud_reg_autori' => $solicitud_registro,'coment_solicitud_reg_autori' =>$comentario_solicitud_registro]);

            }

        }
        else{
            ///////////
            $curp = $request->input("curp");
            if ($curp == 2) {
                $comentario_curp = "";
            } elseif ($curp == 1) {
                $comentario_curp = $request->input("comentario_curp");
            }
            //////////////
            $carnet = $request->input("carnet");
            if ($carnet == 2) {
                $comentario_carnet = "";
            } elseif ($carnet == 1) {
                $comentario_carnet = $request->input("comentario_carnet");
            }
            /////////////
            $constancia_creditos = $request->input("constancia_creditos");
            if ($constancia_creditos == 2) {
                $comentario_constancia_creditos = "";
            } elseif ($constancia_creditos == 1) {
                $comentario_constancia_creditos = $request->input("comentario_constancia_creditos");
            }
            //////////////
            $solicitud_registro = $request->input("solicitud_registro");
            if ($solicitud_registro == 2) {
                $comentario_solicitud_registro = "";
            } elseif ($solicitud_registro == 1) {
                $comentario_solicitud_registro = $request->input("comentario_solicitud_registro");
            }

            if( $curp == 2 && $carnet == 2 && $constancia_creditos == 2 && $solicitud_registro ==2){
                ////mensaje
                $usuario="c.computo@vbravo.tecnm.mx";
                Mail::send('servicio_social.primera_etapa.partials.mensaje_departamento_autorizacion',["correo"=>$correo], function($message)use($usuario,$correo)
                {
                    $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
                    $message->to($correo,"")->subject('Notificacion de Autorización de Documentacion del Servicio Social');
                    // $message->attach(public_path('pdf/fracciones/'.$name));
                });
                ///////////
                DB::table('serv_datos_alumnos')
                    ->where('id_datos_alumnos', $id_datos_alumnos)
                    ->update(['id_estado_enviado' => 4 ]);
                DB::table('serv_doc_empresa_publica')
                    ->where('id_alumno', $id_alumno)
                    ->update([ 'est_curp' => $curp,'coment_curp' =>$comentario_curp,
                        'est_carnet' => $carnet,'coment_carnet' =>$comentario_carnet,
                        'est_constancia_creditos' => $constancia_creditos,'coment_constancia_creditos' =>$comentario_constancia_creditos,
                        'est_solicitud_reg_autori' => $solicitud_registro,'coment_solicitud_reg_autori' =>$comentario_solicitud_registro]);
            }
            else{
                ////mensaje
                $usuario="c.computo@vbravo.tecnm.mx";
                Mail::send('servicio_social.primera_etapa.partials.mensaje_departamento_modificacion',["correo"=>$correo], function($message)use($usuario,$correo)
                {
                    $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
                    $message->to($correo,"")->subject('Notificacion de Modificacion de Documentacion del Servicio Social');
                    // $message->attach(public_path('pdf/fracciones/'.$name));
                });
                DB::table('serv_datos_alumnos')
                    ->where('id_datos_alumnos', $id_datos_alumnos)
                    ->update(['id_estado_enviado' => 2 ]);
                DB::table('serv_doc_empresa_publica')
                    ->where('id_alumno', $id_alumno)
                    ->update([ 'est_curp' => $curp,'coment_curp' =>$comentario_curp,
                        'est_carnet' => $carnet,'coment_carnet' =>$comentario_carnet,
                        'est_constancia_creditos' => $constancia_creditos,'coment_constancia_creditos' =>$comentario_constancia_creditos,
                        'est_solicitud_reg_autori' => $solicitud_registro,'coment_solicitud_reg_autori' =>$comentario_solicitud_registro]);
            }
        }

return back();
    }
    public function autorizacion_documentacion_modifcaciones($id_datos_alumnos){

        $datos_alumno = DB::table('serv_datos_alumnos')
            ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
            ->get();
        $tipo_empresa=$datos_alumno[0]->id_tipo_empresa;
        $id_alumno=$datos_alumno[0]->id_alumno;
        if($tipo_empresa ==1 ){
            $documentacion = DB::table('serv_doc_empresa_privada')
                ->where('serv_doc_empresa_privada.id_alumno','=',$id_alumno)
                ->get();
        }
        elseif($tipo_empresa == 2){
            $documentacion = DB::table('serv_doc_empresa_publica')
                ->where('serv_doc_empresa_publica.id_alumno','=',$id_alumno)
                ->get();

        }
        $registro_tipo_empresa = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->where('serv_datos_alumnos.id_alumno','=',$id_alumno)
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','serv_tipo_empresa.tipo_empresa')
            ->get();
        //dd($registro_tipo_empresa);
        return view('servicio_social.departamento_servicio.autorizacion_modifcacion_primera_etapa',compact('tipo_empresa','documentacion','registro_tipo_empresa'));

    }
}
