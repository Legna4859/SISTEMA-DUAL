<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ri_clasif_r;
class RiClasifRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clasificaciones = DB::table('ri_clasif_r')
            ->orderBy('id_cl_r', 'asc')
            ->get();

        return view('riesgos.clasifica',compact('clasificaciones'));
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
            'des_cl' => 'required',


        ]);

        $clasificacion = array(
            'des_cl' => mb_strtoupper($request->get('des_cl'),'utf-8'),

        );

        ri_clasif_r::create($clasificacion);
        return redirect('/riesgos/clasifica');

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
        return ( ri_clasif_r::find($id));
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
            'des_clasificacion_modi' => 'required',


        ]);

        $selec_mod = array(
            'des_cl' => mb_strtoupper($request->get('des_clasificacion_modi'),'utf-8'),


        );

        ri_clasif_r::find($id)->update($selec_mod);
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
        ri_clasif_r::destroy($id);
        return back();
    }
}
