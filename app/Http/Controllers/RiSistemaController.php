<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ri_sistema;
class RiSistemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sistema = DB::table('ri_sistema')
            ->orderBy('id_sistema', 'asc')
            ->get();

        return view('riesgos.sistema',compact('sistema'));
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
            'desc_sistema' => 'required',


        ]);

        $sistema = array(
            'desc_sistema' => mb_strtoupper($request->get('desc_sistema'),'utf-8'),

        );

        ri_sistema::create($sistema);
        return redirect('/riesgos/sistema');


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
        return ( ri_sistema::find($id));
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
            'desc_sistema_modi' => 'required',


        ]);

        $selec_mod = array(
            'desc_sistema' => mb_strtoupper($request->get('desc_sistema_modi'),'utf-8'),


        );

        ri_sistema::find($id)->update($selec_mod);
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
        ri_sistema::destroy($id);
        return back();
    }
}
