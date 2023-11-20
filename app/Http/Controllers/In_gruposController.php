<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as FPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpParser\Node\Stmt\While_;
use Session;

class In_gruposController extends Controller
{
    public function index()
    {
       $grupos=DB::select('SELECT * FROM `in_grupo_ingles` ORDER BY `in_grupo_ingles`.`id_grupo_ingles` ASC');
        return view('ingles.partials.mostrar_grupo',compact('grupos'));
    }
    public function autorizacion_cargas(){
        $periodo_ingles=Session::get('periodo_ingles');
        $alumnos = DB::table('in_validar_carga')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'in_validar_carga.id_alumno')
            ->join('in_carga_academica_ingles', 'in_carga_academica_ingles.id_alumno', '=', 'in_validar_carga.id_alumno')
            ->join('in_niveles_ingles', 'in_niveles_ingles.id_niveles_ingles', '=', 'in_carga_academica_ingles.id_nivel')
            ->join('in_grupo_ingles', 'in_grupo_ingles.id_grupo_ingles', '=', 'in_carga_academica_ingles.id_grupo')
            ->where('in_carga_academica_ingles.id_periodo_ingles','=',$periodo_ingles)
            ->where('in_validar_carga.id_periodo','=',$periodo_ingles)
            ->where('in_validar_carga.id_estado','=',2)
            ->select('gnral_alumnos.id_alumno','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno','in_validar_carga.*','in_carga_academica_ingles.*','in_niveles_ingles.descripcion as nivel_ingles','in_grupo_ingles.descripcion as grupo_ingles')
            ->get();

