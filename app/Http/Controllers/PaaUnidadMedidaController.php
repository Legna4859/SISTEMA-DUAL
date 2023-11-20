<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Paa_UnidadMedida;
use Session;

class PaaUnidadMedidaController extends Controller
{
    public function index(){
        $unidadmedidas=DB::select('SELECT * FROM pa_unimed ORDER BY pa_unimed.nom_unimed ASC');
        return view('informe_paa.unidad_medida',compact('unidadmedidas'));

    }
    public function store(Request $request){
        $this->validate($request,[
            'nombre_unidad' => 'required',

        ]);
        $unidad = array(
            'nom_unimed' => mb_strtoupper($request->get('nombre_unidad'),'utf-8'),
        );
        $agrega_unidad=Paa_UnidadMedida::create($unidad);
        return back();
    }
    public function editar($id){
        $unidad= DB::selectOne('SELECT * FROM pa_unimed WHERE id_unimed =  '.$id.'');
        return response()->json($unidad);
    }
    public function  modificar(Request $request,$id){
        $this->validate($request,[
            'unidad' => 'required',
        ]);
        $unidad= mb_strtoupper($request->get('unidad'),'utf-8');
        $unidades= Paa_UnidadMedida::find($id);
        $unidades->nom_unimed = $unidad;
        $unidades->save();
        return back();
    }
}
