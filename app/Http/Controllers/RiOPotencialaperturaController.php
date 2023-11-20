<?php

namespace App\Http\Controllers;

use App\ri_o_potencialapertura;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RiOPotencialaperturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $potencialaperturas = DB::table('ri_o_potencialapertura')
            ->orderBy('id_potencialapertura', 'asc')
            ->get();

        return view('riesgos.potencialapertura',compact('potencialaperturas'));
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
            'des_potencialapertura' => 'required',
            'calificacion' => 'required',

        ]);

        $potencialaperturas = array(
            'des_potencialapertura' => mb_strtoupper($request->get('des_potencialapertura'),'utf-8'),
            'calificacion' => mb_strtoupper($request->get('calificacion'),'utf-8'),

        );

        ri_o_potencialapertura::create($potencialaperturas);
        return redirect('/riesgos/potencialapertura');
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
        return (ri_o_potencialapertura::find($id));
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
            'des_potencialapertura_modi' => 'required',
            'calificacion_modi' => 'required',

        ]);

        $selec_mod = array(
            'des_potencialapertura' => mb_strtoupper($request->get('des_potencialapertura_modi'),'utf-8'),
            'calificacion' => mb_strtoupper($request->get('calificacion_modi'),'utf-8'),

        );

        ri_o_potencialapertura::find($id)->update($selec_mod);
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
        ri_o_potencialapertura::destroy($id);
        return back();
    }
}
