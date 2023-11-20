<?php

namespace App\Http\Controllers;

use App\Gnral_Personales;
use App\SgcAuditorias;
use App\SgcPersonasAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SgcPersonasAuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $auditores_l=SgcPersonasAuditoria::all()->where('id_categoria','1');
        $auditores=SgcPersonasAuditoria::all()->where('id_categoria','2');
        $auditores_e=SgcPersonasAuditoria::all()->where('id_categoria','3');
        $personas=Gnral_Personales::all()->sortBy('nombre');
//        $personas=DB::table('gnral_personales')->whereExists(function ($query) {
//            $query->select('id_personal')->from('aud_personas_auditoria')->whereRaw('aud_personas_auditoria.id_personal <> gnral_personales.id_personal');
//        })->orderByRaw('nombre ASC')->get();
        return view('sgc.auditores',compact('auditores','auditores_l','auditores','auditores_e','personas'));
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
            'nuevo_auditor' => 'required',
        ]);
        if(!$validator->fails()){
            $personas_aud= array(
                'id_personal' => mb_strtoupper($request->get('nuevo_auditor'),'utf-8'),
                'id_categoria' => mb_strtoupper($request->get('id_categoria'),'utf-8'),
            );
            SgcPersonasAuditoria::create($personas_aud);
        }
        else{
            Session::put('errors',$validator->errors());
            return redirect()->back();
        }
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
        //
        SgcPersonasAuditoria::destroy($id);
        return back();
    }
}
