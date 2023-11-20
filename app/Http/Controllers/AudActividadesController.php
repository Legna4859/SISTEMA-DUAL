<?php

namespace App\Http\Controllers;

use App\AudActividades;
use App\ri_proceso;
use App\ri_sistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AudActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividades=AudActividades::orderBy('descripcion','ASC')->get();
        return view('auditorias.actividades_auditoria',compact('actividades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'La descripcion de la actividad es requerida',
        ]);
        if(!$validator->fails())
            AudActividades::create(array(
                'descripcion' => $request->get('descripcion'),
            ));
        else
            return back()->withErrors($validator->errors())->withInput($request->input());
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'La descripcion de la actividad es requerida',
        ]);
        if(!$validator->fails())
            AudActividades::find($id)->update(array(
                'descripcion' => $request->get('descripcion'),
            ));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        AudActividades::destroy($id);
        return back();
    }
}
