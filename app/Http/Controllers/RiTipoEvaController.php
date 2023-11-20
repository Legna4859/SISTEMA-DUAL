<?php

namespace App\Http\Controllers;

use App\ri_tipo_eva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ri_tipoeva;
use App\Http\Controllers\Controller;

class RiTipoEvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $evaluaciones = DB::table('ri_tipo_eva')
            ->orderBy('des_eva', 'asc')
            ->get();

        return view('riesgos.tipoeva',compact('evaluaciones'));
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
        //dd($request);
        $this->validate($request,[
            'des_tipoeva' => 'required',


        ]);

        $evaluacion = array(
            'des_eva' => mb_strtoupper($request->get('des_tipoeva'),'utf-8'),

        );

        ri_tipo_eva::create($evaluacion);
        return redirect('/riesgos/tipoeva');
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
        return (ri_tipo_eva::find($id));
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
            'des_tipoeva_modi' => 'required',


        ]);

        $eva_mod = array(
            'des_eva' => mb_strtoupper($request->get('des_tipoeva_modi'),'utf-8'),


        );

        ri_tipo_eva::find($id)->update($eva_mod);
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
        ri_tipo_eva::destroy($id);
        return back();
    }
}
