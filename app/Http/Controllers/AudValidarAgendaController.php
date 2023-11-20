<?php

namespace App\Http\Controllers;

use App\AudAgenda;
use App\AudAreaGeneral;
use App\AudAuditorAuditoria;
use App\AudAuditorias;
use App\AudValidarAgenda;
use App\Gnral_Personales;
use App\GnralJefeUnidadAdministrativa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AudValidarAgendaController extends Controller
{
    private $horas_f=[];
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
                        ->get();
//                    $agendaAud=AudAgenda::where('id_auditor_auditoria',$id_auditor)->where('fecha',$fecha)->get();
                    if ($id_auditor_e!=0)
                        $agendaAudE=DB::table('aud_agenda')
                            ->join('aud_agenda_evento','aud_agenda.id_agenda','=','aud_agenda_evento.id_agenda')
                            ->where('aud_agenda_evento.id_auditor_auditoria',$id_auditor_e)
                            ->where('aud_agenda.fecha',$fecha)
                            ->get();
//                        $agendaAudE=AudAgenda::where('id_auditor_auditoria',$id_auditor_e)->where('fecha',$fecha)->get();
                    foreach ($agendaAud as $agenda) {
                        $this->generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
                    }
                    if ($id_auditor_e!=0)
                        foreach ($agendaAudE as $agenda) {
                            $this->generateTimeRange(Carbon::parse($agenda->hora_i),Carbon::parse($agenda->hora_f)->subMinutes(1));
                        }
                    $agendaArea=AudAgenda::where('id_area',$id_area)->where('fecha',$fecha)->get();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        Session::forget('procesos-agenda');
        Session::put('procesos-agenda',json_decode($_GET['data']));

        return redirect('auditorias/agenda/'.$id);
    }

    public function setItem($id){
        Session::put('dia',$id);
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

    private function generateTimeRange(Carbon $start_hour, Carbon $end_hour) {
        for($hour = $start_hour; $hour->lte($end_hour); $hour->addMinute('30')) {
            $this->horas_f[]=$hour->format('H').':'.$hour->format('i');
        }
    }

    public function disponibilidad($id){
       //  dd($_GET['datos']);
        $datos=json_decode($_GET['datos']);
        //dd($datos);
        $fecha="";
        $areas=[];
        $responsables=[];
        $id_evento=0;
        $proceso=0;
        foreach ($datos as $dato){
            if($dato->name == 'fecha')
                $fecha=$dato->value;
            elseif ($dato->name == 'area')
                $areas=json_decode($dato->value);
            elseif($dato->name == 'responsable')
                $responsables=json_decode($dato->value);
            elseif ($dato->name == 'id_evento')
                $id_evento = $dato->value;
            elseif($dato->name=='procesos'&&isset(json_decode($dato->value)[0]->generales[0]))
                $proceso=json_decode($dato->value)[0]->generales[0];
        }
        //dd($proceso);
        $areas=AudValidarAgenda::resolveAreas($areas);
        $responsables=AudValidarAgenda::resolveResponsibles($responsables,$fecha);

        $responsable_jefe=AudValidarAgenda::checkRespons($responsables, $areas);
        if ($responsable_jefe==true&&$proceso==0)
            return array(['type' => 'Error', 'message' => 'El responsable del evento es jefe del área seleccionada']);
        else{
            $horas_ocupadas=AudValidarAgenda::checkAvailability($responsables,$areas,$fecha,$id_evento);
            $horario=AudValidarAgenda::generateRange("9:00:00","18:00:00");
            return view('auditorias.calcula_horas_i',compact('horas_ocupadas','horario'));
        }
            /*if (((sizeof($areas[0]->generales)>0)or(sizeof($areas[0]->especificos)>0)) and ((sizeof($responsables[0]->generales)>0)or(sizeof($responsables[0]->especificos)>0))){
                if (sizeof($areas[0]->especificos)>0){
                    if (sizeof($responsables[0]->especificos)>0){
                        $responsable_jefe=AudValidarAgenda::checkRespons($responsables, $areas[0]->especificos);
                        if ($responsable_jefe==true)
                            return array(['type' => 'Error', 'message' => 'El responsable del evento es jefe del área seleccionada']);
                        else{
                            $horas_ocupadas=AudValidarAgenda::checkAvailability($responsables,$areas[0]->especificos,$fecha,$id_evento);
                            $horario=AudValidarAgenda::generateRange("9:00:00","18:00:00");
                            return view('auditorias.calcula_horas_i',compact('horas_ocupadas','horario'));
                        }
                    }
                    else{

                    }
                }
                else{
                    if (sizeof($responsables[0]->especificos)>0){
                        $areas=AudValidarAgenda::checkInvolved($areas[0]->generales);
                        $responsable_jefe=AudValidarAgenda::checkRespons($responsables, $areas);
                        if ($responsable_jefe==true)
                            return array(['type' => 'Error', 'message' => 'El responsable del evento es jefe del área seleccionada']);
                        else{
                            $horas_ocupadas=AudValidarAgenda::checkAvailability($responsables,$areas,$fecha,$id_evento);
                            $horario=AudValidarAgenda::generateRange("9:00:00","18:00:00");
                            return view('auditorias.calcula_horas_i',compact('horas_ocupadas','horario'));
                        }
                    }
                    else{

                    }
                }
            }
            else{
                return array(['type' => 'Error', 'message' => 'Se debe seleccionar al menos un elemento de la sección Área y un elemento de la sección el Respondable']);
            }*/

    }

    public function hora($id){
        $datos=json_decode($_GET['datos']);
        $fecha="";
        $areas=[];
        $responsables=[];
        $inicio='';
        $id_evento=0;
        $proceso=0;
        foreach ($datos as $dato){
            if($dato->name == 'fecha')
                $fecha=$dato->value;
            elseif ($dato->name == 'area')
                $areas=json_decode($dato->value);
            elseif($dato->name == 'responsable')
                $responsables=json_decode($dato->value);
            elseif ($dato->name == "inicio") $inicio=$dato->value;
            elseif ($dato->name == "id_evento") $id_evento=$dato->value;
            elseif($dato->name=='procesos'&&isset(json_decode($dato->value)[0]->generales[0]))
                $proceso=json_decode($dato->value)[0]->generales[0];
        }


        $areas=AudValidarAgenda::resolveAreas($areas);
        $responsables=AudValidarAgenda::resolveResponsibles($responsables,$fecha);

        $responsable_jefe=AudValidarAgenda::checkRespons($responsables, $areas);
        if ($responsable_jefe==true&&$proceso==0)
            return array(['type' => 'Error', 'message' => 'El responsable del evento es jefe del área seleccionada']);
        else{
            $horas_finales=AudValidarAgenda::checkEnd($responsables,$areas,$fecha,$inicio);
            if (sizeof($horas_finales)>0)
                $horas_ocupadas[]=min($horas_finales);
            else $horas_ocupadas[]="18:00";
            if (sizeof($horas_ocupadas)>0){
                $horario=AudValidarAgenda::generateRange(Carbon::parse($inicio)->addMinute('30'), Carbon::parse($horas_ocupadas[0]));
            }
            else
                $horario=AudValidarAgenda::generateRange(Carbon::parse($inicio)->addMinute('30'), Carbon::parse('18:00'));
            return view('auditorias.calcula_horas_f', compact('datos', 'horario'));
        }
            /*if (((sizeof($areas[0]->generales)>0)or(sizeof($areas[0]->especificos)>0)) and ((sizeof($responsables[0]->generales)>0)or(sizeof($responsables[0]->especificos)>0))){
                if (sizeof($areas[0]->especificos)>0){
                    if (sizeof($responsables[0]->especificos)>0){
                        $responsable_jefe=AudValidarAgenda::checkRespons($responsables, $areas[0]->especificos);
                        if ($responsable_jefe==true)
                            return array(['type' => 'Error', 'message' => 'El responsable del evento es jefe del área seleccionada']);
                        else{
                            $horas_finales=AudValidarAgenda::checkEnd($responsables,$areas[0]->especificos,$fecha,$inicio);
                            if (sizeof($horas_finales)>0)
                                $horas_ocupadas[]=min($horas_finales);
                            else $horas_ocupadas[]="18:00";
                            if (sizeof($horas_ocupadas)>0){
                                $horario=AudValidarAgenda::generateRange(Carbon::parse($inicio)->addMinute('30'), Carbon::parse($horas_ocupadas[0]));
                            }
                            else
                                $horario=AudValidarAgenda::generateRange(Carbon::parse($inicio)->addMinute('30'), Carbon::parse('18:00'));
                            return view('auditorias.calcula_horas_f', compact('datos', 'horario'));
                        }
                    }
                    else{

                    }
                }
                else{
                    if (sizeof($responsables[0]->especificos)>0){
                        $areas=AudValidarAgenda::checkInvolved($areas[0]->generales);
                        $responsable_jefe=AudValidarAgenda::checkRespons($responsables, $areas);
                        if ($responsable_jefe==true)
                            return array(['type' => 'Error', 'message' => 'El responsable del evento es jefe del área seleccionada']);
                        else{

                            $horas_finales=AudValidarAgenda::checkEnd($responsables,$areas,$fecha,$inicio);
                            if (sizeof($horas_finales)>0)
                                $horas_ocupadas[]=min($horas_finales);
                            else $horas_ocupadas[]="18:00";
                            if (sizeof($horas_ocupadas)>0){
                                $horario=AudValidarAgenda::generateRange(Carbon::parse($inicio)->addMinute('30'), Carbon::parse($horas_ocupadas[0]));
                            }
                            else
                                $horario=AudValidarAgenda::generateRange(Carbon::parse($inicio)->addMinute('30'), Carbon::parse('18:00'));
                            return view('auditorias.calcula_horas_f', compact('datos', 'horario'));
                        }
                    }
                    else{

                    }
                }
            }
            else{
                return array(['type' => 'Error', 'message' => 'Se debe seleccionar al menos un elemento de la sección Área y un elemento de la sección el Respondable']);
            }*/
    }
}
