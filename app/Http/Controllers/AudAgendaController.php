<?php

namespace App\Http\Controllers;

use App\AudActividades;
use App\AudAgenda;
use App\AudAgendaActividad;
use App\AudAgendaActividadArea;
use App\AudAgendaActividadPersona;
use App\AudAgendaArea;
use App\AudAgendaAuditor;
use App\AudAgendaEvento;
use App\AudAgendaProceso;
use App\AudAreaGeneral;
use App\AudAreaGeneralUnidad;
use App\AudAuditorAuditoria;
use App\AudAuditores;
use App\AudAuditoriaProceso;
use App\AudAuditorias;
use App\audParseCase;
use App\AudPersonalGeneral;
use App\AudPersonalGeneralPersonal;
use App\AudValidarAgenda;
use App\Gnral_Personales;
use App\gnral_unidad_administrativa;
use App\ri_proceso_unidad;
use App\SgcAgenda;
use App\SgcAsignaAudi;
use App\SgcAuditorias;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Collection;

class AudAgendaController extends Controller
{
    private $horas_f=[];
    private $procesosT=[];
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
        $validator = Validator::make($request->all(), [
            'fecha' => 'required',
            'procesos' => 'required',
            'inicio' => 'required',
            'fin' => 'required',

        ]);
        //dd(json_decode($request->get('responsable')));

        if ($validator->fails()) {
          //  dd($validator->errors());
            return back()->withErrors($validator->errors())->withInput($request->input());
        }
        $procesos = self::resolveProcesses(json_decode($request->get('procesos')));
        $areas = AudValidarAgenda::resolveAreas(json_decode($request->get('area')));
        $responsables = AudValidarAgenda::resolveResponsibles(json_decode($request->get('responsable')),$request->fecha);

