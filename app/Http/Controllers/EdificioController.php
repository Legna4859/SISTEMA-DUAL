<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Hrs_Edificios;

class EdificioController extends Controller
{

    public function index()
    {
        $edificios = DB::table('hrs_edificios')
        ->orderBy('nombre', 'asc')
        ->get();
        $edificios = Hrs_Edificios::paginate(10);
        return view('generales.edificios',compact('edificios'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre_edificio' => 'required',
        ]);

        $edificios = array(
            'nombre' => mb_strtoupper($request->get('nombre_edificio'),'utf-8')
        );

        $agrega_edificio=Hrs_Edificios::create($edificios);
        //flash('Los datos se han guardado correctamente','success');
        return redirect('/generales/edificios');
    }

    public function show($id)
    {
        //
    }

    public function edit($id_edificio)
    {
        $edificios = DB::table('hrs_edificios')
                ->orderBy('nombre', 'asc')
                ->get();
        $edificio_edit = Hrs_Edificios::find($id_edificio);
        return view('generales.edificios',compact('edificios'))->with(['edit' => true, 'edificio_edit' => $edificio_edit]);
    }

    public function update(Request $request, $id_edificio)
    {
                $this->validate($request,[
                'nombre_edificio' => 'required',
                ]);

        $edificios = array(
                    'nombre' => mb_strtoupper($request->get('nombre_edificio'),'utf-8')
                    );

        Hrs_Edificios::find($id_edificio)->update($edificios);
        //flash('Los datos se han modificado correctamente','success');
        return redirect('/generales/edificios');
    }

    public function destroy($id_edificio)
    {
        Hrs_Edificios::destroy($id_edificio);
        //flash('Los datos se han eliminado correctamente','danger');
        return redirect('/generales/edificios');
    }
}
