<?php

namespace App\Http\Controllers;

use App\ri_tipo_eva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ritipo_f;
use App\Http\Controllers\Controller;

class RiTipoFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $factores = DB::table('ri_tipo_f')
            ->orderBy('id_tipo_f', 'asc')
            ->get();

        return view('riesgos.tipof',compact('factores'));
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
            'des_tipof' => 'required',


        ]);

        $factor = array(
            'des_tf' => mb_strtoupper($request->get('des_tipof'),'utf-8'),

        );

        ritipo_f::create($factor);
        return redirect('/riesgos/tipof');
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
        return (ritipo_f::find($id));
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
            'des_tipof_modi' => 'required',


        ]);

        $tf_mod = array(
            'des_tf' => mb_strtoupper($request->get('des_tipof_modi'),'utf-8'),


        );

        ritipo_f::find($id)->update($tf_mod);
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
        ritipo_f::destroy($id);
        return back();
    }
}
