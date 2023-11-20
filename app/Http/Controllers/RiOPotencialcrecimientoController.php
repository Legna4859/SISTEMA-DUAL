<?php

namespace App\Http\Controllers;

use App\ri_o_potencialcrecimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RiOPotencialcrecimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $potencialcrecimientos = DB::table('ri_o_potencialcrecimiento')
            ->orderBy('id_potencialcrecimiento', 'asc')
            ->get();

        return view('riesgos.potencialcrecimiento',compact('potencialcrecimientos'));
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
            'des_potencialcrecimiento' => 'required',
            'calificacion' => 'required',

        ]);

        $potencialcrecimientos = array(
            'des_potencialcrecimiento' => mb_strtoupper($request->get('des_potencialcrecimiento'),'utf-8'),
            'calificacion' => mb_strtoupper($request->get('calificacion'),'utf-8'),

        );

        ri_o_potencialcrecimiento::create($potencialcrecimientos);
        return redirect('/riesgos/potencialcrecimiento');
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
        return (ri_o_potencialcrecimiento::find($id));
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
            'des_potencialcrecimiento_modi' => 'required',
            'calificacion_modi' => 'required',

        ]);

        $selec_mod = array(
            'des_potencialcrecimiento' => mb_strtoupper($request->get('des_potencialcrecimiento_modi'),'utf-8'),
            'calificacion' => mb_strtoupper($request->get('calificacion_modi'),'utf-8'),

        );

        ri_o_potencialcrecimiento::find($id)->update($selec_mod);
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
        ri_o_potencialcrecimiento::destroy($id);
        return back();
    }
}
