<?php

namespace App\Http\Controllers;

use App\ri_o_mejorareputacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RiOMejorareputacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mejorareputaciones = DB::table('ri_o_mejorareputacion')
            ->orderBy('id_mejorareputacion', 'asc')
            ->get();

        return view('riesgos.mejorareputacion',compact('mejorareputaciones'));
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
            'des_mejorareputacion' => 'required',
            'calificacion' => 'required',

        ]);

        $mejorareputaciones = array(
            'des_mejorareputacion' => mb_strtoupper($request->get('des_mejorareputacion'),'utf-8'),
            'calificacion' => mb_strtoupper($request->get('calificacion'),'utf-8'),

        );

        ri_o_mejorareputacion::create($mejorareputaciones);
        return redirect('/riesgos/mejorareputacion');
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
        return (ri_o_mejorareputacion::find($id));
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
        // dd($request);
        $this->validate($request,[
            'des_mejorareputacion_modi' => 'required',
            'calificacion_modi' => 'required',

        ]);

        $selec_mod = array(
            'des_mejorareputacion' => mb_strtoupper($request->get('des_mejorareputacion_modi'),'utf-8'),
            'calificacion' => mb_strtoupper($request->get('calificacion_modi'),'utf-8'),

        );

        ri_o_mejorareputacion::find($id)->update($selec_mod);
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
        ri_o_mejorareputacion::destroy($id);
        return back();
    }
}
