<?php

namespace App\Http\Controllers;

use App\ri_o_ocurrenciasp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RiOOcurrenciaspController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ocurrenciasps = DB::table('ri_o_ocurrenciasp')
            ->orderBy('id_ocurrenciap', 'asc')
            ->get();

        return view('riesgos.ocurrenciasp',compact('ocurrenciasps'));
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
            'des_ocurrenciasp' => 'required',
            'calificacion' => 'required',

        ]);

        $ocurrenciasps = array(
            'des_ocurrenciasp' => mb_strtoupper($request->get('des_ocurrenciasp'),'utf-8'),
            'calificacion' => mb_strtoupper($request->get('calificacion'),'utf-8'),

        );

        ri_o_ocurrenciasp::create($ocurrenciasps);
        return redirect('/riesgos/ocurrenciasp');
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
        return (ri_o_ocurrenciasp::find($id));
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
            'des_ocurrenciasp_modi' => 'required',
            'calificacion_modi' => 'required',

        ]);

        $selec_mod = array(
            'des_ocurrenciasp' => mb_strtoupper($request->get('des_ocurrenciasp_modi'),'utf-8'),
            'calificacion' => mb_strtoupper($request->get('calificacion_modi'),'utf-8'),

        );

        ri_o_ocurrenciasp::find($id)->update($selec_mod);
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
        ri_o_ocurrenciasp::destroy($id);
        return back();
    }
}
