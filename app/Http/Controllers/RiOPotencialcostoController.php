<?php

namespace App\Http\Controllers;


use App\ri_o_potencialcosto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RiOPotencialcostoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $potencialcostos = DB::table('ri_o_potencialcosto')
            ->orderBy('id_potencialcosto', 'asc')
            ->get();

        return view('riesgos.potencialcosto',compact('potencialcostos'));
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
            'des_potencialcosto' => 'required',


        ]);

        $potencialcostos = array(
            'des_potencialcosto' => mb_strtoupper($request->get('des_potencialcosto'),'utf-8'),


        );

        ri_o_potencialcosto::create($potencialcostos);
        return redirect('/riesgos/potencialcosto');
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
        return (ri_o_potencialcosto::find($id));
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
            'des_potencialcosto_modi' => 'required',


        ]);

        $selec_mod = array(
            'des_potencialcosto' => mb_strtoupper($request->get('des_potencialcosto_modi'),'utf-8'),

        );

        ri_o_potencialcosto::find($id)->update($selec_mod);
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
        ri_o_potencialcosto::destroy($id);
        return back();
    }
}
