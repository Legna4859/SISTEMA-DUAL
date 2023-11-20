<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Mail;
use Illuminate\Support\Facades\Auth;
class Serv_alta_alumnosController extends Controller
{
    public function index(){
        $autorizados = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->join('gnral_carreras','gnral_carreras.id_carrera','=','gnral_alumnos.id_carrera')
            ->where('serv_datos_alumnos.id_estado_enviado','=',4)
            ->whereIn('serv_datos_alumnos.id_estado_presentacion',[0,1])
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','serv_tipo_empresa.tipo_empresa','gnral_carreras.nombre as carrera')
            ->get();
        //dd($autorizados);
return view('servicio_social.departamento_servicio.documentos_alumnos.estado_constancia_presentacion',compact('autorizados'));

    }
    public function registrar_constancia($id_datos_alumnos){
        $registro = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.curp_al','gnral_alumnos.genero','gnral_alumnos.fecha_nac','gnral_alumnos.entidad_nac_al','serv_tipo_empresa.tipo_empresa')
            ->get();

        $periodos = DB::table('serv_periodos')
              ->get();

        return view("servicio_social.departamento_servicio.documentos_alumnos.registra_constancia",compact('registro','periodos'));
    }
public function guardar_presentacion(Request $request){

        $this->validate($request,[
        'id_alumno' => 'required',
        'id_periodo'=>'required',


    ]);

    $id_alumno = $request->input("id_alumno");
    $id_periodo = $request->input("id_periodo");

    $file=$request->file('pdf_documento_carta');
    $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();

    $name="carta_presentacion_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
    $file->move(public_path().'/servicio_social_pdf/carta_presentacion/',$name);
    DB:: table('serv_constancia_presentacion')->insert(['id_estado_envio' =>1,
        'pdf_constancia_presentacion'=>$name,'id_periodo' =>$id_periodo,
        'id_alumno' =>$alumno[0]->id_alumno]);
    DB::table('serv_datos_alumnos')
        ->where('id_alumno', $id_alumno)
        ->update(['id_estado_presentacion' => 1]);
    return back();

}

public function modificar_carta_presentacion($id_datos_alumnos){
    $registro = DB::table('serv_datos_alumnos')
        ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
        ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
        ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
        ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.curp_al','gnral_alumnos.genero','gnral_alumnos.fecha_nac','gnral_alumnos.entidad_nac_al','serv_tipo_empresa.tipo_empresa')
        ->get();

    $periodos = DB::table('serv_periodos')
        ->get();

    $datos_constancia = DB::table('serv_constancia_presentacion')
        ->where('id_alumno','=',$registro[0]->id_alumno)
        ->get();
    return view('servicio_social.departamento_servicio.documentos_alumnos.modificar_carta_presentacion',compact('registro','periodos','datos_constancia'));
 }
public function modificacion_carta_presentacion(Request $request){
    $this->validate($request,[
        'id_alumno' => 'required',
        'id_periodo'=>'required',


    ]);

    $id_alumno = $request->input("id_alumno");
    $id_periodo = $request->input("id_periodo");

    $file=$request->file('pdf_documento_carta');
    $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();

    $name="carta_presentacion_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
    $file->move(public_path().'/servicio_social_pdf/carta_presentacion/',$name);

    DB::table('serv_constancia_presentacion')
        ->where('id_alumno', $id_alumno)
        ->update(['id_periodo' => $id_periodo]);
    return back();
}
public function ver_carta_presentacion($id_datos_alumnos)
{
    $registro = DB::table('serv_datos_alumnos')
        ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
        ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
        ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
        ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.curp_al','gnral_alumnos.genero','gnral_alumnos.fecha_nac','gnral_alumnos.entidad_nac_al','serv_tipo_empresa.tipo_empresa')
        ->get();
    $datos_constancia = DB::table('serv_constancia_presentacion')
        ->join('serv_periodos','serv_periodos.id_periodo','=','serv_constancia_presentacion.id_periodo')
        ->where('serv_constancia_presentacion.id_alumno','=',$registro[0]->id_alumno)
        ->get();
  return view('servicio_social.departamento_servicio.documentos_alumnos.ver_carta_presentacion',compact('registro','datos_constancia'));
}
public function enviar_carta_presentacion(Request $request){
    $this->validate($request,[
        'id_datos_alumnos_m' => 'required',
    ]);

    $id_datos_alumnos = $request->input("id_datos_alumnos_m");

    $registro = DB::table('serv_datos_alumnos')
        ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
        ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
        ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
        ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.curp_al','gnral_alumnos.genero','gnral_alumnos.fecha_nac','gnral_alumnos.entidad_nac_al','serv_tipo_empresa.tipo_empresa')
        ->get();

    $correo=$registro[0]->correo_electronico;
    ////mensaje
    $usuario="c.computo@vbravo.tecnm.mx";
    Mail::send('servicio_social.departamento_servicio.documentos_alumnos.mensaje_envio_cartaaceptacion',["correo"=>$correo], function($message)use($usuario,$correo)
    {
        $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
        $message->to($correo,"")->subject('Notificacion de Envio de Carta de Presentación-Aceptación');
        // $message->attach(public_path('pdf/fracciones/'.$name));
    });
    DB::table('serv_datos_alumnos')
        ->where('id_alumno', $registro[0]->id_alumno)
        ->update(['id_estado_presentacion' =>2]);
    return back();
}
public function proceso_modificacion_cartapresentacion()
{
    $modificaciones = DB::table('serv_datos_alumnos')
        ->join('gnral_alumnos as alum','alum.id_alumno','=','serv_datos_alumnos.id_alumno')
        ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
        ->join('gnral_carreras','gnral_carreras.id_carrera','=','alum.id_carrera')
        ->where('serv_datos_alumnos.id_estado_enviado','=',4)
         ->whereIn('serv_datos_alumnos.id_estado_presentacion',[2,5])
        ->select('serv_datos_alumnos.*','alum.cuenta','alum.nombre','alum.apaterno','alum.amaterno','serv_tipo_empresa.tipo_empresa','gnral_carreras.nombre as carrera')
        ->get();
    $alumnos= array();
    foreach ($modificaciones as $modificacion){
        $datos['id_datos_alumnos']=$modificacion->id_datos_alumnos;
        $datos['correo_electronico']=$modificacion->correo_electronico;
        $datos['id_alumno']=$modificacion->id_alumno;

        $periodo=DB::table('serv_constancia_presentacion')
            ->join('serv_periodos','serv_periodos.id_periodo','=','serv_constancia_presentacion.id_periodo')
            ->where('serv_constancia_presentacion.id_alumno', $modificacion->id_alumno)
            ->select('serv_periodos.*')
            ->get();
        $datos['id_periodo']=$periodo[0]->id_periodo;
        $datos['nombre_periodo']=$periodo[0]->periodo;
        $datos['cuenta']=$modificacion->cuenta;
        $datos['nombre']=mb_strtoupper($modificacion->nombre, 'utf-8')." ". mb_strtoupper($modificacion->apaterno, 'utf-8') . " " . mb_strtoupper($modificacion->amaterno, 'utf-8');
        $datos['carrera']=$modificacion->carrera;
        array_push($alumnos,$datos);
    }

    //dd($alumnos);
    return view('servicio_social.departamento_servicio.documentos_alumnos.proceso_modificacion_carta_presentacion',compact('alumnos'));

}
public function proceso_revicion_cartapresentacion(){
    $modificaciones = DB::table('serv_datos_alumnos')
        ->join('gnral_alumnos as alum','alum.id_alumno','=','serv_datos_alumnos.id_alumno')
        ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
        ->join('gnral_carreras','gnral_carreras.id_carrera','=','alum.id_carrera')
        ->where('serv_datos_alumnos.id_estado_enviado','=',4)
        ->where('serv_datos_alumnos.id_estado_presentacion','=',3)
        ->select('serv_datos_alumnos.*','alum.cuenta','alum.nombre','alum.apaterno','alum.amaterno','serv_tipo_empresa.tipo_empresa','gnral_carreras.nombre as carrera')
        ->get();
    $alumnos= array();
    foreach ($modificaciones as $modificacion) {
        $datos['id_datos_alumnos'] = $modificacion->id_datos_alumnos;
        $datos['correo_electronico'] = $modificacion->correo_electronico;
        $datos['id_alumno'] = $modificacion->id_alumno;

        $periodo = DB::table('serv_constancia_presentacion')
            ->join('serv_periodos', 'serv_periodos.id_periodo', '=', 'serv_constancia_presentacion.id_periodo')
            ->where('serv_constancia_presentacion.id_alumno', $modificacion->id_alumno)
            ->select('serv_periodos.*','serv_constancia_presentacion.pdf_constancia_presentacion')
            ->get();
        $carta_alumno = DB::table('serv_constancia_presentacion_alumno')
            ->where('id_alumno', $modificacion->id_alumno)
            ->get();
        //dd($periodo);
        $datos['id_periodo'] = $periodo[0]->id_periodo;
        $datos['nombre_periodo'] = $periodo[0]->periodo;
        $datos['cuenta'] = $modificacion->cuenta;
        $datos['nombre'] = mb_strtoupper($modificacion->nombre, 'utf-8') . " " . mb_strtoupper($modificacion->apaterno, 'utf-8') . " " . mb_strtoupper($modificacion->amaterno, 'utf-8');
        $datos['carrera'] = $modificacion->carrera;
        $datos['pdf_constancia_presentacion'] = $carta_alumno[0]->pdf_carta_presentacion;
        array_push($alumnos, $datos);
    }
    return view('servicio_social.departamento_servicio.documentos_alumnos.proceso_revicion_carta_presentacion',compact('alumnos'));


}
public function autorizar_cartapresentacionalumno(Request $request){
    $this->validate($request,[
        'id_dat' => 'required',
    ]);

    $id_datos_alumnos = $request->input("id_dat");

    $registro = DB::table('serv_datos_alumnos')
        ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
        ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
        ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
        ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.curp_al','gnral_alumnos.genero','gnral_alumnos.fecha_nac','gnral_alumnos.entidad_nac_al','serv_tipo_empresa.tipo_empresa')
        ->get();

    $correo=$registro[0]->correo_electronico;
    ////mensaje
    $usuario="c.computo@vbravo.tecnm.mx";
    Mail::send('servicio_social.departamento_servicio.doc_enviar_alumno.comentario_autorizacion_carta',["correo"=>$correo], function($message)use($usuario,$correo)
    {
        $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
        $message->to($correo,"")->subject('Notificacion de Envio de Carta de Presentación-Aceptación');
        // $message->attach(public_path('pdf/fracciones/'.$name));
    });
    DB::table('serv_datos_alumnos')
        ->where('id_alumno', $registro[0]->id_alumno)
        ->update(['id_estado_presentacion' =>4]);
    return back();

}
public function proceso_autorizadas_cartapresentacion(){
    $modificaciones = DB::table('serv_datos_alumnos')
        ->join('gnral_alumnos as alum','alum.id_alumno','=','serv_datos_alumnos.id_alumno')
        ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
        ->join('gnral_carreras','gnral_carreras.id_carrera','=','alum.id_carrera')
        ->where('serv_datos_alumnos.id_estado_enviado','=',4)
        ->where('serv_datos_alumnos.id_estado_presentacion','=',4)
        ->select('serv_datos_alumnos.*','alum.cuenta','alum.nombre','alum.apaterno','alum.amaterno','serv_tipo_empresa.tipo_empresa','gnral_carreras.nombre as carrera')
        ->get();
    $alumnos= array();
    foreach ($modificaciones as $modificacion) {
        $datos['id_datos_alumnos'] = $modificacion->id_datos_alumnos;
        $datos['correo_electronico'] = $modificacion->correo_electronico;
        $datos['id_alumno'] = $modificacion->id_alumno;

        $periodo = DB::table('serv_constancia_presentacion')
            ->join('serv_periodos', 'serv_periodos.id_periodo', '=', 'serv_constancia_presentacion.id_periodo')
            ->where('serv_constancia_presentacion.id_alumno', $modificacion->id_alumno)
            ->select('serv_periodos.*', 'serv_constancia_presentacion.pdf_constancia_presentacion')
            ->get();
        $carta_alumno = DB::table('serv_constancia_presentacion_alumno')
             ->where('id_alumno', $modificacion->id_alumno)
            ->get();
        //dd($periodo);
        $datos['id_periodo'] = $periodo[0]->id_periodo;
        $datos['nombre_periodo'] = $periodo[0]->periodo;
        $datos['cuenta'] = $modificacion->cuenta;
        $datos['nombre'] = mb_strtoupper($modificacion->nombre, 'utf-8') . " " . mb_strtoupper($modificacion->apaterno, 'utf-8') . " " . mb_strtoupper($modificacion->amaterno, 'utf-8');
        $datos['carrera'] = $modificacion->carrera;
        $datos['pdf_constancia_presentacion'] = $carta_alumno[0]->pdf_carta_presentacion;
        array_push($alumnos, $datos);
    }
    $periodos = DB::table('serv_periodos')
        ->get();

    return view('servicio_social.departamento_servicio.documentos_alumnos.proceso_autorizacion_carta_presentacion',compact('alumnos','periodos'));

}
public function enviocartapresentacionalumno(){
    $id_usuario = Session::get('usuario_alumno');
    $periodo = Session::get('periodo_actual');
    $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
    $id_alumno=$alumno[0]->id_alumno;

    $registro_servicio = DB::table('serv_datos_alumnos')
        ->select(DB::raw('count(*) as contar'))
        ->where('id_alumno', '=', $id_alumno)
        ->get();
    $estado_servicio=$registro_servicio[0]->contar;
    if($estado_servicio == 0){
        $estado_servicio=0;
        $estado_carta=0;
        return view('servicio_social.departamento_servicio.doc_enviar_alumno.estado_carta_presentacion',compact('estado_servicio','estado_carta'));

    }else{
        $registro_servicio = DB::table('serv_datos_alumnos')
            ->select(DB::raw('count(*) as contar'))
            ->where('id_alumno', '=', $id_alumno)
            ->where('id_estado_enviado', '=', 4)
            ->get();
        $registro_servicio=$registro_servicio[0]->contar;
        if($registro_servicio == 0){
            $estado_servicio=1;
            $estado_carta=0;
            return view('servicio_social.departamento_servicio.doc_enviar_alumno.estado_carta_presentacion',compact('estado_servicio','estado_carta'));
        }else{
            $estado_servicio=2;
            $datos_alumnos = DB::table('serv_datos_alumnos')
                ->where('id_alumno', '=', $id_alumno)
                ->where('id_estado_enviado', '=', 4)
                ->get();

            if($datos_alumnos[0]->id_estado_presentacion == 0){
                $estado_carta=1;
                return view('servicio_social.departamento_servicio.doc_enviar_alumno.estado_carta_presentacion',compact('estado_servicio','estado_carta'));

            }elseif($datos_alumnos[0]->id_estado_presentacion == 1)
            {
                $estado_carta=2;
                return view('servicio_social.departamento_servicio.doc_enviar_alumno.estado_carta_presentacion',compact('estado_servicio','estado_carta'));


            }
            elseif($datos_alumnos[0]->id_estado_presentacion == 2)
            {
                $estado_carta=3;
                $carta_presentacion = DB::table('serv_constancia_presentacion')
                    ->join('gnral_alumnos  as alum','alum.id_alumno','=','serv_constancia_presentacion.id_alumno')
                    ->join('serv_periodos','serv_periodos.id_periodo','=','serv_constancia_presentacion.id_periodo')
                    ->where('serv_constancia_presentacion.id_alumno', '=', $id_alumno)
                    ->select('serv_constancia_presentacion.*','alum.cuenta','alum.nombre','alum.apaterno','alum.amaterno')
                    ->get();

                $carta_alumno = DB::table('serv_constancia_presentacion_alumno')
                    ->select(DB::raw('count(*) as contar'))
                    ->where('id_alumno', '=', $id_alumno)
                    ->get();
                $carta_alumno=$carta_alumno[0]->contar;
                if($carta_alumno == 0){
                    $carta_alumno=0;
                   // dd($carta_presentacion);
                return view('servicio_social.departamento_servicio.doc_enviar_alumno.envio_carta_presentacion',compact('estado_servicio','carta_presentacion','carta_alumno'));
                }else{
                    $carta_alumno=1;
                    $carta_alumno_presentacion = DB::table('serv_constancia_presentacion_alumno')
                        ->where('id_alumno', '=', $id_alumno)
                        ->get();

                    return view('servicio_social.departamento_servicio.doc_enviar_alumno.envio_carta_presentacion',compact('estado_servicio','carta_presentacion','carta_alumno','carta_alumno_presentacion','datos_alumnos'));

                }


            }
            elseif($datos_alumnos[0]->id_estado_presentacion == 3)
            {
                $carta_presentacion = DB::table('serv_constancia_presentacion')
                    ->join('gnral_alumnos  as alum','alum.id_alumno','=','serv_constancia_presentacion.id_alumno')
                    ->join('serv_periodos','serv_periodos.id_periodo','=','serv_constancia_presentacion.id_periodo')
                    ->where('serv_constancia_presentacion.id_alumno', '=', $id_alumno)
                    ->select('serv_constancia_presentacion.*','alum.cuenta','alum.nombre','alum.apaterno','alum.amaterno')
                    ->get();
                $estado_carta=4;
                return view('servicio_social.departamento_servicio.doc_enviar_alumno.estado_carta_presentacion',compact('estado_servicio','carta_presentacion','estado_carta'));


            }
            elseif($datos_alumnos[0]->id_estado_presentacion == 4)
            {
                $estado_carta=5;
                $carta_presentacion = DB::table('serv_constancia_presentacion')
                    ->join('gnral_alumnos  as alum','alum.id_alumno','=','serv_constancia_presentacion.id_alumno')
                    ->join('serv_periodos','serv_periodos.id_periodo','=','serv_constancia_presentacion.id_periodo')
                    ->where('serv_constancia_presentacion.id_alumno', '=', $id_alumno)
                    ->select('serv_constancia_presentacion.*','alum.cuenta','alum.nombre','alum.apaterno','alum.amaterno')
                    ->get();

                return view('servicio_social.departamento_servicio.doc_enviar_alumno.estado_carta_presentacion',compact('estado_servicio','carta_presentacion','estado_carta'));

            }
            elseif($datos_alumnos[0]->id_estado_presentacion == 5)
            {
                $estado_carta=6;
                $carta_presentacion = DB::table('serv_constancia_presentacion')
                    ->join('gnral_alumnos  as alum','alum.id_alumno','=','serv_constancia_presentacion.id_alumno')
                    ->join('serv_periodos','serv_periodos.id_periodo','=','serv_constancia_presentacion.id_periodo')
                    ->where('serv_constancia_presentacion.id_alumno', '=', $id_alumno)
                    ->select('serv_constancia_presentacion.*','alum.cuenta','alum.nombre','alum.apaterno','alum.amaterno')
                    ->get();
                $carta_alumno_presentacion = DB::table('serv_constancia_presentacion_alumno')
                    ->where('id_alumno', '=', $id_alumno)
                    ->get();
                return view('servicio_social.departamento_servicio.doc_enviar_alumno.modificacion_carta_presentacion',compact('carta_presentacion','estado_carta','carta_alumno_presentacion','datos_alumnos'));


            }

        }
    }
}
public function guardarcartapresentacionalumno(Request $request){
    $this->validate($request,[
        'id_alumno' => 'required',
    ]);

    $id_alumno = $request->input("id_alumno");
    $file=$request->file('ls_pdf_documento_alumno');
    $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();

    $name="carta_presentacion_alumno_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
    $file->move(public_path().'/servicio_social_pdf/carta_presentacion/',$name);
    $hoy = date("Y-m-d H:i:s");
    DB:: table('serv_constancia_presentacion_alumno')->insert(['id_alumno' =>$id_alumno,
        'pdf_carta_presentacion'=>$name,'fecha_registro' =>$hoy]);
    return back();

}
public function modificar_cartapresentacionalumno(Request $request){
        //dd($request);
    $this->validate($request,[
        'id_al' => 'required',
    ]);

    $id_alumno = $request->input("id_al");
    $file=$request->file('mod_pdf_documento_carta_alumno');
    //dd($file);
    $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();

    $name="carta_presentacion_alumno_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
    $file->move(public_path().'/servicio_social_pdf/carta_presentacion/',$name);
    $hoy = date("Y-m-d H:i:s");
    DB::table('serv_constancia_presentacion_alumno')
        ->where('id_alumno', $id_alumno)
        ->update(['fecha_registro' =>$hoy]);
    return back();
}
public function enviar_cartapresentacionalumno(Request $request,$id_datos_alumnos){

    $id_usuario = Session::get('usuario_alumno');
    $datos_alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
    $usuario="c.computo@vbravo.tecnm.mx";
    $nombre_alumno=$datos_alumno[0]->cuenta." ".$datos_alumno[0]->nombre." ".$datos_alumno[0]->apaterno." ".$datos_alumno[0]->amaterno;
/*
    Mail::send('servicio_social.departamento_servicio.doc_enviar_alumno.comentario_autorizar_carta_presentacion',['nombre' => $nombre_alumno], function($message)use($usuario,$nombre_alumno)
    {
        $message->from(Auth::user()->email, 'Estudiante:'.$nombre_alumno);
        $message->to('desarrollo.sistemas@vbravo.tecnm.mx', 'Departamento de Servicio Social y Residencia')->subject('Envio de Carta de Presentación-Aceptación del Servicio Social');
        // $message->attach(public_path('pdf/fracciones/'.$name));
    });
*/
    DB::table('serv_datos_alumnos')
        ->where('id_datos_alumnos', $id_datos_alumnos)
        ->update(['id_estado_presentacion' => 3]);

return back();
}
public function rechazar_cartapresentacionalumno($id_datos_alumnos){
    $registro_servicio = DB::table('serv_datos_alumnos')
        ->where('id_datos_alumnos', '=', $id_datos_alumnos)
        ->get();
    $id_alumno=$registro_servicio[0]->id_alumno;
    $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();
    $constancia_presentacion=DB::table('serv_constancia_presentacion_alumno')
        ->where('id_alumno', '=', $id_alumno)
        ->get();

    return view('servicio_social.departamento_servicio.doc_enviar_alumno.partials_modificacion_carta_presentacion',compact('alumno','constancia_presentacion','id_datos_alumnos'));
}
public function envio_rechazar_cartapresentacion(Request $request){

    $this->validate($request,[
        'id_constancia_presentacion_alumno' => 'required',
        'id_dat_alumn' => 'required',
        'comentario_carta' => 'required',
    ]);

    $id_constancia_presentacion_alumno = $request->input("id_constancia_presentacion_alumno");
    $id_datos_alumnos = $request->input("id_dat_alumn");
    $comentario_carta = $request->input("comentario_carta");

    $registro = DB::table('serv_datos_alumnos')
        ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
        ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
        ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
        ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','gnral_alumnos.curp_al','gnral_alumnos.genero','gnral_alumnos.fecha_nac','gnral_alumnos.entidad_nac_al','serv_tipo_empresa.tipo_empresa')
        ->get();

    $correo=$registro[0]->correo_electronico;
    ////mensaje
    $usuario="c.computo@vbravo.tecnm.mx";
    Mail::send('servicio_social.departamento_servicio.doc_enviar_alumno.comentario_rechazo_carta',["correo"=>$correo], function($message)use($usuario,$correo)
    {
        $message->from(Auth::user()->email, 'Departamento de Servicio Social y Residencia Profesional');
        $message->to($correo,"")->subject('Notificacion de Modificación de Carta de Presentación-Aceptación');
        // $message->attach(public_path('pdf/fracciones/'.$name));
    });
    DB::table('serv_datos_alumnos')
        ->where('id_alumno', $registro[0]->id_alumno)
        ->update(['id_estado_presentacion' =>5]);
    DB::table('serv_constancia_presentacion_alumno')
        ->where('id_alumno', $registro[0]->id_alumno)
        ->update(['comentario_departamento' =>$comentario_carta]);
    return back();
}
}
