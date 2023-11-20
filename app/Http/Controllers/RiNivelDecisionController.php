<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ri_nivel_decision;
class RiNivelDecisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $decisiones = DB::table('ri_nivel_decision')
            ->orderBy('id_nivel_de', 'asc')
            ->get();

        return view('riesgos.decision',compact('decisiones'));
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
            'des_nivel_des' => 'required',


        ]);

        $estrategia = array(
            'des_nivel_des' => mb_strtoupper($request->get('des_nivel_des'),'utf-8'),

        );

        ri_nivel_decision::create($estrategia);
        return redirect('/riesgos/decision');

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
        return (ri_nivel_decision::find($id));
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
            'des_decision_modi' => 'required',


        ]);

        $selec_mod = array(
            'des_nivel_des' => mb_strtoupper($request->get('des_decision_modi'),'utf-8'),


        );

        ri_nivel_decision::find($id)->update($selec_mod);
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
        ri_nivel_decision::destroy($id);
        return back();
    }
}
