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
use App\AudAuditorias;
use App\audParseCase;
use App\AudPersonalGeneral;
use App\AudPersonalGeneralPersonal;
use App\gnral_unidad_administrativa;
use App\GnralJefeUnidadAdministrativa;
use App\ri_proceso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AudAgendaEventoController extends Controller
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
        $agendaT=AudAgenda::where('id_agenda',$id)
            ->select('id_agenda','id_auditoria','fecha','hora_i','hora_f','criterios')
            ->orderBy('fecha','ASC')
            ->orderBy('hora_i','ASC')
            ->orderBy('hora_f','ASC')->get();

        $auditoria=AudAuditorias::where('id_auditoria', $agendaT[0]->id_auditoria)->get();

        $procesosAsignados=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$auditoria[0]->id_auditoria)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();

        $actividades=AudActividades::all();

        $auditoresT=AudAuditorAuditoria::join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
            ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
            ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
            ->where('aud_auditor_auditoria.id_auditoria','=',$auditoria[0]->id_auditoria)
            ->where('aud_auditor_auditoria.deleted_at','=',NULL)
            ->select('aud_auditor_auditoria.id_categoria','aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre','abreviaciones.titulo')
            ->orderBy('aud_auditor_auditoria.id_categoria','ASC')
            ->orderBy('gnral_personales.sexo','ASC')
            ->orderBy('gnral_personales.nombre','ASC')
            ->get();

        $areas=gnral_unidad_administrativa::orderBy('nom_departamento','ASC')->get();

        $areas->map(function ($value){
            $value['nom_departamento']=audParseCase::parseNombre($value['nom_departamento']);
            return $value;
        });

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

        $agendaT->map(function ($value) use ($auditoresT, $generalAreas){
            $result=AudAgendaAuditor::join('aud_auditor_auditoria','aud_agenda_auditor.id_auditor_auditoria','=','aud_auditor_auditoria.id_auditor_auditoria')
                ->where('aud_agenda_auditor.id_agenda',$value->id_agenda)
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
                    array_push($id_auditores,$auditor->id_auditor_auditoria);
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
                $generales=[];
                $result = $result->get();
                foreach ($result as $area) {
                    array_push($areas,audParseCase::parseNombre($area->nom_departamento));
                    array_push($id_areas,$area->id_unidad_admin);
                }
                $coincidencia=[];
                foreach ($generalAreas as $general){
                    if (sizeof($general->involucradas)==sizeof($id_areas)){
                        $coincidencia=array_intersect($general->involucradas,$id_areas);
                        if (sizeof($coincidencia)==sizeof($id_areas))
                            array_push($generales,$general->descripcion);
                    }
                }
                if (sizeof($coincidencia)>0){
                    $value['areas']=array();
                    $value['areas_generales']=$generales;
                }
                else{
                    $value['areas']=$areas;
                    $value['areas_generales']=array();
                }
                $value['a']=$area;
                $value['b']=$generales;
                $value['c']=$coincidencia;

            }
            return $value;
        });
        $procesosT=$this->procesosT;

        return view('auditorias.edit_evento',compact('agendaT','actividades','procesosT','procesosAsignados','generalAreas','areas','auditoresT'));
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
        $auditoria_id=DB::table('aud_agenda_evento')
            ->join('aud_auditor_auditoria','aud_auditor_auditoria.id_auditor_auditoria','=','aud_agenda_evento.id_auditor_auditoria')
            ->join('aud_auditoria','aud_auditor_auditoria.id_auditoria','=','aud_auditoria.id_auditoria')
            ->where('aud_agenda_evento.id_agenda','=',$id)
            ->select('aud_auditoria.id_auditoria')
            ->distinct()
            ->get()[0]->id_auditoria;
        $procesos=DB::table('ri_proceso')
            ->join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
            ->where('aud_auditoria_proceso.id_auditoria','=',$auditoria_id)
            ->where('aud_auditoria_proceso.deleted_at','=',NULL)
            ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.des_proceso')
            ->orderBy('ri_proceso.des_proceso','ASC')
            ->get();
        if (!Session::get('procesos-evento'))
            Session::put('procesos-evento',AudAgendaEvento::where('id_agenda',$id)->get()->pluck('id_auditoria_proceso')->toArray());
        $auditoria_id=$id;
        return view('auditorias.edita_procesos_evento',compact('datos','auditoria_id','procesosE','procesos','id'));
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
        Session::forget('procesos-evento');
        Session::put('procesos-evento',json_decode($request->get('data')));

        return redirect('auditorias/evento/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public  function editar_evt($id,$type)
    {
        $id_agenda=$id;
        //
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
        $areas=gnral_unidad_administrativa::orderBy('nom_departamento','ASC')->get();
        $areas->map(function ($value){
            $value['nom_departamento']=audParseCase::parseNombre($value['nom_departamento']);
            return $value;
        });
        $actividades=AudActividades::all();
        $agendaT=[];
        $procesosT=[];
        $procesosAsignados=[];
        $auditoresT=[];
        $this->procesosT=[];
        $agendaT=AudAgenda::where('id_agenda',$id)
            ->select('id_agenda','id_auditoria','fecha','hora_i','hora_f','criterios')
            ->orderBy('fecha','ASC')
            ->orderBy('hora_i','ASC')
            ->orderBy('hora_f','ASC')->get();

        if ($type==1)
        {


            $auditoria=AudAuditorias::where('id_auditoria', $agendaT[0]->id_auditoria)->get();

            $procesosAsignados=ri_proceso::join('aud_auditoria_proceso','aud_auditoria_proceso.id_proceso','=','ri_proceso.id_proceso')
                ->where('aud_auditoria_proceso.id_auditoria','=',$auditoria[0]->id_auditoria)
                ->where('aud_auditoria_proceso.deleted_at','=',NULL)
                ->select('aud_auditoria_proceso.id_auditoria_proceso','ri_proceso.clave','ri_proceso.des_proceso')
                ->orderBy('ri_proceso.des_proceso','ASC')
                ->get();

            $auditoresT=AudAuditorAuditoria::join('gnral_personales','gnral_personales.id_personal','=','aud_auditor_auditoria.id_personal')
                ->join('abreviaciones_prof','abreviaciones_prof.id_personal','=','gnral_personales.id_personal')
                ->join('abreviaciones','abreviaciones.id_abreviacion','=','abreviaciones_prof.id_abreviacion')
                ->where('aud_auditor_auditoria.id_auditoria','=',$auditoria[0]->id_auditoria)
                ->where('aud_auditor_auditoria.deleted_at','=',NULL)
                ->select('aud_auditor_auditoria.id_categoria','aud_auditor_auditoria.id_auditor_auditoria','gnral_personales.nombre','abreviaciones.titulo')
                ->orderBy('aud_auditor_auditoria.id_categoria','ASC')
                ->orderBy('gnral_personales.sexo','ASC')
                ->orderBy('gnral_personales.nombre','ASC')
                ->get();

            $agendaT->map(function ($value) use ($auditoresT, $generalAreas){
                $result=AudAgendaAuditor::join('aud_auditor_auditoria','aud_agenda_auditor.id_auditor_auditoria','=','aud_auditor_auditoria.id_auditor_auditoria')
                    ->where('aud_agenda_auditor.id_agenda',$value->id_agenda)
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
                        array_push($id_auditores,$auditor->id_auditor_auditoria);
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
                    $generales=[];
                    $result = $result->get();
                    foreach ($result as $area) {
                        array_push($areas,audParseCase::parseNombre($area->nom_departamento));
                        array_push($id_areas,$area->id_unidad_admin);
                    }
                    $coincidencia=[];
                    foreach ($generalAreas as $general){
                        if (sizeof($general->involucradas)==sizeof($id_areas)){
                            $coincidencia=array_intersect($general->involucradas,$id_areas);
                            if (sizeof($coincidencia)==sizeof($id_areas))
                                array_push($generales,$general->descripcion);
                        }
                    }
                    if (sizeof($coincidencia)>0){
                        $value['areas']=array();
                        $value['areas_generales']=$generales;
                    }
                    else{
                        $value['areas']=$areas;
                        $value['areas_generales']=array();
                    }
                }
                return $value;
            });
            $procesosT=$this->procesosT;
        }

        //dd($agendaT);
        return view('auditorias.edit_evento',compact('agendaT','actividades','procesosT','procesosAsignados','generalAreas','areas','auditoresT','id_agenda'));
    }

    public function valida($id)
    {
        $this->horas_f=[];
        $datos=json_decode($_GET['datos']);
        $fecha="";
        $id_area=0;
        $id_auditor=0;
        $id_auditor_e=0;
        $id_proceso=0;
        $opcion=0;
        foreach ($datos as $dato){
            if($dato->name == "fecha") $fecha=$dato->value;
            elseif ($dato->name == "proceso") $id_proceso=$dato->value;
            elseif ($dato->name == "area") $id_area=$dato->value;
            elseif ($dato->name == "auditor") $id_auditor=$dato->value;
            elseif ($dato->name == "opcion") $opcion=$dato->value;
        }
        switch ($opcion){
            case 1:
                foreach ($datos as $dato){
                    if ($dato->name == "auditor_entrenamiento") $id_auditor_e=$dato->value;
                }

                $jefe_area=GnralJefeUnidadAdministrativa::where('id_unidad_admin',$id_area)->get()->pluck('id_personal');

                $auditor=DB::table('gnral_personales')
                    ->join('aud_auditor_auditoria','aud_auditor_auditoria.id_personal','=','gnral_personales.id_personal')
                    ->where('aud_auditor_auditoria.id_auditor_auditoria','=',$id_auditor)
                    ->select('gnral_personales.id_personal')
                    ->get()->pluck('id_personal');
                $auditor_e[0]=0;
                if ($id_auditor_e!=0){
                    $auditor_e=DB::table('gnral_personales')
                        ->join('aud_auditor_auditoria','aud_auditor_auditoria.id_personal','=','gnral_personales.id_personal')
                        ->where('aud_auditor_auditoria.id_auditor_auditoria','=',$id_auditor_e)
                        ->select('gnral_personales.id_personal')
                        ->get()->pluck('id_personal');
                }
                if ($jefe_area[0]==$auditor[0] || $jefe_area[0]==$auditor_e[0]){
                    return array("El auditor seleccionado es el Jefe del Area seleccionada");
                }
                else{
                    $agendaAud=DB::table('aud_agenda')
                        ->join('aud_agenda_evento','aud_agenda.id_agenda','=','aud_agenda_evento.id_agenda')
                        ->where('aud_agenda_evento.id_auditor_auditoria',$id_auditor)
                        ->where('aud_agenda.fecha',$fecha)
                        ->where('aud_agenda.id_agenda','<>',$id)
                        ->get();
//                    $agendaAud=AudAgenda::where('id_auditor_auditoria',$id_auditor)->where('fecha',$fecha)->get();
                    if ($id_auditor_e!=0)
                        $agendaAudE=DB::table('aud_agenda')
                            ->join('aud_agenda_evento','aud_agenda.id_agenda','=','aud_agenda_evento.id_agenda')
                            ->where('aud_agenda_evento.id_auditor_auditoria',$id_auditor_e)
                            ->where('aud_agenda.fecha',$fecha)
                            ->where('aud_agenda.id_agenda','<>',$id)
                            ->get();
//                        $agendaAudE=AudAgenda::where('id_auditor_auditoria',$id_auditor_e)->where('fecha',$fecha)->get();
                    foreach ($agendaAud as $agenda) {
                        $this->generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
                    }
                    if ($id_auditor_e!=0)
                        foreach ($agendaAudE as $agenda) {
                            $this->generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
                        }
                    $agendaArea=AudAgenda::where('id_area',$id_area)->where('fecha',$fecha)->where('aud_agenda.id_agenda','<>',$id)->get();
                    foreach ($agendaArea as $agenda) {
                        $this->generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
                    }
                    $horas_ocupadas=$this->horas_f;
                    $this->horas_f=[];
                    $this->generateTimeRange(Carbon::parse("09:00:00"),Carbon::parse("18:00:00"));
                    $horario=$this->horas_f;
                    return view('auditorias.calcula_horas_i',compact('datos','horas_ocupadas','horario'));
                }
            case 2:
                $inicio='';
                foreach ($datos as $dato){
                    if ($dato->name == "inicio") $inicio=$dato->value;
                    elseif ($dato->name == "auditor_entrenamiento") $id_auditor_e=$dato->value;
                }
                $agendaAud=DB::table('aud_agenda')
                    ->join('aud_agenda_evento','aud_agenda.id_agenda','=','aud_agenda_evento.id_agenda')
                    ->where('aud_agenda_evento.id_auditor_auditoria',$id_auditor)
                    ->where('aud_agenda.fecha',$fecha)
                    ->where('aud_agenda.hora_i','>',$inicio)
                    ->orderBy('aud_agenda.hora_i','ASC')
                    ->get();
//                $agendaAud = AudAgenda::orderBy('hora_i','ASC')->where('hora_i','>',$inicio)->where('id_auditor_auditoria', $id_auditor)->where('fecha', $fecha)->get();
                if ($id_auditor_e!=0)
                    $agendaAudE=DB::table('aud_agenda')
                        ->join('aud_agenda_evento','aud_agenda.id_agenda','=','aud_agenda_evento.id_agenda')
                        ->where('aud_agenda_evento.id_auditor_auditoria',$id_auditor_e)
                        ->where('aud_agenda.fecha',$fecha)
                        ->where('aud_agenda.hora_i','>',$inicio)
                        ->orderBy('aud_agenda.hora_i','ASC')
                        ->get();
//                    $agendaAudE=AudAgenda::orderBy('hora_i','ASC')->where('hora_i','>',$inicio)->where('id_auditor_auditoria',$id_auditor_e)->where('fecha',$fecha)->get();
                foreach ($agendaAud as $agenda) {
                    $this->generateTimeRange(Carbon::parse($agenda->hora_i), Carbon::parse($agenda->hora_f));
                }
                if ($id_auditor_e!=0){
                    foreach ($agendaAudE as $agenda) {
                        $this->generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f));
                    }
                }

                $agendaArea = AudAgenda::orderBy('hora_i','ASC')->where('hora_i','>',$inicio)->where('id_area', $id_area)->where('fecha', $fecha)->get();
                foreach ($agendaArea as $agenda) {
                    $this->generateTimeRange(Carbon::parse($agenda->hora_i), Carbon::parse($agenda->hora_f));
                }
                if (sizeof($this->horas_f))
                    $horas_ocupadas[]=min($this->horas_f);
                else $horas_ocupadas[]="18:00";
                $this->horas_f=[];
                if (sizeof($horas_ocupadas)>0){
                    $fin=$horas_ocupadas[0];
                    $this->generateTimeRange(Carbon::parse($inicio)->addMinute('30'), Carbon::parse($fin));
                }
                else
                    $this->generateTimeRange(Carbon::parse($inicio)->addMinute('30'), Carbon::parse('18:00'));
                $horario = $this->horas_f;
                return view('auditorias.calcula_horas_f', compact('datos', 'horario'));

            case 3:
                $jefe_area=GnralJefeUnidadAdministrativa::where('id_unidad_admin',$id_area)->get()->pluck('id_personal');

                $auditor=DB::table('gnral_personales')
                    ->join('aud_auditor_auditoria','aud_auditor_auditoria.id_personal','=','gnral_personales.id_personal')
                    ->select('gnral_personales.id_personal')
                    ->get()->pluck('id_personal');
                if ($jefe_area[0]==$auditor[0]){
                    return "El auditor seleccionado es el Jefe del Area seleccionada";
                }
                else{
                    $horas_ocupadas=[];
                    $this->generateTimeRange(Carbon::parse("09:00:00"),Carbon::parse("18:00:00"));
                    $horario=$this->horas_f;
                    return view('auditorias.calcula_horas_i',compact('datos','horas_ocupadas','horario'));
                }
        }
    }

    public function updateEvent(Request $request, $id){
      //  dd($request->all());
        $validator = Validator::make($request->all(), [
            'fecha' => 'required',
            'procesos' => 'required',
            'area' => 'required',
            'responsable' => 'required',
            'inicio' => 'required',
            'fin' => 'required'
        ]);
        if($validator->fails()){
            Session::put('errors',$validator->errors());
            return back();
        }
        AudAgenda::findOrFail($id)->update(array(
            'hora_i' => $request->get('inicio'),
            'hora_f' => $request->get('fin'),
            'id_area' => $request->get('area'),
            'criterios' => $request->get('criterios'),
        ));
        /*
        $eventos=AudAgendaEvento::where('id_agenda',$id)->get();
        foreach ($eventos as $evento)
            AudAgendaEvento::destroy($evento->id_agenda_evento);
        $procesos=explode(',',str_replace(']','',str_replace('[','',$request->get('procesos'))));
        for ($i=0;$i<sizeof($procesos);$i++){
            AudAgendaEvento::create(array(
                'id_agenda' => $id,
                'id_auditoria_proceso' => $procesos[$i],
                'id_auditor_auditoria' => $request->get('auditor')
            ));
            if ($request->get('auditor_entrenamiento')){
                AudAgendaEvento::create(array(
                    'id_agenda' => $id,
                    'id_auditoria_proceso' => $procesos[$i],
                    'id_auditor_auditoria' => $request->get('auditor_entrenamiento')

                ));
            }

        }*/
        Session::forget('procesos-evento');
      //  dd($id);
        $auditoria_id=DB::table('aud_agenda')
            ->join('aud_agenda_auditor','aud_agenda_auditor.id_agenda','=','aud_agenda.id_agenda')
            ->join('aud_auditor_auditoria','aud_auditor_auditoria.id_auditor_auditoria','=','aud_agenda_auditor.id_auditor_auditoria')
            ->where('aud_agenda.id_agenda','=',$id)
            ->select('aud_auditor_auditoria.id_auditoria')
            ->distinct()
            ->get()[0]->id_auditoria;
       // dd($auditoria_id);
        return redirect(url('auditorias/agenda').'/'.$auditoria_id);
    }

//    private function generateTimeRange(Carbon $start_hour, Carbon $end_hour) {
//        for($hour = $start_hour; $hour->lte($end_hour); $hour->addMinute('30')) {
//            $this->horas_f[]=$hour->format('H').':'.$hour->format('i');
//        }
//    }

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

}
