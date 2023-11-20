<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\ri_clasif_factor;

class RiClasifFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ffactores = DB::table('ri_clasif_factor')
            ->orderBy('des_cl_f', 'asc')
            ->get();

        return view('riesgos.factor',compact('ffactores'));
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

        $this->validate($request,[
            'des_cl_f' => 'required',


        ]);

        $evaluacion = array(
            'des_cl_f' => mb_strtoupper($request->get('des_cl_f'),'utf-8'),

        );

        ri_clasif_factor::create($evaluacion);
        return redirect('/riesgos/factor');
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
        return (ri_clasif_factor::find($id));
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
            'des_factor_modi' => 'required',


        ]);

        $factor_mod = array(
            'des_cl_f' => mb_strtoupper($request->get('des_factor_modi'),'utf-8'),


        );

        ri_clasif_factor::find($id)->update($factor_mod);
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
        ri_clasif_factor::destroy($id);
        return back();
    }
}
