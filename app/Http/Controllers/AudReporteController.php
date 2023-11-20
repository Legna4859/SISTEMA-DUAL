<?php

namespace App\Http\Controllers;

use App\AudAgenda;
use App\AudAgendaArea;
use App\AudAuditores;
use App\AudAuditorias;
use App\AudClasificacion;
use App\AudNota;
use App\audParseCase;
use App\AudReporte;
use App\gnral_unidad_administrativa;
use App\GnralJefeUnidadAdministrativa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AudReporteController extends Controller
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
        $this->validate($request,[
            'id_agenda' => 'required',
            'id_area' => 'required',
            'id_auditado' => 'required'
        ]);
        AudReporte::create(array(
            'id_agenda' => $request->get('id_agenda'),'utf-8',
            'id_area' => $request->get('id_area'),'utf-8',
            'id_auditado' => $request->get('id_auditado'),'utf-8',
        ));

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
        $esLider=false;
        if ($idLider = AudAuditores::where('id_categoria',1)->get()[0]->id_personal==Session::get('id_perso')){
            $esLider=true;
        }
        $agenda=AudAgenda::find($id);
        $auditoria=AudAuditorias::find($agenda->id_auditoria);
        $auditorias=AudAuditorias::where('id_programa',$auditoria->id_programa)->orderBy('fecha_i','ASC')->get();
        $noAud="";
        $count=1;
        foreach ($auditorias as $aud){
            if ($aud->id_auditoria==$auditoria->id_auditoria)
                $noAud=$count;
            $count++;
        }
        $areas=AudAgendaArea::join('gnral_unidad_administrativa','aud_agenda_area.id_area','=','gnral_unidad_administrativa.id_unidad_admin')
            ->join("gnral_unidad_personal","gnral_unidad_personal.id_unidad_admin","aud_agenda_area.id_area")
            ->join("gnral_personales","gnral_personales.id_personal","gnral_unidad_personal.id_personal")
            ->where('id_agenda',$id)
            ->select('aud_agenda_area.id_area','gnral_unidad_administrativa.nom_departamento', 'gnral_personales.nombre','gnral_personales.id_personal' )
            ->get();



        $newReporte=AudReporte::firstOrcreate(array(
            'id_agenda' => $agenda->id_agenda,
            //'id_area' => $areas->first()->id_area,
            'id_auditado' => $areas->first()->id_personal,
        ));

        $reporte=AudReporte::join('aud_agenda','aud_reportes.id_agenda','=','aud_agenda.id_agenda')
            ->join('gnral_personales','aud_reportes.id_auditado','=','gnral_personales.id_personal')
            ->join('gnral_unidad_personal','gnral_personales.id_personal','=','gnral_unidad_personal.id_personal')
            ->join('gnral_unidad_administrativa','gnral_unidad_personal.id_unidad_admin','=','gnral_unidad_administrativa.id_unidad_admin')
            ->join('abreviaciones_prof','gnral_personales.id_personal','=','abreviaciones_prof.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->where('aud_reportes.id_agenda',$id)
            ->select('gnral_unidad_administrativa.nom_departamento','gnral_personales.nombre','abreviaciones.titulo','aud_agenda.fecha',"aud_agenda.criterios",'aud_agenda.id_agenda','aud_reportes.id_reporte');

        //dd($reporte->get());
        if ($reporte->count()>0)
            $reporte=$reporte->get()[0];
        else
            $reporte=$reporte->get();
       // dd($reporte);
        $criterios=AudNota::where("id_reporte",$reporte->id_reporte)->get();
        if($criterios->count()==0) {
            $criterios = $reporte->criterios;
            $criterios = explode(',', $criterios);
            foreach ($criterios as $criterio)
                if($criterio!="")
                AudNota::create([
                    'id_reporte'=>$reporte->id_reporte,
                    'punto_proceso'=>$criterio
                ]);
            $criterios=AudNota::where("id_reporte",$reporte->id_reporte)->get();
        }
        $audClasificacion=AudClasificacion::all();

        //dd($esLider);
        return view('auditorias.hoja_trabajo',compact('reporte','agenda','areas','noAud','criterios','audClasificacion','esLider'));
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
       //dd($request->all());
        if(isset($request->autorizaNota))
            //
            AudNota::find($request->id_nota_autorizar)->update(["autorizacion"=>($request->autorizaNota=="true"?1:false)]);
        elseif($request->id_nota=="Nueva")
            AudNota::create(["observaciones"=>$request->observaciones!=null?$request->observaciones:"",
                "id_clasificacion"=>$request->id_clasificacion,
                "punto_proceso"=>$request->saveNueva, "id_reporte"=>$request->idReporte,"resultado"=>$request->resultado!=null?$request->resultado:""]);
        else
        AudNota::find($request->id_nota)->update(["observaciones"=>$request->observaciones,
            "id_clasificacion"=>$request->id_clasificacion,"resultado"=>$request->resultado]);
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

    public function getRespons($id){
        $responsable=gnral_unidad_administrativa::join('gnral_unidad_personal','gnral_unidad_administrativa.id_unidad_admin','=','gnral_unidad_personal.id_unidad_admin')
            ->join('gnral_personales','gnral_unidad_personal.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones_prof','gnral_personales.id_personal','=','abreviaciones_prof.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->where('gnral_unidad_administrativa.id_unidad_admin',$id)
            ->select('gnral_personales.id_personal','gnral_personales.nombre','abreviaciones.titulo')->get();
        $responsable[0]->titulo=audParseCase::parseAbr($responsable[0]->titulo);
        $responsable[0]->nombre=audParseCase::parseNombre($responsable[0]->nombre);
        return $responsable;
    }
}
