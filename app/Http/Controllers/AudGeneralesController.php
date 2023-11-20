<?php

namespace App\Http\Controllers;

use App\AudAgendaAuditor;
use App\AudAreaGeneral;
use App\AudAreaGeneralUnidad;
use App\AudAuditorAuditoria;
use App\AudAuditores;
use App\AudPersonalGeneral;
use App\AudPersonalGeneralPersonal;
use App\Gnral_Personales;
use App\gnral_unidad_administrativa;
use Illuminate\Http\Request;

class AudGeneralesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas=gnral_unidad_administrativa::orderBy('nom_departamento','ASC')->get();

        $areas_generales=AudAreaGeneral::orderBy('descripcion','ASC')->get();
        $areas_generales->map(function ($value){
            $result=AudAreaGeneralUnidad::where('id_area_general',$value->id_area_general);
            $areasA = [];
            if ($result->count()>0) {
                $result = $result->get();
                $areasA = [];
                foreach ($result as $area) {
                    array_push($areasA,$area->id_unidad_admin);
                }
            }
            $value->areas=$areasA;
        });

        $auditores=AudAuditores::join('gnral_personales','aud_auditores.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones_prof','gnral_personales.id_personal','=','abreviaciones_prof.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->select('abreviaciones.titulo','gnral_personales.nombre','aud_auditores.id_categoria','gnral_personales.id_personal')
            ->orderBy('aud_auditores.id_categoria','ASC')
            ->orderBy('gnral_personales.sexo','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();
        $equipo=1;
        $entrenamiento=1;
        $auditores->map(function ($value) use(&$equipo,&$entrenamiento){
            if ($value->id_categoria==1) $value['categoria']="Auditor Líder";
            elseif ($value->id_categoria==2) $value['categoria']="Auditor ".$entrenamiento++;
            else $value['categoria']="AE".$equipo++;
            return $value;
        });

        $id_personal_grupo=[];
        $personal_generales=AudPersonalGeneral::orderBy('descripcion','ASC')->get();
        $personal_generales->map(function ($value) use (&$id_personal_grupo){
            $result=AudPersonalGeneralPersonal::where('id_personal_general',$value->id_personal_general);
            $personal = [];
            if ($result->count()>0) {
                $result = $result->get();
                $personal = [];
                foreach ($result as $persona) {
                    array_push($personal,$persona->id_personal);
                    if (!in_array($persona->id_personal,$id_personal_grupo))
                        array_push($id_personal_grupo,$persona->id_personal);
                }
            }
            $value->personal=$personal;
        });

        $personalT=Gnral_Personales::join('abreviaciones_prof','gnral_personales.id_personal','=','abreviaciones_prof.id_personal')
            ->join('abreviaciones','abreviaciones_prof.id_abreviacion','=','abreviaciones.id_abreviacion')
            ->select('abreviaciones.titulo','gnral_personales.nombre','gnral_personales.id_personal')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();
        return view('auditorias.generales',compact('auditores','areas','areas_generales','personalT','personal_generales'));
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

        switch ($request->get('catalogo')){
            case 'areas':{
                $areaG=AudAreaGeneral::create(array(
                    'descripcion' => $request->get('descripcion')
                ));
                $areas=json_decode($request->get('areas'));
                for ($i=0; $i<sizeof($areas);$i++){
                    AudAreaGeneralUnidad::create(array(
                        'id_area_general' => $areaG->id_area_general,
                        'id_unidad_admin' => $areas[$i]
                    ));
                }
                return back();
            }
            case 'personal':{
                $personalG=AudPersonalGeneral::create(array(
                    'descripcion' => $request->get('descripcion')
                ));
                $personales=json_decode($request->get('personal'));
                for ($i=0; $i<sizeof($personales);$i++){
                    AudPersonalGeneralPersonal::create(array(
                        'id_personal_general' => $personalG->id_personal_general,
                        'id_personal' => $personales[$i]
                    ));
                }
                return back();
            }
        }
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
        switch ($request->get('catalogo')){
            case 'areas':{
                $areaUp= array(
                    'descripcion' => $request->get('descripcion')
                );
                AudAreaGeneral::find($id)->update($areaUp);

                AudAreaGeneralUnidad::where('id_area_general', $id)->delete();
                $areas=json_decode($request->get('areas'));
                for ($i=0; $i<sizeof($areas);$i++){
                    AudAreaGeneralUnidad::create(array(
                        'id_area_general' => $id,
                        'id_unidad_admin' => $areas[$i]
                    ));
                }
                return back();
            }
            case 'personal':{
                $personalUp=array(
                    'descripcion' => $request->get('descripcion')
                );
                AudPersonalGeneral::find($id)->update($personalUp);
                AudPersonalGeneralPersonal::where('id_personal_general',$id)->delete();
                $personales=json_decode($request->get('personal'));
                for ($i=0; $i<sizeof($personales);$i++){
                    AudPersonalGeneralPersonal::create(array(
                        'id_personal_general' => $id,
                        'id_personal' => $personales[$i]
                    ));
                }
                return back();
            }
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
        $request=$_REQUEST;
        if ($request['accion']=="area"){
            AudAreaGeneralUnidad::where('id_area_general',$id)->delete();
            AudAreaGeneral::find($id)->delete();
            return back();
        }
        else{
            AudPersonalGeneralPersonal::where('id_personal_general',$id)->delete();
            AudPersonalGeneral::find($id)->delete();
            return back();
        }

    }
}