        return view('ingles.departamento.validar_carga_ingles',compact('alumnos'));

    }
    public function ver_carga_academica_ingles($id_validar_carga)
    {
        $periodo_ingles=Session::get('periodo_ingles');

        $validar_carga = DB::table('in_validar_carga')
            ->where('id_validar_carga', '=', $id_validar_carga)
            ->select('in_validar_carga.*')
            ->get();

        $datosalumno = DB::table('gnral_alumnos')
        ->where('id_alumno', '=', $validar_carga[0]->id_alumno)
        ->select('gnral_alumnos.*')
        ->get();
        $id_alumno=$datosalumno[0]->id_alumno;

        $carga_academica= DB::table('in_carga_academica_ingles')
            ->where('id_alumno', '=', $id_alumno)
            ->where('id_periodo_ingles', '=', $periodo_ingles)
            ->select('in_carga_academica_ingles.*')
            ->get();
        $horario_profesor= DB::table('in_hrs_ingles_profesor')
            ->where('id_grupo', '=', $carga_academica[0]->id_grupo)
            ->where('id_nivel', '=', $carga_academica[0]->id_nivel)
            ->where('id_periodo', '=', $periodo_ingles)
            ->select('in_hrs_ingles_profesor.*')
            ->get();
        $id_grupo=$horario_profesor[0]->id_grupo;
        $id_nivel=$horario_profesor[0]->id_nivel;
        $id_periodo=$horario_profesor[0]->id_periodo;
        $horas_profesor= DB::table('in_hrs_horas_profesor')
            ->where('id_grupo', '=', $id_grupo)
            ->where('id_nivel', '=', $id_nivel)
            ->where('id_periodo', '=', $id_periodo)
            ->select('in_hrs_horas_profesor.id_semana')
            ->get();
        $array_horario_ing = array();
        $array_semana = array();
        foreach ($horas_profesor as $horario_grupo) {
            $horario_prof['id_semana'] = $horario_grupo->id_semana;
            array_push($array_horario_ing, $horario_prof);
        }

        $sem = DB::select('select id_semana FROM hrs_semanas ');
        foreach ($sem as $sem) {
            $semanas['id_semana'] = $sem->id_semana;
            array_push($array_semana, $semanas);
        }

        $resultado_semana = array();
        foreach ($array_semana as $vehiculo) {
            $esta = false;
            foreach ($array_horario_ing as $vehiculo2) {
                if ($vehiculo['id_semana'] == $vehiculo2['id_semana']) {
                    $esta = true;
                    break;
                } // esta es la que se me olvidaba
            }
            if (!$esta) $resultado_semana[] = $vehiculo;
        }

        $array_ingles = array();
        foreach ($resultado_semana as $resultado) {
            $array_ing['id_semana'] = $resultado['id_semana'];
            $array_ing['nivel'] = 0;
            $array_ing['grupo'] = 0;
            $array_ing['disponibilidad'] = 3;
            array_push($array_ingles, $array_ing);
        }
        $profesores_horario = DB::select('
SELECT in_grupo_ingles.descripcion grupo,in_niveles_ingles.descripcion nivel, in_hrs_horas_profesor.* 
FROM  in_hrs_horas_profesor,in_niveles_ingles,in_grupo_ingles 
WHERE in_hrs_horas_profesor.id_grupo = ' . $id_grupo . ' AND in_hrs_horas_profesor.id_nivel = ' . $id_nivel . '
 AND in_hrs_horas_profesor.id_periodo = ' . $periodo_ingles . ' and in_hrs_horas_profesor.id_grupo=in_grupo_ingles.id_grupo_ingles
  and in_hrs_horas_profesor.id_nivel=in_niveles_ingles.id_niveles_ingles  
ORDER BY `in_hrs_horas_profesor`.`id_semana` ASC');
//dd($profesores_horario);
        foreach ($profesores_horario as $profesor_hor) {
            $array_labor['id_semana'] = $profesor_hor->id_semana;
            $array_labor['nivel'] = $profesor_hor->nivel;
            $array_labor['grupo'] = $profesor_hor->grupo;
            $array_labor['disponibilidad'] = 2;

            array_push($array_ingles, $array_labor);
        }
        foreach ($array_ingles as $key => $row) {
            $aux[$key] = $row['id_semana'];
        }
        array_multisort($aux, SORT_ASC, $array_ingles);

        $profesor = DB::selectOne('SELECT in_profesores_ingles.* FROM in_hrs_ingles_profesor,in_profesores_ingles 
WHERE in_hrs_ingles_profesor.id_grupo = ' . $id_grupo . ' AND in_hrs_ingles_profesor.id_nivel = ' . $id_nivel . ' 
AND in_hrs_ingles_profesor.id_periodo = ' . $periodo_ingles . '
 and in_hrs_ingles_profesor.id_profesor=in_profesores_ingles.id_profesores');
        //dd($profesor);
          $semanas=DB::select('select * FROM hrs_semanas ORDER by hora,id_semana');
        $disponibilidad=1;

        return view('ingles.departamento.ver_carga_academica_ingles',compact('array_ingles','disponibilidad','id_nivel','semanas','datosalumno','id_validar_carga','profesor'));
    }
    public function modificar_carga_academica_ingles($id_validar_carga){
        $alumno = DB::table('in_validar_carga')
            ->join('gnral_alumnos', 'gnral_alumnos.id_alumno', '=', 'in_validar_carga.id_alumno')
            ->where('in_validar_carga.id_validar_carga','=',$id_validar_carga)
            ->select('gnral_alumnos.id_alumno','gnral_alumnos.cuenta','gnral_alumnos.nombre','gnral_alumnos.apaterno','gnral_alumnos.amaterno')
            ->get();
           return view('ingles.departamento.mensaje_permiso',compact('alumno','id_validar_carga'));
    }
    public function modificacion_carga_academica_ingles(Request $request){

        $this->validate($request, [
            'id_validar_carga' => 'required',
        ]);
        $id_validar_carga = $request->input('id_validar_carga');
         $comentario="MODIFICA TU CARGA ACADEMICA";
        DB::table('in_validar_carga')
            ->where('id_validar_carga',$id_validar_carga)
            ->update(['id_estado' => 3,'comentario' =>$comentario]);
        $id_usuario = Session::get('usuario_alumno');

        $hoy = date("Y-m-d H:i:s");
        DB:: table('in_mod_carga_usuario')->insert(['id_validar_carga' =>$id_validar_carga,
            'fecha_cambio' =>$hoy,'id_usuario'=>$id_usuario]);
        return back();

    }


}
