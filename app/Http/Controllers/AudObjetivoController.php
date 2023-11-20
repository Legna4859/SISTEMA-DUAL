<?php

namespace App\Http\Controllers;

use App\AudObjetivo;
use Illuminate\Http\Request;

class AudObjetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $objetivos=AudObjetivo::all()->sortBy('descripcion');
        return view('auditorias.objetivos',compact('objetivos','objetivos'));
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
        $this->validate($request,[
            'descripcion' => 'required',
        ]);
        $objetivo= array(
            'descripcion' => $request->get('descripcion'),'utf-8'
        );
        AudObjetivo::create($objetivo);
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
        $this->validate($request,[
            'descripcion_modi' => 'required',
        ]);
        $objetivo= array(
            'descripcion' => $request->get('descripcion_modi'),'utf-8'
        );
        AudObjetivo::find($id)->update($objetivo);
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
        AudObjetivo::destroy($id);
        return back();
    }
}
