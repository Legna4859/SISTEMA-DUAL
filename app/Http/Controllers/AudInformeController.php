<?php

namespace App\Http\Controllers;

use App\AudAuditorAuditoria;
use App\AudAuditores;
use App\AudAuditorias;
use App\AudInforme;
use App\GnralPersonales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AudInformeController extends Controller
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
        $informe=AudInforme::where('id_auditoria',$id)->get();
        if($informe->count()==0)
            $informe=AudInforme::create(["id_auditoria"=>$id]);
        else
            $informe=$informe->first();


        Session::forget(['auditorUsed','dateUsed']);
        $fecha=AudAuditorias::where('id_auditoria',$id)->get()->pluck('id_programa');
        $auditorias=AudAuditorias::orderBy('fecha_i','ASC')->where('id_programa',$fecha)->get();
        $auditoria_id=$id;
        $lider=AudAuditorAuditoria::where('id_auditoria',$id)->where('id_categoria','1')->get();
        $equipo=AudAuditorAuditoria::where('id_auditoria',$id)->where('id_categoria','2')->get();
        $entrenados=AudAuditorAuditoria::where('id_auditoria',$id)->where('id_categoria','3')->get();
        $personas=GnralPersonales::orderBy('nombre')->get();


        $procesosE=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso')
            ->orderBy('ri_proceso.clave','ASC')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();

        // no existe $auditEx
        $auditoresEx=null;
        $esLider=false;
        if ($idLider = AudAuditores::where('id_categoria',1)->get()[0]->id_personal==Session::get('id_perso'))
            $esLider=true;$idLider = AudAuditores::where('id_categoria',1)->get()[0];

        $personas=AudInforme::getPersonas($id);
        $noConformidad=AudInforme::getDatosInforme($id,1);
        $fortalezas=AudInforme::getDatosInforme($id,5);
        $oportunidades=AudInforme::getDatosInforme($id,2);
        $seguimientoAcciones=AudInforme::getDatosInforme($id,4);

        //dd($personas);
        return view('auditorias.informe',compact('auditorias','auditoria_id','lider','equipo',
            'personas','informe','noConformidad','fortalezas','oportunidades','seguimientoAcciones',
            'entrenados','personas','procesosE','esLider'));

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
        $informe=AudInforme::find($id);
        //dd($request->all());
        $informe->update([$request->field=>$request->value]);
      //  dd($informe);
        return redirect()->back();
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
