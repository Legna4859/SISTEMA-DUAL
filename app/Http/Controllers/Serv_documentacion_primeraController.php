<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Mail;
use Illuminate\Support\Facades\Auth;
class Serv_documentacion_primeraController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
        $id_alumno=$alumno[0]->id_alumno;

        $registro_servicio = DB::table('serv_datos_alumnos')
            ->select(DB::raw('count(*) as contar'))
            ->where('id_alumno', '=', $id_alumno)
            ->get();
        $registro_servicio=$registro_servicio[0]->contar;
        $tipos_empresas = DB::table('serv_tipo_empresa')->get();


              if($registro_servicio == 0){
                  return view('servicio_social.primera_etapa.registro_tipo_empresa',compact('registro_servicio','tipos_empresas','alumno'));

              }
              else{
                  $id_estado_enviado = DB::table('serv_datos_alumnos')
                      ->where('id_alumno', '=', $id_alumno)
                      ->get();

                  $id_estado_enviado=$id_estado_enviado[0]->id_estado_enviado;
                  if($id_estado_enviado == 0 || $id_estado_enviado == 1 ) {

                      $registro_tipo_empresa = DB::table('serv_datos_alumnos')
                          ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'serv_datos_alumnos.id_alumno')
                          ->join('serv_tipo_empresa', 'serv_tipo_empresa.id_tipo_empresa', '=', 'serv_datos_alumnos.id_tipo_empresa')
                          ->where('serv_datos_alumnos.id_alumno', '=', $id_alumno)
                          ->select('serv_datos_alumnos.*', 'gnral_alumnos.cuenta', 'gnral_alumnos.nombre', 'gnral_alumnos.apaterno', 'gnral_alumnos.amaterno', 'serv_tipo_empresa.tipo_empresa')
                          ->get();
                      if ($registro_tipo_empresa[0]->id_tipo_empresa == 1) {
                          $registro_empresa_privada = DB::table('serv_doc_empresa_privada')
                              ->where('id_alumno', '=', $id_alumno)
                              ->get();

                          $verificacion_registro_empresa = $registro_empresa_privada[0]->id_estado_documentacion;
                          if ($verificacion_registro_empresa == 0) {
                              $datos_empresa = DB::table('serv_doc_empresa_privada')
                                  ->where('id_alumno', '=', $id_alumno)
                                  ->get();

                          } else {
                              $datos_empresa = DB::table('serv_doc_empresa_privada')
                                  ->where('id_alumno', '=', $id_alumno)
                                  ->get();
                              //dd($datos_empresa);
                          }

                      } elseif ($registro_tipo_empresa[0]->id_tipo_empresa == 2) {
                          $registro_empresa_publica = DB::table('serv_doc_empresa_publica')
                              ->where('id_alumno', '=', $id_alumno)
                              ->get();

                          $verificacion_registro_empresa = $registro_empresa_publica[0]->id_estado_documentacion;
                          if ($verificacion_registro_empresa == 0) {
                              $datos_empresa = DB::table('serv_doc_empresa_publica')
                                  ->where('id_alumno', '=', $id_alumno)
                                  ->get();
                          } else {
                              $datos_empresa = DB::table('serv_doc_empresa_publica')
                                  ->where('id_alumno', '=', $id_alumno)
                                  ->get();
                              //dd($datos_empresa);
                          }
                      }
                      return view('servicio_social.primera_etapa.registro_tipo_empresa', compact('registro_servicio', 'registro_tipo_empresa', 'alumno', 'verificacion_registro_empresa', 'datos_empresa'));
                  }
                  ///3 es en proceso de modificacion 4 es aceptado
                  elseif($id_estado_enviado == 2 || $id_estado_enviado == 3 || $id_estado_enviado == 4)
                  {
                      $registro_tipo_empresa = DB::table('serv_datos_alumnos')
                          ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'serv_datos_alumnos.id_alumno')
                          ->join('serv_tipo_empresa', 'serv_tipo_empresa.id_tipo_empresa', '=', 'serv_datos_alumnos.id_tipo_empresa')
                          ->where('serv_datos_alumnos.id_alumno', '=', $id_alumno)
                          ->select('serv_datos_alumnos.*', 'gnral_alumnos.cuenta', 'gnral_alumnos.nombre', 'gnral_alumnos.apaterno', 'gnral_alumnos.amaterno', 'serv_tipo_empresa.tipo_empresa')
                          ->get();
                      if ($registro_tipo_empresa[0]->id_tipo_empresa == 1) {
                          $datos_empresa = DB::table('serv_doc_empresa_privada')
                              ->where('id_alumno', '=', $id_alumno)
                              ->get();


                      } elseif ($registro_tipo_empresa[0]->id_tipo_empresa == 2) {
                          $datos_empresa = DB::table('serv_doc_empresa_publica')
                              ->where('id_alumno', '=', $id_alumno)
                              ->get();

                      }
                      //dd($registro_tipo_empresa);
                      return view("servicio_social.primera_etapa.modificacion_documentacion",compact('registro_tipo_empresa','datos_empresa','id_estado_enviado'));


                  }

              }
    }
    public function registro_tipo_empresa(Request $request){
        $this->validate($request,[
            'correo_electronico' => 'required',
            'tipo_empresa' => 'required',

        ]);
        $correo_electronico = $request->input("correo_electronico");
        $tipo_empresa = $request->input("tipo_empresa");

        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
        $id_alumno=$alumno[0]->id_alumno;
        $hoy = date("Y-m-d H:i:s");
        DB:: table('serv_datos_alumnos')->insert(['correo_electronico' =>$correo_electronico,'id_tipo_empresa' =>$tipo_empresa,'id_periodo'=>$periodo,'id_alumno'=>$id_alumno,'fecha_registro'=>$hoy]);
       if($tipo_empresa == 1){
           DB:: table('serv_doc_empresa_privada')->insert(['id_alumno'=>$id_alumno]);
       }
       elseif($tipo_empresa == 2){
           DB:: table('serv_doc_empresa_publica')->insert(['id_alumno'=>$id_alumno]);
       }

        return back();

    }
    public function modificar_tipo_empresa($id_datos_alumnos){
        $registro_tipo_empresa = DB::table('serv_datos_alumnos')
            ->join('gnral_alumnos','gnral_alumnos.id_alumno','=','serv_datos_alumnos.id_alumno')
            ->join('serv_tipo_empresa','serv_tipo_empresa.id_tipo_empresa','=','serv_datos_alumnos.id_tipo_empresa')
            ->where('serv_datos_alumnos.id_datos_alumnos','=',$id_datos_alumnos)
            ->select('serv_datos_alumnos.*','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','serv_tipo_empresa.tipo_empresa')
            ->get();
        $tipos_empresas = DB::table('serv_tipo_empresa')->get();
        return view('servicio_social.primera_etapa.partials.modificar_datos_alumno',compact('registro_tipo_empresa','tipos_empresas'));

    }
    public function modificacion_tipo_empresa(Request $request){
        $this->validate($request,[
            'id_datos_alumnos' => 'required',
            'correo_electronico' => 'required',
            'tipo_empresa'=>'required',

        ]);
        $correo_electronico = $request->input("correo_electronico");
        $tipo_empresa = $request->input("tipo_empresa");
        $id_datos_alumnos = $request->input("id_datos_alumnos");
        $periodo = Session::get('periodo_actual');
        $hoy = date("Y-m-d H:i:s");
          $registro_alumno = DB::table('serv_datos_alumnos')->where('id_datos_alumnos', '=', $id_datos_alumnos)->get();
        $registro_empresa_publica = DB::table('serv_doc_empresa_publica')
            ->select(DB::raw('count(*) as contar'))
            ->where('id_alumno', '=', $registro_alumno[0]->id_alumno)
            ->get();
        $registro_empresa_publica=$registro_empresa_publica[0]->contar;
        if($registro_empresa_publica > 0){
            DB::delete('DELETE FROM serv_doc_empresa_publica WHERE id_alumno='.$registro_alumno[0]->id_alumno.'');
        }
        $registro_empresa_privada = DB::table('serv_doc_empresa_privada')
            ->select(DB::raw('count(*) as contar'))
            ->where('id_alumno', '=', $registro_alumno[0]->id_alumno)
            ->get();
        $registro_empresa_privada=$registro_empresa_privada[0]->contar;
        if($registro_empresa_privada > 0){
            DB::delete('DELETE FROM serv_doc_empresa_privada WHERE id_alumno='.$registro_alumno[0]->id_alumno.'');

        }
        DB::table('serv_datos_alumnos')
            ->where('id_datos_alumnos', $id_datos_alumnos)
            ->update(['correo_electronico' => $correo_electronico, 'id_tipo_empresa' => $tipo_empresa,'id_periodo'=>$periodo,'fecha_registro'=>$hoy]);

        if($tipo_empresa == 1){
            DB:: table('serv_doc_empresa_privada')->insert(['id_alumno'=>$registro_alumno[0]->id_alumno]);
        }
        elseif($tipo_empresa == 2){
            DB:: table('serv_doc_empresa_publica')->insert(['id_alumno'=>$registro_alumno[0]->id_alumno]);
        }

        return back();
    }
    public function  registro_tipo_empresa_alumno(Request $request,$id_datos_alumnos){
        $file=$request->file('pdf_documento');
        //dd($request->id_asigna_planeacion_tutor);
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
        $name="primera_etapa_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);

        DB:: table('serv_doc_empresa_privada')->insert(['id_alumno' =>$alumno[0]->id_alumno,'id_periodo' =>$periodo,
            'pdf_documento'=>$name,'fecha'=>$hoy]);
        return back();
    }
    public function registro_tipo_empresa_publica(Request $request,$id_datos_alumnos){
        $file=$request->file('pdf_documento');
        //dd($request->id_asigna_planeacion_tutor);
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
        $name="primera_etapa_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);

        DB:: table('serv_doc_empresa_publica')->insert(['id_alumno' =>$alumno[0]->id_alumno,'id_periodo' =>$periodo,
            'pdf_documento'=>$name,'fecha'=>$hoy]);
        return back();
    }
    public function modificar_pdf_empresaprivada(Request $request,$id_empresa_privada){
        $file=$request->file('pdf_documento');
        //dd($request->id_asigna_planeacion_tutor);
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
        $name="primera_etapa_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);

        DB::table('serv_doc_empresa_privada')
            ->where('id_empresa_privada', $id_empresa_privada)
            ->update(['id_periodo' => $periodo, 'pdf_documento' => $name,'fecha'=>$hoy]);
        return back();
    }
    public function modificar_pdf_empresapublica(Request $request,$id_empresa_privada){
        $file=$request->file('pdf_documento');
        //dd($request->id_asigna_planeacion_tutor);
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
        $name="primera_etapa_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);

        DB::table('serv_doc_empresa_publica')
            ->where('id_empresa_publica', $id_empresa_privada)
            ->update(['id_periodo' => $periodo, 'pdf_documento' => $name,'fecha'=>$hoy]);
        return back();
    }

    public function eliminar_registro_servicio(Request $request,$id_datos_alumnos){
        $registro_alumno = DB::table('serv_datos_alumnos')->where('id_datos_alumnos', '=', $id_datos_alumnos)->get();
        $id_tipo_empresa=$registro_alumno[0]->id_tipo_empresa;
        $id_usuario = Session::get('usuario_alumno');
        $alumno = DB::table('gnral_alumnos')->where('id_usuario', '=', $id_usuario)->get();
        if($id_tipo_empresa == 1){
            $datos_empresa=DB::table('serv_doc_empresa_privada')
                ->where('id_alumno', '=', $alumno[0]->id_alumno)
                ->get();
            DB::delete('DELETE FROM serv_doc_empresa_privada WHERE id_empresa_privada='.$datos_empresa[0]->id_empresa_privada.'');
            DB::delete('DELETE FROM serv_datos_alumnos WHERE id_datos_alumnos='.$id_datos_alumnos.'');
        }
        elseif($id_tipo_empresa == 2){
            $datos_empresa=DB::table('serv_doc_empresa_publica')
                ->where('id_alumno', '=', $alumno[0]->id_alumno)
                ->get();
            DB::delete('DELETE FROM serv_doc_empresa_publica WHERE id_empresa_publica='.$datos_empresa[0]->id_empresa_publica.'');
            DB::delete('DELETE FROM serv_datos_alumnos WHERE id_datos_alumnos='.$id_datos_alumnos.'');

        }
        return back();
    }
    public function enviar_registro_servicio(Request $request,$id_datos_alumnos){
        $registro_alumno = DB::table('serv_datos_alumnos')->where('id_datos_alumnos', '=', $id_datos_alumnos)->get();
         $id_estado_enviado=$registro_alumno[0]->id_estado_enviado;

if($id_estado_enviado == 0){

    DB::table('serv_datos_alumnos')
        ->where('id_datos_alumnos', $id_datos_alumnos)
        ->update(['id_estado_enviado' => 1]);
    ///envio de notificacion
}
else {

    DB::table('serv_datos_alumnos')
        ->where('id_datos_alumnos', $id_datos_alumnos)
        ->update(['id_estado_enviado' => 3]);
}
        return back();
    }
    public function registrar_carta_aceptacion(Request $request,$id_alumno,$tipo_empresa){
        $file=$request->file('carta_aceptacion');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();
        $name="carta_aceptacion_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);
       if($tipo_empresa == 1)
       {
           DB::table('serv_doc_empresa_privada')
               ->where('id_alumno', $id_alumno)
               ->update(['pdf_carta_aceptacion' => $name,'fecha'=>$hoy]);
       }
        return back();
    }
    public  function registrar_anexo_tecnico(Request $request,$id_alumno,$tipo_empresa){
        $file=$request->file('anexo_tecnico');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();
        $name="anexo_tecnico_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);
        if($tipo_empresa == 1)
        {
            DB::table('serv_doc_empresa_privada')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_anexo_tecnico' => $name,'fecha'=>$hoy]);
        }
        return back();

    }
    public  function registrar_curp(Request $request,$id_alumno,$tipo_empresa){

        $file=$request->file('curp');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();
        $name="curp_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);
        if($tipo_empresa == 1)
        {
            DB::table('serv_doc_empresa_privada')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_curp' => $name,'fecha'=>$hoy]);
        }
        if($tipo_empresa == 2)
        {
            DB::table('serv_doc_empresa_publica')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_curp' => $name,'fecha'=>$hoy]);
        }
        return back();

    }
    public  function registrar_carnet(Request $request,$id_alumno,$tipo_empresa){
        //dd($request);
        $file=$request->file('carnet');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();
        $name="carnet_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);
        if($tipo_empresa == 1)
        {
            DB::table('serv_doc_empresa_privada')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_carnet' => $name,'fecha'=>$hoy]);
        }
        if($tipo_empresa == 2)
        {
            DB::table('serv_doc_empresa_publica')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_carnet' => $name,'fecha'=>$hoy]);
        }
        return back();

    }

    public  function registrar_costancia_creditos(Request $request,$id_alumno,$tipo_empresa){
        //dd($request);
        $file=$request->file('costancia_creditos');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();
        $name="costancia_creditos_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);
        if($tipo_empresa == 1)
        {
            DB::table('serv_doc_empresa_privada')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_constancia_creditos' => $name,'fecha'=>$hoy]);
        }
        if($tipo_empresa == 2)
        {
            DB::table('serv_doc_empresa_publica')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_constancia_creditos' => $name,'fecha'=>$hoy]);
        }
        return back();

    }

    public  function registrar_solicitud_registro(Request $request,$id_alumno,$tipo_empresa){
        //dd($request);
        $file=$request->file('solicitud_registro');
        $hoy = date("Y-m-d H:i:s");
        $alumno = DB::table('gnral_alumnos')->where('id_alumno', '=', $id_alumno)->get();
        $name="solicitud_registro_".$alumno[0]->cuenta.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/servicio_social_pdf/primera_etapa/',$name);
        if($tipo_empresa == 1)
        {
            DB::table('serv_doc_empresa_privada')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_solicitud_reg_autori' => $name,'fecha'=>$hoy]);
        }
        if($tipo_empresa == 2)
        {
            DB::table('serv_doc_empresa_publica')
                ->where('id_alumno', $id_alumno)
                ->update(['pdf_solicitud_reg_autori' => $name,'fecha'=>$hoy]);
        }
        return back();

    }
}


