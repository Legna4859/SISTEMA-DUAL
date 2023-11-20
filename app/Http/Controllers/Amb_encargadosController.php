<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\amb_encargados;
use App\amb_procedimientos;
use Session;
use Mail;
use Illuminate\Support\Facades\Auth;
class Amb_encargadosController extends Controller
{
    public function index(){

        return view('ambiental.jefe_ambiental.encargado_procedimientos');
    }
    public function ver_encargados()
    {
        $proce = DB::table('amb_procedimientos')
            ->orderBy('amb_procedimientos.nom_procedimiento', 'ASC')
            ->get();
        $encargados=array();
        $i=0;
        foreach($proce as $proce){
            $contar_e= DB::table('amb_encargados')
                 ->where('amb_encargados.id_procedimiento','=',$proce->id_procedimiento)
                ->select(DB::raw('count(*) as contar'))
                ->get();
            $contar_e=$contar_e[0]->contar;
            $proces['id_procedimiento']=$proce->id_procedimiento;
            $proces['nom_procedimiento']=$proce->nom_procedimiento;
            $proces['i']=++$i;
            if($contar_e == 0){ ///esta vacio el ararray
                $proces['id_encargado']="";
                $proces['id_personal']="";
                $proces['nombre_personal']="";
                $proces['status']=0;

            }else{
                $encargado= DB::table('amb_encargados')
                    ->join('gnral_personales','amb_encargados.id_personal','=','gnral_personales.id_personal')
                    ->where('amb_encargados.id_procedimiento','=',$proce->id_procedimiento)
                    ->select('amb_encargados.*','gnral_personales.nombre')
                    ->get();
                $proces['id_encargado']=$encargado[0]->id_encargado;
                $proces['id_personal']=$encargado[0]->id_personal;
                $proces['nombre_personal']=$encargado[0]->nombre;
                $proces['status']=1;
            }

            array_push($encargados,$proces);
        }
        return $encargados;
    }
    public function ver_procedimientos(){

        return view('ambiental.jefe_ambiental.procedimientos');
    }
    public function procedimientos(){
        $procedimientos=array();
        $proce = DB::table('amb_procedimientos')
            ->orderBy('amb_procedimientos.nom_procedimiento', 'ASC')
            ->get();
        $i=0;
        foreach($proce as $proce)
        {
            $proces['id_procedimiento']=$proce->id_procedimiento;
            $proces['nom_procedimiento']=$proce->nom_procedimiento;
            $proces['i']=++$i;
            array_push($procedimientos,$proces);
        }


        return $procedimientos;
    }
    public function ver_procedimiento_periodo($id_periodo){
        $procedimientos=DB::select('SELECT amb_documentacion_encargados.*,gnral_personales.nombre,amb_procedimientos.nom_procedimiento 
from amb_documentacion_encargados, amb_procedimientos, amb_encargados, gnral_personales 
where amb_documentacion_encargados.id_encargado=amb_encargados.id_encargado and
      amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and 
      amb_encargados.id_personal=gnral_personales.id_personal and
      amb_documentacion_encargados.id_periodo_amb='.$id_periodo.'');
        return $procedimientos;
    }
    public function eliminar_procedimiento($id_procedimiento){
        $eliminar=amb_procedimientos::where('id_procedimiento',$id_procedimiento)->delete();

   }
   public function registrar_procedimiento(Request  $request){
       $this->validate($request,[
           'nom_procedimiento' => 'required',
       ]);
       $nom_procedimiento = $request->input("nom_procedimiento");
       $nom_procedimiento=mb_strtoupper($nom_procedimiento ,'utf-8');
       DB:: table('amb_procedimientos')->insert(['nom_procedimiento'=>$nom_procedimiento]);
   }
   public function modificar_procedimiento(Request $request,$id_procedimiento){
       $this->validate($request,[
           'nom_procedimiento' => 'required',
       ]);
       $nom_procedimiento = $request->input("nom_procedimiento");
       $nom_procedimiento=mb_strtoupper($nom_procedimiento ,'utf-8');
       DB::table('amb_procedimientos')
           ->where('id_procedimiento', $id_procedimiento)
           ->update(['nom_procedimiento' => $nom_procedimiento]);
   }
   public function personal_tecnologico(){
       $personales = DB::table('gnral_personales')
           ->orderBy('nombre', 'ASC')
           ->get();
       return $personales;
   }
   public function guardar_encargado(Request $request, $id_procedimiento){
       $this->validate($request,[
           'nom_procedimiento' => 'required',
           'id_personal' => 'required',
       ]);
       $id_personal = $request->input("id_personal");
       $hoy = date("Y-m-d H:i:s");
       DB:: table('amb_encargados')->insert(['id_personal'=>$id_personal,'id_procedimiento'=>$id_procedimiento,'fecha_reg'=>$hoy]);
   }
   public function modificar_encargado(Request $request, $id_procedimiento){
       $this->validate($request,[
           'nom_procedimiento' => 'required',
           'id_personal' => 'required',
       ]);
       $id_personal = $request->input("id_personal");
       $hoy = date("Y-m-d H:i:s");
       DB::table('amb_encargados')
           ->where('id_procedimiento', $id_procedimiento)
           ->update(['id_personal' => $id_personal,'fecha_reg'=>$hoy]);
       }
       public function ver_periodos(){
           $contar_e= DB::table('amb_periodo_amb')
               ->where('amb_periodo_amb.estado_periodo','=',1)
               ->select(DB::raw('count(*) as contar'))
               ->get();
        return view('ambiental.jefe_ambiental.periodos_ambiental');
       }
       public function periodos_registrados(){
           $periodos=DB::table('amb_periodo_amb')
               ->orderBy('id_periodo_amb', 'ASC')
               ->get();
           return $periodos;
       }
       public function periodo_activado(){
           $contar_e= DB::table('amb_periodo_amb')
                ->where('amb_periodo_amb.estado_periodo','=',1)
               ->select(DB::raw('count(*) as contar'))
               ->get();
           return $contar_e;
       }
       public function guardar_periodo_activo($id_periodo){

           DB::table('amb_periodo_amb')
               ->where('id_periodo_amb', $id_periodo)
               ->update(['amb_periodo_amb.estado_periodo' => 1]);
       }
    public function guardar_periodo_desactivo($id_periodo){

        DB::table('amb_periodo_amb')
            ->where('id_periodo_amb', $id_periodo)
            ->update(['amb_periodo_amb.estado_periodo' => 2]);
    }
    public function enviar_documentacion_amb(){
        $activo_periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->select(DB::raw('count(*) as contar'))
            ->get();
        $activo_periodo=$activo_periodo[0]->contar;
        if($activo_periodo == 0){
        return view('ambiental.encargado_amb.desactivo_periodo');
        }else{
            $periodo= DB::table('amb_periodo_amb')
                ->where('amb_periodo_amb.estado_periodo','=',1)
                ->get();
            $id_usuario = Session::get('usuario_alumno');
            $id_personal= DB::table('gnral_personales')
                ->where('gnral_personales.tipo_usuario','=',$id_usuario)
                ->get();
            $id_personal=$id_personal[0]->id_personal;
            $procedimientos= DB::table('amb_encargados')
                    ->join('amb_procedimientos','amb_procedimientos.id_procedimiento','=','amb_encargados.id_procedimiento')
                    ->where('amb_encargados.id_personal','=',$id_personal)
                    ->select('amb_encargados.*','amb_procedimientos.nom_procedimiento')
                ->get();

            return view('ambiental.encargado_amb.activo_periodo',compact('periodo','procedimientos'));
        }

    }
    public function historial_documentacion_amb(){

        return view('ambiental.encargado_amb.historial_envio_documentacion');

    }
    public function ver_procedimiento_encargado($id_periodo){
        $id_usuario = Session::get('usuario_alumno');
        $id_personal= DB::table('gnral_personales')
            ->where('gnral_personales.tipo_usuario','=',$id_usuario)
            ->get();
        $id_personal=$id_personal[0]->id_personal;
        $procedimientos=DB::select('SELECT amb_documentacion_encargados.*,gnral_personales.nombre,amb_procedimientos.nom_procedimiento 
from amb_documentacion_encargados, amb_procedimientos, amb_encargados, gnral_personales 
where amb_documentacion_encargados.id_encargado=amb_encargados.id_encargado and
      amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and 
      amb_encargados.id_personal=gnral_personales.id_personal and
      gnral_personales.id_personal='.$id_personal.' and 
      amb_documentacion_encargados.id_periodo_amb='.$id_periodo.'');
        return $procedimientos;
    }
    public function estado_documentacion_amb($id_encargado){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $id_periodo=$periodo[0]->id_periodo_amb;

        $contar=DB::selectOne('SELECT count( 	id_documentacion_encar) contar 
        from amb_documentacion_encargados where id_periodo_amb='.$id_periodo.' and id_encargado='.$id_encargado.' ');

        $estado_actual=0;
        if($contar->contar == 0){
            $estado_actual=0;
        } else{
            $contar1=DB::selectOne('SELECT *from amb_documentacion_encargados where id_periodo_amb='.$id_periodo.' and id_encargado='.$id_encargado.' ');
            $contar1=$contar1->estado_envio_doc;
            //verificacion de estado de envio de la documentacion 0 todavia no enviado 1 enviado
            if($contar1 == 0) {
                $estado_actual = 1;
            }
            elseif($contar1 == 1) {
                $estado_actual = 2;
            }
            elseif($contar1 == 2) {
                $estado_actual = 3;
            }
            elseif($contar1 == 3) {
                $estado_actual = 2;
            }
            elseif($contar1 == 4) {
                $estado_actual = 4;
            }
        }
        return $estado_actual;


    }
    public function ver_estado_documentacion_amb($id_encargado){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $id_periodo=$periodo[0]->id_periodo_amb;
        $procedimiento= DB::table('amb_encargados')
            ->join('amb_procedimientos','amb_encargados.id_procedimiento','=','amb_procedimientos.id_procedimiento')
            ->where('amb_encargados.id_encargado','=',$id_encargado)
            ->select('amb_encargados.*','amb_procedimientos.nom_procedimiento')
            ->get();

        /*
        $estado_doc=DB::selectOne('SELECT count( 	id_documentacion_encar) contar 
        from amb_documentacion_encargados where id_periodo_amb='.$id_periodo.' and id_encargado='.$id_encargado.' ');
        $estado_doc=$estado_doc->contar;
        dd($estado_doc);
        */
        return view('ambiental.encargado_amb.procedimiento_doc',compact('id_encargado','periodo','procedimiento'));

    }
    public function estado_documentacion_encargado($id_encargado){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $id_periodo=$periodo[0]->id_periodo_amb;
        $documentacion= DB::table('amb_documentacion_encargados')
            ->where('amb_documentacion_encargados.id_periodo_amb','=',$id_periodo)
            ->where('amb_documentacion_encargados.id_encargado','=',$id_encargado)
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

        if($documentacion[0]->evi_estado_acc_m1 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_cuestion_ambas_per_m2 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_necesidades_espectativas_m2 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_aspecto_ambiental_m2 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_riesgo_oportu_m2 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_grado_objetivo_m3 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_programa_gestion_m3 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_noconformid_correctivas_m4 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_resu_seg_med_m4 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_cumplimiento_req_m4 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_resultado_audi_m4 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_adecuacion_recurso_m5 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_comunicacion_pertinente_m6 != 0){
            $suma_evi++;
        }
        if($documentacion[0]->evi_oportunidades_mejora_m7 != 0){
            $suma_evi++;
        }
        if($suma_doc == 0)
        {
            $estado = 2;
        }else {
            if ($suma_doc == $suma_evi) {
                $estado = 1;
            } else {
                $estado = 0;
            }
        }
        return $estado;

    }
    public function registrar_doc_1(Request $request,$id_encargado){
        $this->validate($request,[
            'file' => 'required',
        ]);



        $file=$request->file('file');
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $periodo_nom=$periodo[0]->fecha_an.'_'.$periodo[0]->fecha_mes;
        $name="evi_estado_acc_m1 _".$periodo_nom."_".$id_encargado.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/sub_vinculacion/',$name);
        $hoy = date("Y-m-d H:i:s");
        DB:: table('amb_documentacion_encargados')->insert(['id_encargado' =>$id_encargado,
            'id_periodo_amb' =>$periodo[0]->id_periodo_amb,
            'evi_estado_acc_m1'=>1,
            'pdf_estado_acc_m1'=>$name,'fecha_registro' =>$hoy]);


    }
    public function modificar_doc_1(Request $request,$id_encargado){
        $this->validate($request,[
            'file' => 'required',
        ]);



        $file=$request->file('file');
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $periodo_nom=$periodo[0]->fecha_an.'_'.$periodo[0]->fecha_mes;
        $name="evi_estado_acc_m1 _".$periodo_nom."_".$id_encargado.".".$file->getClientOriginalExtension();
        $file->move(public_path().'/sub_vinculacion/',$name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_estado_acc_m1'=>1,
                'pdf_estado_acc_m1'=>$name,'fecha_registro' =>$hoy]);
    }
    public function ver_documentacion_encargado($id_encargado){
        $periodo= DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo','=',1)
            ->get();
        $id_periodo=$periodo[0]->id_periodo_amb;

        $documentacion=DB::select('SELECT *from amb_documentacion_encargados where id_periodo_amb='.$id_periodo.' and id_encargado='.$id_encargado.' ');
        return $documentacion;
    }
    public function respuestas(){
        $respuestas=DB::select('SELECT * FROM `amb_respuestas` ');
        return $respuestas;
    }

    public function modificar_doc_2condoc(Request $request,$id_encargado){
            $this->validate($request, [
                'file' => 'required',
            ]);


            $file = $request->file('file');
            $periodo = DB::table('amb_periodo_amb')
                ->where('amb_periodo_amb.estado_periodo', '=', 1)
                ->get();
            $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
            $name = "evi_cuestion_ambas_per_m2_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/sub_vinculacion/', $name);
            $hoy = date("Y-m-d H:i:s");
            DB::table('amb_documentacion_encargados')
                ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
                ->where('id_encargado', $id_encargado)
                ->update(['evi_cuestion_ambas_per_m2' => 1,
                    'pdf_cuestion_ambas_per_m2' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_2sindoc($id_encargado){
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_cuestion_ambas_per_m2' => 2,
                'pdf_cuestion_ambas_per_m2' => "", 'fecha_registro' => $hoy]);
    }
    public function modificar_doc_3condoc(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an .'_'. $periodo[0]->fecha_mes;
        $name = "evi_necesidades_espectativas_m2_". $periodo_nom ."_". $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_necesidades_espectativas_m2' => 1,
                'pdf_necesidades_espectativas_m2' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_3sindoc($id_encargado){
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_necesidades_espectativas_m2' => 2,
                'pdf_necesidades_espectativas_m2' => "", 'fecha_registro' => $hoy]);
    }
    public function modificar_doc_4(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_aspecto_ambiental_m2_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_aspecto_ambiental_m2' => 1,
                'pdf_aspecto_ambiental_m2' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_5(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_riesgo_oportu_m2_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_riesgo_oportu_m2' => 1,
                'pdf_riesgo_oportu_m2' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_6(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_grado_objetivo_m3_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_grado_objetivo_m3' => 1,
                'pdf_grado_objetivo_m3' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_7(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_programa_gestion_m3_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_programa_gestion_m3' => 1,
                'pdf_programa_gestion_m3' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_8(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_noconformid_correctivas_m4_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_noconformid_correctivas_m4' => 1,
                'pdf_noconformid_correctivas_m4' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_9(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_resu_seg_med_m4_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_resu_seg_med_m4' => 1,
                'pdf_resu_seg_med_m4' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_10(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_cumplimiento_req_m4_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_cumplimiento_req_m4' => 1,
                'pdf_cumplimiento_req_m4' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_11(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_resultado_audi_m4_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_resultado_audi_m4' => 1,
                'pdf_resultado_audi_m4' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_12condoc(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an .'_'. $periodo[0]->fecha_mes;
        $name = "evi_adecuacion_recurso_m5_". $periodo_nom ."_". $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_adecuacion_recurso_m5' => 1,
                'pdf_adecuacion_recurso_m5' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_12sindoc($id_encargado){
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_adecuacion_recurso_m5' => 2,
                'pdf_adecuacion_recurso_m5' => "", 'fecha_registro' => $hoy]);
    }
    public function modificar_doc_13(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an . '_' . $periodo[0]->fecha_mes;
        $name = "evi_comunicacion_pertinente_m6_" . $periodo_nom . "_" . $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_comunicacion_pertinente_m6' => 1,
                'pdf_comunicacion_pertinente_m6' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_14condoc(Request $request,$id_encargado){
        $this->validate($request, [
            'file' => 'required',
        ]);


        $file = $request->file('file');
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $periodo_nom = $periodo[0]->fecha_an .'_'. $periodo[0]->fecha_mes;
        $name = "evi_oportunidades_mejora_m7_". $periodo_nom ."_". $id_encargado . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/sub_vinculacion/', $name);
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_oportunidades_mejora_m7' => 1,
                'pdf_oportunidades_mejora_m7' => $name, 'fecha_registro' => $hoy]);

    }
    public function modificar_doc_14sindoc($id_encargado){
        $periodo = DB::table('amb_periodo_amb')
            ->where('amb_periodo_amb.estado_periodo', '=', 1)
            ->get();
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_periodo_amb', $periodo[0]->id_periodo_amb)
            ->where('id_encargado', $id_encargado)
            ->update(['evi_oportunidades_mejora_m7' => 2,
                'pdf_oportunidades_mejora_m7' => "", 'fecha_registro' => $hoy]);
    }
    public function enviar_documentacion($id_documentacion_encar){
        $documentacion= DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar','=',$id_documentacion_encar)
            ->get();
        $id_encargado=$documentacion[0]->id_encargado;
        $pro=DB::selectOne('SELECT gnral_personales.nombre,amb_procedimientos.nom_procedimiento,amb_encargados.*
from gnral_personales, amb_procedimientos,amb_encargados where
        amb_encargados.id_personal=gnral_personales.id_personal and 
        amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and amb_encargados.id_encargado='.$id_encargado.'');
        $nombre_encargado=$pro->nombre;
        $nombre_procedimiento=$pro->nom_procedimiento;
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_envio_doc' => 1,
                 'fecha_registro' => $hoy]);
        $jefe_vinculacion=DB::selectOne('SELECT gnral_personales.* from gnral_unidad_personal, gnral_personales
WHERE gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin=17');
        $jefe_correo=$jefe_vinculacion->correo;
        Mail::send('ambiental.encargado_amb.notificacion_envio_doc',["procedimiento"=>$nombre_procedimiento,"nombre"=>$nombre_encargado], function($message)use($nombre_encargado,$jefe_correo,$nombre_procedimiento)
        {
            $message->from(Auth::user()->email, 'Encargado del Procedimiento: '.$nombre_encargado);
            $message->to($jefe_correo,"")->subject('Notificacion de Envio de la Documentación del Procedimiento '.$nombre_procedimiento);
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
    }

    public function enviar_documentacion_mod($id_documentacion_encar){
        $documentacion= DB::table('amb_documentacion_encargados')
             ->where('id_documentacion_encar','=',$id_documentacion_encar)
            ->get();
        $id_encargado=$documentacion[0]->id_encargado;
        $pro=DB::selectOne('SELECT gnral_personales.nombre,amb_procedimientos.nom_procedimiento,amb_encargados.*
from gnral_personales, amb_procedimientos,amb_encargados where
        amb_encargados.id_personal=gnral_personales.id_personal and 
        amb_encargados.id_procedimiento=amb_procedimientos.id_procedimiento and amb_encargados.id_encargado='.$id_encargado.'');
        $nombre_encargado=$pro->nombre;
        $nombre_procedimiento=$pro->nom_procedimiento;

        if($documentacion[0]->estado_estado_acc_m1 == 2 ){
            $cal_estado_acc_m1=0;
        }else{
            $cal_estado_acc_m1=1;
        }
        if($documentacion[0]->estado_cuestion_ambas_per_m2 == 2){
              $cal_cuestion_ambas_per_m2=0;
        }else{
            $cal_cuestion_ambas_per_m2=1;
        }
        if($documentacion[0]->estado_necesidades_espectativas_m2 ==2){
            $cal_necesidades_espectativas_m2=0;
        }else{
            $cal_necesidades_espectativas_m2=1;
        }
        if($documentacion[0]->estado_aspecto_ambiental_m2 ==2){
          $cal_aspecto_ambiental_m2=0;
        }else{
            $cal_aspecto_ambiental_m2=1;
        }
        if($documentacion[0]->estado_riesgo_oportu_m2 == 2){
            $cal_riesgo_oportu_m2=0;
        }else{
            $cal_riesgo_oportu_m2=1;
        }
        if($documentacion[0]->estado_grado_objetivo_m3 == 2){
            $cal_grado_objetivo_m3=0;
        }else{
          $cal_grado_objetivo_m3=1;
        }
        if($documentacion[0]->estado_programa_gestion_m3 == 2){
            $cal_programa_gestion_m3=0;
        }else{
            $cal_programa_gestion_m3=1;
        }
        if($documentacion[0]->estado_noconformid_correctivas_m4 == 2){
            $cal_noconformid_correctivas_m4=0;
        }else{
            $cal_noconformid_correctivas_m4=1;
        }
        if($documentacion[0]->estado_resu_seg_med_m4 == 2 ){
           $cal_resu_seg_med_m4=0;
        }else{
            $cal_resu_seg_med_m4=1;
        }
        if($documentacion[0]->estado_cumplimiento_req_m4 == 2){
           $cal_cumplimiento_req_m4=0;
        }else{
            $cal_cumplimiento_req_m4=1;
        }
        if($documentacion[0]->estado_resultado_audi_m4 == 2){
            $cal_resultado_audi_m4 =0;
        }else{
            $cal_resultado_audi_m4 = 1;
        }
        if($documentacion[0]->estado_adecuacion_recurso_m5 == 2){
             $cal_adecuacion_recurso_m5 = 0;
        }else{
            $cal_adecuacion_recurso_m5 = 1;
        }
        if($documentacion[0]->estado_comunicacion_pertinente_m6 == 2){
            $cal_comunicacion_pertinente_m6=0;
        }else{
           $cal_comunicacion_pertinente_m6=1;
        }
        if($documentacion[0]->estado_oportunidades_mejora_m7 == 2){
           $cal_oportunidades_mejora_m7=0;
        }else{
            $cal_oportunidades_mejora_m7=1;
        }

        $jefe_vinculacion=DB::selectOne('SELECT gnral_personales.* from gnral_unidad_personal, gnral_personales
WHERE gnral_unidad_personal.id_personal=gnral_personales.id_personal and gnral_unidad_personal.id_unidad_admin=17');
        $jefe_correo=$jefe_vinculacion->correo;
        Mail::send('ambiental.encargado_amb.notificacion_envio_doc',["procedimiento"=>$nombre_procedimiento,"nombre"=>$nombre_encargado], function($message)use($nombre_encargado,$jefe_correo,$nombre_procedimiento)
        {
            $message->from(Auth::user()->email, 'Encargado del Procedimiento: '.$nombre_encargado);
            $message->to($jefe_correo,"")->subject('Notificacion de Envio de Modificación de la Documentación del Procedimiento '.$nombre_procedimiento);
            // $message->attach(public_path('pdf/fracciones/'.$name));
        });
        $hoy = date("Y-m-d H:i:s");
        DB::table('amb_documentacion_encargados')
            ->where('id_documentacion_encar', $id_documentacion_encar)
            ->update(['estado_envio_doc' => 3,
                'cal_estado_acc_m1' => $cal_estado_acc_m1,
                'cal_cuestion_ambas_per_m2' => $cal_cuestion_ambas_per_m2,
                'cal_necesidades_espectativas_m2' => $cal_necesidades_espectativas_m2,
                'cal_aspecto_ambiental_m2' => $cal_aspecto_ambiental_m2,
                'cal_riesgo_oportu_m2' => $cal_riesgo_oportu_m2,
                'cal_grado_objetivo_m3' => $cal_grado_objetivo_m3,
                'cal_programa_gestion_m3' => $cal_programa_gestion_m3,
                'cal_noconformid_correctivas_m4' => $cal_noconformid_correctivas_m4,
                'cal_resu_seg_med_m4' => $cal_resu_seg_med_m4,
                'cal_cumplimiento_req_m4' => $cal_cumplimiento_req_m4,
                'cal_resultado_audi_m4' => $cal_resultado_audi_m4,
                'cal_adecuacion_recurso_m5' => $cal_adecuacion_recurso_m5,
                'cal_comunicacion_pertinente_m6' => $cal_comunicacion_pertinente_m6,
                'cal_oportunidades_mejora_m7' => $cal_oportunidades_mejora_m7,
                'fecha_registro' => $hoy]);
    }
    public function estado_registro_encargado($id_periodo,$id_encargado){


        $contar=DB::selectOne('SELECT count( 	id_documentacion_encar) contar 
        from amb_documentacion_encargados where id_periodo_amb='.$id_periodo.' and id_encargado='.$id_encargado.' ');


        if($contar->contar == 0){
            $estado_actual=0;
        } else{
            $estado_actual=1;
        }
        return $estado_actual;


    }
}
