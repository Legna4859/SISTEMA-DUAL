<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Paa_Accion;
use Session;

class PaaAccionController extends Controller
{
    public function index(){
        $acciones=DB::select('SELECT pa_accion.id_accion,pa_accion.nom_accion,pa_unimed.id_unimed,pa_unimed.nom_unimed 
FROM pa_accion,pa_unimed where pa_accion.id_unimed=pa_unimed.id_unimed');
        $unidades=DB::select('SELECT * FROM pa_unimed ORDER BY pa_unimed.nom_unimed ASC');

        return view('informe_paa.accion',compact('acciones','unidades'));
    }
public function store(Request $request){
    $this->validate($request,[
        'nombre_accion' => 'required',
        'selectunidad' => 'required',
    ]);
    $accion = array(
        'nom_accion' => mb_strtoupper($request->get('nombre_accion'),'utf-8'),
        'id_unimed' => $request->input('selectunidad'),
    );

    $agrega_accion=Paa_Accion::create($accion);
    return back();
       // dd($request);
}
public function editar($id){
        $accion=DB::selectOne('SELECT pa_accion.id_accion,pa_accion.nom_accion,pa_unimed.id_unimed,pa_unimed.nom_unimed 
FROM pa_accion,pa_unimed where pa_accion.id_unimed=pa_unimed.id_unimed and pa_accion.id_accion='.$id.' ORDER BY pa_accion.nom_accion ASC');
        $unidades=DB::select('SELECT * FROM pa_unimed ORDER BY pa_unimed.nom_unimed ASC');
    return view('informe_paa.modificar_accion', compact('accion', 'id','unidades'));


}
public function modificar(Request $request){
    $this->validate($request,[
        'id_accion' => 'required',
        'accion' => 'required',
        'select_unidad' => 'required',
    ]);
    $id_accion= $request->get('id_accion');
    $accion= mb_strtoupper($request->get('accion'),'utf-8');
    $id_unidad= $request->get('select_unidad');

    $acciones= Paa_Accion::find($id_accion);
    $acciones->nom_accion = $accion;
    $acciones->id_unimed = $id_unidad;
    $acciones->save();
    return back();
    //return redire

        dd($request);
}
}
