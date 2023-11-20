<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;
use Illuminate\Support\Facades\Auth;
class Resi_departamento_autorizar_anteproyectoController extends Controller
{
    public function index()
    {
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=0;
        return view('residencia.autorizar_anteproyecto.departamento_autorizar_anteproyecto',compact('carreras','mostrar','nombre_periodo'));
    }
    public function anteproyecto_autorizar_departamento($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;
        $periodo = Session::get('periodo_actual');
        $anteproyectos=DB::table('gnral_alumnos')
             ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_proyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
            ->where('resi_anteproyecto.id_periodo','=',$periodo)
            ->where('resi_anteproyecto.estado_enviado','=',3)
            ->where('resi_anteproyecto.autorizacion_departamento','=',0)
            ->where('gnral_alumnos.id_carrera','=',$id_carrera)
            ->select('resi_anteproyecto.id_anteproyecto','resi_proyecto.nom_proyecto','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.id_alumno')
            ->get();

         $anteproyectos_alumn=array();
        foreach ($anteproyectos as $ante)
        {
            $documentacion=DB::selectOne('SELECT count(id_alumno) contar FROM `resi_alta_residencia` WHERE `id_alumno` = '.$ante->id_alumno.' AND `id_estado_solicitud`=1 AND `id_periodo` = '.$periodo.' ');
            $documentacion1=DB::selectOne('SELECT count(id_alumno) contar FROM `resi_alta_residencia` WHERE `id_alumno` = '.$ante->id_alumno.' AND `id_estado_solicitud`=4 AND `id_periodo` = '.$periodo.' ');

            if($documentacion->contar == 1 || $documentacion1->contar == 1) {


                $antepro['id_anteproyecto'] = $ante->id_anteproyecto;
                $antepro['nom_proyecto'] = $ante->nom_proyecto;
                $antepro['cuenta'] = $ante->cuenta;
                $antepro['alumno'] = $ante->alumno;
                $antepro['apaterno'] = $ante->apaterno;
                $antepro['amaterno'] = $ante->amaterno;
                $antepro['id_alumno'] = $ante->id_alumno;
                $documentacion=DB::selectOne('SELECT  *FROM `resi_alta_residencia` WHERE `id_alumno` = '.$ante->id_alumno.' AND `id_periodo` = '.$periodo.' ');
                $antepro['estado_alumno'] = $documentacion->id_estado_solicitud;
                array_push($anteproyectos_alumn, $antepro);
            }
        }
       // dd($anteproyectos_alumn);

        return view('residencia.autorizar_anteproyecto.departamento_autorizar_anteproyecto',compact('carreras','mostrar','nombre_periodo','anteproyectos_alumn','id_carrera'));
    }
    public  function anteproyecto_proceso_modificacion($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;
        $periodo = Session::get('periodo_actual');
        $anteproyectos=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_proyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
            ->where('resi_anteproyecto.id_periodo','=',$periodo)
            ->where('resi_anteproyecto.estado_enviado','=',3)
            ->where('resi_anteproyecto.autorizacion_departamento','=',0)
            ->where('gnral_alumnos.id_carrera','=',$id_carrera)
            ->select('resi_anteproyecto.id_anteproyecto','resi_proyecto.nom_proyecto','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.id_alumno')
            ->get();

        $anteproyectos_alumn=array();
        foreach ($anteproyectos as $ante)
        {
            $documentacion=DB::selectOne('SELECT count(id_alumno) contar FROM `resi_alta_residencia` WHERE `id_alumno` = '.$ante->id_alumno.' AND `id_estado_solicitud` = 2 AND `id_periodo` = '.$periodo.' ');
            if($documentacion->contar) {


                $antepro['id_anteproyecto'] = $ante->id_anteproyecto;
                $antepro['nom_proyecto'] = $ante->nom_proyecto;
                $antepro['cuenta'] = $ante->cuenta;
                $antepro['alumno'] = $ante->alumno;
                $antepro['apaterno'] = $ante->apaterno;
                $antepro['amaterno'] = $ante->amaterno;
                $antepro['id_alumno'] = $ante->id_alumno;
                array_push($anteproyectos_alumn, $antepro);
            }
        }

        return view('residencia.autorizar_anteproyecto.proceso_modificacion_documento_resi',compact('carreras','mostrar','nombre_periodo','anteproyectos_alumn','id_carrera'));

    }
    public function anteproyecto_autorizar_alumno($id_anteproyecto){
        $anteproyecto=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
             ->where('resi_anteproyecto.id_anteproyecto','=',$id_anteproyecto)
            ->select('resi_anteproyecto.id_anteproyecto','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno')
            ->get();
        return view('residencia.autorizar_anteproyecto.autorizar_alumno_anteproyecto',compact('anteproyecto'));


    }
    public function anteproyecto_autorizacion_alumno(Request $request){
        $id_anteproyecto = $request->input("id_anteproyecto");
        DB::update("UPDATE resi_anteproyecto SET autorizacion_departamento=1  WHERE resi_anteproyecto.id_anteproyecto=$id_anteproyecto");
        return back();
    }
    public function anteproyectos_autorizados(){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=0;
        return view('residencia.autorizar_anteproyecto.anteproyectos_autorizados_carreras',compact('carreras','mostrar','nombre_periodo'));
    }
    public function anteproyectos_autorizados_carrera($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;
        $periodo = Session::get('periodo_actual');
        $anteproyectos=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_proyecto','resi_proyecto.id_proyecto','=','resi_anteproyecto.id_proyecto')
            ->where('resi_anteproyecto.id_periodo','=',$periodo)
            ->where('resi_anteproyecto.estado_enviado','=',3)
            ->where('resi_anteproyecto.autorizacion_departamento','=',1)
            ->where('gnral_alumnos.id_carrera','=',$id_carrera)
            ->select('resi_anteproyecto.id_anteproyecto','resi_proyecto.nom_proyecto','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno')
            ->get();
        return view('residencia.autorizar_anteproyecto.anteproyectos_autorizados_carreras',compact('carreras','mostrar','nombre_periodo','anteproyectos','id_carrera'));

    }
    public function registro_datos_envio_documentos(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.' and  resi_anteproyecto.estado_enviado=3');

