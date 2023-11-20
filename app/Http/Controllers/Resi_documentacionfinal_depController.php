<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;
use Illuminate\Support\Facades\Auth;
class Resi_documentacionfinal_depController extends Controller
{
    public function index(){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=0;
        return view('residencia.autorizacion_documentos_final_residencia.autorizar_doc_finales',compact('nombre_periodo','carreras','mostrar'));

    }
    public function revisar_doc_finales($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;

        $periodo = Session::get('periodo_actual');
        $alumnos=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_liberacion_documentos','resi_anteproyecto.id_anteproyecto','=','resi_liberacion_documentos.id_anteproyecto')
              ->where('resi_liberacion_documentos.id_periodo','=',$periodo)
            ->whereIn('resi_liberacion_documentos.id_estado_enviado',[1,3])
            ->where('gnral_alumnos.id_carrera','=',$id_carrera)
            ->select('resi_liberacion_documentos.id_estado_enviado','resi_liberacion_documentos.id_liberacion_documentos','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.id_alumno')
            ->get();
        //dd($alumnos);
        return view('residencia.autorizacion_documentos_final_residencia.autorizar_doc_finales',compact('nombre_periodo','carreras','mostrar','id_carrera','alumnos'));


    }
    public function mod_doc_finales($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;

        $periodo = Session::get('periodo_actual');
        $alumnos=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_liberacion_documentos','resi_anteproyecto.id_anteproyecto','=','resi_liberacion_documentos.id_anteproyecto')
            ->where('resi_liberacion_documentos.id_periodo','=',$periodo)
            ->where('resi_liberacion_documentos.id_estado_enviado','=',2)
            ->where('gnral_alumnos.id_carrera','=',$id_carrera)
            ->select('resi_liberacion_documentos.id_liberacion_documentos','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.id_alumno')
            ->get();
        return view('residencia.autorizacion_documentos_final_residencia.proceso_mod_doc_finales',compact('nombre_periodo','carreras','mostrar','id_carrera','alumnos'));
    }
    public function alumno_liberacion_final($id_liberacion_documentos){
        $alumno=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_liberacion_documentos','resi_anteproyecto.id_anteproyecto','=','resi_liberacion_documentos.id_anteproyecto')
            ->where('resi_liberacion_documentos.id_liberacion_documentos','=',$id_liberacion_documentos)
            ->select('resi_liberacion_documentos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.id_alumno')
            ->get();
       return view('residencia.autorizacion_documentos_final_residencia.partials_autorizar_doc_final',compact('alumno'));

    }
    public function enviar_doc_final_dep(Request $request,$id_liberacion_documentos){

        $this->validate($request,[
            'acta_calificacion'=> 'required',
            'proyecto' => 'required',
            'portada' => 'required',
            'evaluacion_final_residencia' => 'required',
            'oficio_aceptacion_informe_interno' => 'required',
            'formato_evaluacion' => 'required',
            'oficio_aceptacion_informe_revisor' => 'required',
            'oficio_aceptacion_informe_externo' => 'required',
            'formato_hora' => 'required',
            'seguimiento_interno' => 'required',
            'seguimiento_externo' => 'required',
        ]);
          $contaraprobado=0;
        $acta_calificacion = $request->input("acta_calificacion");
        if($acta_calificacion == 2){
            $contaraprobado++;
            $comentario_acta_calificacion="";
        }else{
            $comentario_acta_calificacion = $request->input("comentario_acta_calificacion");
        }

        $proyecto = $request->input("proyecto");
        if($proyecto == 2){
            $contaraprobado++;
            $comentario_proyecto="";
        }else{
            $comentario_proyecto = $request->input("comentario_proyecto");
        }

        $portada = $request->input("portada");
        if($portada == 2){
            $contaraprobado++;
            $comentario_portada="";
        }else{
            $comentario_portada = $request->input("comentario_portada");
        }

        $evaluacion_final_residencia = $request->input("evaluacion_final_residencia");
        if($evaluacion_final_residencia == 2){
            $contaraprobado++;
            $comentario_evaluacion_final_residencia="";
        }else{
            $comentario_evaluacion_final_residencia = $request->input("comentario_evaluacion_final_residencia");
        }

        $oficio_aceptacion_informe_interno = $request->input("oficio_aceptacion_informe_interno");
        if($oficio_aceptacion_informe_interno == 2){
            $contaraprobado++;
            $comentario_oficio_aceptacion_informe_interno="";
        }else{
            $comentario_oficio_aceptacion_informe_interno = $request->input("comentario_oficio_aceptacion_informe_interno");
        }

        $formato_evaluacion = $request->input("formato_evaluacion");
        if($formato_evaluacion == 2){
            $contaraprobado++;
            $comentario_formato_evaluacion="";
        }else{
            $comentario_formato_evaluacion = $request->input("comentario_formato_evaluacion");
        }

        $oficio_aceptacion_informe_revisor = $request->input("oficio_aceptacion_informe_revisor");
        if($oficio_aceptacion_informe_revisor == 2){
            $contaraprobado++;
            $comentario_oficio_aceptacion_informe_revisor="";
        }else{
            $comentario_oficio_aceptacion_informe_revisor = $request->input("comentario_oficio_aceptacion_informe_revisor");
        }

        $oficio_aceptacion_informe_externo = $request->input("oficio_aceptacion_informe_externo");
        if($oficio_aceptacion_informe_externo == 2){
            $contaraprobado++;
            $comentario_oficio_aceptacion_informe_externo="";
        }else{
            $comentario_oficio_aceptacion_informe_externo = $request->input("comentario_oficio_aceptacion_informe_externo");
        }

        $formato_hora = $request->input("formato_hora");
        if($formato_hora == 2){
            $contaraprobado++;
            $comentario_formato_hora="";
        }else{
            $comentario_formato_hora = $request->input("comentario_formato_hora");
        }

        $seguimiento_interno = $request->input("seguimiento_interno");
        if($seguimiento_interno == 2){
            $contaraprobado++;
            $comentario_seguimiento_interno="";
        }else{
            $comentario_seguimiento_interno = $request->input("comentario_seguimiento_interno");
        }

        $seguimiento_externo = $request->input("seguimiento_externo");
        if($seguimiento_externo == 2){
            $contaraprobado++;
            $comentario_seguimiento_externo="";
        }else{
            $comentario_seguimiento_externo = $request->input("comentario_seguimiento_externo");
        }
        $documento=DB::selectOne('select *from resi_liberacion_documentos where id_liberacion_documentos='.$id_liberacion_documentos.'');
     $correo=$documento->correo_electronico;
        $usuario="c.computo@vbravo.tecnm.mx";
       if($contaraprobado == 11){
           Mail::send('residencia.autorizacion_documentos_final_residencia.comentario_aceptar_doc_final',["correo"=>$correo], function($message)use($usuario,$correo)
           {
               $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
               $message->to($correo,"")->subject('Notificacion de Autorización de la Documentacion de la Liberación de Residencia Profesional');
               // $message->attach(public_path('pdf/fracciones/'.$name));
           });
            DB::table('resi_liberacion_documentos')
               ->where('id_liberacion_documentos', $id_liberacion_documentos)
               ->update(['id_estado_enviado' => 4,
                   'estado_acta_calificacion'=>$acta_calificacion,
                   'comentario_acta_calificacion'=> $comentario_acta_calificacion,
                   'estado_proyecto' => $proyecto,
                   'comentario_proyecto' => $comentario_proyecto,
                   'estado_portada' => $portada,
                   'comentario_portada' => $comentario_portada,
                   'estado_evaluacion_final_residencia' => $evaluacion_final_residencia,
                   'comentario_evaluacion_final_residencia' => $comentario_evaluacion_final_residencia,
                   'estado_oficio_aceptacion_informe_interno' => $oficio_aceptacion_informe_interno,
                   'comentario_oficio_aceptacion_informe_interno' => $comentario_oficio_aceptacion_informe_interno,
                   'estado_formato_evaluacion' => $formato_evaluacion,
                   'comentario_formato_evaluacion' => $comentario_formato_evaluacion,
                   'estado_oficio_aceptacion_informe_revisor' => $oficio_aceptacion_informe_revisor,
                   'comentario_oficio_aceptacion_informe_revisor' => $comentario_oficio_aceptacion_informe_revisor,
                   'estado_oficio_aceptacion_informe_externo' => $oficio_aceptacion_informe_externo,
                   'comentario_oficio_aceptacion_informe_externo' => $comentario_oficio_aceptacion_informe_externo,
                   'estado_formato_hora' => $formato_hora,
                   'comentario_formato_hora' => $comentario_formato_hora,
                   'estado_seguimiento_interno' => $seguimiento_interno,
                   'comentario_seguimiento_interno' => $comentario_seguimiento_interno,
                   'estado_seguimiento_externo' => $seguimiento_externo,
                   'comentario_seguimiento_externo' => $comentario_seguimiento_externo]);
       }else{
           Mail::send('residencia.autorizacion_documentos_final_residencia.comentario_modificar_doc_final',["correo"=>$correo], function($message)use($usuario,$correo)
           {
               $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
               $message->to($correo,"")->subject('Notificación de Modificación de la Documentacion de la Liberación de Residencia Profesional');
               // $message->attach(public_path('pdf/fracciones/'.$name));

           });
           DB::table('resi_liberacion_documentos')
               ->where('id_liberacion_documentos', $id_liberacion_documentos)
               ->update(['id_estado_enviado' => 2,
                   'estado_acta_calificacion'=>$acta_calificacion,
                   'comentario_acta_calificacion'=> $comentario_acta_calificacion,
                   'estado_proyecto' => $proyecto,
                   'comentario_proyecto' => $comentario_proyecto,
                   'estado_portada' => $portada,
                   'comentario_portada' => $comentario_portada,
                   'estado_evaluacion_final_residencia' => $evaluacion_final_residencia,
                   'comentario_evaluacion_final_residencia' => $comentario_evaluacion_final_residencia,
                   'estado_oficio_aceptacion_informe_interno' => $oficio_aceptacion_informe_interno,
                   'comentario_oficio_aceptacion_informe_interno' => $comentario_oficio_aceptacion_informe_interno,
                   'estado_formato_evaluacion' => $formato_evaluacion,
                   'comentario_formato_evaluacion' => $comentario_formato_evaluacion,
                   'estado_oficio_aceptacion_informe_revisor' => $oficio_aceptacion_informe_revisor,
                   'comentario_oficio_aceptacion_informe_revisor' => $comentario_oficio_aceptacion_informe_revisor,
                   'estado_oficio_aceptacion_informe_externo' => $oficio_aceptacion_informe_externo,
                   'comentario_oficio_aceptacion_informe_externo' => $comentario_oficio_aceptacion_informe_externo,
                   'estado_formato_hora' => $formato_hora,
                   'comentario_formato_hora' => $comentario_formato_hora,
                   'estado_seguimiento_interno' => $seguimiento_interno,
                   'comentario_seguimiento_interno' => $comentario_seguimiento_interno,
                   'estado_seguimiento_externo' => $seguimiento_externo,
                   'comentario_seguimiento_externo' => $comentario_seguimiento_externo]);
       }
return back();
    }
    public function alumno_liberacion_final_mod($id_liberacion_documentos){
        $alumno=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_liberacion_documentos','resi_anteproyecto.id_anteproyecto','=','resi_liberacion_documentos.id_anteproyecto')
            ->where('resi_liberacion_documentos.id_liberacion_documentos','=',$id_liberacion_documentos)
            ->select('resi_liberacion_documentos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.id_alumno')
            ->get();
        return view('residencia.autorizacion_documentos_final_residencia.partials_autorizar_doc_modi_final',compact('alumno'));

    }
    public function doc_autorizada_finales($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=1;

        $periodo = Session::get('periodo_actual');
        $alumnos=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_liberacion_documentos','resi_anteproyecto.id_anteproyecto','=','resi_liberacion_documentos.id_anteproyecto')
            ->where('resi_liberacion_documentos.id_periodo','=',$periodo)
            ->where('resi_liberacion_documentos.id_estado_enviado','=',4)
            ->where('gnral_alumnos.id_carrera','=',$id_carrera)
            ->select('resi_liberacion_documentos.id_liberacion_documentos','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.id_alumno')
            ->get();
        return view('residencia.autorizacion_documentos_final_residencia.doc_finales_autorizado',compact('nombre_periodo','carreras','mostrar','id_carrera','alumnos'));

    }
    public function ver_doc_finales_aut($id_liberacion_documentos){
        $alumno=DB::table('gnral_alumnos')
            ->join('resi_anteproyecto','gnral_alumnos.id_alumno','=','resi_anteproyecto.id_alumno')
            ->join('resi_liberacion_documentos','resi_anteproyecto.id_anteproyecto','=','resi_liberacion_documentos.id_anteproyecto')
            ->where('resi_liberacion_documentos.id_liberacion_documentos','=',$id_liberacion_documentos)
            ->select('resi_liberacion_documentos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre as alumno','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.id_alumno')
            ->get();
        return view('residencia.autorizacion_documentos_final_residencia.ver_doc_final_aut_al',compact('alumno'));

    }
    public function ver_anteproyectos_revisores(){
        $nombre_periodo = Session::get('nombre_periodo');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $mostrar=0;
        return view('residencia.documento_pressent_resi.estado_alumno_anteproyecto',compact('nombre_periodo','carreras','mostrar'));

    }
    public function ver_estados_alumnos($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $periodo = Session::get('periodo_actual');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $anteproyecto_autorizados=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
       gnral_alumnos.amaterno,resi_anteproyecto.id_anteproyecto,resi_proyecto.id_proyecto,
       resi_proyecto.nom_proyecto,resi_anteproyecto.estado_enviado from resi_anteproyecto,
    resi_proyecto,gnral_alumnos where resi_anteproyecto.id_alumno=gnral_alumnos.id_alumno 
and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto and resi_anteproyecto.id_periodo='.$periodo.'
                                  and gnral_alumnos.id_carrera='.$id_carrera.' and resi_anteproyecto.estado_enviado=3');


        $array_anteproyecto=array();
        foreach ($anteproyecto_autorizados as  $autorizado){
            $dat_ante['nombre']=$autorizado->nombre." ".$autorizado->apaterno." ".$autorizado->amaterno;
            $dat_ante['id_anteproyecto']=$autorizado->id_anteproyecto;
            $dat_ante['cuenta']=$autorizado->cuenta;
            $dat_ante['nom_proyecto']=$autorizado->nom_proyecto;
$checar_empresa=DB::selectOne('SELECT COUNT(id_anteproyecto)anteproyecto FROM
                                               `resi_proy_empresa` WHERE `id_anteproyecto` = '.$autorizado->id_anteproyecto.'');

            if($checar_empresa->anteproyecto == 0){
                $dat_ante['estado_empresa']=0;
            }else{
                $checar_asesor=DB::selectOne('SELECT COUNT(id_anteproyecto)anteproyecto FROM resi_asesores WHERE `id_anteproyecto` = '.$autorizado->id_anteproyecto.'');
                $checar_asesor=$checar_asesor->anteproyecto;
                if($checar_asesor == 0){
                    $dat_ante['estado_empresa']=1;
                }else{
                    $dat_ante['estado_empresa']=2;
                }

            }
            array_push($array_anteproyecto,$dat_ante);
        }

        $mostrar=1;
        return view('residencia.documento_pressent_resi.estado_alumno_anteproyecto',compact('nombre_periodo','carreras','mostrar','array_anteproyecto','id_carrera'));


    }
    public function proceso_mod_anteproyecto($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $periodo = Session::get('periodo_actual');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $anteproyecto_autorizados=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
       gnral_alumnos.amaterno,resi_anteproyecto.id_anteproyecto,resi_proyecto.id_proyecto,
       resi_proyecto.nom_proyecto,resi_anteproyecto.estado_enviado from resi_anteproyecto,
    resi_proyecto,gnral_alumnos where resi_anteproyecto.id_alumno=gnral_alumnos.id_alumno 
and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto and resi_anteproyecto.id_periodo='.$periodo.'
                                  and gnral_alumnos.id_carrera='.$id_carrera.' and resi_anteproyecto.estado_enviado in (0,2)');

        $mostrar=1;
        return view('residencia.documento_pressent_resi.mod_anteproyecto_revision',compact('nombre_periodo','carreras','mostrar','anteproyecto_autorizados','id_carrera'));

    }
    public function proceso_revision_anteproyecto($id_carrera){
        $nombre_periodo = Session::get('nombre_periodo');
        $periodo = Session::get('periodo_actual');
        $carreras=DB::table('gnral_carreras')
            ->where('gnral_carreras.id_carrera','!=',9)
            ->where('gnral_carreras.id_carrera','!=',11)
            ->where('gnral_carreras.id_carrera','!=',15)
            ->select('gnral_carreras.*')
            ->get();
        $anteproyecto_autorizados=DB::select('SELECT gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,
       gnral_alumnos.amaterno,resi_anteproyecto.id_anteproyecto,resi_proyecto.id_proyecto,
       resi_proyecto.nom_proyecto,resi_anteproyecto.estado_enviado from resi_anteproyecto,
    resi_proyecto,gnral_alumnos where resi_anteproyecto.id_alumno=gnral_alumnos.id_alumno 
and resi_anteproyecto.id_proyecto=resi_proyecto.id_proyecto and resi_anteproyecto.id_periodo='.$periodo.'
                                  and gnral_alumnos.id_carrera='.$id_carrera.' and resi_anteproyecto.estado_enviado=1');

        $mostrar=1;
        return view('residencia.documento_pressent_resi.rev_anteproyecto_alumno',compact('nombre_periodo','carreras','mostrar','anteproyecto_autorizados','id_carrera'));

    }
}
