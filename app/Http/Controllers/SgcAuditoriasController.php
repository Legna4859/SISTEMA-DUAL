<?php

namespace App\Http\Controllers;

use App\gnral_unidad_administrativa;
use App\SgcAsignaAudi;
use App\SgcAuditorias;
use App\GnralPersonales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SgcAuditoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditorias=SgcAuditorias::get();
        $personas=GnralPersonales::all()->sortBy('nombre');
        return view('sgc.auditorias',compact('auditorias','auditorias','personas'));
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
            'objetivo' => 'required',
            'alcance' => 'required',
//            'criterios' =>'required',
            'fecha_i' => 'required',
            'fecha_f' => 'required',
        ]);
        if(!$validator->fails()){
            $auditoria_n= array(
                'objetivo' => mb_strtoupper($request->get('objetivo'),'utf-8'),
                'alcance' => mb_strtoupper($request->get('alcance'),'utf-8'),
//              'criterios' => mb_strtoupper($request->get('criterios'),'utf-8'),
                'fecha_i' => mb_strtoupper($request->get('fecha_i'),'utf-8'),
                'fecha_f' => mb_strtoupper($request->get('fecha_f'),'utf-8'),
            );
            SgcAuditorias::create($auditoria_n);
        }
        $validator2 = Validator::make($request->all(), [
            'fecha_i' => 'required',
            'fecha_f' => 'required'
        ]);
        if(!$validator2->fails()){
            $auditoria_n= array(
                'fecha_i' => mb_strtoupper($request->get('fecha_i'),'utf-8'),
                'fecha_f' => mb_strtoupper($request->get('fecha_f'),'utf-8'),
                'id_programa' => Session::get('id_programa')
            );
//            dd($auditoria_n);
            SgcAuditorias::create($auditoria_n);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tipe,$id)
    {
        $tipo=$tipe;
        $personas=GnralPersonales::all()->sortBy('nombre');
        $numero=$id;
        return view('sgc.auditores', compact('auditorias','tipo','numero','personas'));
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

        $this->validate($request,[
            'objetivo' => 'required',
            'alcance' => 'required',
            'fecha_i' => 'required',
            'fecha_f' => 'required',
        ]);
        $auditoria= array(
            'objetivo' => mb_strtoupper($request->get('objetivo'),'utf-8'),
            'alcance' => mb_strtoupper($request->get('alcance'),'utf-8'),
            'fecha_i' => mb_strtoupper($request->get('fecha_i'),'utf-8'),
            'fecha_f' => mb_strtoupper($request->get('fecha_f'),'utf-8'),
        );
        SgcAuditorias::find($id)->update($auditoria);
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

        SgcAuditorias::destroy($id);
        return back();
    }
}
