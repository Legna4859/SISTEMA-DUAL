<?php

namespace App\Http\Controllers;

use App\SgcAgenda;
use App\SgcNotas;
use App\SgcReportes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SgcReportesController extends Controller
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
            'fecha' => 'required',
        ]);
        $reporte= array(
            'id_agenda' => $request->get('id_agenda'),'utf-8',
            'fecha' => $request->get('fecha'),'utf-8',
        );
        SgcReportes::create($reporte);
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
        $agenda=SgcAgenda::get()->where('id_agenda',$id);
//        dd($agenda);
        $reporte=SgcReportes::get()->where('id_agenda',$id);
        foreach ($agenda as $agendas){
            $auditoria=$agendas->getAsign;
        }
        foreach ($reporte as $rep){
            Session::put('id_reporte',$rep->id_reporte);
        }
        if (Session::get('id_reporte')){
            $notas=SgcNotas::get()->where('id_reporte',Session::get('id_reporte'));
            foreach ($agenda as $ag){
//                dd($ag->procesos);
                if ($ag->procesos!=""){
                    $array_procesos=explode(',',$ag->procesos);
//                    dd($array_procesos);
                    for($i=0;$i<sizeof($array_procesos);$i++) $array_procesos[$i]=ltrim($array_procesos[$i]);
                    foreach ($notas as $nota){
                        $i=array_search(ltrim($nota->proceso),$array_procesos);
                        if($i>=0)
                            unset($array_procesos[$i]);
                    }
//                    dd(sizeof($array_procesos));
                }
            }
            if (isset($array_procesos)) {
                if (sizeof($array_procesos) > 0)
                    return view('sgc.hoja_trabajo', compact('agenda', 'agenda', 'auditoria', 'notas', 'array_procesos'));
                else
                    return view('sgc.hoja_trabajo', compact('agenda', 'agenda', 'auditoria', 'notas'));
            }
            else
                return view('sgc.hoja_trabajo',compact('agenda','agenda','auditoria','notas'));
        }
        else{
            return view('sgc.hoja_trabajo',compact('agenda','agenda','auditoria'));
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
}
