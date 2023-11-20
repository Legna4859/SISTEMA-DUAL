<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpParser\Node\Stmt\While_;
use Session;

class In_nivelesController extends Controller
{
    public function index()
    {
        $niveles=DB::select('SELECT * FROM `in_niveles_ingles` ORDER BY `in_niveles_ingles`.`id_niveles_ingles` ASC');
        return view('ingles.partials.mostrar_niveles',compact('niveles'));
    }
    public function periodos(){
        $periodos=DB::select('SELECT * FROM `in_periodos` ORDER BY `id_periodo_ingles` ASC');
        return view('ingles.partials.mostrar_periodos',compact('periodos'));
    }
    public function calificaciones_profesor()
    {
        $periodo_ingles = Session::get('periodo_ingles');
        $cuenta_niveles = DB::table('in_hrs_ingles_profesor')
            ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_hrs_ingles_profesor.id_nivel')
            ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_hrs_ingles_profesor.id_grupo')
            ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
            ->select(DB::raw('count(in_hrs_ingles_profesor.id_profesor) as total'))
            ->get();
        $cuenta_niveles = $cuenta_niveles[0]->total;
       // dd($cuenta_niveles);
        if ($cuenta_niveles == 0) {
            $cuenta_niveles = 0;
            $profesores=0;

        }
        else{
            $cuenta_niveles=1;
            $profesores = DB::table('in_hrs_ingles_profesor')
                ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_hrs_ingles_profesor.id_nivel')
                ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_hrs_ingles_profesor.id_grupo')
                 ->join('in_profesores_ingles', 'in_profesores_ingles.id_profesores', '=', 'in_hrs_ingles_profesor.id_profesor')
                 ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
                ->select('in_profesores_ingles.*')
                ->groupBy('in_profesores_ingles.id_profesores')
                ->orderBy('in_profesores_ingles.apellido_paterno', 'ASC')
                ->orderBy( 'in_profesores_ingles.apellido_materno', 'ASC')
                ->orderBy('in_profesores_ingles.nombre', 'ASC')
                ->get();

        }
        return view('ingles.departamento.profesores_calificaciones', compact('profesores', 'cuenta_niveles'));
    }
    public function calificacion_profesor($id_profesor){
        $periodo_ingles = Session::get('periodo_ingles');
        $cuenta_niveles = DB::table('in_hrs_ingles_profesor')
            ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_hrs_ingles_profesor.id_nivel')
            ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_hrs_ingles_profesor.id_grupo')
            ->where('in_hrs_ingles_profesor.id_profesor', '=', $id_profesor)
            ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
            ->select(DB::raw('count(in_hrs_ingles_profesor.id_profesor) as total'))
            ->get();
        $cuenta_niveles = $cuenta_niveles[0]->total;
        if ($cuenta_niveles == 0) {
            $cuenta_niveles = 0;

        } else {
            $cuenta_niveles = 1;
            $niveles = DB::table('in_hrs_ingles_profesor')
                ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_hrs_ingles_profesor.id_nivel')
                ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_hrs_ingles_profesor.id_grupo')
                ->where('in_hrs_ingles_profesor.id_profesor', '=', $id_profesor)
                ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
                ->select('in_niveles_ingles.descripcion as nivel', 'in_grupo_ingles.descripcion as grupo', 'in_hrs_ingles_profesor.*')
                ->orderBy('in_niveles_ingles.id_niveles_ingles', 'ASC')
                ->orderBy('in_grupo_ingles.id_grupo_ingles', 'ASC')
                ->get();
        }
        return view('ingles.profesores_ingles.inicio_calificaciones', compact('niveles', 'cuenta_niveles'));

    }
    public function modificar_per($id_unidad,$id_nivel,$id_grupo){
        $periodo_ingles = Session::get('periodo_ingles');
        $periodo_calificacion = DB::table('in_cal_periodo')
            ->where('in_cal_periodo.id_unidad', '=', $id_unidad)
            ->where('in_cal_periodo.id_periodo', '=', $periodo_ingles)
            ->where('in_cal_periodo.id_nivel', '=', $id_nivel)
            ->where('in_cal_periodo.id_grupo', '=', $id_grupo)
            ->select('in_cal_periodo.*')
            ->get();

        return view('ingles.profesores_ingles.modificar_periodo_ingles_calificaciones', compact('periodo_calificacion'));

    }
    public function modificacion_per(Request $request){
        $this->validate($request, [
            'fecha_periodo' => 'required',
            'id_nivel' => 'required',
            'id_unidad' => 'required',
            'id_grupo' => 'required',
            'fecha_anterior' => 'required',
        ]);

        $periodo_ingles=Session::get('periodo_ingles');
        $fecha_periodo = $request->input('fecha_periodo');
        $fecha_periodo = str_replace('/', '-', $fecha_periodo);
        $fecha_periodo = date("Y-m-d", strtotime($fecha_periodo));
        $id_nivel = $request->input('id_nivel');
        $id_unidad = $request->input('id_unidad');
        $id_grupo = $request->input('id_grupo');
        $fecha_anterior = $request->input('fecha_anterior');
        $fec=date("Y-m-d H:i");
        $profesor = DB::table('in_hrs_ingles_profesor')
            ->join('in_profesores_ingles', 'in_profesores_ingles.id_profesores', '=', 'in_hrs_ingles_profesor.id_profesor')
            ->where('in_hrs_ingles_profesor.id_nivel', '=', $id_nivel)
            ->where('in_hrs_ingles_profesor.id_grupo', '=', $id_grupo)
            ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
            ->select('in_profesores_ingles.*')
            ->get();
        $id_profesor=$profesor[0]->id_profesores;
        if($id_unidad == 1)
        {
            DB::table('in_cal_periodo')
                ->where('id_unidad',$id_unidad)
                ->where('id_periodo',$periodo_ingles)
                ->where('id_nivel',$id_nivel)
                ->where('id_grupo',$id_grupo)
                ->update(['fecha' =>$fecha_periodo]);
            $inserta_calificacion = DB:: table('in_bitacora_periodo')->insert(['id_unidad'=>1,'id_nivel'=>$id_nivel,'id_grupo'=>$id_grupo,'fecha_anterior'=>$fecha_anterior,'fecha_registrada'=>$fecha_periodo,'fecha_modificacion'=>$fec,'id_periodo'=>$periodo_ingles,'id_profesor'=>$id_profesor]);

        }
        else{
            DB::table('in_cal_periodo')
                ->where('id_unidad',2)
                ->where('id_periodo',$periodo_ingles)
                ->where('id_nivel',$id_nivel)
                ->where('id_grupo',$id_grupo)
                ->update(['fecha' =>$fecha_periodo]);
            DB::table('in_cal_periodo')
                ->where('id_unidad',3)
                ->where('id_periodo',$periodo_ingles)
                ->where('id_nivel',$id_nivel)
                ->where('id_grupo',$id_grupo)
                ->update(['fecha' =>$fecha_periodo]);
            DB::table('in_cal_periodo')
                ->where('id_unidad',4)
                ->where('id_periodo',$periodo_ingles)
                ->where('id_nivel',$id_nivel)
                ->where('id_grupo',$id_grupo)
                ->update(['fecha' =>$fecha_periodo]);
            $inserta_calificacion = DB:: table('in_bitacora_periodo')->insert(['id_unidad'=>2,'id_nivel'=>$id_nivel,'id_grupo'=>$id_grupo,'fecha_anterior'=>$fecha_anterior,'fecha_registrada'=>$fecha_periodo,'fecha_modificacion'=>$fec]);

        }
        return back();
    }
    public function modificar_cal($id_carga_academica,$id_unidad){
        $alumno = DB::table('in_carga_academica_ingles')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'in_carga_academica_ingles.id_alumno')
            ->where('in_carga_academica_ingles.id_carga_ingles', '=', $id_carga_academica)
            ->select('gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno')
            ->get();
        $nombre_alumno = mb_strtoupper($alumno[0]->apaterno, 'utf-8') . " " . mb_strtoupper($alumno[0]->amaterno, 'utf-8') . " " . mb_strtoupper($alumno[0]->nombre, 'utf-8');

