<?php

namespace App\Http\Controllers;

use App\AudAuditores;
use App\AudCategoria;
use App\AudAuditorAuditoria;
use App\Gnral_Personales;
use App\SgcPersonasAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AudAuditoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditores=AudAuditores::all();
        $auditoresT=AudAuditores::join('gnral_personales','aud_auditores.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones_prof','gnral_personales.id_personal','=','abreviaciones_prof.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->select('aud_auditores.id_auditores','abreviaciones.titulo','gnral_personales.nombre','gnral_personales.sexo','aud_auditores.id_categoria')
            ->orderBy('aud_auditores.id_categoria','ASC')
            ->orderBy('gnral_personales.sexo','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();
        $equipo=1;
        $entrenamiento=1;
        $auditoresT->map(function ($value) use (&$equipo,&$entrenamiento){
            if($value->id_categoria==1) $value->alias="Auditor Lider";
            elseif ($value->id_categoria==2) $value->alias="Auditor ".$equipo++;
            else $value->alias="AE".$entrenamiento++;
        });
        $id_auditores=$auditores->pluck('id_personal');
        $categorias=AudCategoria::all();
        $personas=Gnral_Personales::all()->sortBy('nombre')->whereNotIn('id_personal',$id_auditores);
        return view('auditorias.auditores',compact('auditores','auditoresT','personas','categorias'));
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
            'id_categoria' => 'required'
        ]);
        if(!$validator->fails())
            AudAuditores::create(array(
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

        $data=json_decode($id);
        foreach ($data as $datos){
            $rol = array(
                'id_categoria' => $datos->id_categoria,
            );
            AudAuditores::find($datos->id_personas_auditoria)->update($rol);
        }
        return back();
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
        AudAuditores::destroy($id);
        return back();
    }
}
