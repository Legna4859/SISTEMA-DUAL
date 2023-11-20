<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Hrs_Situaciones;

class SituacionController extends Controller
{

    public function index()
    {
        $situaciones = DB::table('hrs_situaciones')
                ->orderBy('situacion', 'asc')
                ->get();
        return view('generales.situaciones',compact('situaciones'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {     
                $this->validate($request,[
                'nombre_situacion' => 'required',
                'abre_situacion' => 'required',
                ]);

                $situaciones = array(
                    'situacion' => mb_strtoupper($request->get('nombre_situacion'),'utf-8'),
                    'abrevia' => mb_strtoupper($request->get('abre_situacion'),'utf-8')
                    );

                $agrega_situacion=Hrs_Situaciones::create($situaciones);
                //flash('Los datos se han guardado correctamente','success');
                return redirect('/generales/situaciones');
    }

    public function show($id)
    {
        //
    }

    public function edit($id_situacion)
    {
        $situaciones = DB::table('hrs_situaciones')
                ->orderBy('situacion', 'asc')
                ->get();
        $situacion_edit = Hrs_Situaciones::find($id_situacion);
        return view('generales.situaciones',compact('situaciones'))->with(['edit' => true, 'situacion_edit' => $situacion_edit]);
    }

    public function update(Request $request, $id_situacion)
    {
        $this->validate($request,[
                'nombre_situacion' => 'required',
                'abre_situacion' => 'required|max:255',
                ]);

        $situaciones = array(
                    'situacion' => mb_strtoupper($request->get('nombre_situacion'),'utf-8'),
                    'abrevia' => mb_strtoupper($request->get('abre_situacion'),'utf-8')
                    );

        Hrs_Situaciones::find($id_situacion)->update($situaciones);
        //flash('Los datos se han modificado correctamente','success');
        return redirect('/generales/situaciones');

    }

    public function destroy($id_situacion)
    {
        Hrs_Situaciones::destroy($id_situacion);
        //flash('Los datos se han eliminado correctamente','danger');
        return redirect('/generales/situaciones');
    }
}
