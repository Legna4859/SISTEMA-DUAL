<?php

namespace App\Http\Controllers;

use App\ri_proceso;
use App\SgcAuditorias;
use App\SgcObjetivos;
use App\SgcPrograma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SgcProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $programas = SgcPrograma::all();
        return view("sgc.programas",compact('programas','programas'));
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
        $validator = Validator::make($request->all(), [
            'inicio' => 'required',
            'fin' => 'required',
            'lugar' => 'required',
            'alcance' => 'required',
            'metodos' =>'required',
            'responsabilidades' => 'required',
        ]);
        if($validator->fails()){
            Session::put('errors',$validator->errors());
            return redirect()->back();
        }
        $programa = array(
            'fecha_i' => Carbon::parse($request->get('inicio'))->format('Y-m-d'),
            'fecha_f' => Carbon::parse($request->get('fin'))->format('Y-m-d'),
            'lugar' => $request->get('lugar'),
            'alcance' => $request->get('alcance'),
            'metodos' => $request->get('metodos'),
            'responsabilidades' => $request->get('responsabilidades')
        );
        SgcPrograma::create($programa);
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
        Session::put('id_programa',$id);
        $programas=SgcPrograma::get()->where('id_programa',$id);
        $objetivos=SgcObjetivos::all();
        return view('sgc.ver_programa',compact('programas','programas','objetivos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Session::put('id_programa',$id);
//        dd(Session::get('id_programa'));
        $programas=SgcPrograma::get()->where('id_programa',$id);
        $auditorias=SgcAuditorias::get()->where('id_programa',$id)->sortBy('id_auditoria');
//        dd($auditorias);
        $procesos =ri_proceso::all();

        return view('sgc.add_auditorias',compact('programas','programas','auditorias','procesos'));
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
        //
        SgcPrograma::destroy($id);
        return back();
    }
}
