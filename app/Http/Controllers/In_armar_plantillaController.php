<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Session;

class In_armar_plantillaController extends Controller
{

    public function index(){
        /*
       $profesores_ingles= DB::select('SELECT in_profesores_ingles.id_profesores,in_profesores_ingles.nombre,
in_profesores_ingles.apellido_paterno,in_profesores_ingles.apellido_materno,in_nivel_ingles.descripcion nivel_ingles,
in_titulo.descripcion titulo,in_profesores_ingles.fecha_emision_titulo,in_profesores_ingles.horas_maximas,
in_sexo.descripcion sexo FROM in_profesores_ingles,in_titulo,in_sexo,in_nivel_ingles WHERE
 in_profesores_ingles.id_nivel_ingles=in_nivel_ingles.id_nivel_ingles and in_sexo.id_sexo=in_profesores_ingles.id_sexo 
and in_profesores_ingles.id_tipo_titulo=in_titulo.id_titulo');
         */
       return view('ingles.mostrar_profesores_ingles',compact('profesores_ingles'));

    }
    public function mostrar_profesore_ingles(){
        $profesores_ingles= DB::select('SELECT in_profesores_ingles.id_profesores,in_profesores_ingles.nombre,
in_profesores_ingles.apellido_paterno,in_profesores_ingles.apellido_materno,in_nivel_ingles.descripcion nivel_ingles,
in_titulo.descripcion titulo,in_profesores_ingles.fecha_emision_titulo,in_profesores_ingles.horas_maximas,
in_sexo.descripcion sexo FROM in_profesores_ingles,in_titulo,in_sexo,in_nivel_ingles WHERE
 in_profesores_ingles.id_nivel_ingles=in_nivel_ingles.id_nivel_ingles and in_sexo.id_sexo=in_profesores_ingles.id_sexo 
and in_profesores_ingles.id_tipo_titulo=in_titulo.id_titulo');
        return $profesores_ingles;
    }
    public function agregar_profesor($id_profesor){
        $profesor= DB::selectOne('SELECT * FROM in_profesores_ingles WHERE id_profesores ='.$id_profesor.'');
return view('ingles.partials.insertar_horas',compact('profesor'));
    }
    public function agregar_horas_profesor($id_profesores,$horas_maximas){

        $id_profesor_ingles = $id_profesores;
        $horas_profesor = $horas_maximas;
        DB::update('UPDATE in_profesores_ingles SET horas_maximas ='.$horas_profesor.'  WHERE in_profesores_ingles.id_profesores ='.$id_profesor_ingles.'');
    }
public function plantilla_profesor()
{
    $periodo_ingles=Session::get('periodo_ingles');
    $profesores_periodo = DB::select('SELECT in_profesores_ingles.* from in_profesores_ingles,in_plantilla_periodo
 WHERE in_profesores_ingles.id_profesores=in_plantilla_periodo.id_profesor and
  in_plantilla_periodo.id_periodo='.$periodo_ingles.'');
 $profesores= DB::select('SELECT * FROM in_profesores_ingles where in_profesores_ingles.id_profesores not in(SELECT in_plantilla_periodo.id_profesor FROM in_plantilla_periodo where id_periodo='.$periodo_ingles.') ');

 return view('ingles.plantilla_ingles_periodo',compact('profesores','profesores_periodo'));
}
public function ingles_plantilla($id_profesor){
    $profesor= DB::selectOne('SELECT * FROM in_profesores_ingles WHERE id_profesores ='.$id_profesor.'');
    return view('ingles.partials.agregar_profesor_plantilla',compact('profesor'));

}
public function agregar_ingles_plantilla(Request $request){
    $this->validate($request, [
        'id_profesor_ingles' => 'required',

    ]);
    $id_profesor_ingles = $request->input('id_profesor_ingles');
    $periodo_ingles=Session::get('periodo_ingles');
    DB:: table('in_plantilla_periodo')->insert(['id_periodo'=>$periodo_ingles,'id_profesor'=>$id_profesor_ingles]);
return back();
}
public function eliminar_profesor_plantilla(Request $request){
    $this->validate($request, [
        'id_prof' => 'required',

    ]);
    $id_profesor_ingles = $request->input('id_prof');
    $periodo_ingles=Session::get('periodo_ingles');

    DB::delete('DELETE FROM in_plantilla_periodo WHERE id_periodo='.$periodo_ingles.' and id_profesor='.$id_profesor_ingles.'');
return back();
}
}
