<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class Resi_agregar_empresaController extends Controller
{
    public function index(){
       $empresas= DB::select('SELECT * FROM `resi_empresa` ORDER BY `resi_empresa`.`nombre` ASC ');
      // dd($empresa);
return view('residencia.empresas',compact('empresas'));
}
public  function modificar_empresa($id_empresa){
      $empresa=DB::selectOne('SELECT * FROM resi_empresa WHERE id_empresa='.$id_empresa.'');
//dd($empresa);
        return view('residencia.partials.modificar_empresa',compact('empresa'));

}
public  function modificacion_empresa(Request $request){
    $this->validate($request,[
        'id_empresa' => 'required',
        'nombre' => 'required',
        'domicilio' => 'required',
        'telefono' => 'required',
        'correo' => 'required',
        'director_general' => 'required',
    ]);
    $id_empresa = $request->input("id_empresa");
    $nombre = $request->input("nombre");
    $domicilio = $request->input("domicilio");
    $telefono = $request->input("telefono");
    $correo = $request->input("correo");
    $director_general = $request->input("director_general");

    DB::update("UPDATE resi_empresa SET nombre='$nombre',domicilio='$domicilio',tel_empresa='$telefono',correo='$correo',dir_gral='$director_general'  WHERE resi_empresa.id_empresa=$id_empresa");
return back();
}
public function insertar_empresa(Request $request){
    $this->validate($request,[
        'nombre' => 'required',
        'domicilio' => 'required',
        'telefono' => 'required',
        'correo' => 'required',
        'director_general' => 'required',
    ]);
    $nombre = $request->input("nombre");
    $domicilio = $request->input("domicilio");
    $telefono = $request->input("telefono");
    $correo = $request->input("correo");
    $director_general = $request->input("director_general");
    DB:: table('resi_empresa')->insert(['nombre' =>$nombre,'domicilio' =>$domicilio,'tel_empresa' =>$telefono,'correo'=>$correo,'dir_gral'=>$director_general]);
return back();
}
public function agregar_empresa(){
    $empresa= DB::select('SELECT * FROM `resi_empresa` ORDER BY `resi_empresa`.`nombre` ASC ');
    $sectores=DB::select('SELECT * FROM `resi_sector`');
    $giros=DB::select('SELECT * FROM `resi_giro`');
    $id_usuario = Session::get('usuario_alumno');
    $periodo = Session::get('periodo_actual');
    $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
    $alumno=$datosalumno->id_alumno;
    $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
    if($anteproyecto == null){
    $reg_empresa = 0;
    $proyecto_empresa = 0;
    $emp = 0;
}
else {
    $registro_empresa = DB::selectOne('SELECT count(id_proy_empresa) registro FROM resi_proy_empresa WHERE id_anteproyecto =' . $anteproyecto->id_anteproyecto . '');
    $registro_empresa = $registro_empresa->registro;
    if ($registro_empresa == 0) {
        $reg_empresa = 0;
        $proyecto_empresa = 0;
        $emp = 0;
    } else {
        $reg_empresa = 1;
        $proyecto_empresa = DB::selectOne('SELECT * FROM resi_proy_empresa WHERE id_anteproyecto =' . $anteproyecto->id_anteproyecto . '');
//dd($proyecto_empresa);
        $emp = DB::selectOne('SELECT * FROM resi_empresa WHERE id_empresa =' . $proyecto_empresa->id_empresa . '');

    }
}   //dd($emp);

return view('residencia.agregar_empresa_anteproyecto',compact('emp','empresa','anteproyecto','reg_empresa','proyecto_empresa','sectores','giros'));

}
public function datos_empresa($id_empresa){
        $empresa=DB::selectOne('SELECT * FROM `resi_empresa` WHERE `id_empresa` ='.$id_empresa.'');
    return response()->json($empresa);

}
public function registrar_empresa_asesor(Request $request){
        //dd($request);

    $this->validate($request,[
        'id_anteproyecto' => 'required',
        'asesor' => 'required',
        'puesto_asesor' => 'required',
        'empresa' => 'required',
        'sector' => 'required',
        'giro' => 'required',
        'informacion_empresa' => 'required',

    ]);
    $id_anteproyecto = $request->input("id_anteproyecto");
    $asesor = $request->input("asesor");
    $puesto_asesor = $request->input("puesto_asesor");
    $empresa = $request->input("empresa");
    $sector = $request->input("sector");
    $giro = $request->input("giro");
    $informacion_empresa = $request->input("informacion_empresa");
    DB:: table('resi_proy_empresa')->insert(['id_empresa' =>$empresa,'id_anteproyecto' =>$id_anteproyecto,'asesor' =>$asesor,'puesto'=>$puesto_asesor,'id_giro'=> $giro, 'id_sector'=> $sector, 'informacion_empresa'=> $informacion_empresa]);
return back();
}
public function modificar_empresa_asesor(Request $request){
   // dd($request);
    $this->validate($request,[
        'id_anteproyecto' => 'required',
        'asesor' => 'required',
        'puesto_asesor' => 'required',
        'empresa' => 'required',
        'sector' => 'required',
        'giro' => 'required',
        'informacion_empresa' => 'required',

    ]);
    $id_anteproyecto = $request->input("id_anteproyecto");
    $asesor = $request->input("asesor");
    $puesto_asesor = $request->input("puesto_asesor");
    $empresa = $request->input("empresa");
    $sector = $request->input("sector");
    $giro = $request->input("giro");
    $informacion_empresa = $request->input("informacion_empresa");
    DB::update("UPDATE resi_proy_empresa SET id_empresa ='$empresa',asesor='$asesor',puesto='$puesto_asesor',id_giro='$giro',id_sector='$sector',informacion_empresa='$informacion_empresa' WHERE resi_proy_empresa.id_anteproyecto=$id_anteproyecto");
return back();
}
}
