<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ri_unidad_parte;
use Session;

class RiAddPartesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   private $id_unidad_admin;
    public function __construct()
    {
        //dd("oki");
        $this->middleware('auth');

        $this->id_unidad_admin=Session()->has('id_unidad_admin')?Session()->has('id_unidad_admin'):false;

        if(!$this->id_unidad_admin)
            return back();
        else        $this->id_unidad_admin=session::get('id_unidad_admin');

    }

    public function index($id_proceso)
    {

        //$partes_unidad = ri_unidad_parte::where('id_unidad_admin',$this->id_unidad_admin)->where('id_proceso',$id_proceso)->get();
        $partes_unidad = ri_unidad_parte::where('id_proceso',$id_proceso)->get();

        $partes = DB::table('ri_partes')
            ->orderBy('des_parte', 'asc')
            ->get();

       return view('riesgos.addpartes',compact('partes_unidad','partes'));
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
    public function store(Request $request,$id_proceso)
    {
        //
     //
        //  dd($this->id_unidad_admin);

        $this->validate($request,[
            'parte_interesada' => 'required',
        ]);

        $parte = array(
            'id_parte' => mb_strtoupper($request->get('parte_interesada'),'utf-8'),
            'id_unidad_admin' => mb_strtoupper($this->id_unidad_admin,'utf-8'),
            'id_proceso'=>$id_proceso,
        );
        ri_unidad_parte::create($parte);
        return back();
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
        Session::put('collapseStatepartes', $id);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        ri_unidad_parte::destroy($id);
        return back();
    }
}
