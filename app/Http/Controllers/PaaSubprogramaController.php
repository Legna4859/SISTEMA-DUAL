<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Paa_Subprograma;
use Session;
class PaaSubprogramaController extends Controller
{
    public function index(){
        $subprogramas=DB::select('SELECT * FROM pa_subprograma');

        return view('informe_paa.subprograma',compact('subprogramas'));

    }
    public function  store(Request $request)
    {
        $this->validate($request,[
            'nombre_subprograma' => 'required',

        ]);
        $subprograma = array(
            'nom_subprograma' => mb_strtoupper($request->get('nombre_subprograma'),'utf-8'),
        );
        $agrega_subprograma=Paa_Subprograma::create($subprograma);
        return back();
    }
public function editar($id){
    $subprograma= DB::selectOne('SELECT * FROM pa_subprograma WHERE id_subprograma =  '.$id.'');
    return response()->json($subprograma);
}
public function  modificar(Request $request,$id){
    $this->validate($request,[
        'nom_subprograma' => 'required',
    ]);
    $nombre_subprograma= mb_strtoupper($request->get('nom_subprograma'),'utf-8');
    $subprograma= Paa_Subprograma::find($id);
    $subprograma->nom_subprograma = $nombre_subprograma;
    $subprograma->save();
    return back();
}
}
