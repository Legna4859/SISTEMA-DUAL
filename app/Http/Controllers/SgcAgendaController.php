<?php

namespace App\Http\Controllers;

use App\gnral_unidad_administrativa;
use App\SgcAgenda;
use App\SgcAsignaAudi;
use App\SgcAuditorias;
use App\GnralPersonales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SgcAgendaController extends Controller
{
    private $horas_f=[];
    /**
     * Display a listing of the resource.
     *php
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
            'inicio' => 'required',
            'fin' => 'required',
            'area' => 'required',
            'procesos' => 'required'
        ]);
        $evento= array(
            'hora_i' => mb_strtoupper($request->get('inicio'),'utf-8'),
            'hora_f' => mb_strtoupper($request->get('fin'),'utf-8'),
            'fecha' => Session::get('dateUsed'),
            'id_area' => mb_strtoupper($request->get('area'),'utf-8'),
            'procesos' => mb_strtoupper($request->get('procesos'),'utf-8'),
            'id_asigna_audi' => mb_strtoupper($request->get('auditor'),'utf-8'),
        );
        SgcAgenda::create($evento);
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
        Session::forget('id_reporte');
        Session::forget('errors');
        $auditorias=SgcAuditorias::get()->where('id_auditoria',$id);
        $fechas=SgcAgenda::get()->where('id_auditoria',$id);
        foreach ($auditorias as $auditoria) {
            $fechas = $this->generateDateRange(Carbon::parse($auditoria->fecha_i),Carbon::parse($auditoria->fecha_f));
        }
        $auditores=SgcAsignaAudi::all()->where('id_auditoria',$id);
        $eventos=collect();
        foreach ($auditores as $auditor) {
            foreach ($auditor->getAgenda as $agenda){
                foreach ($agenda->area as $area){
                    $eventos->push(['id_auditor'=>$auditor->id_auditor,'fecha'=>$agenda->fecha,'area'=>$area->nom_departamento,'procesos'=>$agenda->procesos,'hora_i'=>$agenda->hora_i,'hora_f'=>$agenda->hora_f,'auditor'=>$agenda->getAsign->getAbrPer[0]->getAbreviatura[0]->titulo.' '.$agenda->getAsign->getNombre[0]->nombre,'id_agenda'=>$agenda->id_agenda]);
                }
            }
        }
        $areas=gnral_unidad_administrativa::all();

        if(Session::get('auditorUsed')){
            $auditorSelected=SgcAsignaAudi::get()->where('id_auditoria',$id)->where('id_auditor',Session::get('auditorUsed'));
            if (Session::get('dateUsed')){
                foreach ($auditorSelected as $aud){
                    foreach ($aud->getAgenda as $agenda) {
                        if($agenda->fecha==Session::get('dateUsed')){
                            $this->generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f));
                        }
                    }
                }
            }

            return view('sgc.agenda',compact('auditorias','auditorias','fechas','auditores','eventos','areas','auditorSelected'));
        }
        else{
            return view('sgc.agenda',compact('auditorias','auditorias','fechas','auditores','eventos','areas'));
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
        Session::put('dateUsed',$id);
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
    }

    public function setAuditor(Request $request){
        dd("entro");
    }

    private function generateDateRange(Carbon $start_date, Carbon $end_date) {
        $dates = [];
        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            if(!$date->isSaturday() && !$date->isSunday())
                $dates[] = $date->format('Y-m-d');
        }
        return $dates;
    }

    private function generateTimeRange(Carbon $start_hour, Carbon $end_hour) {
        for($hour = $start_hour; $hour->lte($end_hour); $hour->addMinute('30')) {
            $hours = [];
            $hours [] = $hour->format('H');
            $hours[]=$hour->format('i');
            $this->horas_f[]=$hours;
        }
    }
}
