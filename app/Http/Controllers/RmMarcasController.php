<?php

namespace App\Http\Controllers;

use App\RmMarcas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class RmMarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $marca  = $request->get('buscarpor');
        $marcas = RmMarcas::where('marca','like',"%$marca%")->paginate(3);
        return view('RMateriales.marcas',compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = RmMarcas::paginate(3);
        return view('RMateriales.marcas', compact('marcas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'marca' => 'required'
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $marcas = new RmMarcas();
        $marcas->marca = $request->get('marca');
        $marcas->save();
        Session::flash('message','Your message');
        return Redirect::to('/Marcas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\RmMarcas $rmMarcas
     * @return \Illuminate\Http\Response
     */
    public function edit(RmMarcas $rmMarcas)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\RmMarcas $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marcas = RmMarcas::find($id);
        $marcas->marca = $request->input('marca');
        $marcas->condicion = '1';
        $marcas->save();

        return Redirect::to('/Marcas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\RmMarcas $rmMarcas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //echo $id;
        /*RmMarcas::destroy($id);
        return Redirect::to('/Agregar-Marca');
        */
    }
    public function activar(Request $request)
    {
        $marcas = RmMarcas::findOrFail($request->id);
        $marcas->condicion = '1';
        $marcas->save();

        return Redirect::to('/Marcas');

    }
    public function desactivar(Request $request)
    {
        $marcas = RmMarcas::findOrFail($request->id);
        $marcas->condicion = '0';
        $marcas->save();

        return Redirect::to('/Marcas');
    }

}
