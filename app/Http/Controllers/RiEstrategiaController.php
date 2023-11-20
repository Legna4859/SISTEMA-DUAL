<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\riEstrategia;
class RiEstrategiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $estrategias = riEstrategia::orderBy('descripcion', 'asc')->get();

        return view('riesgos.estrategia',compact('estrategias'));
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

        $estrategia = array(
            'descripcion' => mb_strtoupper($request->get('descripcion'),'utf-8'),

        );

        riEstrategia::create($estrategia);
        return redirect('/riesgos/estrategia');

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
        return (riEstrategia::find($id));
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
            'des_estrategia_modi' => 'required',


        ]);

        $selec_mod = array(
            'descripcion' => mb_strtoupper($request->get('des_estrategia_modi'),'utf-8'),


        );

        riEstrategia::find($id)->update($selec_mod);
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
        riEstrategia::find($id)-> delete();
        return back();

    }
}

