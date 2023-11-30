<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

use App\Http\Requests;

class Dual_Alumnos_MateriasController extends Controller
{

    public function index($id_duales_actuales)
    {
        $id_periodo=Session::get('periodo_actual');
        //dd($id_duales_actuales);
        $id_carrera = Session::get('carrera');
        $reticulas = DB::select('select *from gnral_reticulas WHERE gnral_reticulas.id_carrera=' . $id_carrera . '');
        $datos_reticulas = array();
        $dual = DB::SelectOne('SELECT * FROM `cal_duales_actuales` WHERE id_duales_actuales = '.$id_duales_actuales.' ');
        $estado_alumno= DB::SelectOne('SELECT * FROM eva_validacion_de_cargas WHERE id_alumno = '.$dual->id_alumno.' AND id_periodo = '.$id_periodo.' ');
        //dd($estado_alumno);
        $materias_alumnos_duales = DB::select('SELECT gnral_materias.id_materia, gnral_materias.nombre,eva_carga_academica.id_carga_academica, 
       eva_carga_academica.id_alumno, eva_carga_academica.id_materia 
        FROM gnral_reticulas, gnral_materias, eva_carga_academica, eva_validacion_de_cargas 
        WHERE gnral_materias.id_reticula = gnral_reticulas.id_reticula 
          AND gnral_reticulas.id_carrera = '.$id_carrera.'
          AND eva_carga_academica.id_carga_academica = eva_carga_academica.id_carga_academica 
          AND eva_carga_academica.id_alumno = '.$dual->id_alumno.'
          AND eva_carga_academica.id_periodo ='.$id_periodo.'
          AND eva_validacion_de_cargas.id_alumno = eva_carga_academica.id_alumno
          AND eva_validacion_de_cargas.id_periodo = eva_carga_academica.id_periodo;');
      //dd($materias_alumnos_duales);

        foreach ($reticulas as $reticula) {
            $nombre['id_reticula'] = $reticula->id_reticula;
            $nombre['reticula'] = $reticula->clave;
            $semestres = DB::select('SELECT DISTINCT gnral_materias.id_semestre,gnral_semestres.descripcion semestre FROM 
                gnral_reticulas,gnral_materias,gnral_semestres WHERE gnral_reticulas.id_reticula=' . $reticula->id_reticula . ' AND
                gnral_materias.id_reticula=gnral_reticulas.id_reticula AND
                gnral_materias.id_semestre=gnral_semestres.id_semestre order by id_semestre');
            $datos_semestres = array();
            if ($semestres != null) {
                foreach ($semestres as $semes) {
                    $semestres = array();
                    $semestres['semestre'] = $semes->semestre;
                    $semestres['id_semestre'] = $semes->id_semestre;
                    $materias = DB::select('SELECT DISTINCT gnral_materias.id_materia,gnral_materias.nombre,gnral_materias.clave,
                        gnral_materias.id_semestre ,gnral_materias.id_reticula from 
                        gnral_materias,gnral_reticulas WHERE 
                        gnral_materias.id_reticula=' . $reticula->id_reticula . ' AND 
                        gnral_materias.id_semestre=' . $semes->id_semestre . '');
                        //dd($materias);
                    $nombre_materias = array();
                      //dd($nombre_materias);
                    if ($materias != null) {
                        foreach ($materias as $mates) {
                            $nombrem = array();
                            $nombrem['id_materia'] = $mates->id_materia;
                            $nombrem['materia'] = $mates->nombre;
                            $nombrem['clave'] = $mates->clave;
                            $nombrem['id_semestre'] = $mates->id_semestre;
                            $nombrem['id_reticula'] = $mates->id_reticula;
                            array_push($nombre_materias, $nombrem);
                        }
                
                        $semestres["materias"] = $nombre_materias;
                        array_push($datos_semestres, $semestres);
                    } else {
                        $nombrem = "No existen materias";
                        array_push($nombre_materias, $nombrem);

                        $semestres["materias"] = $nombre_materias;
                        array_push($datos_semestres, $semestres);
                    }
                }
                $nombre["semestres"] = $datos_semestres;
                array_push($datos_reticulas, $nombre);
            }
        }
        //dd($datos_reticulas);

        return view('duales.partials.materias', compact('materias_alumnos_duales','id_duales_actuales','estado_alumno','dual'))->with('reticulas', $datos_reticulas);

    }

    public function agrega_materias(Request $request)
    {
        $id_duales_actuales = $request->get('id_duales_actuales');
        $id_alumno = 0;
        $arr_mate = explode(',', $request->get('materias'));
        $ciclo = count($arr_mate);
        $arreglo = array();

        $datos_duales = DB::selectOne('SELECT * FROM cal_duales_actuales WHERE cal_duales_actuales.id_duales_actuales = '.$id_duales_actuales.'');
        //dd($datos_duales);

        for ($i = 0; $i < $ciclo; $i++)
        {
            $dat = array();          
            $dat['id_materia'] = $arr_mate[$i];
            array_push($arreglo, $dat);
        }

        foreach ($arreglo as $dat)
        {
            DB::table('eva_carga_academica')
                ->insert([
                    'id_alumno' => $datos_duales->id_alumno,
                    'id_materia' => $dat['id_materia'],
                    'id_status_materia' => 1,
                    'id_tipo_curso' => 1,
                    'id_periodo' => $datos_duales->id_periodo,
                    'grupo' => 1
                ]);
        }
        return back();
        //dd($arreglo);

    }

    public  function eliminar_carga_academica($id_carga_academica )
    {
        //dd($id_carga_academica);
        DB::delete('DELETE FROM eva_carga_academica  WHERE id_carga_academica ='.$id_carga_academica.'');
        return back();
    }

}