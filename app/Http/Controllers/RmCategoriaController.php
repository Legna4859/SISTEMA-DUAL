<?php

namespace App\Http\Controllers;

use App\RmCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \Validator;

class RmCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = RmCategoria::paginate(3);
        return view('RMateriales.RMCategorias.agregarcate', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),

            [
                'nombre' => 'required',
            ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $categorias = new RmCategoria();
        $categorias->nombre=$request->get('nombre');
        $categorias->descripcion=$request->get('descripcion');
        $categorias->save();

        //return response()->json(['success'=>'Data is succesfully added']);
        //return \redirect('Agregar-Marca')->with('message','Formulario OK');

        //\Session::flash('message','store');
        //return redirect('Agregar-Marca')->with('show_modal',true);

        //return back()->with('flash',"La Marca se ah agregado correctamente");
        return Redirect::to('/Categorias');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RmCategoria  $rmCategoria
     * @return \Illuminate\Http\Response
     */
    public function show(RmCategoria $rmCategoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RmCategoria  $rmCategoria
     * @return \Illuminate\Http\Response
     */
    public function edit(RmCategoria $rmCategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RmCategoria  $rmCategoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categorias = RmCategoria::find($id);
        $categorias->nombre = $request->input('nombre');
        $categorias->descripcion = $request->input('descripcion');
        $categorias->condicion = '1';
        $categorias->save();

        return Redirect::to('/Categorias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RmCategoria  $rmCategoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //RmCategoria::destroy($id);
        //return Redirect::to('/Agregar-Categoria');

    }
    public function activar(Request $request)
    {
        $categoria = RmCategoria::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();

        return Redirect::to('/Categorias');

    }
    public function desactivar(Request $request)
    {
        $categoria = RmCategoria::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();

        return Redirect::to('/Categorias');
    }
}
