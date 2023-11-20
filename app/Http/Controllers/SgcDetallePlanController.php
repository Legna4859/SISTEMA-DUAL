<?php

namespace App\Http\Controllers;

use App\GnralPersonales;
use App\SgcAsignaAudi;
use App\SgcAuditorias;
use App\SgcNormatividad;
use App\SgcNormAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SgcDetallePlanController extends Controller
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
        Session::forget(['auditorUsed','dateUsed']);
        $auditorias=SgcAuditorias::get()->where('id_auditoria',$id);
        $lider=SgcAsignaAudi::all()->where('id_auditoria',$id)->where('id_categoria','1');
        $equipo=SgcAsignaAudi::all()->where('id_auditoria',$id)->where('id_categoria','2');
        $entrenados=SgcAsignaAudi::all()->where('id_auditoria',$id)->where('id_categoria','3');
        $auditores=SgcAsignaAudi::all()->where('id_auditoria',$id)->pluck('id_auditor');
        $personas=GnralPersonales::all()->sortBy('nombre');
        $normatividad=SgcNormatividad::all()->sortBy('descripcion');
        $criteriosAud=SgcNormAuditoria::get()->where('id_auditoria',$id);
        $criteriosUsed=SgcNormAuditoria::get()->where('id_auditoria',$id)->pluck('id_normatividad');
//        dd($criteriosAud);
//        dd($auditores->search(40,true));
        foreach ($personas as $persona)
        {
//            dd($persona->getAbrPer[0]->getAbreviatura[0]->titulo);
        }
        return view('sgc.detalle_plan',compact('auditorias','auditorias','lider','equipo','entrenados','personas','auditores','normatividad','criteriosAud','criteriosUsed'));
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
        dd("llego");
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
    }
}
