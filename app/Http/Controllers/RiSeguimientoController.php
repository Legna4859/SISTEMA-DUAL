<?php

namespace App\Http\Controllers;

use App\gnral_unidad_administrativa;
use App\ri_estrategia_accion;
use App\ri_o_planseguimiento;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

class RiSeguimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //dd(Session::get('id_unidad_admin'));
        $unidades=gnral_unidad_administrativa::all();
       return view("riesgos.seguimiento",compact('unidades'));

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
    public function show(Request $request)
    {


         $fechaminea=ri_estrategia_accion::join("ri_factores","ri_factores.id_factor","=","ri_estrategia_accion.id_factor")
        ->join("ri_registro_riesgo","ri_registro_riesgo.id_reg_riesgo","=","ri_factores.id_reg_riesgo")
        ->join("ri_riesgo","ri_riesgo.id_riesgo","=","ri_registro_riesgo.id_riesgo")
        ->join("ri_requisitos","ri_requisitos.id_requisito","=","ri_riesgo.id_requisito")
        ->join("ri_unidad_parte","ri_unidad_parte.id_uni_p","=","ri_requisitos.id_uni_p")
        ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","=","ri_unidad_parte.id_unidad_admin")
        //->select("ri_estrategia_accion.*","gnral_unidad_administrativa.*")
        ->min("fecha_final");
         $fechaminps=ri_o_planseguimiento::join("ri__reg_oportunidad","ri__reg_oportunidad.id_oportunidad","=","ri_o_planseguimiento.id_oportunidad")
             ->join("ri_requisitos","ri_requisitos.id_requisito","=","ri__reg_oportunidad.id_requisito")
             ->join("ri_unidad_parte","ri_unidad_parte.id_uni_p","=","ri_requisitos.id_uni_p")
             ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","=","ri_unidad_parte.id_unidad_admin")
            // ->select("ri_o_planseguimiento.*","gnral_unidad_administrativa.*")
             ->min("fecha");
         $fechaMaxea=ri_estrategia_accion::join("ri_factores","ri_factores.id_factor","=","ri_estrategia_accion.id_factor")
             ->join("ri_registro_riesgo","ri_registro_riesgo.id_reg_riesgo","=","ri_factores.id_reg_riesgo")
             ->join("ri_riesgo","ri_riesgo.id_riesgo","=","ri_registro_riesgo.id_riesgo")
             ->join("ri_requisitos","ri_requisitos.id_requisito","=","ri_riesgo.id_requisito")
             ->join("ri_unidad_parte","ri_unidad_parte.id_uni_p","=","ri_requisitos.id_uni_p")
             ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","=","ri_unidad_parte.id_unidad_admin")
             //->select("ri_estrategia_accion.*","gnral_unidad_administrativa.*")
             ->max("fecha_final");
         $fechaMaxps=ri_o_planseguimiento::join("ri__reg_oportunidad","ri__reg_oportunidad.id_oportunidad","=","ri_o_planseguimiento.id_oportunidad")
             ->join("ri_requisitos","ri_requisitos.id_requisito","=","ri__reg_oportunidad.id_requisito")
             ->join("ri_unidad_parte","ri_unidad_parte.id_uni_p","=","ri_requisitos.id_uni_p")
             ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","=","ri_unidad_parte.id_unidad_admin")
             //->select("fecha")->pluck("fecha");
             //->select("ri_o_planseguimiento.*","gnral_unidad_administrativa.*")
             //->get();
             ->max("fecha");
        //dd($fechaMaxps);
        //dd(($fechaminea."----".$fechaminps."----".$fechaMaxea."----".$fechaMaxps));
         $fecha_inical= Carbon::createFromFormat("Y-m-d",$fechaminea<=$fechaminps?$fechaminea:$fechaminps);
         $fecha_final=Carbon::createFromFormat("Y-m-d",$fechaMaxea>=$fechaMaxps?$fechaMaxea:$fechaMaxps);

         $meses=CarbonPeriod::create($fecha_inical,'1 months',$fecha_final->modify("1 months"));
         $array_full=array();
        foreach ($meses as $date) {
            $datos=array();
            if($date->format("m")==1)
              array_push($datos,"Enero ".$date->format("Y"));
            if($date->format("m")==2)
                array_push($datos,"Febrero ".$date->format("Y"));
            if($date->format("m")==3)
                array_push($datos,"Marzo ".$date->format("Y"));
            if($date->format("m")==4)
                array_push($datos,"Abril ".$date->format("Y"));
            if($date->format("m")==5)
                array_push($datos,"Mayo ".$date->format("Y"));
            if($date->format("m")==6)
                array_push($datos,"Junio ".$date->format("Y"));
            if($date->format("m")==7)
                array_push($datos,"Julio ".$date->format("Y"));
            if($date->format("m")==8)
                array_push($datos,"Agosto ".$date->format("Y"));
            if($date->format("m")==9)
                array_push($datos,"Septiembre ".$date->format("Y"));
            if($date->format("m")==10)
                array_push($datos,"Octubre ".$date->format("Y"));
            if($date->format("m")==11)
                array_push($datos,"Noviembre ".$date->format("Y"));
            if($date->format("m")==12)
                array_push($datos,"Diciembre ".$date->format("Y"));

            array_push($datos, $date->format("m").$date->format("Y"));

            $datos_riesgo=ri_estrategia_accion::join("ri_factores","ri_factores.id_factor","=","ri_estrategia_accion.id_factor")
                ->join("ri_registro_riesgo","ri_registro_riesgo.id_reg_riesgo","=","ri_factores.id_reg_riesgo")
                ->join("ri_riesgo","ri_riesgo.id_riesgo","=","ri_registro_riesgo.id_riesgo")
                ->join("ri_requisitos","ri_requisitos.id_requisito","=","ri_riesgo.id_requisito")
                ->join("ri_unidad_parte","ri_unidad_parte.id_uni_p","=","ri_requisitos.id_uni_p")
                ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","=","ri_unidad_parte.id_unidad_admin")
                ->select("ri_estrategia_accion.*","gnral_unidad_administrativa.*")
                ->whereYear("fecha_final","=", $date->format("Y"))
                ->whereMonth("fecha_final","=", $date->format("m"))
                ->get();


            $datos_oportunidad= ri_o_planseguimiento::join("ri__reg_oportunidad","ri__reg_oportunidad.id_oportunidad","=","ri_o_planseguimiento.id_oportunidad")
                ->join("ri_requisitos","ri_requisitos.id_requisito","=","ri__reg_oportunidad.id_requisito")
                ->join("ri_unidad_parte","ri_unidad_parte.id_uni_p","=","ri_requisitos.id_uni_p")
                ->join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","=","ri_unidad_parte.id_unidad_admin")
                ->select("ri_o_planseguimiento.*","gnral_unidad_administrativa.*")
                ->whereYear("fecha","=", $date->format("Y"))
                ->whereMonth("fecha","=", $date->format("m"))
                ->get();

            array_push($datos,compact('datos_riesgo',"datos_oportunidad"));
            array_push($array_full,$datos);
            //dd($array_full);
        }

        //dd($array_full);
        return  view("riesgos.cronograma",compact("array_full"));

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

        $dato=null;
        if($request->action=="oportunidad")
        $dato=ri_o_planseguimiento::find($id);
        if($request->action=="riesgo")
            $dato=ri_estrategia_accion::find($id);

        $dato->released=!$dato->released;
            $dato->comments=$request->comments;
           $dato->save();


            return redirect()->back();
    }

    public function updateFile(Request $request, $id)
    {
        //

        $dato=null;
        if($request->action=="oportunidad")
            $dato=ri_o_planseguimiento::find($id);
        if($request->action=="riesgo")
            $dato=ri_estrategia_accion::find($id);

        if($request->value==0)
        {
            Storage::disk('public')->delete($dato->file);
            $dato->file=null;
        }
        $dato->status=$request->value;
        $dato->save();



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

    public function updateDateRiesgo(ri_estrategia_accion $id,Request $request){
     $id->fecha=$request->fecha_final_edit_ri;
     $id->update();
    }
    public function updateDateOportunidad(ri_o_planseguimiento $id,Request $request){
        $id->fecha=$request->fecha_final_edit_ri;
        $id->update();
    }
}
