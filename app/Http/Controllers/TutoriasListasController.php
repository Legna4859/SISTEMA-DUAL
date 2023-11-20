<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class TutoriasListasController extends Controller
{
   public function index(){
      $id_jefe_periodo=Session::get('id_jefe_periodo');
      $nombre_periodo=DB::selectOne('SELECT gnral_periodos.periodo, gnral_jefes_periodos.* 
      from gnral_periodos, gnral_jefes_periodos WHERE gnral_periodos.id_periodo = gnral_jefes_periodos.id_periodo 
      and gnral_jefes_periodos.id_jefe_periodo='.$id_jefe_periodo.'');
     $nombre_periodo=$nombre_periodo->periodo;

       $grupos_tutorias=DB::select('SELECT exp_asigna_tutor.*,gnral_personales.nombre,
       exp_asigna_generacion.grupo, exp_generacion.generacion from 
       exp_asigna_tutor, gnral_personales, exp_asigna_generacion, exp_generacion where 
       exp_asigna_tutor.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion 
      and exp_asigna_tutor.id_personal = gnral_personales.id_personal and exp_asigna_generacion.id_generacion= exp_generacion.id_generacion 
      and exp_asigna_tutor.id_jefe_periodo ='.$id_jefe_periodo.'  ORDER BY exp_generacion.generacion asc, exp_asigna_generacion.grupo asc ');

       $array_grupos_tutorias=array();
       foreach ($grupos_tutorias as $grupos){
           $grup['id_asigna_tutor']=$grupos->id_asigna_tutor;
           $grup['id_personal']=$grupos->id_personal;
           $grup['id_asigna_generacion']=$grupos->id_asigna_generacion;
           $grup['nombre']=$grupos->nombre;
           $grup['grupo']=$grupos->grupo;
           $grup['generacion']=$grupos->generacion;

           $estado_semestre_grup=DB::selectOne('SELECT COUNT(id_grupo_semestre)contar FROM tu_grupo_semestre where id_asigna_tutor ='.$grupos->id_asigna_tutor.'');
           $estado_semestre_grup=$estado_semestre_grup->contar;

           if($estado_semestre_grup == 0){
               $grup['id_estado_semestre']=0;
               $grup['nombre_semestre']="";
               $grup['id_grupo_semestre']="";
           }else{
               $datos_semestre=DB::selectOne('SELECT tu_grupo_tutorias.descripcion semestre, tu_grupo_semestre.* 
               FROM tu_grupo_semestre, tu_grupo_tutorias WHERE tu_grupo_semestre.id_grupo_tutorias = tu_grupo_tutorias.id_grupo_tutorias 
               and tu_grupo_semestre.id_asigna_tutor ='.$grupos->id_asigna_tutor.'');

               $grup['id_estado_semestre']=1;
               $grup['nombre_semestre']=$datos_semestre->semestre;
               $grup['id_grupo_semestre']=$datos_semestre->id_grupo_semestre;
           }
           array_push($array_grupos_tutorias, $grup);
       }
      return view('tutorias.jefe.listas_asistencias',compact('array_grupos_tutorias','nombre_periodo'));
   }
   public function agregar_semestre_grupo($id_asigna_tutor){

       $semestres=DB::select('SELECT * FROM `tu_grupo_tutorias` ORDER BY `tu_grupo_tutorias`.`descripcion` ASC');
       $datos_grupo=DB::selectOne('SELECT exp_asigna_tutor.*,gnral_personales.nombre,
       exp_asigna_generacion.grupo, exp_generacion.generacion from 
       exp_asigna_tutor, gnral_personales, exp_asigna_generacion, exp_generacion where 
       exp_asigna_tutor.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion 
      and exp_asigna_tutor.id_personal = gnral_personales.id_personal and exp_asigna_generacion.id_generacion= exp_generacion.id_generacion 
      and exp_asigna_tutor.id_asigna_tutor='.$id_asigna_tutor.' ');

       return view('tutorias.jefe.modal_reg_semestre',compact('semestres','id_asigna_tutor','datos_grupo'));

   }
   public function guardar_registro_semestre(Request $request){
       $id_asigna_tutor = $request->input("id_asigna_tutor");
       $id_grupo_tutorias = $request->input("id_grupo_tutorias");
       $hoy = date("Y-m-d H:i:s");
       DB::table('tu_grupo_semestre')->insert([
           'id_asigna_tutor'=>$id_asigna_tutor,
           'id_grupo_tutorias'=>$id_grupo_tutorias,
           'fecha_registro'=>$hoy,

       ]);
       return back();
   }
   public function modificar_semestre_grupo($id_asigna_tutor){
       $semestres=DB::select('SELECT * FROM `tu_grupo_tutorias` ORDER BY `tu_grupo_tutorias`.`descripcion` ASC');
       $datos_grupo=DB::selectOne('SELECT exp_asigna_tutor.*,gnral_personales.nombre,tu_grupo_semestre.id_grupo_semestre,tu_grupo_semestre.id_grupo_tutorias,
       exp_asigna_generacion.grupo, exp_generacion.generacion from  tu_grupo_semestre,
       exp_asigna_tutor, gnral_personales, exp_asigna_generacion, exp_generacion where 
       exp_asigna_tutor.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion 
      and exp_asigna_tutor.id_personal = gnral_personales.id_personal and exp_asigna_generacion.id_generacion= exp_generacion.id_generacion 
      and tu_grupo_semestre.id_asigna_tutor = exp_asigna_tutor.id_asigna_tutor
      and exp_asigna_tutor.id_asigna_tutor='.$id_asigna_tutor.' ');
       return view('tutorias.jefe.modal_mod_semestre',compact('semestres','id_asigna_tutor','datos_grupo'));


   }
   public function guardar_modificacion_semestre(Request $request){
       $id_grupo_semestre = $request->input("id_grupo_semestre");
       $id_grupo_tutorias = $request->input("id_grupo_tutorias");
       $hoy = date("Y-m-d H:i:s");
       DB::table('tu_grupo_semestre')
           ->where('id_grupo_semestre', $id_grupo_semestre)
           ->update(['id_grupo_tutorias' => $id_grupo_tutorias,
               'fecha_registro'=>$hoy]);
       return back();

   }
   public function ver_estudiantes_grupo($id_asigna_tutor){
       $id_jefe_periodo=Session::get('id_jefe_periodo');
       $nombre_periodo=DB::selectOne('SELECT gnral_periodos.periodo, gnral_jefes_periodos.*, gnral_carreras.nombre carrera
      from gnral_periodos, gnral_jefes_periodos, gnral_carreras WHERE gnral_periodos.id_periodo = gnral_jefes_periodos.id_periodo 
      and gnral_jefes_periodos.id_jefe_periodo= '.$id_jefe_periodo.' and  gnral_carreras.id_carrera = gnral_jefes_periodos.id_carrera ');


       $estudiantes=DB::select('SELECT gnral_alumnos.id_alumno, gnral_alumnos.cuenta,
       gnral_alumnos.nombre, gnral_alumnos.apaterno, gnral_alumnos.amaterno FROM gnral_alumnos, 
       exp_asigna_generacion, exp_asigna_alumnos, exp_asigna_tutor where exp_asigna_tutor.id_asigna_tutor= '.$id_asigna_tutor.' and 
       exp_asigna_tutor.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion and
       exp_asigna_alumnos.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion and
       exp_asigna_alumnos.id_alumno = gnral_alumnos.id_alumno  
       ORDER BY `gnral_alumnos`.`apaterno` ASC, gnral_alumnos.amaterno ASC, gnral_alumnos.nombre');
       $datos_grupo=DB::selectOne('SELECT exp_asigna_tutor.*,gnral_personales.nombre,tu_grupo_semestre.id_grupo_semestre,tu_grupo_semestre.id_grupo_tutorias,
       exp_asigna_generacion.grupo, exp_generacion.generacion,tu_grupo_tutorias.descripcion grup from  tu_grupo_semestre,
       exp_asigna_tutor, gnral_personales, exp_asigna_generacion, exp_generacion,tu_grupo_tutorias where 
       exp_asigna_tutor.id_asigna_generacion = exp_asigna_generacion.id_asigna_generacion 
      and exp_asigna_tutor.id_personal = gnral_personales.id_personal and exp_asigna_generacion.id_generacion= exp_generacion.id_generacion and tu_grupo_semestre.id_grupo_tutorias = tu_grupo_tutorias.id_grupo_tutorias
      and tu_grupo_semestre.id_asigna_tutor = exp_asigna_tutor.id_asigna_tutor
      and exp_asigna_tutor.id_asigna_tutor='.$id_asigna_tutor.' ');



       return view('tutorias.jefe.lista_estudiantes_semestre',compact('nombre_periodo','estudiantes','datos_grupo','id_asigna_tutor'));


   }
}
