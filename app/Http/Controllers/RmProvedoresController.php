<?php

namespace App\Http\Controllers;

use App\RmProvedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RmProvedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $buscar  = $request->get('buscarpor');
        $tipo = $request->get('tipo');
        $provedores = RmProvedores::buscarpor($tipo, $buscar)->paginate(3);


        return view('RMateriales.provedores',compact('provedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provedores = RmProvedores::paginate(3);
        return view('RMateriales.provedores',compact('provedores'));
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
                'nombre' => 'required',
                'contacto' => 'nullable',
                'email' => 'required',
            ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }


        $provedores = new RmProvedores();
        $provedores->nombre = $request->get('nombre');
        $provedores->contacto = $request->get('contacto');
        $provedores->email = $request->get('email');
        $provedores->save();

        /*return response()->json(['success' => 'Datos correctos']);
        echo 'Ahora ah insertado en BD';
        */
        return Redirect::to('/Provedores');//ruta hacia el archivo web.php

        }

    /**
     * Display the specified resource.
     *
     * @param  \App\RmProvedores  $rmProvedores
     * @return \Illuminate\Http\Response
     */
    public function show(RmProvedores $rmProvedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RmProvedores  $rmProvedores
     * @return \Illuminate\Http\Response
     */
    public function edit(RmProvedores $rmProvedores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RmProvedores  $rmProvedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $provedores = RmProvedores::find($id);
        $provedores->nombre = $request->input('nombre');
        $provedores->contacto = $request->input('contacto');
        $provedores->email = $request->input('email');
        $provedores->condicion = '1';
        $provedores->save();

        return Redirect::to('/Provedores');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RmProvedores  $rmProvedores
     * @return \Illuminate\Http\Response
     */
    public function destroy(RmProvedores $rmProvedores)
    {
        //
    }
    public function activar(Request $request)
    {
        $categoria = RmProvedores::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();

        return Redirect::to('/Provedores');

    }
    public function desactivar(Request $request)
    {
        $categoria = RmProvedores::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();

        return Redirect::to('/Provedores');
    }
}