        $cuenta_carga = DB::table('in_evaluar_calificacion')
             ->where('in_evaluar_calificacion.id_carga_ingles', '=', $id_carga_academica)
            ->where('in_evaluar_calificacion.id_unidad', '=',$id_unidad)
            ->select(DB::raw('count(in_evaluar_calificacion.id_carga_ingles) as total'))
            ->get();
       $cuenta_carga=$cuenta_carga[0]->total;
       if($cuenta_carga ==0){
           $cuenta_carga=0;
           $calificacion=0;
       }
       else{
           $cuenta_carga=1;
           $carga = DB::table('in_evaluar_calificacion')
               ->where('in_evaluar_calificacion.id_carga_ingles', '=', $id_carga_academica)
               ->where('in_evaluar_calificacion.id_unidad', '=',$id_unidad)
               ->select('in_evaluar_calificacion.calificacion')
               ->get();
           $calificacion=$carga[0]->calificacion;

       }
return view('ingles.departamento.modificar_calificacion_ingles',compact('nombre_alumno','cuenta_carga','calificacion','id_carga_academica','id_unidad'));
    }
    public function guardar_modificacion_calif(Request $request){
        $this->validate($request, [
            'calificacion' => 'required',
            'id_carga_academica' => 'required',
            'id_unidad' => 'required',
            'registrada' => 'required',
            'calificacion_anterior'=>'required'
        ]);
        $periodo_ingles=Session::get('periodo_ingles');
        $calificacion_anterior = $request->input('calificacion_anterior');
        $calificacion = $request->input('calificacion');
        $id_carga_academica = $request->input('id_carga_academica');
        $id_unidad = $request->input('id_unidad');
        $registrada = $request->input('registrada');
        $fec=date("Y-m-d H:i");
        $alumno = DB::table('in_carga_academica_ingles')
              ->where('in_carga_academica_ingles.id_carga_ingles', '=', $id_carga_academica)
            ->select('in_carga_academica_ingles.*')
            ->get();
        $id_nivel=$alumno[0]->id_nivel;
        $id_grupo=$alumno[0]->id_grupo;
        $profesor = DB::table('in_hrs_ingles_profesor')
            ->join('in_profesores_ingles', 'in_profesores_ingles.id_profesores', '=', 'in_hrs_ingles_profesor.id_profesor')
            ->where('in_hrs_ingles_profesor.id_nivel', '=', $id_nivel)
            ->where('in_hrs_ingles_profesor.id_grupo', '=', $id_grupo)
            ->where('in_hrs_ingles_profesor.id_periodo', '=', $periodo_ingles)
            ->select('in_profesores_ingles.*')
            ->get();
        $id_profesor=$profesor[0]->id_profesores;

        if($registrada ==0){
            $inserta_calificacion = DB:: table('in_evaluar_calificacion')->insert(['id_unidad'=>$id_unidad,'id_carga_ingles'=>$id_carga_academica,'calificacion'=>$calificacion]);

        }else{
            DB::table('in_evaluar_calificacion')
                ->where('id_unidad',$id_unidad)
                ->where('id_carga_ingles',$id_carga_academica)
                ->update(['calificacion' =>$calificacion]);
        }
        $inserta_bitacora_cal = DB:: table('in_bitacora_calificaciones')->insert(['id_unidad'=>$id_unidad,'id_carga_ingles'=>$id_carga_academica,'fecha_modificacion'=>$fec,'id_periodo'=>$periodo_ingles,'id_profesor'=>$id_profesor,'calificacion_registrada'=>$calificacion,'calificacion_anterior'=>$calificacion_anterior]);

        return back();
    }
}
