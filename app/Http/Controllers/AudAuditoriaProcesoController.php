<?php

namespace App\Http\Controllers;

use App\AudAuditoriaProceso;
use App\AudAuditorias;
use App\AudProgramas;
use App\ri_proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AudAuditoriaProcesoController extends Controller
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
        $auditorias=AudAuditorias::where('id_auditoria',$id)->get();
        $auditoriasPrograma=AudAuditorias::where('id_programa',$auditorias[0]->id_programa)->get();
        $correcto=AudAuditoriaProceso::where('id_auditoria',$id)->get();
        $procesosExistentes=AudAuditoriaProceso::where('id_auditoria',$id)->get()->pluck('id_proceso')->toArray();
        $procesos=ri_proceso::orderBy('clave')->orderBy('des_proceso')->whereNotIn('id_proceso',$procesosExistentes)->get();

        $procesosE=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso')
            ->orderBy('ri_proceso.clave','ASC')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();

        $procesosEnAgenda=AudAuditoriaProceso::orderBy('id_proceso')->whereIn('id_auditoria',$auditoriasPrograma->pluck('id_auditoria'))->get()->pluck('id_proceso')->unique()->toArray();

        return view('auditorias.editar_procesosA',compact('procesos','auditorias','procesos','procesosE','procesosEnAgenda'));
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
        /*update aud_programa*/
        $id_auditoria=AudAuditorias::find($id);
        AudProgramas::where("id_programa",$id_auditoria->id_programa)->update(["active"=>0]);

        $eliminar=json_decode($request->get('eliminar'));
        $agregar=json_decode($request->get('agregar'));
        if (sizeof($agregar)>0){
            foreach ($agregar as $newItem){
                $nuevo = array(
                    'id_auditoria' => $id,
                    'id_proceso' => $newItem
                );
                AudAuditoriaProceso::create($nuevo);
            }

        }
        if (sizeof($eliminar)>0){
            foreach ($eliminar as $item){
                AudAuditoriaProceso::destroy($item);
            }
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
    }

    public function addObs(Request $request, $id){
        AudAuditoriaProceso::find($id)->update(array(
            'observacion' => $request->get('observacion')
        ));
        return back();
    }
    public function editObs(Request $request, $id){
        AudAuditoriaProceso::find($id)->update(array(
            'observacion' => $request->get('observacion')
        ));
        return back();
    }
    public function delObs($id){
        AudAuditoriaProceso::find($id)->update(array(
            'observacion' => NULL
        ));
        return "ok";
    }
}