     //   dd($responsables);
        if ($procesos['tipo'] == "procesos") {
            $agenda = AudAgenda::create(array(
                'id_auditoria' => $request->get('id_auditoria'),
                'fecha' => $request->get('fecha'),
                'hora_i' => $request->get('inicio'),
                'hora_f' => $request->get('fin'),
                'criterios' => $request->get('criterios'),
            ));

            foreach ($procesos['elementos'] as $proceso) {
                AudAgendaProceso::create(array(
                    'id_agenda' => $agenda->id_agenda,
                    'id_auditoria_proceso' => $proceso
                ));
            }
            foreach ($responsables as $responsable) {
                AudAgendaAuditor::create(array(
                    'id_agenda' => $agenda->id_agenda,
                    'id_auditor_auditoria' => $responsable
                ));
            }
            foreach ($areas as $area) {
                AudAgendaArea::create(array(
                    'id_agenda' => $agenda->id_agenda,
                    'id_area' => $area
                ));
            }
        }
        elseif ($procesos['tipo'] == "actividades") {
            foreach ($procesos['elementos'] as $actividad){
                $agendaTarea=AudAgendaActividad::create(array(
                    'id_actividad' => $actividad,
                    'id_auditoria' => $request->get('id_auditoria'),
                    'fecha' => $request->get('fecha'),
                    'hora_i' => $request->get('inicio'),
                    'hora_f' => $request->get('fin'),
                    )
                );
                if (sizeof($areas)>0)
                    foreach ($areas as $area){
                        AudAgendaActividadArea::create(array(
                            'id_agenda_actividad' => $agendaTarea->id_agenda_actividad,
                            'id_area' => $area
                        ));
                    }
                if (sizeof($responsables)>0)
                    foreach ($responsables as $responsable){
                        $dato=AudAgendaActividadPersona::create(array(
                            'id_agenda_actividad' => $agendaTarea->id_agenda_actividad,
                            'id_personal' => $responsable
                        ));
                       // dd($dato);
                    }
            }
        }
        return back();
    }

    /*public function store2(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'fecha' => 'required',
            'procesos' => 'required',
            'area' => 'required',
            'auditor' => 'required',
            'inicio' => 'required',
            'fin' => 'required'
        ]);
        if($validator->fails()){
            Session::put('errors',$validator->errors());
            return back();
        }
        $agenda=AudAgenda::create(array(
            'fecha' => $request->get('fecha'),
            'hora_i' => $request->get('inicio'),
            'hora_f' => $request->get('fin'),
            'id_area' => $request->get('area'),
            'criterios' => $request->get('criterios'),
        ));
        $procesos=explode(',',str_replace(']','',str_replace('[','',$request->get('procesos'))));
        for ($i=0;$i<sizeof($procesos);$i++){

            AudAgendaEvento::create(array(
                'id_agenda' => $agenda->id_agenda,
                'id_auditoria_proceso' => $procesos[$i],
                'id_auditor_auditoria' => $request->get('auditor')
            ));
            if ($request->get('auditor_entrenamiento')){
                AudAgendaEvento::create(array(
                    'id_agenda' => $agenda->id_agenda,
                    'id_auditoria_proceso' => $procesos[$i],
                    'id_auditor_auditoria' => $request->get('auditor_entrenamiento')

                ));
            }
        }
        Session::forget('editando');
        Session::forget('procesos-agenda');
        return back();

    }*/

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id){

        $datos=$this->getDatos($id);
        $auditoria=$datos["auditoria"];
        $auditorias=$datos["auditorias"];
        $fechas=$datos["fechas"];
        $areasT=$datos["areasT"];
        $procesosAsignados=$datos["procesosAsignados"];
        $actividades=$datos["actividades"];
        $auditoresT=$datos["auditoresT"];
        $agendaT=$datos["agendaT"];
        $procesosT=$datos["procesosT"];
        $esLider=$datos["esLider"];
        $porcentaje=$datos["porcentaje"];
        $generalAreas=$datos["generalAreas"];
        $generalPersonales=$datos["generalPersonales"];
        $agendaFinal=$datos["agendaFinal"];

        //dd($agendaFinal);
        return view('auditorias.agenda2',compact('auditoria','auditorias','fechas', 'areasT' ,'procesosAsignados', 'actividades','auditoresT','agendaT','procesosT','esLider','porcentaje','generalAreas','generalPersonales','agendaFinal'));
    }
    public function getDatos($id){
        $auditoria=AudAuditorias::find($id);

        $programa=AudAuditorias::find($id);
        $auditorias=AudAuditorias::orderBy('fecha_i','ASC')->where('id_programa',$programa->id_programa)->get();

        $fechas = $this->generateDateRange(Carbon::parse($auditoria->fecha_i),Carbon::parse($auditoria->fecha_f));

        $procesosAsignados=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso','ri_proceso.id_proceso')
            ->orderBy('ri_proceso.clave','ASC')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();

        $procesosAsignados->map(function($value){
            $value->unidades=ri_proceso_unidad::where("id_proceso",$value->id_proceso)->select("id_unidad_admin")->pluck("id_unidad_admin");
        });

        // dd($procesosAsignados);


        $auditoresT=AudAuditorAuditoria::join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
            ->where('aud_auditor_auditoria.id_auditoria','=',$id)
            ->where('aud_auditor_auditoria.deleted_at','=',NULL)
            ->select('aud_auditor_auditoria.id_categoria','aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre','abreviaciones.titulo')
            ->orderBy('aud_auditor_auditoria.id_categoria','ASC')
            ->orderBy('gnral_personales.sexo','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();

        $areasT=gnral_unidad_administrativa::orderBy('nom_departamento','ASC')->get();

        $agendaT=AudAgenda::where('id_auditoria',$id)
            ->select('id_agenda','fecha','hora_i','hora_f','criterios')
            ->orderBy('fecha','ASC')
            ->orderBy('hora_i','ASC')
            ->orderBy('hora_f','ASC')
            ->orderBy("id_agenda","ASC")
            ->get();
        $this->procesosT=[];

        $generalAreas=AudAreaGeneral::select('id_area_general','descripcion')->get();
        $generalAreas->map(function($value){
            $id_areas=[];
            $result=AudAreaGeneralUnidad::where('id_area_general',$value->id_area_general);
            if ($result->count()>0){
                $result=$result->get();
                foreach ($result as $item){
                    array_push($id_areas,$item->id_unidad_admin);
                }
            }
            $value['involucradas']=$id_areas;
        });
        $generalPersonales=AudPersonalGeneral::select('id_personal_general','descripcion')->get();
        $generalPersonales->map(function ($value){
            $id_personales=[];
            $result=AudPersonalGeneralPersonal::where('id_personal_general',$value->id_personal_general);
            if ($result->count()>0){
                $result=$result->get();
                foreach ($result as $item){
                    array_push($id_personales,$item->id_personal);
                }
            }
            $value['involucrados']=$id_personales;
        });

        //    dd($agendaT);
        $agendaT->map(function ($value) use ($auditoresT, $generalAreas){
            $result=AudAgendaAuditor::join('aud_auditor_auditoria','aud_agenda_auditor.id_auditor_auditoria','=','aud_auditor_auditoria.id_auditor_auditoria')
                ->where('aud_agenda_auditor.id_agenda',$value->id_agenda)
                ->select('aud_auditor_auditoria.id_auditor_auditoria','aud_auditor_auditoria.id_personal','aud_auditor_auditoria.id_categoria')
                ->orderBy('aud_auditor_auditoria.id_categoria','ASC');

            //  dd($result);
            if ($result->count()>0){
                $result=$result->get();
                $auditores=[];
                $id_auditores=[];
                $id_personal_lider=[];

                foreach ($result as $auditor){
                    $equipo=1;
                    $entrenamiento=1;
                    if ($auditor->id_categoria==1){
                        array_push($auditores,'Auditor Lider');
                        array_push($id_personal_lider,$auditor->id_personal);
                    }

                    elseif ($auditor->id_categoria==2){
                        foreach ($auditoresT as $item){
                            if ($item->id_categoria==2){
                                if ($item->id_auditor_auditoria==$auditor->id_auditor_auditoria)
                                    array_push($auditores,'Auditor '.$equipo);
                                $equipo++;
                            }
                        }
                    }
                    elseif ($auditor->id_categoria==3){
                        foreach ($auditoresT as $item){
                            if ($item->id_categoria==3){
                                if ($item->id_auditor_auditoria==$auditor->id_auditor_auditoria)
                                    array_push($auditores,'AE '.$entrenamiento);
                                $entrenamiento++;
                            }
                        }
                    }
                    array_push($id_auditores,$auditor->id_personal);
                }
                $value['auditores']=$auditores;
                $value['id_auditores']=$id_auditores;
                $value['id_personal_lider']=$id_personal_lider;
            }

            $result=AudAgendaProceso::join('aud_auditoria_proceso','aud_agenda_proceso.id_auditoria_proceso','=','aud_auditoria_proceso.id_auditoria_proceso')
                ->join('ri_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
                ->where('aud_agenda_proceso.id_agenda',$value->id_agenda)
                ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.des_proceso')
                ->orderBy('ri_proceso.des_proceso','ASC');
            // dd($result->get());
            if ($result->count()>0) {
                $procesos=[];
                $result = $result->get();
                foreach ($result as $proceso) {
                    if (!in_array($proceso->id_auditoria_proceso,$this->procesosT))
                        array_push($this->procesosT,$proceso->id_auditoria_proceso);

                    array_push($procesos,audParseCase::parseProceso($proceso->des_proceso));
                }
                $value['procesos']=$procesos;
            }

            $result=AudAgendaArea::join('gnral_unidad_administrativa','aud_agenda_area.id_area','=','gnral_unidad_administrativa.id_unidad_admin')
                ->where('aud_agenda_area.id_agenda',$value->id_agenda)
                ->select('gnral_unidad_administrativa.id_unidad_admin','gnral_unidad_administrativa.nom_departamento')
                ->orderBy('gnral_unidad_administrativa.nom_departamento','ASC');
            if ($result->count()>0) {
                $areas=[];
                $id_areas=[];
                $result = $result->get();
                foreach ($result as $area) {
                    array_push($areas,audParseCase::parseNombre($area->nom_departamento));
                    array_push($id_areas,$area->id_unidad_admin);
                }
                $coincidencia=[];
                $nom_general=[];
                foreach ($generalAreas as $general){
                    if (sizeof($general->involucradas)==sizeof($id_areas)){
                        $coincidencia=array_intersect($general->involucradas,$id_areas);
                        if (sizeof($coincidencia)==sizeof($id_areas))
                            array_push($nom_general,$general->descripcion);
                    }
                }
                if (sizeof($coincidencia)>0)
                    $value['areas']=$nom_general;
                else
                    $value['areas']=$areas;
            }
            return $value;
        });
        $procesosT=$this->procesosT;
        $esLider=false;
        if ($idLider = AudAuditores::where('id_categoria',1)->get()[0]->id_personal==Session::get('id_perso')){
            $esLider=true;$idLider = AudAuditores::where('id_categoria',1)->get()[0];
        }
        $porcentaje=ceil((sizeof($procesosT)*100)/$procesosAsignados->count());

        $actividades=AudActividades::all();
        $agendaActividadT=AudAgendaActividad::join('aud_actividad','aud_agenda_actividad.id_actividad','=','aud_actividad.id_actividad')
            ->where('aud_agenda_actividad.id_auditoria',$id)
            ->select('aud_actividad.descripcion','aud_agenda_actividad.id_agenda_actividad','aud_agenda_actividad.fecha','aud_agenda_actividad.hora_i','aud_agenda_actividad.hora_f')
            ->orderBy('fecha','ASC')
            ->orderBy('hora_i','ASC')
            ->orderBy('hora_f','ASC')->get();

        //   dd($agendaActividadT);
        $agendaActividadT->map(function ($value) use($auditoresT, $generalAreas, $generalPersonales){
            $result=AudAgendaActividadArea::join('gnral_unidad_administrativa','aud_agenda_actividad_area.id_area','=','gnral_unidad_administrativa.id_unidad_admin')
                ->where('aud_agenda_actividad_area.id_agenda_actividad',$value->id_agenda_actividad)
                ->select('gnral_unidad_administrativa.id_unidad_admin','gnral_unidad_administrativa.nom_departamento')
                ->orderBy('gnral_unidad_administrativa.nom_departamento','ASC');
            if ($result->count()>0) {
                $areas=[];
                $id_areas=[];
                $result = $result->get();
                foreach ($result as $area) {
                    array_push($areas,audParseCase::parseNombre($area->nom_departamento));
                    array_push($id_areas,$area->id_unidad_admin);
                }
                $coincidencia=[];
                $nom_general=[];
                foreach ($generalAreas as $general){
                    if (sizeof($general->involucradas)==sizeof($id_areas)){
                        $coincidencia=array_intersect($general->involucradas,$id_areas);
                        if (sizeof($coincidencia)==sizeof($id_areas))
                            array_push($nom_general,$general->descripcion);
                    }
                }
                if (sizeof($coincidencia)>0)
                    $value['areas']=$nom_general;
                else
                    $value['areas']=$areas;
            }

            $result=AudAgendaActividadPersona::join('gnral_personales','aud_agenda_actividad_persona.id_personal','=','gnral_personales.id_personal')
                ->where('aud_agenda_actividad_persona.id_agenda_actividad',$value->id_agenda_actividad)
                ->select('gnral_personales.id_personal');
            if ($result->count()>0){
                $result=$result->get();
                $auditores=[];
                $id_personales=[];
                $id_personal_lider=[];
                foreach ($result as $personal){
                    array_push($id_personales,$personal->id_personal);
                }
                static $nom_general=[];
                foreach ($generalPersonales as $general){
                    if (sizeof($general->involucrados)==sizeof($id_personales)){
                        $coincidencia=array_intersect($general->involucrados,$id_personales);
                        if (sizeof($coincidencia)==sizeof($id_personales))
                            array_push($nom_general,$general->descripcion);
                    }
                }
                if (sizeof($nom_general)>0)
                    $value['personal']=$nom_general;
                else{
                    /*$result=AudAgendaActividadPersona::join('gnral_personales','aud_agenda_actividad_persona.id_personal','=','gnral_personales.id_personal')
                        ->join('aud_auditor_auditoria','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
                        ->where('aud_agenda_actividad_persona.id_agenda_actividad',$value->id_agenda_actividad)
                        ->select('aud_auditor_auditoria.id_auditor_auditoria','aud_auditor_auditoria.id_personal','aud_auditor_auditoria.id_categoria')
                        ->orderBy('aud_auditor_auditoria.id_categoria','ASC');*/
                    $result=AudAgendaActividadPersona::join('aud_auditor_auditoria','aud_agenda_actividad_persona.id_personal','=','aud_auditor_auditoria.id_auditor_auditoria')
                        ->where('aud_agenda_actividad_persona.id_agenda_actividad',$value->id_agenda_actividad)
                        ->select('aud_auditor_auditoria.id_auditor_auditoria','aud_auditor_auditoria.id_personal','aud_auditor_auditoria.id_categoria')
                        ->orderBy('aud_auditor_auditoria.id_categoria','ASC');
                    if ($result->count()>0){
                        $result=$result->get();
                        $auditores=[];
                        $id_auditores=[];
                        $id_personal_lider=[];
                        foreach ($result as $auditor){
                            $equipo=1;
                            $entrenamiento=1;
                            if ($auditor->id_categoria==1){
                                array_push($auditores,'Auditor Lider');
                                array_push($id_personal_lider,$auditor->id_personal);
                            }

                            elseif ($auditor->id_categoria==2){
                                foreach ($auditoresT as $item){
                                    if ($item->id_categoria==2){
                                        if ($item->id_auditor_auditoria==$auditor->id_auditor_auditoria)
                                            array_push($auditores,'Auditor '.$equipo);
                                        $equipo++;
                                    }
                                }
                            }
                            elseif ($auditor->id_categoria==3){
                                foreach ($auditoresT as $item){
                                    if ($item->id_categoria==3){
                                        if ($item->id_auditor_auditoria==$auditor->id_auditor_auditoria)
                                            array_push($auditores,'AE '.$entrenamiento);
                                        $entrenamiento++;
                                    }
                                }
                            }
                            array_push($id_auditores,$auditor->id_personal);
                        }
                        //    $value['id_agenda'] = $value['id_agenda_actividad'];
                        $value['personal']=$auditores;
                        $value['id_auditores']=$id_auditores;
                        $value['id_personal_lider']=$id_personal_lider;
                    }
                }
            }

        });

        $agend=$agendaT->merge($agendaActividadT)->sortBy("fecha")->sortBy("hora_i");
        // dd($agend);
        $agendaF=collect();

        foreach ($agend as $item){
            if (isset($item->criterios))
                $criterios=$item->criterios;
            else
                $criterios="";
            if (isset($item->procesos))
                $procesos=$item->procesos;
            elseif (isset($item->descripcion))
                $procesos=$item->descripcion;
            if (isset($item->auditores))
                $responsables=$item->auditores;
            elseif (isset($item->personal))
                $responsables=$item->personal;
            else
                $responsables=array();
            if (isset($item->areas))
                $areas=$item->areas;
            else
                $areas=array();
            if (isset($item->id_auditores)){
                $id_auditores=$item->id_auditores;
                if(isset($item->id_agenda)) {
                    $id_agenda=$item->id_agenda;
                    $tipo = 1;
                }
                else{
                    $id_agenda=$item->id_agenda_actividad;
                    $tipo = 2;
                }
            }
            else{
                $id_auditores=array();
                $tipo=2;
                $id_agenda=$item->id_agenda_actividad;
            }
            if (isset($item->id_personal_lider))
                $id_personal_lider=$item->id_personal_lider;
            else
                $id_personal_lider=array();
            //dd($id_agenda);
            $agendaF->push([
                'id_agenda' => $id_agenda,
                'tipo' => $tipo,
                'fecha' => $item->fecha,
                'inicio' => $item->hora_i,
                'fin' => $item->hora_f,
                'criterios' => $criterios,
                'procesos' => $procesos,
                'responsables' => $responsables,
                'areas' => $areas,
                'id_auditores' => $id_auditores,
                'id_personal_lider' => $id_personal_lider
            ]);
        }

        $datos=[
            'auditoria'=>$auditoria,
            'auditorias'=>$auditorias,
            'fechas'=>$fechas,
            'areasT'=>$areasT,
            'procesosAsignados'=>$procesosAsignados,
            'actividades'=>$actividades,
            'auditoresT'=>$auditoresT,
            'agendaT'=>$agendaT,
            'procesosT'=>$procesosT,
            'esLider'=>$esLider,
            'porcentaje'=>$porcentaje,
            'generalAreas'=>$generalAreas,
            'generalPersonales'=>$generalPersonales,
            'agendaFinal'=>$agendaF->sortBy('fecha')->sortBy('inicio')->sortBy('fin'),
        ];
        return $datos;
    }

    public function show2($id)
    {
        //
        $programa_fecha=AudAuditorias::where('id_auditoria',$id)->get()->pluck('id_programa');
        $auditorias=AudAuditorias::orderBy('fecha_i','ASC')->where('id_programa',$programa_fecha)->get();
        $auditoria=AudAuditorias::where('id_auditoria',$id)->get();
        $auditoria_id=$id;
        foreach ($auditoria as $auditoria_dat) {
            $fechas = $this->generateDateRange(Carbon::parse($auditoria_dat->fecha_i),Carbon::parse($auditoria_dat->fecha_f));
        }
        $this->generateTimeRange(Carbon::parse("09:00:00"),Carbon::parse("18:00:00"));
        $horario=$this->horas_f;

        $procesos=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.des_proceso')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get()->whereIn('id_auditoria_proceso',Session::get('procesos-agenda'));


        $procesosAsignados=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();

        $actividades=AudActividades::all();

        $procesosE=Session::get('procesos-agenda');


        $auditoresT=AudAuditorAuditoria::join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
            ->where('aud_auditor_auditoria.id_auditoria','=',$id)
            ->where('aud_auditor_auditoria.deleted_at','=',NULL)
            ->select('aud_auditor_auditoria.id_categoria','aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre','abreviaciones.titulo')
            ->orderBy('aud_auditor_auditoria.id_categoria','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();




        $auditor_l=DB::table('aud_auditor_auditoria')
            ->join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
            ->where('aud_auditor_auditoria.id_auditoria','=',$id)
            ->where('aud_auditor_auditoria.deleted_at','=',NULL)
            ->where('aud_auditor_auditoria.id_categoria','=',1)
            ->select('aud_auditor_auditoria.id_categoria','aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre','abreviaciones.titulo')
            ->orderBy('aud_auditor_auditoria.id_categoria','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get()[0];

        $auditores=DB::table('aud_auditor_auditoria')
            ->join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
            ->where('aud_auditor_auditoria.id_auditoria','=',$id)
            ->where('aud_auditor_auditoria.deleted_at','=',NULL)
            ->where('aud_auditor_auditoria.id_categoria','=',2)
            ->select('aud_auditor_auditoria.id_categoria','aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre','abreviaciones.titulo')
            ->orderBy('aud_auditor_auditoria.id_categoria','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();

        $auditores_entrenamiento=DB::table('aud_auditor_auditoria')
            ->join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
            ->where('aud_auditor_auditoria.id_auditoria','=',$id)
            ->where('aud_auditor_auditoria.deleted_at','=',NULL)
            ->where('aud_auditor_auditoria.id_categoria','=',3)
//            ->select('aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre')
//            ->orderBy('gnral_personales.nombre','ASC')
            ->select('aud_auditor_auditoria.id_categoria','aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre','abreviaciones.titulo')
            ->orderBy('aud_auditor_auditoria.id_categoria','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();

        $auditores_all=DB::table('aud_auditor_auditoria')
            ->join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
            ->where('aud_auditor_auditoria.id_auditoria','=',$id)
            ->where('aud_auditor_auditoria.deleted_at','=',NULL)
            ->select('aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();

        $areas=gnral_unidad_administrativa::orderBy('nom_departamento','ASC')->get();


        $horasAgenda=DB::table('aud_agenda')
            ->join('aud_agenda_evento','aud_agenda.id_agenda','=','aud_agenda_evento.id_agenda')
            ->join('aud_auditor_auditoria','aud_auditor_auditoria.id_auditor_auditoria','=','aud_agenda_evento.id_auditor_auditoria')
            ->join('gnral_unidad_administrativa','gnral_unidad_administrativa.id_unidad_admin','=','aud_agenda.id_area')
            ->where('aud_auditor_auditoria.id_auditoria','=',$id)
            ->select('aud_agenda.id_agenda','aud_agenda.fecha','aud_agenda.hora_i','aud_agenda.hora_f','gnral_unidad_administrativa.nom_departamento','aud_agenda.criterios')
            ->orderBy('aud_agenda.fecha','ASC')
            ->orderBy('aud_agenda.hora_i','ASC')
            ->orderBy('aud_agenda.hora_f','ASC')
            ->distinct()
            ->get();
//        $fechasAgenda=AudAgenda::orderBy('hora_i','ASC')->whereIn('id_auditor_auditoria',$auditores_all->pluck('id_auditor_auditoria'))->get();

//        $agendas_all=DB::table('aud_agenda')
//            ->join('aud_auditor_auditoria','aud_auditor_auditoria.id_auditor_auditoria','=','aud_agenda.id_auditor_auditoria')
//            ->join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
//            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','aud_auditor_auditoria.id_personal')
//            ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
//            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_auditoria_proceso','=','aud_agenda.id_auditoria_proceso')
//            ->join('ri_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
//            ->join('gnral_unidad_administrativa','gnral_unidad_administrativa.id_unidad_admin','=','aud_agenda.id_area')
//            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
//            ->select('aud_agenda.id_agenda','aud_agenda.fecha','aud_agenda.hora_i','aud_agenda.hora_f','gnral_unidad_administrativa.nom_departamento', 'abreviaciones.titulo','gnral_personales.nombre','ri_proceso.des_proceso')
//            ->get();
        $procesosAuditoria=AudAuditoriaProceso::where('id_auditoria',$id)->get();
        $procesosEnAgenda=DB::table('aud_agenda_evento')
            ->join('aud_agenda','aud_agenda_evento.id_agenda','=','aud_agenda.id_agenda')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_auditoria_proceso','=','aud_agenda_evento.id_auditoria_proceso')
            ->join('aud_auditoria','aud_auditoria_proceso.id_auditoria','=','aud_auditoria.id_auditoria')
            ->where('aud_auditoria.id_auditoria','=',$id)
            ->select('aud_agenda_evento.id_auditoria_proceso')
            ->distinct()
            ->get()
            ->pluck('id_auditoria_proceso');
        $porcentaje=round(sizeof($procesosEnAgenda)*100/count($procesosAuditoria));

      //  dd("todo;");
        return view('auditorias.agenda',compact('variables','auditoria_id','auditorias','fechas','horario', 'procesos','auditores','auditor_l','areas','procesosE','auditores_entrenamiento','horasAgenda','porcentaje', 'procesosAsignados','actividades','auditoresT'));
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

    public function edit2($id,$dia)
    {
        //
        Session::put('dia',$dia);
        Session::put('editando',true);
        $procesos=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();
        $auditoria_id=$id;
        return view('auditorias.edita_procesos_agenda',compact('datos','procesos','auditoria_id'));
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
     //   dd($id);
        $data=$_REQUEST;
        if ($data['tipo']==1){
            AudAgendaArea::where('id_agenda',$id)->delete();
            AudAgendaAuditor::where('id_agenda',$id)->delete();
            AudAgendaProceso::where('id_agenda',$id)->delete();
            AudAgenda::destroy($id);

        }
        else{
            //dd($id);
            AudAgendaActividadPersona::where('id_agenda_actividad',$id)->delete();
            AudAgendaActividadArea::where('id_agenda_actividad',$id)->delete();
            AudAgendaActividad::destroy($id);
        }

        return back();
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
//        for($hour = $start_hour; $hour->lte($end_hour); $hour->addMinute('30')) {
        $hour=$start_hour;
        while($hour->lte($end_hour)){
            $rango[]=
            $this->horas_f[]=[
                'inicio' => $hour->format('H').':'.$hour->format('i'),
                'fin' => $hour->addMinute('30')->format('H').':'.$hour->format('i')
            ];
        }
    }

    private function resolveResponsibles($responsibles){
        if (sizeof($responsibles[0]->especificos)>0)
            return $responsibles[0]->especificos;
        else{

        }
    }
    private function resolveProcesses($processes){
        if (sizeof($processes[0]->especificos)>0)
            return array('tipo'=>'procesos','elementos'=>$processes[0]->especificos);
        else{
            return array('tipo'=>'actividades','elementos'=>$processes[0]->generales);
        }
    }
    private function resolveAreas($areas){
        if (sizeof($areas[0]->especificos)>0)
            return $areas[0]->especificos;
        else{
            $array_resolve=[];
            foreach ($areas[0]->generales as $area) {
                $resolve=AudAreaGeneral::join('aud_area_general_unidad','aud_area_general.id_area_general','=','aud_area_general_unidad.id_area_general')
                    ->where('aud_area_general.id_area_general',$area)
                    ->select('aud_area_general_unidad.id_unidad_admin')
                    ->get();
                foreach ($resolve as $area){
                    array_push($array_resolve, $area->id_unidad_admin);
                }
            }
            return $array_resolve;
        }
    }
}
