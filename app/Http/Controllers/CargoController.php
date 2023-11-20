<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Gnral_Cargos;

class CargoController extends Controller
{

    public function index()
    {
        $cargos = DB::table('gnral_cargos')
        ->orderBy('cargo', 'asc')
        ->get();
        return view('generales.cargos',compact('cargos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre_cargo' => 'required',
            'nombre_abrevia' => 'required'
        ]);

        $cargos = array(
            'cargo' =>  mb_strtoupper($request->get('nombre_cargo'),'utf-8'),
            'abre' =>  mb_strtoupper($request->get('nombre_abrevia'),'utf-8')
        );

        $agrega_cargo=Gnral_Cargos::create($cargos);
        return redirect('/generales/cargos');
    }

    public function show($id)
    {
        //
    }

    public function edit($id_cargo)
    {
        $cargos = DB::table('gnral_cargos')
        ->orderBy('cargo', 'asc')
        ->get();
        $cargo_edit = Gnral_Cargos::find($id_cargo);
        return view('generales.cargos',compact('cargos'))->with(['edit' => true, 'cargo_edit' => $cargo_edit]);
    }

    public function update(Request $request, $id_cargo)
    {
         $this->validate($request,[
            'nombre_cargo' => 'required',
            'nombre_abrevia' => 'required'
        ]);

        $cargos = array(
            'cargo' =>  mb_strtoupper($request->get('nombre_cargo'),'utf-8'),
            'abre' =>  mb_strtoupper($request->get('nombre_abrevia'),'utf-8')
        );

        Gnral_Cargos::find($id_cargo)->update($cargos);
        return redirect('/generales/cargos');
    }

    public function destroy($id_cargo)
    {
        Gnral_Cargos::destroy($id_cargo);
        return redirect('/generales/cargos');
    }
}
