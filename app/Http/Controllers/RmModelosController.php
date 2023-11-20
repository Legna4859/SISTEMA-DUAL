<?php

namespace App\Http\Controllers;

use App\RmModelos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RmModelosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modelo  = $request->get('buscarpor');
        $modelos = RmModelos::where('modelo','like',"%$modelo%")->paginate(3);


        return view('RMateriales.modelos',compact('modelos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelos = RmModelos::paginate(3);
        return view('RMateriales.modelos',compact('modelos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =\Validator::make($request->all(),
            [
                'modelo' => 'required'
            ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }


        $modelos = new RmModelos();
        $modelos->modelo = $request->get('modelo');
        $modelos->save();

        /*return response()->json(['success' => 'Datos correctos']);
        echo 'Ahora ah insertado en BD';
        */
        return Redirect::to('/Modelos');//ruta hacia el archivo web.php
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RmModelos  $rmModelos
     * @return \Illuminate\Http\Response
     */
    public function show(RmModelos $rmModelos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RmModelos  $rmModelos
     * @return \Illuminate\Http\Response
     */
    public function edit(RmModelos $rmModelos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RmModelos  $rmModelos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelos = RmModelos::find($id);
        $modelos->modelo = $request->input('modelo');
        $modelos->condicion = '1';
        $modelos->save();

        return Redirect::to('/Modelos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RmModelos  $rmModelos
     * @return \Illuminate\Http\Response
     */
    public function destroy(RmModelos $rmModelos)
    {
        //
    }
    public function activar(Request $request)
    {
        $categoria = RmModelos::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();

        return Redirect::to('/Modelos');

    }
    public function desactivar(Request $request)
    {
        $categoria = RmModelos::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();

        return Redirect::to('/Modelos');
    }
}
