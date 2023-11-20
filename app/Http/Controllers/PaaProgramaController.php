<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Paa_Programa;
use Session;

class PaaProgramaController extends Controller
{
    public function index(){
        $programas=DB::select('SELECT * FROM pa_programa');

        return view('informe_paa.programa',compact('programas'));

    }
    public function  store(Request $request){
       // dd($request);
        $this->validate($request,[
            'desc_programa' => 'required',
        ]);

        $programa = array(
            'nom_programa' => mb_strtoupper($request->get('desc_programa'),'utf-8'),
        );

        $agrega_aula=Paa_Programa::create($programa);
        return back();
        //return redirect('/paa/programa_paa');
    }
    public function editar($id){
        $programa= DB::selectOne('SELECT * FROM pa_programa WHERE id_programa = '.$id.'');
        return response()->json($programa);
    }
    public function modificar(Request $request,$id){
       //dd($request);
        $this->validate($request,[
            'nom_programa' => 'required',
        ]);
        $nombre_programa= mb_strtoupper($request->get('nom_programa'),'utf-8');
        $programa= Paa_Programa::find($id);
        $programa->nom_programa = $nombre_programa;
        $programa->save();
        return back();
        //return redirect('/paa/programa_paa');
}

}