     if($anteproyecto == null){


     }else{
         $anteproyecto=DB::selectOne('SELECT  *FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.' and  resi_anteproyecto.estado_enviado=3');

         if($anteproyecto->autorizacion_departamento == 0){
             $documentos_alta=DB::selectOne('select *from resi_alta_residencia where id_alumno='.$alumno.' and id_periodo='.$periodo.'');
         if($documentos_alta == null){
             return view('residencia.autorizacion_documentos_alta_residencia.registrar_datos_alumnos',compact('datosalumno'));

         }else{
             if($documentos_alta->id_estado_solicitud == 0){

                 return view('residencia.autorizacion_documentos_alta_residencia.registrar_documentos_alta_residencia',compact('documentos_alta','datosalumno'));

             }
             if($documentos_alta->id_estado_solicitud == 1){
                 return view('residencia.autorizacion_documentos_alta_residencia.envio_documento',compact('documentos_alta'));

             }
             if($documentos_alta->id_estado_solicitud == 2){

                 return view('residencia.autorizacion_documentos_alta_residencia.modificacion_documentos_alumnos',compact('documentos_alta','datosalumno'));

             }
             if($documentos_alta->id_estado_solicitud == 4){

                 return view('residencia.autorizacion_documentos_alta_residencia.envio_documento',compact('documentos_alta'));

             }


         }
         }else{

                 return view('residencia.autorizacion_documentos_alta_residencia.autorizacion_doc_alta_residencia');


         }
     }

    }
    public function registrar_correo_documentacion(Request $request){
        $this->validate($request,[
            'correo_electronico_doc' => 'required',
        ]);
        $correo_electronico_doc = $request->input("correo_electronico_doc");
        $id_usuario = Session::get('usuario_alumno');
        $id_periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $id_alumno=$datosalumno->id_alumno;
        DB:: table('resi_alta_residencia')->insert(['id_alumno' =>$id_alumno,'id_periodo' =>$id_periodo,'correo' =>$correo_electronico_doc]);
        return back();
    }
    public function modificar_correo_documentacion(Request $request){
        //dd($request);
        $this->validate($request,[
            'id_alta_residencia'=> 'required',
            'correo_electronico_doc' => 'required',
        ]);
        $id_alta_residencia = $request->input("id_alta_residencia");
        $correo_electronico_doc = $request->input("correo_electronico_doc");
        $id_usuario = Session::get('usuario_alumno');
        $id_periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $id_alumno=$datosalumno->id_alumno;
        DB::update("UPDATE resi_alta_residencia SET id_alumno ='$id_alumno',id_periodo='$id_periodo',correo='$correo_electronico_doc' WHERE id_alta_residencia=$id_alta_residencia");

         return back();
    }
    public function registrar_solicitud_residencia(Request $request,$id_alta_residencia){
        $file=$request->file('solicitud_residencia');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="solicitud_residencia_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_solicitud_residencia' => $name]);
        return back();
    }
    public function registrar_constancia_avance_academico(Request $request, $id_alta_residencia){
        $file=$request->file('constancia_avance_academico');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="constancia_avance_academico_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_constancia_avance_academico' => $name]);
        return back();
    }
    public function registrar_comprobante_seguro(Request $request, $id_alta_residencia){
        $file=$request->file('comprobante_seguro');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="comprobante_seguro_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_comprobante_seguro' => $name]);
        return back();
    }
    public function registrar_oficio_asignacion_jefatura(Request $request, $id_alta_residencia){
        $file=$request->file('oficio_asignacion_jefatura');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="oficio_asignacion_jefatura_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_oficio_asignacion_jefatura' => $name]);
        return back();
    }
    public function registrar_oficio_aceptacion_empresa(Request $request, $id_alta_residencia){
        $file=$request->file('oficio_aceptacion_empresa');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="oficio_aceptacion_empresa_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_oficio_aceptacion_empresa' => $name]);
        return back();
    }
    public function registrar_oficio_presentacion_tecnologico(Request $request, $id_alta_residencia){
        $file=$request->file('oficio_presentacion_tecnologico');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="oficio_presentacion_tecnologico_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_oficio_presentacion_tecnologico' => $name]);
        return back();
    }
    public function registrar_anteproyecto(Request $request, $id_alta_residencia){
        $file=$request->file('anteproyecto');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="anteproyecto_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_anteproyecto' => $name]);
        return back();
    }
    public function registrar_carta_compromiso(Request $request, $id_alta_residencia){
        $file=$request->file('carta_compromiso');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="carta_compromiso_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_carta_compromiso' => $name]);
        return back();
    }
    public function registrar_convenio_empresa(Request $request, $id_alta_residencia){

        $file=$request->file('convenio_empresa');
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();

        $name="convenio_empresa_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/residencia_pdf/',$name);

        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['pdf_convenio_empresa' => $name,'id_estado_convenio' =>1]);
        return back();
    }
    public function envio_documento_residencia(Request $request,  $id_alta_residencia){
        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['id_estado_solicitud' => 1]);
        return back();
    }
    public function envio_documento_residencia_modificada(Request $request,  $id_alta_residencia){
        DB::table('resi_alta_residencia')
            ->where('id_alta_residencia', $id_alta_residencia)
            ->update(['id_estado_solicitud' =>4]);
        return back();
    }

    public function autorizacion_documentacion($id_anteproyecto){
        $anteproyecto=DB::selectOne('SELECT * FROM `resi_anteproyecto` WHERE `id_anteproyecto` = '.$id_anteproyecto.'');
        $id_alumno=$anteproyecto->id_alumno;
        $id_periodo=$anteproyecto->id_periodo;
        $alumno=DB::selectOne('select *from gnral_alumnos where id_alumno='.$id_alumno.'');
        $documentos=DB::selectOne('SELECT * FROM `resi_alta_residencia` WHERE `id_alumno` = '.$id_alumno.' AND `id_periodo` = '.$id_periodo.' ');
//dd($documentos)
    return view('residencia.autorizar_anteproyecto.partial_documento_alumno',compact('anteproyecto','alumno','documentos'));
    }
    public function autorizacion_documentacion_modificada($id_anteproyecto){
        $anteproyecto=DB::selectOne('SELECT * FROM `resi_anteproyecto` WHERE `id_anteproyecto` = '.$id_anteproyecto.'');
        $id_alumno=$anteproyecto->id_alumno;
        $id_periodo=$anteproyecto->id_periodo;
        $alumno=DB::selectOne('select *from gnral_alumnos where id_alumno='.$id_alumno.'');
        $documentos=DB::selectOne('SELECT * FROM `resi_alta_residencia` WHERE `id_alumno` = '.$id_alumno.' AND `id_periodo` = '.$id_periodo.' ');

        return view('residencia.autorizar_anteproyecto.partial_documento_modificado_autorizar',compact('anteproyecto','alumno','documentos'));
    }
    public function enviar_alumno_documentacion_sin_convenio(Request $request,$id_alumno,$id_periodo,$id_convenio){
        $alumno=DB::selectOne('SELECT * FROM `resi_alta_residencia` WHERE `id_alumno` = '.$id_alumno.' AND `id_periodo` = '.$id_periodo.' ');
        $correo=$alumno->correo;
        if($id_convenio == 0){
            $this->validate($request,[
                'solicitud_residencia'=> 'required',
                'constancia_avance_academico' => 'required',
                'comprobante_seguro' => 'required',
                'oficio_asignacion_jefatura' => 'required',
                'oficio_aceptacion_empresa' => 'required',
                'oficio_presentacion_tecnologico' => 'required',
                'anteproyecto' => 'required',
                'carta_compromiso' => 'required',
            ]);
            $solicitud_residencia = $request->input("solicitud_residencia");
            $total_documento_aceptado=0;
            if($solicitud_residencia == 1){
                $comentario_solicitud_residencia = $request->input("comentario_solicitud_residencia");
            }else{
                $total_documento_aceptado++;
                $comentario_solicitud_residencia="";
            }
            $constancia_avance_academico = $request->input("constancia_avance_academico");
            if($constancia_avance_academico == 1){
                $comentario_constancia_avance_academico = $request->input("comentario_constancia_avance_academico");
            }else{
                $total_documento_aceptado++;
                $comentario_constancia_avance_academico="";
            }
            $comprobante_seguro = $request->input("comprobante_seguro");
            if($comprobante_seguro == 1){
                $comentario_comprobante_seguro = $request->input("comentario_comprobante_seguro");
            }else{
                $total_documento_aceptado++;
                $comentario_comprobante_seguro="";
            }
            $oficio_asignacion_jefatura = $request->input("oficio_asignacion_jefatura");
            if($oficio_asignacion_jefatura == 1){
                $comentario_oficio_asignacion_jefatura = $request->input("comentario_oficio_asignacion_jefatura");
            }else{
                $total_documento_aceptado++;
                $comentario_oficio_asignacion_jefatura="";
            }
            $oficio_aceptacion_empresa = $request->input("oficio_aceptacion_empresa");
            if($oficio_aceptacion_empresa == 1){
                $comentario_oficio_aceptacion_empresa = $request->input("comentario_oficio_aceptacion_empresa");
            }else{
                $total_documento_aceptado++;
                $comentario_oficio_aceptacion_empresa="";
            }
            $oficio_presentacion_tecnologico = $request->input("oficio_presentacion_tecnologico");
            if($oficio_presentacion_tecnologico == 1){
                $comentario_oficio_presentacion_tecnologico = $request->input("comentario_oficio_presentacion_tecnologico");
            }else{
                $total_documento_aceptado++;
                $comentario_oficio_presentacion_tecnologico="";
            }
            $anteproyecto = $request->input("anteproyecto");
            if($anteproyecto == 1){
                $comentario_anteproyecto = $request->input("comentario_anteproyecto");
            }else{
                $total_documento_aceptado++;
                $comentario_anteproyecto="";
            }
            $carta_compromiso = $request->input("carta_compromiso");
            if($carta_compromiso == 1){
                $comentario_carta_compromiso = $request->input("comentario_carta_compromiso");
            }else{
                $total_documento_aceptado++;
                $comentario_carta_compromiso="";
            }
            if($total_documento_aceptado == 8){
                ////mensaje
                $usuario="c.computo@vbravo.tecnm.mx";
                Mail::send('residencia.autorizacion_documentos_alta_residencia.mensaje_autoriza_doc_alta_resi',["correo"=>$correo], function($message)use($usuario,$correo)
                {
                    $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
                    $message->to($correo,"")->subject('Notificacion de Autorización de Documentacion de Alta de Residencia');
                    // $message->attach(public_path('pdf/fracciones/'.$name));
                });
                DB::table('resi_alta_residencia')
                    ->where('id_alumno', $id_alumno)
                    ->where('id_periodo', $id_periodo)
                    ->update(['id_estado_solicitud' => 3,
                        'solicitud_residencia' => $solicitud_residencia,
                        'comentario_solicitud_residencia' => $comentario_solicitud_residencia,
                        'constancia_avance_academico' => $constancia_avance_academico ,
                        'comentario_constancia_avance_academico' => $comentario_constancia_avance_academico,
                        'comprobante_seguro' => $comprobante_seguro,
                        'comentario_comprobante_seguro' => $comentario_comprobante_seguro,
                        'oficio_asignacion_jefatura' => $oficio_asignacion_jefatura,
                        'comentario_oficio_asignacion_jefatura' => $comentario_oficio_asignacion_jefatura,
                        'oficio_aceptacion_empresa' => $oficio_aceptacion_empresa,
                        'comentario_oficio_aceptacion_empresa' => $comentario_oficio_aceptacion_empresa,
                        'oficio_presentacion_tecnologico' => $oficio_presentacion_tecnologico,
                        'comentario_oficio_presentacion_tecnologico' => $comentario_oficio_presentacion_tecnologico,
                        'anteproyecto' => $anteproyecto,
                        'comentario_anteproyecto' => $comentario_anteproyecto,
                        'carta_compromiso' => $carta_compromiso,
                        'comentario_carta_compromiso' => $comentario_carta_compromiso,
                    ]);
                DB::table('resi_anteproyecto')
                    ->where('id_alumno', $id_alumno)
                    ->where('id_periodo', $id_periodo)
                    ->update(['autorizacion_departamento' => 1]);

            }else{
                ////mensaje
                $usuario="c.computo@vbravo.tecnm.mx";
                Mail::send('residencia.autorizacion_documentos_alta_residencia.mensaje_mod_doc_alta_resi',["correo"=>$correo], function($message)use($usuario,$correo)
                {
                    $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
                    $message->to($correo,"")->subject('Notificacion de Modificación de Documentacion de Alta de Residencia');
                    // $message->attach(public_path('pdf/fracciones/'.$name));
                });
                //dd($request);
                DB::table('resi_alta_residencia')
                    ->where('id_alumno', $id_alumno)
                    ->where('id_periodo', $id_periodo)
                    ->update(['id_estado_solicitud' => 2,
                        'solicitud_residencia' => $solicitud_residencia,
                        'comentario_solicitud_residencia' => $comentario_solicitud_residencia,
                        'constancia_avance_academico' => $constancia_avance_academico ,
                        'comentario_constancia_avance_academico' => $comentario_constancia_avance_academico,
                        'comprobante_seguro' => $comprobante_seguro,
                        'comentario_comprobante_seguro' => $comentario_comprobante_seguro,
                        'oficio_asignacion_jefatura' => $oficio_asignacion_jefatura,
                        'comentario_oficio_asignacion_jefatura' => $comentario_oficio_asignacion_jefatura,
                        'oficio_aceptacion_empresa' => $oficio_aceptacion_empresa,
                        'comentario_oficio_aceptacion_empresa' => $comentario_oficio_aceptacion_empresa,
                        'oficio_presentacion_tecnologico' => $oficio_presentacion_tecnologico,
                        'comentario_oficio_presentacion_tecnologico' => $comentario_oficio_presentacion_tecnologico,
                        'anteproyecto' => $anteproyecto,
                        'comentario_anteproyecto' => $comentario_anteproyecto,
                        'carta_compromiso' => $carta_compromiso,
                        'comentario_carta_compromiso' => $comentario_carta_compromiso,
                    ]);
            }
        }
        else{

            $this->validate($request,[
                'solicitud_residencia'=> 'required',
                'constancia_avance_academico' => 'required',
                'comprobante_seguro' => 'required',
                'oficio_asignacion_jefatura' => 'required',
                'oficio_aceptacion_empresa' => 'required',
                'oficio_presentacion_tecnologico' => 'required',
                'anteproyecto' => 'required',
                'carta_compromiso' => 'required',
                'convenio_empresa' => 'required',
            ]);

            $solicitud_residencia = $request->input("solicitud_residencia");
            $total_documento_aceptado=0;
            if($solicitud_residencia == 1){
                $comentario_solicitud_residencia = $request->input("comentario_solicitud_residencia");
            }else{
                $total_documento_aceptado++;
                $comentario_solicitud_residencia="";
            }
            $constancia_avance_academico = $request->input("constancia_avance_academico");
            if($constancia_avance_academico == 1){
                $comentario_constancia_avance_academico = $request->input("comentario_constancia_avance_academico");
            }else{
                $total_documento_aceptado++;
                $comentario_constancia_avance_academico="";
            }
            $comprobante_seguro = $request->input("comprobante_seguro");
            if($comprobante_seguro == 1){
                $comentario_comprobante_seguro = $request->input("comentario_comprobante_seguro");
            }else{
                $total_documento_aceptado++;
                $comentario_comprobante_seguro="";
            }
            $oficio_asignacion_jefatura = $request->input("oficio_asignacion_jefatura");
            if($oficio_asignacion_jefatura == 1){
                $comentario_oficio_asignacion_jefatura = $request->input("comentario_oficio_asignacion_jefatura");
            }else{
                $total_documento_aceptado++;
                $comentario_oficio_asignacion_jefatura="";
            }
            $oficio_aceptacion_empresa = $request->input("oficio_aceptacion_empresa");
            if($oficio_aceptacion_empresa == 1){
                $comentario_oficio_aceptacion_empresa = $request->input("comentario_oficio_aceptacion_empresa");
            }else{
                $total_documento_aceptado++;
                $comentario_oficio_aceptacion_empresa="";
            }
            $oficio_presentacion_tecnologico = $request->input("oficio_presentacion_tecnologico");
            if($oficio_presentacion_tecnologico == 1){
                $comentario_oficio_presentacion_tecnologico = $request->input("comentario_oficio_presentacion_tecnologico");
            }else{
                $total_documento_aceptado++;
                $comentario_oficio_presentacion_tecnologico="";
            }
            $anteproyecto = $request->input("anteproyecto");
            if($anteproyecto == 1){
                $comentario_anteproyecto = $request->input("comentario_anteproyecto");
            }else{
                $total_documento_aceptado++;
                $comentario_anteproyecto="";
            }
            $carta_compromiso = $request->input("carta_compromiso");
            if($carta_compromiso == 1){
                $comentario_carta_compromiso = $request->input("comentario_carta_compromiso");
            }else{
                $total_documento_aceptado++;
                $comentario_carta_compromiso="";
            }
            $convenio_empresa  = $request->input("convenio_empresa");
            if($carta_compromiso == 1){
                $comentario_convenio_empresa  = $request->input("comentario_convenio_empresa");
            }else{
                $total_documento_aceptado++;
                $comentario_convenio_empresa ="";
            }

            if($total_documento_aceptado == 9){
                ////mensaje
                $usuario="c.computo@vbravo.tecnm.mx";
                Mail::send('residencia.autorizacion_documentos_alta_residencia.mensaje_autoriza_doc_alta_resi',["correo"=>$correo], function($message)use($usuario,$correo)
                {
                    $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
                    $message->to($correo,"")->subject('Notificacion de Autorización de Documentacion de Alta de Residencia');
                    // $message->attach(public_path('pdf/fracciones/'.$name));
                });
                DB::table('resi_alta_residencia')
                    ->where('id_alumno', $id_alumno)
                    ->where('id_periodo', $id_periodo)
                    ->update(['id_estado_solicitud' => 3,
                        'solicitud_residencia' => $solicitud_residencia,
                        'comentario_solicitud_residencia' => $comentario_solicitud_residencia,
                        'constancia_avance_academico' => $constancia_avance_academico ,
                        'comentario_constancia_avance_academico' => $comentario_constancia_avance_academico,
                        'comprobante_seguro' => $comprobante_seguro,
                        'comentario_comprobante_seguro' => $comentario_comprobante_seguro,
                        'oficio_asignacion_jefatura' => $oficio_asignacion_jefatura,
                        'comentario_oficio_asignacion_jefatura' => $comentario_oficio_asignacion_jefatura,
                        'oficio_aceptacion_empresa' => $oficio_aceptacion_empresa,
                        'comentario_oficio_aceptacion_empresa' => $comentario_oficio_aceptacion_empresa,
                        'oficio_presentacion_tecnologico' => $oficio_presentacion_tecnologico,
                        'comentario_oficio_presentacion_tecnologico' => $comentario_oficio_presentacion_tecnologico,
                        'anteproyecto' => $anteproyecto,
                        'comentario_anteproyecto' => $comentario_anteproyecto,
                        'carta_compromiso' => $carta_compromiso,
                        'comentario_carta_compromiso' => $comentario_carta_compromiso,
                        'convenio_empresa' => $convenio_empresa ,
                        'comentario_convenio_empresa' => $comentario_convenio_empresa ,
                    ]);
                DB::table('resi_anteproyecto')
                    ->where('id_alumno', $id_alumno)
                    ->where('id_periodo', $id_periodo)
                    ->update(['autorizacion_departamento' => 1]);

            }else{
                ////mensaje
                $usuario="c.computo@vbravo.tecnm.mx";
                Mail::send('residencia.autorizacion_documentos_alta_residencia.mensaje_mod_doc_alta_resi',["correo"=>$correo], function($message)use($usuario,$correo)
                {
                    $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
                    $message->to($correo,"")->subject('Notificacion de Modificación de Documentacion de Alta de Residencia');
                    // $message->attach(public_path('pdf/fracciones/'.$name));
                });
                DB::table('resi_alta_residencia')
                    ->where('id_alumno', $id_alumno)
                    ->where('id_periodo', $id_periodo)
                    ->update(['id_estado_solicitud' => 2,
                        'solicitud_residencia' => $solicitud_residencia,
                        'comentario_solicitud_residencia' => $comentario_solicitud_residencia,
                        'constancia_avance_academico' => $constancia_avance_academico ,
                        'comentario_constancia_avance_academico' => $comentario_constancia_avance_academico,
                        'comprobante_seguro' => $comprobante_seguro,
                        'comentario_comprobante_seguro' => $comentario_comprobante_seguro,
                        'oficio_asignacion_jefatura' => $oficio_asignacion_jefatura,
                        'comentario_oficio_asignacion_jefatura' => $comentario_oficio_asignacion_jefatura,
                        'oficio_aceptacion_empresa' => $oficio_aceptacion_empresa,
                        'comentario_oficio_aceptacion_empresa' => $comentario_oficio_aceptacion_empresa,
                        'oficio_presentacion_tecnologico' => $oficio_presentacion_tecnologico,
                        'comentario_oficio_presentacion_tecnologico' => $comentario_oficio_presentacion_tecnologico,
                        'anteproyecto' => $anteproyecto,
                        'comentario_anteproyecto' => $comentario_anteproyecto,
                        'carta_compromiso' => $carta_compromiso,
                        'comentario_carta_compromiso' => $comentario_carta_compromiso,
                        'convenio_empresa' => $convenio_empresa ,
                        'comentario_convenio_empresa' => $comentario_convenio_empresa ,
                    ]);
            }
        }

return back();

    }
    public function ver_doc_aceptada_alta($id_anteproyecto){
        $anteproyecto=DB::selectOne('SELECT * FROM `resi_anteproyecto` WHERE `id_anteproyecto` = '.$id_anteproyecto.'');
        $id_alumno=$anteproyecto->id_alumno;
        $id_periodo=$anteproyecto->id_periodo;
        $alumno=DB::selectOne('select *from gnral_alumnos where id_alumno='.$id_alumno.'');
        $documentos=DB::selectOne('SELECT * FROM `resi_alta_residencia` WHERE `id_alumno` = '.$id_alumno.' AND `id_periodo` = '.$id_periodo.' ');

        return view('residencia.autorizar_anteproyecto.ver_doc_aceptado_alta',compact('anteproyecto','alumno','documentos'));

    }


}
