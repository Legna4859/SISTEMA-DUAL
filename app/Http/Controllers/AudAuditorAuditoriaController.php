<?php

namespace App\Http\Controllers;

use App\AudAuditores;
use App\AudAuditorias;
use App\AudCategoria;
use App\AudAuditorAuditoria;
use App\Gnral_Personales;
use App\SgcPersonasAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AudAuditorAuditoriaController extends Controller
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
        $validator = Validator::make($request->all(), [
            'id_auditoria' => 'required',
            'nuevo_auditor' => 'required',
            'id_categoria' => 'required'
        ]);
        if(!$validator->fails())
            AudAuditorAuditoria::create(array(
                'id_auditoria' => $request->get('id_auditoria'),
                'id_personal' => $request->get('nuevo_auditor'),
                'id_categoria' => $request->get('id_categoria'),
            ));
        else
            Session::put('errors',$validator->errors());
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
        $data=json_decode($id);
        foreach ($data as $datos){
            $rol = array(
                'id_categoria' => $datos->id_categoria,
            );
            AudAuditorAuditoria::find($datos->id_personas_auditoria)->update($rol);
        }

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
        $auditoria=$id;
        $fecha=AudAuditorias::where('id_auditoria',$id)->get()->pluck('id_programa');
        $auditorias=AudAuditorias::orderBy('fecha_i','ASC')->where('id_programa',$fecha)->get();
        $auditores=AudAuditorAuditoria::where('id_auditoria',$id)->get();
        $id_auditores=$auditores->pluck('id_personal');
        $categorias=AudCategoria::all();
        $personas=Gnral_Personales::all()->sortBy('nombre')->whereNotIn('id_personal',$id_auditores);

        return view('auditorias.editar_auditores_auditoria',compact('auditores','auditores','personas','categorias','auditoria','auditorias'));
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
        AudAuditorAuditoria::destroy($id);
        return redirect()->back();
    }
}
