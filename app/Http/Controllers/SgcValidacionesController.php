<?php

namespace App\Http\Controllers;

use App\SgcAgenda;
use App\SgcAsignaAudi;
use App\GnralPersonales;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SgcValidacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $horas_f=[];
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
        switch ($id){
            case 1:
                $this->validate($request,[
                    'inicio' => 'required',
                    'fin' => 'required',
                    'fecha' =>'required',
                    'area' => 'required',
                    'id_auditoria' => 'required'
                ]);
                $auditores=SgcAsignaAudi::all()->where('id_auditoria',$request->get('id_auditoria'));
                $personas=GnralPersonales::all()->sortBy('nombre');
                return view('sgc.auditores_evento',compact('datos','auditores','personas'));
            case 2:
                $this->validate($request,[
                    'fecha' => 'required',
                    'id_auditoria' => 'required'
                ]);

                if(Session::get('auditorUsed')){
                    $auditorSelected=SgcAsignaAudi::get()->where('id_auditoria',mb_strtoupper($request->get('id_auditoria'),'utf-8'))->where('id_auditor',Session::get('auditorUsed'));
                    if (Session::get('dateUsed')){
                        foreach ($auditorSelected as $aud){
                            foreach ($aud->getAgenda as $agenda) {
                                if($agenda->fecha==Session::get('dateUsed')){
                                    $this->generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f));
                                }
                            }
                        }
                    }
                    return ($this->horas_f);
                }

            case 3:
        }


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

    private function generateTimeRange(Carbon $start_hour, Carbon $end_hour) {
        for($hour = $start_hour; $hour->lte($end_hour); $hour->addMinute('30')) {
            $hours = [];
            $hours [] = $hour->format('H');
            $hours[]=$hour->format('i');
            $this->horas_f[]=$hours;
        }
    }
}
