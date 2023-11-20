<?php

namespace App\Http\Controllers;

use App\AudAuditores;
use App\AudAuditoriaProceso;
use App\AudAuditorias;
use App\AudAuditorAuditoria;
use App\AudProgramas;
use App\GnralPersonales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AudAuditoriasController extends Controller
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
      //  dd("ok");
        if ($request->get('procesos')){
            $procesos=json_decode($request->get('procesos'));
            Session::put('procesos',$procesos);
        }
        $validator = Validator::make($request->all(), [
            'fecha_de_inicio' => 'required',
            'fecha_de_fin' => 'required',
            'procesos' => 'required',
            'random' => 'required',
            'id_programa' => 'required'
        ]);
        if($validator->fails()){
            Session::put('errors',$validator->errors());
            return back();
        }
        $plan = array(
            'fecha_i' => Carbon::parse($request->get('fecha_de_inicio'))->format('Y-m-d'),
            'fecha_f' => Carbon::parse($request->get('fecha_de_fin'))->format('Y-m-d'),
            'alcance' => $request->get('random'),
            'id_programa' => $request->get('id_programa')
        );
        AudAuditorias::create($plan);
        $id=AudAuditorias::where('alcance',$request->get('random'))->get();
        $planAc = array(
            'alcance' => null,
        );
        AudAuditorias::find($id[0]->id_auditoria)->update($planAc);

        /*update aud_programa*/
        AudProgramas::where("id_programa",$request->get('id_programa'))->update(["active"=>0]);

        foreach ($procesos as $proceso){
            $procesoAuditoria = array(
                'id_auditoria' => $id[0]->id_auditoria,
                'id_proceso'=>$proceso
            );
            AudAuditoriaProceso::create($procesoAuditoria);
        }
        $auditores=AudAuditores::all();
        foreach ($auditores as $auditor){
            AudAuditorAuditoria::create(array(
                'id_auditoria' => $id[0]->id_auditoria,
                'id_personal' => $auditor->id_personal,
                'id_categoria' => $auditor->id_categoria,
            ));
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

        return view('auditorias.ver_plan',compact('auditorias','auditorias','auditoria_id','lider','equipo','entrenados','personas','procesosE','esLider'));
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

        $validator = Validator::make($request->all(),[
            'objetivo' => 'required',
            'alcance' => 'required',
            'criterios' => 'required',
            'fecha_i' => 'required',
            'fecha_f' => 'required',
        ]);
        if($validator->fails()){
            Session::put('errors',$validator->errors());
        }
        else{
            $auditoria= array(
                'objetivo' => $request->get('objetivo'),
                'alcance' => $request->get('alcance'),
                'criterio' => $request->get('criterios'),
                'fecha_i' => Carbon::parse($request->get('fecha_i'))->format("Y-m-d"),
                'fecha_f' => Carbon::parse($request->get('fecha_f'))->format("Y-m-d"),
            );
            AudAuditorias::find($id)->update($auditoria);
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
        AudAuditorias::destroy($id);
        return back();
    }
}
