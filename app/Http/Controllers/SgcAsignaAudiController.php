<?php

namespace App\Http\Controllers;

use App\SgcAsignaAudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SgcAsignaAudiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $grupo_auditor=collect([]);
        $grupo_entrenados=collect([]);
        for ($i=0;$i<=10;$i++){
            if($request->has('auditor'.$i)) $grupo_auditor->push(mb_strtoupper($request->get('auditor'.$i),'utf-8'));
            if($request->has('auditor_ent'.$i)) $grupo_entrenados->push(mb_strtoupper($request->get('auditor_ent'.$i),'utf-8'));
        }
        $lider=array(
            'id_auditoria' => mb_strtoupper($request->get('id_auditoria'),'utf-8'),
            'id_auditor' => mb_strtoupper($request->get('lider'),'utf-8'),
            'id_categoria' => '1',
        );
        SgcAsignaAudi::create($lider);
        foreach ($grupo_auditor as $auditor){
            $auditores=array(
                'id_auditoria' => mb_strtoupper($request->get('id_auditoria'),'utf-8'),
                'id_auditor' => $auditor,
                'id_categoria' => '2',
            );
            SgcAsignaAudi::create($auditores);
        }
        foreach ($grupo_entrenados as $entrena){
            $entrenados=array(
                'id_auditoria' => mb_strtoupper($request->get('id_auditoria'),'utf-8'),
                'id_auditor' => $entrena,
                'id_categoria' => '3',
            );
            SgcAsignaAudi::create($entrenados);
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
        Session::put('auditorUsed',$id);
        return back();
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
            'type' => 'required',
            'id_auditor' => 'required',
        ]);
        if($request->get('type')=='edit_lider'){
            $auditor= array(
                'id_asigna_audi' => $id,
                'id_auditor' => mb_strtoupper($request->get('id_auditor'),'utf-8'),
                'id_categoria' => '1',
            );
            SgcAsignaAudi::find($id)->update($auditor);
        }
        elseif ($request->get('type')=='add_lider'){
            $auditor= array(
                'id_auditoria' => $id,
                'id_auditor' => mb_strtoupper($request->get('id_auditor'),'utf-8'),
                'id_categoria' => '1',
            );
            SgcAsignaAudi::create($auditor);
        }
        elseif($request->get('type')=='edit_equipo'){
            $auditor= array(
                'id_asigna_audi' => $id,
                'id_auditor' => mb_strtoupper($request->get('id_auditor'),'utf-8'),
                'id_categoria' => '2',
            );
            SgcAsignaAudi::find($id)->update($auditor);
        }
        elseif ($request->get('type')=='add_equipo'){
            $auditor= array(
                'id_auditoria' => $id,
                'id_auditor' => mb_strtoupper($request->get('id_auditor'),'utf-8'),
                'id_categoria' => '2',
            );
            SgcAsignaAudi::create($auditor);
        }
        elseif($request->get('type')=='edit_entrenado'){
            $auditor= array(
                'id_asigna_audi' => $id,
                'id_auditor' => mb_strtoupper($request->get('id_auditor'),'utf-8'),
                'id_categoria' => '3',
            );
            SgcAsignaAudi::find($id)->update($auditor);
        }
        elseif ($request->get('type')=='add_entrenado'){
            $auditor= array(
                'id_auditoria' => $id,
                'id_auditor' => mb_strtoupper($request->get('id_auditor'),'utf-8'),
                'id_categoria' => '3',
            );
            SgcAsignaAudi::create($auditor);
        }

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
        SgcAsignaAudi::destroy($id);
        return back();
    }
}
