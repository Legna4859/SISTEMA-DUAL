<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\amb_encargados;
use App\amb_procedimientos;
use Session;
use Mail;
use Illuminate\Support\Facades\Auth;
class Amb_jefe_ambientalController extends Controller
{
    public function index(){
        $contar_e= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->select(DB::raw('count(*) as contar'))
            ->get();


        if($contar_e[0]->contar == 0){
            $estado_periodo=0;
            $periodo="";
        }else{
            $estado_periodo=1;
            $periodo= DB::table('amb_periodo_amb')
                ->where('amb_periodo_amb.estado_periodo','=',1)
                ->get();
            $periodo=$periodo[0]->nombre_periodo_amb;
        }

        return view('ambiental.jefe_ambiental.autorizar_documentacion',compact('periodo','estado_periodo'));
    }
    public function estado_periodo(){
        $contar= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->select(DB::raw('count(*) as contar'))
            ->get();




        return $contar;
    }
    public function ver_documentacion_encargado(){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $id_periodo=$periodo[0]->id_periodo_amb;
        $encargados=DB::select('SELECT amb_documentacion_encargados.*,gnral_personales.nombre,amb_procedimientos.nom_procedimiento 
from amb_documentacion_encargados, amb_procedimientos, amb_encargados, gnral_personales 
where amb_documentacion_encargados.id_encargado=amb_encargados.id_encargado and
      amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and 
      amb_encargados.id_personal=gnral_personales.id_personal and  amb_documentacion_encargados.estado_envio_doc in (1,3) and
      amb_documentacion_encargados.id_periodo_amb='.$id_periodo.'');
        return $encargados;

    }
    public function documentacion_encar($id_documentacion_encar){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        return view('ambiental.jefe_ambiental.evaluar_documentacion1',compact('periodo','id_documentacion_encar'));

    }
    public function documentacion_encar_mod($id_documentacion_encar){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();


        return view('ambiental.jefe_ambiental.evaluar_doc_modificada',compact('periodo','id_documentacion_encar','documentos'));

    }
    public function ver_doc_encargado_proc($id_documentacion_encar){

        $encargado=DB::select('SELECT amb_documentacion_encargados.*,gnral_personales.nombre,amb_procedimientos.nom_procedimiento 
from amb_documentacion_encargados, amb_procedimientos, amb_encargados, gnral_personales 
where amb_documentacion_encargados.id_encargado=amb_encargados.id_encargado and
      amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and 
      amb_encargados.id_personal=gnral_personales.id_personal and
      amb_documentacion_encargados.id_documentacion_encar='.$id_documentacion_encar.'');
        return $encargado;
    }
    public function guardar_validacion_doc1(Request $request,$id_documentacion_encar){
        $estado_estado_acc_m1 = $request->input("estado_estado_acc_m1");

        if($estado_estado_acc_m1 == 1){
            $comentario_estado_acc_m1="";
        }else{
            $comentario_estado_acc_m1 = $request->input("comentario_estado_acc_m1");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_estado_acc_m1' => $estado_estado_acc_m1,
                'comentario_estado_acc_m1' => $comentario_estado_acc_m1,
                'cal_estado_acc_m1'=>1]);
    }
    public function guardar_validacion_doc2(Request $request,$id_documentacion_encar){
        $estado_cuestion_ambas_per_m2 = $request->input("estado_cuestion_ambas_per_m2");

        if($estado_cuestion_ambas_per_m2  == 1){
            $comentario_cuestion_ambas_per_m2 ="";
        }else{
            $comentario_cuestion_ambas_per_m2  = $request->input("comentario_cuestion_ambas_per_m2");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_cuestion_ambas_per_m2' => $estado_cuestion_ambas_per_m2,
                'comentario_cuestion_ambas_per_m2' => $comentario_cuestion_ambas_per_m2,
                'cal_cuestion_ambas_per_m2'=>1]);
    }
    public function guardar_validacion_doc3(Request $request,$id_documentacion_encar){
        $estado_necesidades_espectativas_m2 = $request->input("estado_necesidades_espectativas_m2");

        if($estado_necesidades_espectativas_m2  == 1){
            $comentario_necesidades_espectativas_m2 ="";
        }else{
            $comentario_necesidades_espectativas_m2  = $request->input("comentario_necesidades_espectativas_m2");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_necesidades_espectativas_m2' => $estado_necesidades_espectativas_m2,
                'comentario_necesidades_espectativas_m2' => $comentario_necesidades_espectativas_m2,
                'cal_necesidades_espectativas_m2'=>1]);
    }
    public function guardar_validacion_doc4(Request $request,$id_documentacion_encar){
        $estado_aspecto_ambiental_m2 = $request->input("estado_aspecto_ambiental_m2");

        if($estado_aspecto_ambiental_m2  == 1){
            $comentario_aspecto_ambiental_m2 ="";
        }else{
            $comentario_aspecto_ambiental_m2  = $request->input("comentario_aspecto_ambiental_m2");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_aspecto_ambiental_m2' => $estado_aspecto_ambiental_m2,
                'comentario_aspecto_ambiental_m2' => $comentario_aspecto_ambiental_m2,
                'cal_aspecto_ambiental_m2'=>1]);
    }
    public function guardar_validacion_doc5(Request $request,$id_documentacion_encar){
        $estado_riesgo_oportu_m2 = $request->input("estado_riesgo_oportu_m2");

        if($estado_riesgo_oportu_m2  == 1){
            $comentario_riesgo_oportu_m2 ="";
        }else{
            $comentario_riesgo_oportu_m2 = $request->input("comentario_riesgo_oportu_m2");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_riesgo_oportu_m2' => $estado_riesgo_oportu_m2,
                'comentario_riesgo_oportu_m2' => $comentario_riesgo_oportu_m2,
                'cal_riesgo_oportu_m2'=>1]);
    }
    public function guardar_validacion_doc6(Request $request,$id_documentacion_encar){
        $estado_grado_objetivo_m3 = $request->input("estado_grado_objetivo_m3");

        if($estado_grado_objetivo_m3  == 1){
            $comentario_grado_objetivo_m3 ="";
        }else{
            $comentario_grado_objetivo_m3 = $request->input("comentario_grado_objetivo_m3");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_grado_objetivo_m3' => $estado_grado_objetivo_m3,
                'comentario_grado_objetivo_m3' => $comentario_grado_objetivo_m3,
                'cal_grado_objetivo_m3'=>1]);
    }
    public function guardar_validacion_doc7(Request $request,$id_documentacion_encar){
        $estado_programa_gestion_m3 = $request->input("estado_programa_gestion_m3");

        if($estado_programa_gestion_m3  == 1){
            $comentario_programa_gestion_m3 ="";
        }else{
            $comentario_programa_gestion_m3 = $request->input("comentario_programa_gestion_m3");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_programa_gestion_m3' => $estado_programa_gestion_m3,
                'comentario_programa_gestion_m3' => $comentario_programa_gestion_m3,
                'cal_programa_gestion_m3'=>1]);
    }
    public function guardar_validacion_doc8(Request $request,$id_documentacion_encar){
        $estado_noconformid_correctivas_m4 = $request->input("estado_noconformid_correctivas_m4");

        if($estado_noconformid_correctivas_m4  == 1){
            $comentario_noconformid_correctivas_m4 ="";
        }else{
            $comentario_noconformid_correctivas_m4 = $request->input("comentario_noconformid_correctivas_m4");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_noconformid_correctivas_m4' => $estado_noconformid_correctivas_m4,
                'comentario_noconformid_correctivas_m4' => $comentario_noconformid_correctivas_m4,
                'cal_noconformid_correctivas_m4'=>1]);
    }
    public function guardar_validacion_doc9(Request $request,$id_documentacion_encar){
        $estado_resu_seg_med_m4 = $request->input("estado_resu_seg_med_m4");

        if($estado_resu_seg_med_m4  == 1){
            $comentario_resu_seg_med_m4 ="";
        }else{
            $comentario_resu_seg_med_m4 = $request->input("comentario_resu_seg_med_m4");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_resu_seg_med_m4' => $estado_resu_seg_med_m4,
                'comentario_resu_seg_med_m4' => $comentario_resu_seg_med_m4,
                'cal_resu_seg_med_m4'=>1]);
    }
    public function guardar_validacion_doc10(Request $request,$id_documentacion_encar){
        $estado_cumplimiento_req_m4 = $request->input("estado_cumplimiento_req_m4");

        if($estado_cumplimiento_req_m4  == 1){
            $comentario_cumplimiento_req_m4 ="";
        }else{
            $comentario_cumplimiento_req_m4 = $request->input("comentario_cumplimiento_req_m4");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_cumplimiento_req_m4' => $estado_cumplimiento_req_m4,
                'comentario_cumplimiento_req_m4' => $comentario_cumplimiento_req_m4,
                'cal_cumplimiento_req_m4'=>1]);
    }
    public function guardar_validacion_doc11(Request $request,$id_documentacion_encar){
        $estado_resultado_audi_m4 = $request->input("estado_resultado_audi_m4");

        if($estado_resultado_audi_m4  == 1){
            $comentario_resultado_audi_m4 ="";
        }else{
            $comentario_resultado_audi_m4 = $request->input("comentario_resultado_audi_m4");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_resultado_audi_m4' => $estado_resultado_audi_m4,
                'comentario_resultado_audi_m4' => $comentario_resultado_audi_m4,
                'cal_resultado_audi_m4'=>1]);
    }
    public function guardar_validacion_doc12(Request $request,$id_documentacion_encar){
        $estado_adecuacion_recurso_m5 = $request->input("estado_adecuacion_recurso_m5");

        if($estado_adecuacion_recurso_m5  == 1){
            $comentario_adecuacion_recurso_m5 ="";
        }else{
            $comentario_adecuacion_recurso_m5 = $request->input("comentario_adecuacion_recurso_m5");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_adecuacion_recurso_m5' => $estado_adecuacion_recurso_m5,
                'comentario_adecuacion_recurso_m5' => $comentario_adecuacion_recurso_m5,
                'cal_adecuacion_recurso_m5'=>1]);
    }
    public function guardar_validacion_doc13(Request $request,$id_documentacion_encar){
        $estado_comunicacion_pertinente_m6 = $request->input("estado_comunicacion_pertinente_m6");

        if($estado_comunicacion_pertinente_m6  == 1){
            $comentario_comunicacion_pertinente_m6 ="";
        }else{
            $comentario_comunicacion_pertinente_m6 = $request->input("comentario_comunicacion_pertinente_m6");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_comunicacion_pertinente_m6' => $estado_comunicacion_pertinente_m6,
                'comentario_comunicacion_pertinente_m6' => $comentario_comunicacion_pertinente_m6,
                'cal_comunicacion_pertinente_m6'=>1]);
    }
    public function guardar_validacion_doc14(Request $request,$id_documentacion_encar){
        $estado_oportunidades_mejora_m7 = $request->input("estado_oportunidades_mejora_m7");

        if($estado_oportunidades_mejora_m7  == 1){
            $comentario_oportunidades_mejora_m7 ="";
        }else{
            $comentario_oportunidades_mejora_m7 = $request->input("comentario_oportunidades_mejora_m7");
        }
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_oportunidades_mejora_m7' => $estado_oportunidades_mejora_m7,
                'comentario_oportunidades_mejora_m7' => $comentario_oportunidades_mejora_m7,
                'cal_oportunidades_mejora_m7'=>1]);
    }
    public function enviar_correciones_documentacion($id_documentacion_encar){
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_envio_doc' => 2,
                'fecha_registro'=>$hoy]);
        $usuario="c.computo@vbravo.tecnm.mx";
        $encargado=DB::select('SELECT amb_documentacion_encargados.*,gnral_personales.nombre,gnral_personales.correo,amb_procedimientos.nom_procedimiento 
from amb_documentacion_encargados, amb_procedimientos, amb_encargados, gnral_personales 
where amb_documentacion_encargados.id_encargado=amb_encargados.id_encargado and
      amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and 
      amb_encargados.id_personal=gnral_personales.id_personal and
      amb_documentacion_encargados.id_documentacion_encar='.$id_documentacion_encar.'');
        $correo=$encargado[0]->correo;
        Mail::send('ambiental.jefe_ambiental.notificacion_correcciones',["procedimiento"=>$encargado[0]->nom_procedimiento], function($message)use($usuario,$correo)
        {
            $message->from(Auth::user()->email, 'SUBDIRECCIÓN DE VINCULACIÓN Y EXTENSIÓN');
            $message->to($correo,"")->subject('Notificacion de Corrección de Documentación de Procedimiento de Ambiental Enviada');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        return redirect('/ambiental/ver_documentacion_ambiental');
    }
    public function enviar_aceptacion_documentacion($id_documentacion_encar){
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_envio_doc' => 4,
                'fecha_registro'=>$hoy]);
        $usuario="c.computo@vbravo.tecnm.mx";
        $encargado=DB::select('SELECT amb_documentacion_encargados.*,gnral_personales.nombre,gnral_personales.correo,amb_procedimientos.nom_procedimiento 
from amb_documentacion_encargados, amb_procedimientos, amb_encargados, gnral_personales 
where amb_documentacion_encargados.id_encargado=amb_encargados.id_encargado and
      amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and 
      amb_encargados.id_personal=gnral_personales.id_personal and
      amb_documentacion_encargados.id_documentacion_encar='.$id_documentacion_encar.'');
        $correo=$encargado[0]->correo;
        Mail::send('ambiental.jefe_ambiental.notificacion_aceptacion',["procedimiento"=>$encargado[0]->nom_procedimiento], function($message)use($usuario,$correo)
        {
            $message->from(Auth::user()->email, 'SUBDIRECCIÓN DE VINCULACIÓN Y EXTENSIÓN');
            $message->to($correo,"")->subject('Notificacion de Autorización de Documentación de Procedimiento de Ambiental Enviada');
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        return redirect('/ambiental/ver_documentacion_ambiental');

    }
    public function proceso_de_modificacion(){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $id_periodo=$periodo[0]->id_periodo_amb;

        $encargados=DB::select('SELECT amb_documentacion_encargados.*,gnral_personales.nombre,amb_procedimientos.nom_procedimiento 
from amb_documentacion_encargados, amb_procedimientos, amb_encargados, gnral_personales 
where amb_documentacion_encargados.id_encargado=amb_encargados.id_encargado and
      amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and 
      amb_encargados.id_personal=gnral_personales.id_personal and  amb_documentacion_encargados.estado_envio_doc=2 and
      amb_documentacion_encargados.id_periodo_amb='.$id_periodo.'');
       return view('ambiental.jefe_ambiental.documentacion_modificacion',compact('encargados','periodo'));
    }
    public function documentacion_autorizada(){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        return view('ambiental.jefe_ambiental.documentacion_autorizada',compact('periodo'));
    }
    public function ver_documentacion_autorizada(){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $id_periodo=$periodo[0]->id_periodo_amb;

        $encargados=DB::select('SELECT amb_documentacion_encargados.*,gnral_personales.nombre,amb_procedimientos.nom_procedimiento 
from amb_documentacion_encargados, amb_procedimientos, amb_encargados, gnral_personales 
where amb_documentacion_encargados.id_encargado=amb_encargados.id_encargado and
      amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and 
      amb_encargados.id_personal=gnral_personales.id_personal and  amb_documentacion_encargados.estado_envio_doc=4 and
      amb_documentacion_encargados.id_periodo_amb='.$id_periodo.'');
        return $encargados;
    }
    public function ver_doc_autorizada_departamento($id_documentacion_encar){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        return view('ambiental.jefe_ambiental.ver_doc_autorizada',compact('periodo','id_documentacion_encar'));

    }
    public function  historial_ambiental_departamento(){
        $periodo= DB::table('amb_periodo_amb')
            ->get();

        return view('ambiental.jefe_ambiental.historial_documentacion',compact('periodo'));


    }
    public function ver_doc_encargado_aut($id_documentacion_encar){
        $documentacion= DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->get();
        $id_periodo=$documentacion[0]->id_periodo_amb;
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.id_periodo_amb','=',$id_periodo)
            ->get();
        return view('ambiental.jefe_ambiental.historial_ver_doc_encargado',compact('periodo','id_documentacion_encar'));

    }
    public function ver_doc_encargado_dep_aut($id_documentacion_encar){
       $documentacion= DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->get();
       $id_periodo=$documentacion[0]->id_periodo_amb;
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.id_periodo_amb','=',$id_periodo)
            ->get();

        return view('ambiental.encargado_amb.ver_doc_autorizada_dep',compact('periodo','id_documentacion_encar'));

    }
    public function ver_proc_ambiental($id_periodo){

        return view('ambiental.jefe_ambiental.ver_procedimientos_encargados',compact('id_periodo'));
    }
    public function datos_periodos($id_periodo){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.id_periodo_amb','=',$id_periodo)
            ->get();
        return $periodo;
    }
    public function buscar_encargados_procedimientos($id_periodo){
        $procedimientos=DB::select('SELECT gnral_personales.nombre,amb_encargados.*,amb_procedimientos.nom_procedimiento
from gnral_personales,amb_encargados,amb_procedimientos
where amb_encargados.id_personal=gnral_personales.id_personal 
    and amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento  
ORDER BY amb_procedimientos.nom_procedimiento ASC');

        $i=0;
        $proce=array();
        foreach($procedimientos as $procedimiento)
        {
            $proces['id_encargado']=$procedimiento->id_encargado;
            $proces['id_personal']=$procedimiento->id_personal;
            $proces['id_procedimiento']=$procedimiento->id_procedimiento;
            $proces['nombre_encargado']=$procedimiento->nombre;
            $proces['nombre_procedimiento']=$procedimiento->nom_procedimiento;
            $reg_doc=DB::selectOne('SELECT count(id_documentacion_encar)contar 
       from amb_documentacion_encargados where id_periodo_amb='.$id_periodo.' and id_encargado='.$procedimiento->id_encargado.'');
            $reg_doc=$reg_doc->contar;
            if($reg_doc == 0){
                $proces['estado_doc']=0;
            }else{
                $proces['estado_doc']=1;
            }
            $proces['i']=++$i;
            array_push($proce,$proces);
        }
        return $proce;
    }
    public function ver_proc_encargado_doc($id_periodo,$id_encargado){
        $proc=DB::selectOne('SELECT gnral_personales.nombre, amb_procedimientos.nom_procedimiento 
        from gnral_personales,amb_encargados,amb_procedimientos where
        amb_encargados.id_personal=gnral_personales.id_personal and
        amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and amb_encargados.id_encargado='.$id_encargado.'');


        return view('ambiental.jefe_ambiental.agregar_doc_entregar',compact('id_periodo','id_encargado','proc'));

    }
    public function guardar_dat_doc(Request $request,$id_periodo,$id_encargado){
        $this->validate($request,[
            'doc1' => 'required',
            'doc2' => 'required',
            'doc3' => 'required',
            'doc4' => 'required',
            'doc5' => 'required',
            'doc6' => 'required',
            'doc7' => 'required',
            'doc8' => 'required',
            'doc9' => 'required',
            'doc10' => 'required',
            'doc11' => 'required',
            'doc12' => 'required',
            'doc13' => 'required',
            'doc14' => 'required',
        ]);
        $doc1=$request->input('doc1');
        $doc2=$request->input('doc2');
        $doc3=$request->input('doc3');
        $doc4=$request->input('doc4');
        $doc5=$request->input('doc5');
        $doc6=$request->input('doc6');
        $doc7=$request->input('doc7');
        $doc8=$request->input('doc8');
        $doc9=$request->input('doc9');
        $doc10=$request->input('doc10');
        $doc11=$request->input('doc11');
        $doc12=$request->input('doc12');
        $doc13=$request->input('doc13');
        $doc14=$request->input('doc14');
        $hoy = date("Y-m-d H:i:s");
        DB:: table('amb_documentacion_encargados')->insert(['id_encargado' =>$id_encargado,
            'id_periodo_amb' =>$id_periodo,
              'solic_estado_acc_m1'=>$doc1,
            'solic_cuestion_ambas_per_m2'=>$doc2,
            'solic_necesidades_espectativas_m2'=>$doc3,
            'solic_aspecto_ambiental_m2'=>$doc4,
            'solic_riesgo_oportu_m2'=>$doc5,
            'solic_grado_objetivo_m3'=>$doc6,
            'solic_programa_gestion_m3'=>$doc7,
            'solic_noconformid_correctivas_m4'=>$doc8,
            'solic_resu_seg_med_m4'=>$doc9,
            'solic_cumplimiento_req_m4'=>$doc10,
            'solic_resultado_audi_m4'=>$doc11,
            'solic_adecuacion_recurso_m5'=>$doc12,
            'solic_comunicacion_pertinente_m6'=>$doc13,
            'solic_oportunidades_mejora_m7'=>$doc14,
            'fecha_registro' =>$hoy]);

    }
    public function modificar_guardar_dat_doc(Request $request,$id_periodo,$id_encargado){

        $this->validate($request,[
            'doc1' => 'required',
            'doc2' => 'required',
            'doc3' => 'required',
            'doc4' => 'required',
            'doc5' => 'required',
            'doc6' => 'required',
            'doc7' => 'required',
            'doc8' => 'required',
            'doc9' => 'required',
            'doc10' => 'required',
            'doc11' => 'required',
            'doc12' => 'required',
            'doc13' => 'required',
            'doc14' => 'required',
        ]);
        $doc1=$request->input('doc1');
        $doc2=$request->input('doc2');
        $doc3=$request->input('doc3');
        $doc4=$request->input('doc4');
        $doc5=$request->input('doc5');
        $doc6=$request->input('doc6');
        $doc7=$request->input('doc7');
        $doc8=$request->input('doc8');
        $doc9=$request->input('doc9');
        $doc10=$request->input('doc10');
        $doc11=$request->input('doc11');
        $doc12=$request->input('doc12');
        $doc13=$request->input('doc13');
        $doc14=$request->input('doc14');
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $id_periodo)
            ->where('id_encargado', $id_encargado)
            ->update([
                'solic_estado_acc_m1'=>$doc1,
                'solic_cuestion_ambas_per_m2'=>$doc2,
                'solic_necesidades_espectativas_m2'=>$doc3,
                'solic_aspecto_ambiental_m2'=>$doc4,
                'solic_riesgo_oportu_m2'=>$doc5,
                'solic_grado_objetivo_m3'=>$doc6,
                'solic_programa_gestion_m3'=>$doc7,
                'solic_noconformid_correctivas_m4'=>$doc8,
                'solic_resu_seg_med_m4'=>$doc9,
                'solic_cumplimiento_req_m4'=>$doc10,
                'solic_resultado_audi_m4'=>$doc11,
                'solic_adecuacion_recurso_m5'=>$doc12,
                'solic_comunicacion_pertinente_m6'=>$doc13,
                'solic_oportunidades_mejora_m7'=>$doc14,
                'fecha_registro' =>$hoy
            ]);


    }
    public function estado_doc_validar($id_documentacion_encar){

        $documentacion= DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar','=',$id_documentacion_encar)
            ->get();
        $suma_doc=0;
        $suma_evi=0;

        if($documentacion[0]->solic_estado_acc_m1 == 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_cuestion_ambas_per_m2== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_necesidades_espectativas_m2== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_aspecto_ambiental_m2== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_riesgo_oportu_m2== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_grado_objetivo_m3== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_programa_gestion_m3== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_noconformid_correctivas_m4== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_resu_seg_med_m4== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_cumplimiento_req_m4== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_resultado_audi_m4== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_adecuacion_recurso_m5== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_comunicacion_pertinente_m6== 2){
            $suma_doc++;
        }
        if($documentacion[0]->solic_oportunidades_mejora_m7== 2){
            $suma_doc++;
        }

        if($documentacion[0]->cal_estado_acc_m1 != 0 && $documentacion[0]->solic_estado_acc_m1 == 2 ){
            $suma_evi++;
        }
        if($documentacion[0]->cal_cuestion_ambas_per_m2 != 0 && $documentacion[0]->solic_cuestion_ambas_per_m2== 2) {
            $suma_evi++;
        }
        if($documentacion[0]->cal_necesidades_espectativas_m2 != 0 && $documentacion[0]->solic_necesidades_espectativas_m2== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_aspecto_ambiental_m2 != 0 && $documentacion[0]->solic_aspecto_ambiental_m2== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_riesgo_oportu_m2 != 0 && $documentacion[0]->solic_riesgo_oportu_m2== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_grado_objetivo_m3 != 0 && $documentacion[0]->solic_grado_objetivo_m3== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_programa_gestion_m3 != 0 && $documentacion[0]->solic_programa_gestion_m3== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_noconformid_correctivas_m4 != 0 && $documentacion[0]->solic_noconformid_correctivas_m4== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_resu_seg_med_m4 != 0 && $documentacion[0]->solic_resu_seg_med_m4== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_cumplimiento_req_m4 != 0 && $documentacion[0]->solic_cumplimiento_req_m4== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_resultado_audi_m4 != 0 && $documentacion[0]->solic_resultado_audi_m4== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_adecuacion_recurso_m5 != 0 && $documentacion[0]->solic_adecuacion_recurso_m5== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_comunicacion_pertinente_m6 != 0 && $documentacion[0]->solic_comunicacion_pertinente_m6== 2){
            $suma_evi++;
        }
        if($documentacion[0]->cal_oportunidades_mejora_m7 != 0 && $documentacion[0]->solic_oportunidades_mejora_m7== 2){
            $suma_evi++;
        }
        /// suma de autorizacion
        $suma_aut=0;
        if($documentacion[0]->estado_estado_acc_m1 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_cuestion_ambas_per_m2 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_necesidades_espectativas_m2 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_aspecto_ambiental_m2 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_riesgo_oportu_m2 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_grado_objetivo_m3 == 1 ){
            $suma_aut++;
        }
        if($documentacion[0]->estado_programa_gestion_m3 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_noconformid_correctivas_m4 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_resu_seg_med_m4 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_cumplimiento_req_m4 == 1 ){
            $suma_aut++;
        }
        if($documentacion[0]->estado_resultado_audi_m4 == 1 ){
            $suma_aut++;
        }
        if($documentacion[0]->estado_adecuacion_recurso_m5 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_comunicacion_pertinente_m6 == 1){
            $suma_aut++;
        }
        if($documentacion[0]->estado_oportunidades_mejora_m7 == 1 ){
            $suma_aut++;
        }

        if($suma_doc == $suma_evi){
            if($suma_aut == $suma_doc){
                $estado=1;
            }
            else{
                $estado=3;
            }

        }else{
            $estado=2;
        }



        return $estado;
    }
}
