<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class Resi_Registrar_cronogramaController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $anteproyecto=$anteproyecto->id_anteproyecto;

        if ($periodo%2==0){
            //par
            $semana_asignadas = DB::select('SELECT * FROM resi_cronograma WHERE id_anteproyecto = '.$anteproyecto.'');
            $asignadas = DB::selectOne('select max(resi_cronograma.no_semana)maxima FROM resi_cronograma WHERE id_anteproyecto = '.$anteproyecto.'');


            $array_periodos = array();
            foreach ($semana_asignadas as $asignada) {
                $array_cronograma['no_semana'] = $asignada->no_semana;
                $array_cronograma['id_cronograma'] = $asignada->id_cronograma;
                $array_cronograma['actividad'] = $asignada->actividad;
                $array_cronograma['f_inicio'] = $asignada->f_inicio;
                $array_cronograma['f_termino'] = $asignada->f_termino;
                $array_cronograma['estatus'] = 1;
                array_push($array_periodos, $array_cronograma);

            }
            $ultima_unidad = $asignadas->maxima + 1;
            $total =18;
            // dd($array_periodos);
            $array_peri = array();
            for ($i = $ultima_unidad; $i < $total; $i++) {
                $calificar = $asignadas->maxima + 1;
                if ($i == $calificar) {
                    $array_crono['no_semana'] = $i;
                    $array_crono['id_cronograma'] =0;
                    $array_crono['actividad'] = "";
                    $array_crono['f_inicio'] = "";
                    $array_crono['f_termino'] = "";
                    $array_crono['estatus'] = 2;

                } else {
                    $array_crono['no_semana'] = $i;
                    $array_crono['id_cronograma'] =0;
                    $array_crono['actividad'] = "";
                    $array_crono['f_inicio'] = "";
                    $array_crono['f_termino'] = "";
                    $array_crono['estatus'] = 3;

                }

                array_push($array_peri, $array_crono);
            }


            $semanas = array_merge($array_periodos, $array_peri);
            //  dd($semanas);
        }
        else{
            //impar
            $semana_asignadas = DB::select('SELECT * FROM resi_cronograma WHERE id_anteproyecto = '.$anteproyecto.'');
            $asignadas = DB::selectOne('select max(resi_cronograma.no_semana)maxima FROM resi_cronograma WHERE id_anteproyecto = '.$anteproyecto.'');


            $array_periodos = array();
            foreach ($semana_asignadas as $asignada) {
                $array_cronograma['no_semana'] = $asignada->no_semana;
                $array_cronograma['id_cronograma'] = $asignada->id_cronograma;
                $array_cronograma['actividad'] = $asignada->actividad;
                $array_cronograma['f_inicio'] = $asignada->f_inicio;
                $array_cronograma['f_termino'] = $asignada->f_termino;
                $array_cronograma['estatus'] = 1;
                array_push($array_periodos, $array_cronograma);

            }
            $ultima_unidad = $asignadas->maxima + 1;
            $total =20;
            // dd($array_periodos);
            $array_peri = array();
            for ($i = $ultima_unidad; $i < $total; $i++) {
                $calificar = $asignadas->maxima + 1;
                if ($i == $calificar) {
                    $array_crono['no_semana'] = $i;
                    $array_crono['id_cronograma'] =0;
                    $array_crono['actividad'] = "";
                    $array_crono['f_inicio'] = "";
                    $array_crono['f_termino'] = "";
                    $array_crono['estatus'] = 2;

                } else {
                    $array_crono['no_semana'] = $i;
                    $array_crono['id_cronograma'] =0;
                    $array_crono['actividad'] = "";
                    $array_crono['f_inicio'] = "";
                    $array_crono['f_termino'] = "";
                    $array_crono['estatus'] = 3;

                }

                array_push($array_peri, $array_crono);
            }


            $semanas = array_merge($array_periodos, $array_peri);


        }
        $enviado_anteproyecto=DB::selectOne('select resi_anteproyecto.estado_enviado proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $enviado_anteproyecto=$enviado_anteproyecto->proy;

        return view('residencia.partials.cronograma',compact('semanas','enviado_anteproyecto'));
    }
    public  function agregar_actividad($id_actividad){
        $no_semana=$id_actividad;
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $id_anteproyecto=$anteproyecto->id_anteproyecto;
       $fecha_semana=DB::selectOne('SELECT * FROM `resi_fecha_anteproyecto` WHERE `semana` = '.$no_semana.' ');
        return view('residencia.partials.insertar_actividad',compact('no_semana','id_anteproyecto','fecha_semana'));


    }
    public function registrar_actividad(Request $request)
    {
        $this->validate($request,[
            'id_anteproyecto' => 'required',
            'fecha_inicial' => 'required',
            'no_semana' => 'required',
            'fecha_final' => 'required',
            'actividad' => 'required',
        ]);
        $id_anteproyecto = $request->input("id_anteproyecto");
        $fecha_inicial = $request->input("fecha_inicial");
        $no_semana = $request->input("no_semana");
        $fecha_final = $request->input("fecha_final");
        $actividad = $request->input("actividad");

        DB:: table('resi_cronograma')->insert(['no_semana' => $no_semana,'id_anteproyecto' => $id_anteproyecto, 'actividad' => $actividad, 'f_inicio' => $fecha_inicial, 'f_termino' => $fecha_final]);


        return back();
    }
    public function moficar_actividad($id_cronograma){
        $cronograma=DB::selectOne('SELECT * FROM resi_cronograma WHERE id_cronograma = '.$id_cronograma.'');
        return view('residencia.partials.modificar_actividad', compact('cronograma'));
    }
    public function moficacion_actividad(Request $request){
        //dd($request);
        $this->validate($request,[
            'fecha_inicial' => 'required',
            'id_cronograma' => 'required',
            'fecha_s' => 'required',
            'actividades' => 'required',
        ]);
        $fecha_inicial = $request->input("fecha_inicial");
        $id_cronograma = $request->input("id_cronograma");
        $fecha_final = $request->input("fecha_s");
        $actividades = $request->input("actividades");
        DB::update("UPDATE resi_cronograma SET resi_cronograma.actividad ='$actividades',resi_cronograma.f_inicio ='$fecha_inicial',resi_cronograma.f_termino ='$fecha_final' WHERE resi_cronograma.id_cronograma= $id_cronograma");
        return back();
    }

}