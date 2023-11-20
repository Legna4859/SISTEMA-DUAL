<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ri_o_calificacion;
use Session;

class RiOCalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $calificaciones = DB::table('ri_o_calificacion')
            ->orderBy('id_calificacion', 'asc')
            ->get();

        return view('riesgos.ri_o_calificacion',compact('calificaciones'));
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
            'numero' => 'required',


        ]);

        $parte = array(
            'numero' => mb_strtoupper($request->get('numero'),'utf-8'),

        );

        ri_o_calificacion::create($parte);
        return redirect('/riesgos/calificacion');


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
        return ( ri_o_calificacion::find($id));
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
            'des_calificacion_modi' => 'required',


        ]);

        $selec_mod = array(
            'numero' => mb_strtoupper($request->get('des_calificacion_modi'),'utf-8'),


        );

        ri_o_calificacion::find($id)->update($selec_mod);
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
        ri_o_calificacion::destroy($id);
        return back();
    }
}
