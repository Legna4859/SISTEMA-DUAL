<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\in_nivel_ingles;
use App\in_profesores_ingles;
use App\in_sexo;
use App\in_titulo;

use Session;

class In_registrar_profesoresController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}
   public function index(){
       $usuario = Session::get('usuario_alumno');
       $correo = DB::selectOne('select email from users where id=' . $usuario . '');
       $nivel_ingles = in_nivel_ingles::all();
       $sexos=in_sexo::all();
       $titulos=in_titulo::all();
       return view('ingles.create_profesores',compact('correo','nivel_ingles','sexos','titulos'));
   }
   public function store(Request $request){
      // dd($request);
       $this->validate($request, [
           'nombre_profesor' => 'required',
           'ap_paterno' => 'required',
           'ap_materno' => 'required',
           'sexo' => 'required',
           'nivel_ingles' => 'required',
           'titulo' => 'required',
           'fecha_termino' => 'required',

       ]);
       $usuario = Session::get('usuario_alumno');

       $profesores = array(
           'nombre' => mb_strtoupper($request->input('nombre_profesor'), 'utf-8'),
           'apellido_paterno' => mb_strtoupper($request->input('ap_paterno'), 'utf-8'),
           'apellido_materno' => mb_strtoupper($request->input('ap_materno'), 'utf-8'),
           'id_nivel_ingles' => $request->input('nivel_ingles'),
           'id_tipo_titulo' => $request->input('titulo'),
           'fecha_emision_titulo' =>$request->input('fecha_termino'),
           'horas_maximas' =>0,
           'id_sexo' => $request->input('sexo'),
           'id_tipo_usuario' =>$usuario,

       );

     //  dd($profesores);
       //dd($profesores);
       $agrega_profesor = in_profesores_ingles::create($profesores);
       DB::update("UPDATE users SET info_ok = 2 WHERE users.id=$usuario");
       return redirect('/home');

   }
   public function periodo($id_periodo_ingles){
       $periodos_ingles= DB::select('SELECT * FROM in_periodos ORDER BY in_periodos.id_periodo_ingles ASC');
     return view('ingles.periodos_ingles',compact('periodos_ingles','id_periodo_ingles'));

   }
   public function recargar_periodo($id_periodo){
        //dd($id_periodo);
       $periodo_actual_ingles= DB::selectOne('SELECT * FROM in_periodos WHERE id_periodo_ingles ='.$id_periodo.'');
       $periodo_actual_ingles=$periodo_actual_ingles->periodo_ingles;
       Session::put('periodo_ingles',$id_periodo);
       Session::put('nombre_periodo_ingles',$periodo_actual_ingles);
       //dd($id_periodo);
       return back();
   }
   public function modificar_profesor($id_usuario){
       $nivel_ingles = in_nivel_ingles::all();
       $sexos=in_sexo::all();
       $titulos=in_titulo::all();
       $datos_profesor=DB::selectOne('SELECT * FROM in_profesores_ingles WHERE id_tipo_usuario ='.$id_usuario.'');
       return view('ingles.partials.modificar_profesor', compact('nivel_ingles', 'sexos','titulos','datos_profesor'));
   }
   public function  modificacion_profesor(Request $request){
       $this->validate($request, [
           'nombre_profesor' => 'required',
           'ap_paterno' => 'required',
           'ap_materno' => 'required',
           'sexo' => 'required',
           'nivel_ingles' => 'required',
           'titulo' => 'required',
           'fecha_termino' => 'required',

       ]);
           $nombre = mb_strtoupper($request->input('nombre_profesor'), 'utf-8');
           $apellido_paterno = mb_strtoupper($request->input('ap_paterno'), 'utf-8');
           $apellido_materno = mb_strtoupper($request->input('ap_materno'), 'utf-8');
           $id_nivel_ingles = $request->input('nivel_ingles');
           $id_tipo_titulo = $request->input('titulo');
           $fecha_emision_titulo =$request->input('fecha_termino');
           $id_sexo = $request->input('sexo');
       $usuario = Session::get('usuario_alumno');
       DB::update("UPDATE in_profesores_ingles SET nombre ='$nombre' , apellido_paterno ='$apellido_paterno' , apellido_materno ='$apellido_materno' , id_nivel_ingles =$id_nivel_ingles , id_tipo_titulo =$id_tipo_titulo , fecha_emision_titulo ='$fecha_emision_titulo' , id_sexo =$id_sexo  WHERE in_profesores_ingles.id_tipo_usuario =$usuario");
return back();

   }
}
